<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\API\GestioneCarrieraStudente;
use Laureandosi\Core\CarrieraLaureando;
use Laureandosi\Core\Esame;
use Laureandosi\Core\EsameInformatico;
use Laureandosi\Config\FileConfigurazione;
use DateTime;

class CarrieraLaureandoInf extends CarrieraLaureando
{
    private bool $bonus;
    private float $mediaInf;

    public function __construct(string $mat, string $cdl, string $data)
    {
        // Chiamo il costruttore della classe base per creare la carriera del laureando
        parent::__construct($mat, $cdl, $data);

        $config = new FileConfigurazione();

        // dobbiamo modificare esamiValidi[] del genitore in quanto adesso gli esami potrebbero anche essere informatici
        $this->esamiValidi = [];

        $datiCarriera = GestioneCarrieraStudente::RestituisciCarrieraStudente($mat);
        $carriera = json_decode($datiCarriera, true);

        if (isset($carriera['Esami']['Esame']) && is_array($carriera['Esami']['Esame'])) {

            foreach ($carriera['Esami']['Esame'] as $esame) {

                if ($esame['SOVRAN_FLG'] === 0 && $config->fileFiltroEsami->isValid($esame['DES'], $cdl, $mat)) {
                    if ($config->fileFiltroEsamiInformatici->isInformatico($esame['DES'])) {
                        $e = new EsameInformatico($esame, $cdl, $mat);
                    } else {
                        $e = new Esame($esame, $cdl, $mat);
                    }
                    $this->esamiValidi[] = $e;
                }

            }
        }

        // gestione del bonus
        // recupero anno di immatricolazione e data di chiusura dal primo esame della carriera, se presenti
        $annoImmatricolazione = $data['Esami']['Esame'][0]['ANNO_IMM'] ?? null;
        $dataChiusura = $data['Esami']['Esame'][0]['DATA_CHIUSURA'] ?? null;
        if ($annoImmatricolazione !== null && $dataChiusura !== null) {
            $this->bonus = $this->controlloBonus($annoImmatricolazione, $dataChiusura);
        } else {
            $this->bonus = false;
        }

        // ricalcola CFU e media dopo aver ricostruito EsamiValidi
        $this->cfuTotali = $this->getTotaleCfu();
        $this->cfuMedia = $this->getCfuMedia();
        $this->media = $this->getMedia();
        $this->mediaInf = $this->getMediaEsamiInformatici();

    }

    public function controlloBonus($annoImmatricolazione, $dataChiusura): bool
    {
        // Il bonus è applicato se il laureando termina i suoi studi entro il 01/03 del quarto anno
        $dataLimite = DateTime::createFromFormat('d/m/Y', '01/03/'.($annoImmatricolazione + 4));
        $dataChiusura = DateTime::createFromFormat('d/m/Y', $dataChiusura);
        if( $dataChiusura <= $dataLimite) {
            $this->applicaBonus();
            return true;
        }
        return false;
    }

    public function applicaBonus(): void
    {
        // Individua l'esame peggior valutato tra quelli che contano per la media 
        /** @var Esame $worst */
        $worst = null;

        /** @var Esame $esame */
        foreach ($this->esamiValidi as $esame) {
            if (empty($esame->isFaMedia())) {
                // ignoro gli esami che non fanno media
                continue;
            }
            if (!$esame->getVoto() !== null || !is_numeric($esame->getVoto())) {
                // ignoro i voti non numerici (teoricamente non dovrebbe servire)
                continue;
            }

            $voto = $esame->getVoto();
            if ($worst === null
                || $voto < $worst->getVoto()
                || ($voto == $worst->getVoto() && ($esame->getCfu() ?? 0) > ($worst->getCfu() ?? 0))) {
                $worst = $esame;
            }
        }

        if ($worst !== null) {
            $worst->setFaMedia(false);
            // ricalcola subito CFU e media
            $this->cfuTotali = $this->getTotaleCfu();
            $this->cfuMedia = $this->getCfuMedia();
            $this->media = $this->getMedia();
        }
    }

    public function getMediaEsamiInformatici(): float
    {
        $media_pesata = 0.0;
        $somma_pesata = 0;
        $somma_cfu = 0;

        /** @var EsameInformatico $esame */
        foreach ($this->esamiValidi as $esame) {

            if ($esame instanceof EsameInformatico && $esame->isFaMedia()) {
                $somma_pesata += $esame->getVoto() * $esame->getCfu();
                $somma_cfu += $esame->getCfu();
            }

        }

        if ($somma_cfu > 0) {
            $media_pesata = $somma_pesata / $somma_cfu;
        }

        return $media_pesata;
    }

}