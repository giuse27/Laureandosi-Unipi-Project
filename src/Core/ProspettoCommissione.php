<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;
use Mpdf\Mpdf;

use function Laureandosi\API\inviaRisposta;

class ProspettoCommissione
{
    private FileConfigurazione $fileConfigurazione;

    private array $elencoLaureandi;
    private string $cdl;
    private string $dataLaurea;

    /**
     * Costruttore di Prospetto Commissione
     */
    public function __construct(array $mat, string $cdl, string $data)
    {
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
    public function GeneraProspettoCommissione() : void
    {
        
    }

}
