<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Core\AnagraficaLaureando;
use Laureandosi\Core\CarrieraLaureando;
use Laureandosi\Core\CarrieraLaureandoInf;
use Laureandosi\Config\FileConfigurazione;
use Laureandosi\Core\Esame;
use Laureandosi\Core\EsameInformatico;
use Mpdf\Mpdf;

class ProspettoLaureando
{
    private string $matricola;
    private string $cdl;
    private string $dataLaurea;

    private FileConfigurazione $config;
    private string $path;

    public AnagraficaLaureando $anagrafica;
    private CarrieraLaureando | CarrieraLaureandoInf $carriera;

    private Mpdf $prospettoPDF;

    public function __construct(string $mat, string $cdl, string $data)
    {
        $this->path = dirname(__DIR__, 2) . '/prospetti';

        $this->matricola = $mat;
        $this->cdl = $cdl;
        $this->dataLaurea = $data;

        $this->config = new FileConfigurazione();

        $this->anagrafica = new AnagraficaLaureando($mat);
        switch ($cdl)
        {
            case "TInf":
                $this->carriera = new CarrieraLaureandoInf($mat, $cdl, $data);
                break;
            default:
                $this->carriera = new CarrieraLaureando($mat, $cdl, $data);
                break;
        }
    }

    /**
     * Salva il prospetto in PDF nella cartella ../prospetti/{cdl}/
     * Restituisce il percorso completo del file salvato.
     */
    public function SalvaProspetto(): string
    {

        $path = $this->path . '/' . $this->cdl;

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $this->prospettoPDF = new Mpdf();
        $this->prospettoPDF->WriteHTML(self::getStylePDF(), \Mpdf\HTMLParserMode::HEADER_CSS);

        /** INTESTAZIONE */
        $html = '<h1>' . htmlspecialchars($this->config->getNomeCdl($this->cdl)) . '</h1>';
        $html .= '<h2>CARRIERA E SIMULAZIONE DEL VOTO DI LAUREA</h2>';

        /** DATI STUDENTE */
        $html .= '<div class="info-box"><table class="info-table">';
        $html .= '<tr><td>Matricola:</td><td>' . htmlspecialchars($this->matricola) . '</td></tr>';
        $html .= '<tr><td>Nome:</td><td>' . htmlspecialchars($this->anagrafica->nome) . '</td></tr>';
        $html .= '<tr><td>Cognome:</td><td>' . htmlspecialchars($this->anagrafica->cognome) . '</td></tr>';
        $html .= '<tr><td>Email:</td><td>' . htmlspecialchars($this->anagrafica->email) . '</td></tr>';
        $html .= '<tr><td>Data:</td><td>' . htmlspecialchars($this->dataLaurea) . '</td></tr>';
        //info bonus (valido solo per TInf, negli altri casi nonesiste come campo)
        if($this->cdl == "TInf"){
            $html .= '<tr><td>Bonus:</td><td>'.htmlspecialchars(($this->carriera->isBonus()) ? 'Sì' : 'No').'</td></tr>';
        }
        $html .= '</table></div>';

        /** TABELLA ESAMI SOSTENUTI */
        $html .= '<table class="table-exam"><tr><th>ESAME</th><th>CFU</th><th>VOT</th><th>MED</th>';
        //colonna bonus solo per TInf
        if ($this->cdl == "TInf") { $html .= '<th>INF</th>'; }
        $html .='</tr>';

        /** @var Esame | EsameInformatico $esame */
        foreach ($this->carriera->getEsamiValidi() as $esame) {

            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($esame->getNomeEsame()) . '</td>';
            $html .= '<td class="text-center">' . htmlspecialchars($esame->getCfu()) . '</td>';
            $html .= '<td class="text-center">' . htmlspecialchars($esame->getVoto()) . '</td>';
            $html .= '<td class="text-center">' . (($esame->isFaMedia())? 'X':' ' ). '</td>';
            //colonna INF solo per TInf: mostra se l'esame è informatico
            if($this->cdl == "TInf") {
                $html .= '<td class="text-center">' . (($esame instanceof EsameInformatico) ? 'X' : ' ' ) . '</td>';
            }
            $html .= '</tr>';

        }

        /** TABELLA PER IL SOMMARIO */
        $html .= '</table>';
        $html .='<div class="summary-box"><table class="summary-table">';
        $html .= '<tr><td>MediaPesata (M):</td><td>' . htmlspecialchars(round($this->carriera->getMedia(), 3)) . '</td></tr>';
        $html .= '<tr><td>Crediti che fanno media (CFU):</td><td>' . htmlspecialchars($this->carriera->getCfuMedia()) . '</td></tr>';
        $html .= '<tr><td>Crediti curriculari conseguiti:</td><td>' . htmlspecialchars($this->carriera->getTotaleCfu()).'/'.htmlspecialchars($this->config->fileMediaEEmail->getCfuNecessari($this->cdl)) . '</td></tr>';
        if($this->config->fileMediaEEmail->getServeTesi($this->cdl)) $html .= '<tr><td>Voto di tesi (T):</td><td> 0 </td></tr>';
        $html .= '<tr><td>Formula calcolo voto di laurea:</td><td>' . htmlspecialchars($this->config->fileMediaEEmail->getFormulaLaurea($this->cdl) ?? '') . '</td></tr>';
        if($this->cdl == "TInf") $html .= '<tr><td>Media pesata esami INF:</td><td>' . htmlspecialchars(round($this->carriera->getMediaEsamiInformatici(), 3)) . '</td></tr>';
        $html .= '</table></div>';

        $this->prospettoPDF->WriteHTML($html);

        $nomeFile = $this->matricola . '.pdf';
        $fullPath = $path . DIRECTORY_SEPARATOR . $nomeFile;

        $this->prospettoPDF->Output($fullPath, 'F');

        // restituisco l'HTML  generato in modo che possa essere incluso in un PDF di Commissione
        return $html;
    }

