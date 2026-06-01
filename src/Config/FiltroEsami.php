<?php

namespace Laureandosi\Config;

use Laureandosi\Core\Esame;

class FiltroEsami
{
    private array $datiJSON;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("File di configurazione non trovato in: $path");
        }

        $json = file_get_contents($path);
        $dati = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("JSON non valido: " . json_last_error_msg());
        }

        $this->datiJSON = $dati;
    }

    public function isValid(Esame $esame, string $cdl, string $mat) : bool
    {
        $nomeEsame = $esame->getNomeEsame();

        // Verifico se l'esame è presente nei filtri globali
        if (in_array($nomeEsame, $this->datiJSON['global']['NoCdl'] ?? [], true)) return false;

        // Verifico se l'esame è presente nella lista dei filtri del CdL per gli esami non validi
        if (in_array($nomeEsame, $this->datiJSON[$cdl]['NoCdl'] ?? [], true)) return false;

        // Verifico se l'esame non può essere sostenuto dallo studente specifico
        if (in_array($nomeEsame, $this->datiJSON['specific'][$mat]['NoCdl'] ?? [], true)) return false;

        return true;
    }

    public function faMedia(Esame $esame, string $cdl, string $mat): bool
    {
        $nomeEsame = $esame->getNomeEsame();

        // Verifico se l'esame è presente nei filtri globali
        if (in_array($nomeEsame, $this->datiJSON['global']['NoAvg'] ?? [], true)) return false;

        // Verifico se l'esame è presente nella lista dei filtri del CdL per gli esami che non fanno media
        if (in_array($nomeEsame, $this->datiJSON[$cdl]['NoAvg'] ?? [], true)) return false;

        // Verifico se l'esame non fa media per lo studente specifico
        if (in_array($nomeEsame, $this->datiJSON['specific'][$mat]['NoAvg'] ?? [], true)) return false;

        return true;
    }
}