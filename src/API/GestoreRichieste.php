<?php

declare(strict_types = 1);

/**
 * src/API/RequestHandler.php
 *
 * Single entry point per tutte le richieste AJAX del frontend.
 * Tutte le chiamate passano di qui; RequestHandler smista per 'action'.
 */

require_once  dirname(__DIR__, 2) . '/vendor/autoload.php';

// specifico a chi legge i dati che glieli sto mandando in formato json codificati in utf-8
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

// cerco un parametro di tipo action all'interno della richiesta
$action = $_REQUEST['action'] ?? '';

// qui avviene il reindirizzamento sulla base del valore di action
switch ($action) {

}