<?php

declare(strict_types = 1);

namespace Laureandosi\API;

/**
 * src/API/GestoreRichieste.php
 *
 * Single entry point per tutte le richieste AJAX del frontend.
 * Tutte le chiamate passano di qui; smista per 'action'.
 */

// Carico l'autoloader di Composer per far funzionare i namespace
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;
use Laureandosi\Core\InterfacciaGrafica;

header('Content-Type: application/json; charset=utf-8');

/*
 * Gestione del CORS (Cross-Origin Resource Sharing)
 *
 * Cosa fa: Intercetta le richieste di tipo OPTIONS. Se arriva una di queste richieste, risponde con un codice di stato
 * HTTP 204 (No Content), che significa "Tutto ok, ma non c'è nessun testo da leggere", e poi ferma immediatamente
 * l'esecuzione del resto del codice PHP con exit;.
 *
 * Perché serve: Quando il tuo frontend (es. su http://localhost:3000) prova a fare una richiesta POST a un server con
 * un indirizzo diverso (es. http://localhost:8000), per motivi di sicurezza il browser invia prima una richiesta
 * "ombra" (chiamata Preflight) usando il metodo OPTIONS per chiedere al server: "Ehi, accetti chiamate da me?".
 * Questo blocco di codice accoglie quella richiesta preparatoria, la chiude con successo e lascia via libera per la
 * richiesta reale (GET, POST, ecc.) che arriverà una frazione di secondo dopo.
 */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// HELPER PER GLI ERRORI (Ferma l'esecuzione e invia un JSON pulito)
function inviaErrore(int $codiceHttp, string $messaggio): never {
    http_response_code($codiceHttp);
    inviaRisposta(false, 'error', $messaggio);
    exit();
}

function inviaRisposta(bool $success = true, string $type = '', string $message = '', array $data = []): void {
    echo json_encode(['success' => $success, 'type' => $type, 'message' => $message, 'data' => $data]);
}

// 1. ESTRAZIONE AZIONE
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if (empty($action)) {
    inviaErrore(400, "Azione non specificata");
}

// 2. ESTRAZIONE DATI POST
$cdl = trim($_POST['cdl'] ?? '');
$data_laurea = trim($_POST['data_laurea'] ?? '');

// Decodifico il JSON inviato dallo script.js
$matricole = isset($_POST['matricole']) ? json_decode($_POST['matricole'], true) : [];
if (!is_array($matricole)) {
    $matricole = []; // In caso di JSON malformato, default a array vuoto
}

$interfaccia = new InterfacciaGrafica();

// 3. ROUTING DELLA RICHIESTA
try {
    switch ($action) {
        
        // --- LETTURA (GET) ---
        case 'get_elenco_cdl':
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                inviaErrore(405, "Metodo non consentito. Usa GET.");
            }
            
            $corsi = FileConfigurazione::getCorsiDiLaurea();
            inviaRisposta(true, '', '', $corsi);
            break;

        // --- SCRITTURA / AZIONI (POST) ---
        case 'btn-crea':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                inviaErrore(405, "Metodo non consentito. Usa POST.");
            }

            // validazione dei dati già effettuata in script.js, ma rifaccio un controllo rapido per sicurezza
            if (empty($cdl) || empty($data_laurea) || empty($matricole)) {
                inviaErrore(400, "Dati mancanti o non validi in 'btn-crea'.");
            }

            $interfaccia->GeneraProspetti($matricole, $cdl, $data_laurea);

            inviaRisposta(true, '', 'Prospetti generati con successo (TODO)');
            break;

        case 'btn-apri':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                inviaErrore(405, "Metodo non consentito. Usa POST.");
            }

            // validazione dei dati già effettuata in script.js
            if (empty($cdl)) {
                inviaErrore(400, "Dati mancanti o non validi in 'btn-apri'.");
            }

            $risultati = $interfaccia->ApriProspetti($cdl);

            inviaRisposta(true, '', 'Apertura prospetti in corso (TODO)');
            break;

        case 'btn-invia':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                inviaErrore(405, "Metodo non consentito. Usa POST.");
            }
            
            // validazione dei dati già effettuata in script.js
            if (empty($cdl)) {
                inviaErrore(400, "Dati mancanti o non validi in 'btn-invia'.");
            }

            $risultati = $interfaccia->InviaProspetti($cdl);
            
            inviaRisposta($risultati['success'], $risultati['type'], $risultati['message']);
            break;

        default:
            inviaErrore(400, "Azione '$action' non riconosciuta");
    }

} catch (\Exception $e) {
    // GESTIONE ECCEZIONI GLOBALI
    inviaErrore(500, "Errore interno del server: " . $e->getMessage());
}

// Chiusura sicura
exit();