<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\API\GestioneCarrieraStudente;

/**
 * Dati anagrafici di uno studente laureando.
 * Popolata da GestioneCarrieraStudente::restituisciAnagraficaStudente().
 */
class AnagraficaLaureando
{
    public readonly string $nome;
    public readonly string $cognome;
    public readonly string $email;

    public function __construct(string $matricola)
    {
        $studente = GestioneCarrieraStudente::RestituisciAnagraficaStudente($matricola);
        $this->nome = $studente['nome'];
        $this->cognome = $studente['cognome'];
        $this->email = $studente['EmailAteneo'];
    }

}