<?php

namespace Laureandosi\Config;

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
}