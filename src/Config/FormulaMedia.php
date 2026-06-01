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

    // Dati identificativi
    private string $cdl;
    private string $cdlAlt;
    private string $cdlShort;

    // Formula grezza e CFU totali del piano di studi
    private string $formulaLaurea;
    private int    $totCFU;

    // Range del parametro T (voto/bonus tesi)
    private float $parTMin;
    private float $parTMax;
    private float $parTStep;

    // Range del parametro C (bonus commissione)
    private float $parCMin;
    private float $parCMax;
    private float $parCStep;

    /**
     * Se true, il voto di tesi ha un valore fisso scelto dalla commissione
     * e NON è una variabile libera nella formula.
     */
    private bool $forceThesisValue;

    private string $notaFinale;

    // Dati globali del JSON (soglia lode, titoli)
    private int    $lodeValue;   // valore oltre cui proporre la lode (es. 33 in trentesimi)



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

        $this->cdlShort         = (string)  ($dati['cdlShort']          ?? ''               );
        $this->cdlAlt           = (string)  ($dati['cdlAlt']            ?? ''               );
        $this->cdl              = (string)  ($dati['cdl']               ?? $this->cdlShort  );
        $this->formulaLaurea    = (string)  ($dati['formulaLaurea']     ?? ''               );
        $this->totCFU           = (int)     ($dati['totCFU']            ?? 0                );
        $this->forceThesisValue = (bool)    ($dati['forceThesisValue']  ?? false            );
        $this->notaFinale       = (string)  ($dati['notaFinale']        ?? ''               );
        $this->lodeValue        = (int)     ($dati['lode']              ?? 0                );

        $parT = $dati['parT'] ?? [];
        $this->parTMin          = (float)   ($parT['min']               ?? 0                );
        $this->parTMax          = (float)   ($parT['max']               ?? 0                );
        $this->parTStep         = (float)   ($parT['step']              ?? 0                );

        $parC = $dati['parC'] ?? [];
        $this->parCMin          = (float)   ($parC['min']               ?? 0                );
        $this->parCMax          = (float)   ($parC['max']               ?? 0                );
        $this->parCStep         = (float)   ($parC['step']              ?? 0                );

    }

    // =========================================================================
    // Funzioni Getter, di utilità per recuperare i valori privati
    // =========================================================================
    
    public function getJsonData(): array 
    {
        return $this->datiJson;
    }

    public function getCdl(): string           { return $this->cdl; }
    public function getCdlAlt(): string        { return $this->cdlAlt; }
    public function getCdlShort(): string      { return $this->cdlShort; }
    public function getFormulaLaurea(): string { return $this->formulaLaurea; }
    public function getTotCFU(): int           { return $this->totCFU; }
    public function isForceThesisValue(): bool { return $this->forceThesisValue; }
    public function getNotaFinale(): string    { return $this->notaFinale; }
    public function getLodeValue(): int       { return $this->lodeValue; }

    public function getParTMin(): float  { return $this->parTMin; }
    public function getParTMax(): float  { return $this->parTMax; }
    public function getParTStep(): float { return $this->parTStep; }

    public function getParCMin(): float  { return $this->parCMin; }
    public function getParCMax(): float  { return $this->parCMax; }
    public function getParCStep(): float { return $this->parCStep; }

    // =========================================================================
    // Calcolo voto di laurea
    // =========================================================================

    /**
     * Valuta la formula sostituendo le variabili M, CFU, T, C.
     *
     * Usa eval() in modo controllato: la stringa formula proviene solo
     * da un file JSON di configurazione interno, mai da input utente.
     *
     * float $M   Media ponderata (es. 27.45)
     * float $CFU CFU usati per la media
     * float $T   Bonus tesi (deve essere nel range parT)
     * float $C   Bonus commissione (deve essere nel range parC)
     *
     * float Voto calcolato (non clampato a 110; il chiamante decide)
     * InvalidArgumentException se T o C sono fuori range
     * RuntimeException se la formula contiene errori
     */

    public function calcolaVotoLaurea(float $M, int $CFU, float $T, float $C) : float
    {
        // non ho validato i parametri perché ho assunto che i dati arrivino già buoni perché non inseriti dall'utente
        // Costruisce un'espressione PHP valutabile sostituendo le variabili
        $expr = $this->formulaLaurea;
        $expr = str_replace(
            ['M',   'CFU',  'T',   'C'],
            [$M,    $CFU,   $T,    $C],
            $expr
        );

        try{
            $result = eval("return $expr;");
            return round($result, 3);
        }
        catch(Throwable $e){
            throw new Exception("Errore nel calcolo della formula: ". $e->getMessage());
        }
    }

}