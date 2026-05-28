<?php

namespace Laureandosi\Config;

class FileConfigurazione
{
    private array $elencoEsamiInformatici;
    private array $elencoEsamiFiltrati;
    private array $elencoEsamiEsclusi;
    private array $elencoFormule;

    private string $configDir;

    public function __construct(array $elencoFile = [])
    {
        $this->configDir = dirname(__DIR__, 2) . '/config';
        // inizializzazione da elencoFile...
    }

    /**
     * Restituisce l'elenco dei Corsi di Laurea dal JSON centrale.
     */
    public static function getCorsiDiLaurea(): array
    {
        $path = dirname(__DIR__, 2) . '/config/corsi_di_laurea.json';

        if (!file_exists($path)) {
            throw new \RuntimeException("File corsi_di_laurea.json non trovato in: $path");
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("JSON non valido: " . json_last_error_msg());
        }

        return $data;
    }

    public function getFiltroEsami(): FiltroEsami { /* ... */ }
    public function getFiltroEsamiInf(): FiltroEsamiInformatici { /* ... */ }
    public function getFormule(): array { /* ... */ }
}