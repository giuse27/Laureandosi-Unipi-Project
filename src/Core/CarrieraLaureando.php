<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\API\GestioneCarrieraStudente;
use Laureandosi\Config\FileConfigurazione;

class CarrieraLaureando
{
    private string $matricola;
    private string $cdl;
    private string $dataLaurea;
    private array $esamiValidi = [];
    private int $cfuTotali = 0;
    private int $cfuMedia = 0;
    private float $media = 0.0;

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
            if ($esame['SOVRAN_FLG'] === 0 && $config->isValid($esame['DES'], $cdl, $mat)) {
                $e = new Esame($esame, $cdl, $mat);
                $this->EsamiValidi[] = $e;
            }
        }

        // Calcola subito CFU e Media dopo aver recuperato gli esami e salvo i risultati nelle proprietà della classe
        // $this->ContaCFU();
        // $this->CalcolaMediaPesata();
    }

}
