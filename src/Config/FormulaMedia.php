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



    public function __construct(array $dati) {

        $this->cdl              = (string)  ($dati['cdl']               ?? $this->cdlShort  );
        $this->cdlAlt           = (string)  ($dati['cdlAlt']            ?? ''               );
        $this->cdlShort         = (string)  ($dati['cdlShort']          ?? ''               );
        $this->formulaLaurea    = (string)  ($dati['formulaLaurea']     ?? ''               );
        $this->totCFU           = (int)     ($dati['totCFU']            ?? 0                );
        $this->forceThesisValue = (string)  ($dati['forceThesisValue']  ?? false            );
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

}