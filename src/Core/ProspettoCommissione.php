<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;
use Mpdf\Mpdf;
use Laureandosi\Core\ProspettoLaureando;

use function Laureandosi\API\inviaRisposta;

class ProspettoCommissione
{
    private string $path;
    private FileConfigurazione $fileConfigurazione;

    private array $elencoLaureandi;
    private string $cdl;
    private string $dataLaurea;

    /**
     * Costruttore di Prospetto Commissione
     */
    public function __construct(array $mat, string $cdl, string $data)
    {
        $this->path = dirname(__DIR__, 2) . '/prospetti';
        $this->elencoLaureandi = $mat;
        $this->cdl = $cdl;
        $this->dataLaurea = $data;
        $this->fileConfigurazione = new FileConfigurazione();
    }

    /**
     * Entry point del tasto Genera Prospetti
     * Non mi serve che mi restituisca lo stato del processo in quanto la funzione lavora su dati sicuri, quindi sarà
     * di tipo void e non array
     */
    public function GeneraProspettoCommissione(): void
    {
        // Unico ciclo: creo ogni prospetto, raccolgo anagrafica e scrivo su MPDF
        $infoLaureandi = [];

        $path = $this->path . '/' . $this->cdl;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
        ]);

        // Prima passata: generiamo i singoli prospetti (salvati singolarmente) e raccogliamo dati per la lista
        $prospettiHtml = [];
        foreach ($this->elencoLaureandi as $matricola) {

            $prospetto = new ProspettoLaureando($matricola, $this->cdl, $this->dataLaurea);
            // generaProspetto ora restituisce l'HTML del prospetto oltre a salvare il PDF individuale
            $htmlProspetto = $prospetto->GeneraProspetto();
            $simulazione = $this->GeneraTabellaVoti($prospetto);

            $prospettiHtml[] = $htmlProspetto . $simulazione;

            $infoLaureandi[$matricola] = [
                'nome' => $prospetto->anagrafica->nome,
                'cognome' => $prospetto->anagrafica->cognome,
                'email' => $prospetto->anagrafica->email,
            ];

        }

        // Scrivo lo style e la lista laureandi come prima pagina del PDF commissione
        $mpdf->WriteHTML(ProspettoLaureando::getStylePDF(), \Mpdf\HTMLParserMode::HEADER_CSS);
        $listaLaureandi = $this->generaElencoLaureandi($infoLaureandi);
        $mpdf->WriteHTML($listaLaureandi, \Mpdf\HTMLParserMode::HTML_BODY);

        // Poi aggiungo ogni prospetto come pagina separata
        foreach ($prospettiHtml as $html) {
            $mpdf->AddPage();
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        }

        // Salvo file commissione
        $nomeFile = 'commissione.pdf';
        $fullPath = $path . DIRECTORY_SEPARATOR . $nomeFile;
        $mpdf->Output($fullPath, \Mpdf\Output\Destination::FILE);
    }

    public function generaElencoLaureandi(array $lista): string
    {
        //Mi salvo in un file json le informazioni dei laureandi per poterle usare poi nell'invio email
        $path = $this->path . '/' . $this->cdl . '/laureandi.json';
        file_put_contents($path, json_encode($lista));

        //creo l'elenco per la commissione
        $html = '<h2>' . htmlspecialchars($this->fileConfigurazione->getNomeCdl($this->cdl)) . '</h2>';
        $html .='<h2 id="sottoTitolo"> LAUREANDOSI 2 - Progettazione: mario.cimino@unipi.it, Amministrazione: rose.rosielli@unipi.it</h2>';
        $html .='<h1>LISTA LAUREANDI</h1>';
        $html .= '<table class="laureandi-table"><tr><th>COGNOME</th><th>NOME</th><th>CDL</th><th>VOTO LAUREA</th></tr>';
        foreach ($lista as $matricola => $info) {
            $html .= '<tr><td>' . htmlspecialchars($info['cognome']) . '</td><td>' . htmlspecialchars($info['nome']) . '</td><td> </td><td>/110</td></tr>';
        }
        $html .= '</table>';
        return $html;
    }

    public function GeneraTabellaVoti(ProspettoLaureando $prospetto): string
    {
        $param = $this->fileConfigurazione->fileMediaEEmail->whichParam($this->cdl);
        $subtitle = ($param === 'C') ? 'VOTO COMMISSIONE (C)' : 'VOTO TESI (T)';

        $M = round($prospetto->getMedia(), 3);
        $CFU = $prospetto->getCfuMedia();

        // genera array di valori del parametro
        $values = [];
        $min = $this->fileConfigurazione->fileMediaEEmail->getMinParam($this->cdl, $param);
        $max = $this->fileConfigurazione->fileMediaEEmail->getMaxParam($this->cdl, $param);
        $step = $this->fileConfigurazione->fileMediaEEmail->getStepParam($this->cdl, $param);
        if ($step <= 0) $step = 1;
        for ($v = $min; $v <= $max ; $v += $step) {
            $values[] = $v;
        }

        $count = count($values);
        $doubleColumns = ($count > 7);
        $rows = $doubleColumns ? (int)ceil($count / 2) : $count;
        $colspan = $doubleColumns ? 4 : 2;

        $html = '<table class="table-exam">\n'
            . '<thead>\n'
            . '<tr><td class="text-center" colspan="' . $colspan . '">SIMULAZIONE VOTO DI LAUREA</td></tr>\n'
            . '<tr><td class="text-center">' . $subtitle . '</td><td class="text-center">VOTO LAUREA</td>';

        if ($doubleColumns) {
            $html .= '<td class="text-center">' . $subtitle . '</td><td class="text-center">VOTO LAUREA</td>';
        }

        $html .= '</tr>\n</thead>\n<tbody>';

        for ($i = 0; $i < $rows; ++$i) {

            $left = $values[$i];
            $leftDisplay = (floor($left) == $left) ? (string)intval($left) : rtrim(rtrim(sprintf('%.3f', $left), '0'), '.');

            if ($param === 'C') {
                $leftVoto = $this->fileConfigurazione->fileMediaEEmail->calcolaVotoLaurea($this->cdl, $M, $CFU, 0, $left);
            } else {
                $leftVoto = $this->fileConfigurazione->fileMediaEEmail->calcolaVotoLaurea($this->cdl, $M, $CFU, $left, 0);
            }

            $html .= '\n<tr>\n<td class="text-center">' . $leftDisplay . '</td>\n<td class="text-center">' . $leftVoto . '</td>';

            if ($doubleColumns && ($i + $rows) < $count) {
                $right = $values[$i + $rows];
                $rightDisplay = (floor($right) == $right) ? (string)intval($right) : rtrim(rtrim(sprintf('%.3f', $right), '0'), '.');
                if ($param === 'C') {
                    $rightVoto = $this->fileConfigurazione->fileMediaEEmail->calcolaVotoLaurea($this->cdl, $M, $CFU, 0, $right);
                } else {
                    $rightVoto = $this->fileConfigurazione->fileMediaEEmail->calcolaVotoLaurea($this->cdl, $M, $CFU, $right, 0);
                }
                $html .= '\n<td class="text-center">' . $rightDisplay . '</td>\n<td class="text-center">' . $rightVoto . '</td>';
            }

            $html .= '\n</tr>';

        }

        $html .= '\n</tbody>\n</table>';

        $html .='<p>'.htmlspecialchars($this->fileConfigurazione->fileMediaEEmail->getNotaFinale($this->cdl) ?? '') .'</p>';

        return $html;
    }

}
