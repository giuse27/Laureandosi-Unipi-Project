<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\API\GestioneCarrieraStudente;
use Laureandosi\Config\FileConfigurazione;
use Laureandosi\Core\Esame;

class CarrieraLaureando
{
    protected string $matricola;
    protected string $cdl;
    protected string $dataLaurea;
    /** @var Esame[] */
    protected array $esamiValidi = [];
    protected int $cfuTotali = 0;
    protected int $cfuMedia = 0;
    protected float $media = 0.0;

    public function __construct(string $mat, string $cdl, string $data)
    {
        $this->matricola = $mat;
        $this->cdl = $cdl;
        $this->dataLaurea = $data;
        $datiCarriera = GestioneCarrieraStudente::RestituisciCarrieraStudente($mat);
        $carriera = json_decode($datiCarriera, true);

        // aggiungo gli esami alla carriera del laureando
        $config = new FileConfigurazione();

        foreach ($carriera['Esami']['Esame'] as $esame) {
            if ($esame['SOVRAN_FLG'] === 0 && $config->fileFiltroEsami->isValid($esame['DES'], $cdl, $mat)) {
                $e = new Esame($esame, $cdl, $mat);
                $this->esamiValidi[] = $e;
            }
        }

        // Calcola subito CFU e Media dopo aver recuperato gli esami e salvo i risultati nelle proprietà della classe
        $this->cfuTotali = $this->getTotaleCfu();
        $this->cfuMedia = $this->getCfuMedia();
        $this->media = $this->getMedia();
    }

    public function getTotaleCfu(): int
    {
        $cfu_totali = 0;

        /** @var Esame $esame */
        foreach ($this->esamiValidi as $esame) {
            $cfu_totali += $esame->getCfu();
        }

        return $cfu_totali;
    }

    public function getCfuMedia(): int
    {
        $cfu_media = 0;

        /** @var Esame $esame */
        foreach ($this->esamiValidi as $esame) {
            if($esame->isFaMedia()) {
                $cfu_media += $esame->getCfu();
            }
        }

        return $cfu_media;
    }

    public function getMedia(): float
    {
        $media_pesata = 0.0;
        $somma_pesata = 0;

        // per calcolare la media pesata sommo voto*cfu e divido per cfuMedia
        /** @var Esame $esame */
        foreach ($this->esamiValidi as $esame) {
            if($esame->isFaMedia()) {
                $somma_pesata += $esame->getVoto() * $esame->getCfu();
            }
        }

        if ($this->cfuMedia > 0) {
            $media_pesata = $somma_pesata / $this->cfuMedia;
        }
        
        return $media_pesata;
    }

}
