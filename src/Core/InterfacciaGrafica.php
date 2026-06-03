<?php

namespace Laureandosi\Core;

// Carico l'autoloader di Composer per far funzionare i namespace
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;
use Laureandosi\Config\FormulaMedia;
use Laureandosi\Core\ProspettoCommissione;
use Laureandosi\Core\GestoreEmail;

class InterfacciaGrafica
{
    private FileConfigurazione $fileConfigurazione;
    
    private array $elencoMatricole;
    private string $cdl;
    private string $dataLaurea;

    /**
     * Pressione del pulsante "Genera Prospetti" che avvia la generazione dei prospetti per le matricole selezionate, il corso di laurea e la data di laurea specificati.
     */
    public function GeneraProspetti(array $matricole, string $cdl, string $dataLaurea): void
    {
        $this->elencoMatricole = $matricole;
        $this->cdl = $cdl;
        $this->dataLaurea = $dataLaurea;

        $prospetto_commissione = new ProspettoCommissione($this->elencoMatricole, $this->cdl, $this->dataLaurea);
        $prospetto_commissione->GeneraProspettoCommissione();

        $this->response(true, 'success', 'Prospetti generati con successo');
    }

    /**
     * Pressione del pulsante "Apri Prospetti" che avvia l'apertura dei prospetti per il corso di laurea specificato.
     */
    public function ApriProspetti(string $cdl): void
    {
        $this->cdl = $cdl;

        $file = dirname(__DIR__, 2) . '/prospetti/' . $cdl . '/commissione.pdf';

        if (!file_exists($file)) {
            $this->response(false, 'error', 'Non ho trovato nessun prospetto da aprire per questo CdL');
            return;
        }

        $pdfUrl = '/Laureandosi-Unipi-Project/prospetti/' . $cdl . '/commissione.pdf';
        $this->response(true, 'success', 'Prospetti aperti in una nuova scheda', ['pdfUrl' => $pdfUrl]);
    }

    /**
     * Pressione del pulsante "Invia Prospetti" che avvia l'invio dei prospetti per il corso di laurea specificato.
     */
    public function InviaProspetti(string $cdl): array
    {
        $cartella      = dirname(__DIR__, 2) . '/prospetti/' . $cdl . '/';
        $fileLaureandi = $cartella . 'laureandi.json';
        $fileCoda      = $cartella . 'coda_invio.json';

        // Controllo che esista la cartella e il file con i dati dei laureandi
        if (!is_dir($cartella) || !file_exists($fileLaureandi)) {
            return [
                'success'  => false,
                'type'     => 'error',
                'message'  => 'Non ci sono prospetti da inviare per il CdL selezionato.',
                'finished' => true,
            ];
        }

        $laureandi = json_decode(file_get_contents($fileLaureandi), true);

        // --- Prima chiamata: costruisco la coda ---
        // Se il file coda non esiste siamo alla prima chiamata del loop,
        // quindi costruiamo la lista dei PDF da inviare e la salviamo su disco.
        // Le chiamate successive troveranno già il file e salteranno questo blocco.
        if (!file_exists($fileCoda)) {

            // glob() restituisce un array con i percorsi di tutti i file
            // che corrispondono al pattern — come una "ls *.pdf" da terminale
            $tuttiiPdf = glob($cartella . '*.pdf');

            // array_filter() mantiene solo gli elementi per cui la funzione
            // restituisce true. basename() estrae solo il nome del file dal percorso.
            // array_values() ricostruisce gli indici 0,1,2,... dopo il filter
            $prospettiStudenti = array_values(array_filter(
                $tuttiiPdf,
                fn($p) => basename($p) !== 'commissione.pdf'
            ));

            if (empty($prospettiStudenti)) {
                return [
                    'success'  => false,
                    'type'     => 'warning',
                    'message'  => 'Non ci sono prospetti da inviare.',
                    'finished' => true,
                ];
            }

            $coda = [
                'totale'  => count($prospettiStudenti),
                'inviati' => 0,
                'file'    => $prospettiStudenti,
            ];

            file_put_contents($fileCoda, json_encode($coda, JSON_PRETTY_PRINT));
        }

        // Leggo la coda dal disco
        $coda = json_decode(file_get_contents($fileCoda), true);

        // Coda già vuota: invio già completato in una chiamata precedente
        if (empty($coda['file'])) {
            @unlink($fileCoda);
            return [
                'success'  => true,
                'type'     => 'success',
                'message'  => 'Invio completato.',
                'finished' => true,
            ];
        }

        // --- Invio del prossimo prospetto ---

        // array_shift() rimuove e restituisce il primo elemento dell'array,
        // come poll() su una coda in Java
        $percorsoCorrente = array_shift($coda['file']);
        $nomeFile         = basename($percorsoCorrente);             // es. "123456.pdf"
        $matricola        = pathinfo($nomeFile, PATHINFO_FILENAME);  // es. "123456"

        $emailDestinatario = $laureandi[$matricola]['email'] ?? null;

        if (empty($emailDestinatario)) {
            return [
                'success'  => false,
                'type'     => 'error',
                'message'  => "Email mancante per la matricola $matricola. Invio interrotto.",
                'finished' => true,
            ];
        }

        // InviaEmailConAllegato accetta solo il nome del file (non il percorso completo)
        // perché costruisce il percorso internamente a partire dal cdl
        $gestoreEmail = new GestoreEmail($cdl);
        $esito        = $gestoreEmail->InviaEmailConAllegato($emailDestinatario, $nomeFile);

        if (!$esito['success']) {
            // In caso di errore restituisco subito senza aggiornare la coda,
            // così il frontend può mostrare l'errore e fermarsi
            $esito['finished'] = true;
            return $esito;
        }

        // Successo: cancello il PDF inviato e aggiorno la coda
        unlink($percorsoCorrente);
        $coda['inviati']++;
        $finito = empty($coda['file']);

        if ($finito) {
            @unlink($fileCoda);
        } else {
            file_put_contents($fileCoda, json_encode($coda, JSON_PRETTY_PRINT));
        }

        return [
            'success'  => true,
            'type'     => $finito ? 'success' : 'progress',
            'message'  => $finito
                ? 'Invio completato.'
                : 'Inviato il prospetto n° ' . $coda['inviati'] . ' di ' . $coda['totale'],
            'finished' => $finito,
        ];
    }

    public function getElencoMatricole(): array { return $this->elencoMatricole; }
    public function getCdl(): string { return $this->cdl; }
    public function getDataLaurea(): string { return $this->dataLaurea; }

    public function response(
        bool $success = true,
        string $type = '',
        string $message = '',
        array $data = []): void
    {
        echo json_encode(
            [
            'success' => $success,
            'type' => $type,
            'message' => $message,
            'data' => $data
            ]
        );
    }
}
