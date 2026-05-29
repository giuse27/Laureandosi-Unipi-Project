<?php

namespace Laureandosi\Core;

use Laureandosi\Config\FileConfigurazione;

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
