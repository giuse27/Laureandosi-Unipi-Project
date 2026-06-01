<?php

namespace Laureandosi\Core;

// Carico l'autoloader di Composer per far funzionare i namespace
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;
use Laureandosi\Config\FormulaMedia;


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
    }

    /**
     * Pressione del pulsante "Apri Prospetti" che avvia l'apertura dei prospetti per il corso di laurea specificato.
     */
    public function ApriProspetti(string $cdl): array
    {
        $this->cdl = $cdl;

        $response = [];

        return $response;
    }

    /**
     * Pressione del pulsante "Invia Prospetti" che avvia l'invio dei prospetti per il corso di laurea specificato.
     */
    public function InviaProspetti(string $cdl): array
    {
        $this->cdl = $cdl;

        $response = [];

        // TEST DA RIMUOVERE
        $Email = new GestoreEmail($cdl);
        $response = $Email->InviaEmailConAllegato('g.vaglica@studenti.unipi.it', 'Vaglica.pdf');

        return $response;
    }

    public function getElencoMatricole(): array { return $this->elencoMatricole; }
    public function getCdl(): string { return $this->cdl; }
    public function getDataLaurea(): string { return $this->dataLaurea; }
}
