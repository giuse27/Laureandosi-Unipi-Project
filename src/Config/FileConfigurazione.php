<?php

namespace Laureandosi\Config;

class FileConfigurazione
{
    private string $configDir;
    private string $path_elenco_cdl;
    private string $path_formule_e_mail;
    private string $path_filtro_esami;
    private string $path_esami_informatici;


    /**
     * Costruttore che accetta una directory di configurazione opzionale. Se non viene fornita, utilizza la directory di default.
     * 
     * configDir: Directory in cui si trovano i file di configurazione JSON. Se inserita manualmente va inserita con
     * il path relativo
     */
    public function __construct(string $configDir = '')
    {
        // Se non viene specificata una directory di configurazione, usa quella di default
        $this->configDir = $configDir ?: dirname(__DIR__, 2) . '/config';
        $this->path_elenco_cdl = $this->configDir . '/corsi_di_laurea.json';
        $this->path_formule_e_mail = $this->configDir . '/formule_voto_laurea.json';
        $this->path_filtro_esami = $this->configDir . '/filtro_esami.json';
        $this->path_esami_informatici = $this->configDir . '/esami_informatici.json';
    }

    /**
     * Restituisce l'elenco dei Corsi di Laurea dal JSON centrale.
     */
    public function getCorsiDiLaurea(): array
    {
        $path = $this->path_elenco_cdl;

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
        $path = $this->path_formule_e_mail;

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