<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;

class Esame
{
    // Qui usiamo campi protected perché la classe EsameInformatico vi dovrà accedere
    protected string $nomeEsame;
    protected string $codiceEsame;
    protected int    $cfu;
    protected int    $voto;

    /*
     * true  → l'esame concorre alla media ponderata
     * false → esame presente in carriera ma escluso dal calcolo
     */
    protected bool $faMedia;

    /*
     * true → esame sostenuto come sovranumerario.
     * Un esame sovranumerario NON entra nella media anche se faMedia fosse true;
     * la logica di esclusione è in carico a chi popola faMedia, ma il flag
     * è conservato per trasparenza nel prospetto.
     */
    protected bool $sovranFlag;

    // true → il voto è 30 con lode
    protected bool $lode;

    public function __construct(array $esameJSON, string $cdl, string $mat)
    {
        $this->nomeEsame = $esameJSON['DES'] ?? '';
        $this->codiceEsame = $esameJSON['COD'] ?? '';

        $this->cfu = isset($esameJSON['PESO']) ? (int)$esameJSON['PESO'] : 0;

        $fileConfig = new FileConfigurazione();
        $this->voto = (
            $esameJSON['VOTO'] === "30 e lode" ||
            $esameJSON['VOTO'] === "30  e lode " ||
            $esameJSON['VOTO'] === "30L"
        ) ? $fileConfig->fileMediaEEmail->getLodeValue() : (int)$esameJSON['VOTO'];

        $this->faMedia = $fileConfig->fileFiltroEsami->faMedia($this->nomeEsame, $cdl, $mat);

        $this->sovranFlag = (bool)($esameJSON['SOVRAN_FLAG'] ?? false);
        $this->lode = (bool)($this->voto > 30);

        $this->validate();
    }

    /**
     * Validazione interna per accertarsi che non ci siano errori su voti e cfu
     */
    protected function validate(): void
    {
        if ($this->cfu <= 0) {
            throw new \InvalidArgumentException(
                "Esame '{$this->nomeEsame}': CFU deve essere > 0, ricevuto {$this->cfu}"
            );
        }

        if ($this->voto < 18 || $this->voto > 30) {
            throw new \InvalidArgumentException(
                "Esame '{$this->nomeEsame}': voto deve essere tra 18 e 30, ricevuto {$this->voto}"
            );
        }

        if ($this->lode && $this->voto !== 30) {
            throw new \InvalidArgumentException(
                "Esame '{$this->nomeEsame}': la lode è possibile solo con voto 30"
            );
        }
    }

    /**
     * Funzioni getter di utilità
     */
    public function getNomeEsame(): string { return $this->nomeEsame; }
    public function getCodiceEsame(): string { return $this->codiceEsame; }
    public function getCfu(): int { return $this->cfu; }
    public function getVoto(): int { return $this->voto; }
    public function isFaMedia(): bool { return $this->faMedia; }
    public function isSovranFlag(): bool { return $this->sovranFlag; }
    public function isLode(): bool { return $this->lode; }

    public function setFaMedia(bool $faMedia): void { $this->faMedia = $faMedia; }

}