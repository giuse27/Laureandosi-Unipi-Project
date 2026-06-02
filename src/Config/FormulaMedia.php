<?php

namespace Laureandosi\Config;

/**
 * Incapsula la formula di calcolo del voto di laurea per un singolo CdL.
 *
 * I dati provengono dal blocco "corsi.{cdlShort}" di formule_voto_laurea.json:
 *
 *   "Tinf": {
 *     "cdl":            "T. Ing. Informatica",
 *     "cdlAlt":         "INGEGNERIA INFORMATICA (IFO-L)",
 *     "cdlShort":       "Tinf",
 *     "formulaLaurea":  "M*3+18+T+C",
 *     "totCFU":         177,
 *     "parT":           { "min": 1, "max": 3, "step": 0 },
 *     "parC":           { "min": 1, "max": 7, "step": 1 },
 *     "forceThesisValue": true,
 *     "notaFinale":     "..."
 *   }
 *
 * Le variabili nella stringa formulaLaurea sono:
 *   M   → media ponderata (su 30)
 *   CFU → CFU totali usati per la media
 *   T   → bonus tesi (scelto dalla commissione, range parT)
 *   C   → bonus commissione / carriera (range parC)
 */

class FormulaMedia {

    private string $path;
    private array $datiJson;
    private int $lodeValue;

    public function __construct(string $path) {

        $this->path = $path;

        if (!file_exists($path)) {
            throw new \RuntimeException("File di configurazione non trovato in: $path");
        }

        $json = file_get_contents($path);
        $dati = json_decode($json, true);
        $this->datiJson = $dati;

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("JSON non valido: " . json_last_error_msg());
        }

        $this->lodeValue = (int)($dati['lode']?? 0);

    }

    // =========================================================================
    // Funzioni Getter, di utilità per recuperare i valori privati
    // =========================================================================
    
    public function getJsonData(): array 
    {
        return $this->datiJson;
    }

    public function getLodeValue(): int
    {
        return $this->lodeValue;
    }

    public function getCfuNecessari(string $cdlShort): int
    {
        return (int)($dati['corsi'][$cdlShort]['totCFU']);
    }

}