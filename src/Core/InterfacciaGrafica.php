<?php

namespace Laureandosi\Core;

use Laureandosi\Config\FileConfigurazione;
use Laureandosi\Config\FormulaMedia;

class InterfacciaGrafica
{
    private array $elencoMatricole;
    private string $cdl;
    private string $dataLaurea;
    private FileConfigurazione $fileConfigurazione;

    public function GeneraProspetti(array $matricole, string $cdl, string $dataLaurea): array
    {
        $this->elencoMatricole = $matricole;
        $this->cdl = $cdl;
        $this->dataLaurea = $dataLaurea;

        $prospettiGenerati = [];

        // Prova semplice (DA RIMUOVERE): calcola il voto di laurea con i 4 parametri passati
        // matricole dovrebbe contenere [M, CFU, T, C]
        if (count($matricole) >= 4) {
            $path = dirname(__DIR__, 2) . '/config/formule_voto_laurea.json';
            if (file_exists($path)) {
                $json = file_get_contents($path);
                $dati = json_decode($json, true);

                // Cerco la formula per il CDL
                if (isset($dati['corsi'][$cdl])) {
                    $datiFormula = $dati['corsi'][$cdl];
                    $formula = new FormulaMedia($datiFormula);

                    $M = (float)$matricole[0];
                    $CFU = (int)$matricole[1];
                    $T = (float)$matricole[2];
                    $C = (float)$matricole[3];

                    try {
                        $voto = $formula->calcolaVotoLaurea($M, $CFU, $T, $C);
                        $prospettiGenerati['voto_calcolato'] = $voto;
                        $prospettiGenerati['cdl'] = $cdl;
                    } catch (Exception $e) {
                        $prospettiGenerati['errore'] = $e->getMessage();
                    }
                }
            }
        }

        return $prospettiGenerati;
    }

    public function ApriProspetti(string $cdl): array
    {
        $risultati = [];

        return $risultati;
    }

    public function InviaProspetti(string $cdl): array
    {
        $risultati = [];

        return $risultati;
    }

    public function getElencoMatricole(): array { return $this->elencoMatricole; }
    public function getCdl(): string { return $this->cdl; }
    public function getDataLaurea(): string { return $this->dataLaurea; }
}
