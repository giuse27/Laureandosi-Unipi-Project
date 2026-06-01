<?php

namespace Laureandosi\Core;

// Carico l'autoloader di Composer per far funzionare i namespace
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

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

        // TEST DA RIMUOVERE
        $Email = new GestoreEmail($cdl);
        $risultati = $Email->InviaEmail('g.vaglica@studenti.unipi.it', 'Vaglica.pdf');

        return $risultati;
    }

    public function getElencoMatricole(): array { return $this->elencoMatricole; }
    public function getCdl(): string { return $this->cdl; }
    public function getDataLaurea(): string { return $this->dataLaurea; }
}