    // Metodo statico che fornisce lo stile usato nei PDF (riutilizzabile)
    public static function getStylePDF(): string
    {
        return "<style>body {font-family: sans-serif; font-size: 8pt;}
                    h1, h2 {text-align: center;margin: 0; font-weight: normal;}
                    h1 {font-size: 14pt;}
                    h2 {font-size: 13pt;margin-bottom: 7px;}
                    p {font-size: 8pt;margin: 5px 0;}
                /* Box informazioni studente */
                    .info-box {border: 1px solid #000;padding: 3px;margin-bottom: 5px;}
                    .info-table {width: 100%;border-collapse: collapse;}
                    .info-table td {padding: 1px 5px;}
                /* Elenco laureandi */
                    .laureandi-table {width: 100%;border-collapse: collapse;font-size: 8pt; margin-top: 10px;}
                    .laureandi-table th,.laureandi-table td {border: 1px solid #000;padding: 2px;font-weight: normal;text-align: center; width: 25%;}
                    #sottoTitolo {text-align: center;font-size: 10pt;margin-top: 5px;margin-bottom: 5px;}
                /* Tabella esami */
                    .table-exam {width: 100%;border-collapse: collapse;font-size: 8pt; margin-top: 10px;}
                    .table-exam th,.table-exam td {border: 1px solid #000;padding: 2px;}
                    .table-exam th {font-weight: normal;text-align: center;}
                    .table-exam td::first-child, .table-exam th::first-child {width: 90%;}
                /* Allineamenti */
                    .text-center {text-align: center;}
                    .text-right {text-align: right;}
                /* Box finale */
                    .summary-box {border: 1px solid #000;width: 100%;padding: 5px;margin-top: 10px;}
                    .summary-table {width: 100%;}
                    .summary-table td {padding: 1px 5px;}</style>";
    }

    /**
     * Wrapper usato da ProspettoCommissione per generare e salvare il prospetto.
     * Restituisce l'HTML usato per il PDF (per unire il prospetto alla commissione).
     */
    public function GeneraProspetto(): string
    {
        return $this->SalvaProspetto();
    }

    // Utilità per le altre classi
    public function getMedia(): float
    {
        return $this->carriera->getMedia();
    }

    public function getCfuMedia(): int
    {
        return $this->carriera->getCfuMedia();
    }

}