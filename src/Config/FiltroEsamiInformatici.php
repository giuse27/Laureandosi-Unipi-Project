<?php

namespace Laureandosi\Config;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FiltroEsami;
use Laureandosi\Core\Esame;

class FiltroEsamiInformatici
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

    public function isValid(Esame $esame) : bool
    {
        return in_array($esame->getNomeEsame(), $this->datiJSON['esamiInfo'] ?? [], true);
    }

}