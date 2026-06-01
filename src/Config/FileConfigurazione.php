<?php

namespace Laureandosi\Config;

class FileConfigurazione
{
    private array $elencoEsamiInformatici;
    private array $elencoEsamiFiltrati;
    private array $elencoEsamiEsclusi;
    private array $elencoFormule;

    private string $configDir;

    /**
     * Costruttore che accetta una directory di configurazione opzionale. Se non viene fornita, utilizza la directory di default.
     * 
     * configDir: Directory in cui si trovano i file di configurazione JSON.
     */
    public function __construct(string $configDir = '')
    {
        // Se non viene specificata una directory di configurazione, usa quella di default
        $this->configDir = $configDir ?: dirname(__DIR__, 2) . '/config';
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
        $corsi_di_laurea = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("JSON non valido: " . json_last_error_msg());
        }

        return $corsi_di_laurea;
    }

    /**
     * Restituisce le informazioni di configurazione per le email
     */
    public function getEmailConfig(): array 
    { 
        $path = $this->configDir . '/formule_voto_laurea.json';

        if (!file_exists($path)) {
            throw new \RuntimeException("File formule_voto_laurea.json non trovato in: $path");
        }

        $json = file_get_contents($path);
        $config = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("JSON non valido: " . json_last_error_msg());
        }

        return $config;
     }

}