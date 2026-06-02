<?php

namespace Laureandosi\Config;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Core\Esame;
use Laureandosi\Config\FormulaMedia;
use Laureandosi\Config\FiltroEsami;
use Laureandosi\Config\FiltroEsamiInformatici;

class FileConfigurazione
{
    private string $configDir;
    private string $path_elenco_cdl;

    public FormulaMedia $fileMediaEEmail;
    public FiltroEsami $fileFiltroEsami;
    public FiltroEsamiInformatici $fileFiltroEsamiInformatici;


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

        $path_formule_e_mail = $this->configDir . '/formule_voto_laurea.json';
        $path_filtro_esami = $this->configDir . '/filtro_esami.json';
        $path_esami_informatici = $this->configDir . '/esami_informatici.json';

        $this->fileMediaEEmail = new FormulaMedia($path_formule_e_mail);
        $this->fileFiltroEsami = new FiltroEsami($path_filtro_esami);
        $this->fileFiltroEsamiInformatici = new FiltroEsamiInformatici($path_esami_informatici);
    }

    private function loadJsonConfig(string $path): array
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("File di configurazione non trovato in: $path");
        }

        $json = file_get_contents($path);
        $config = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("JSON non valido: " . json_last_error_msg());
        }

        return $config;
    }

    /**
     * Restituisce l'elenco dei Corsi di Laurea dal JSON centrale.
     */
    public function getCorsiDiLaurea(): array
    {
        return $this->loadJsonConfig($this->path_elenco_cdl);
    }

    public function getNomeCdl($cdlShort): string
    {
        $dati = $this->fileMediaEEmail->getJsonData();
        return (string)($dati['corsi'][$cdlShort]['cdl']);
    }

}