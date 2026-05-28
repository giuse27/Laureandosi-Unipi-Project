/**
 * frontend/home/script.js
 * Logica di front-end in javascript.
 */

document.addEventListener('DOMContentLoaded', async () => {
    await caricaCdl();

    document.getElementById('btn-crea').addEventListener('click', () => eseguiAzione('btn-crea'));
    document.getElementById('btn-apri').addEventListener('click', () => eseguiAzione('btn-apri'));
    document.getElementById('btn-invia').addEventListener('click', () => eseguiAzione('btn-invia'));
});

// La funzione caricaCdl restituisce l'elenco dei corsi di laurea per il menù a tendina
async function caricaCdl() {
    try {
        const richiesta = await fetch('src/API/GestoreRichieste.php?action=get_elenco_cdl');
        const cdl_json = await richiesta.json();

        // MODIFICA: Uso .message invece di .error per stampare il testo corretto
        if (!cdl_json.success) throw new Error(cdl_json.message);

        const select = document.getElementById('cdl');
        cdl_json.data.forEach(corso => {
            const opt = document.createElement('option');
            opt.value = corso.cdlShort;
            opt.textContent = corso.cdlAlt;
            select.appendChild(opt);
        });

    } catch (err) {
        setStatus('error', `Impossibile caricare i CdL: ${err.message}`);
    }
}

// Esegue le azioni dei pulsanti
async function eseguiAzione(action) {
    const cdl = document.getElementById('cdl').value;
    const data_laurea = document.getElementById('data-laurea').value;
    const matricoleText = document.getElementById('matricole').value;

    // MODIFICA: Logica di estrazione e pulizia matricole
    const matricoleArray = matricoleText
        .split(/[\n, ]+/)
        .map(m => m.trim())
        .filter(m => m !== "")
        .map(m => Number(m))
        .filter(m => !isNaN(m));

    
    // --- 1. VALIDAZIONE BASE ---
    if (action === 'btn-crea' && (!cdl || !data_laurea || matricoleArray.length === 0)) {
        msg = '';
        if (!cdl && data_laurea && matricoleArray.length !== 0)     msg = 'inserisci il CdL.';
        if (cdl && !data_laurea && matricoleArray.length !== 0)     msg = 'inserisci la data di laurea.';
        if (cdl && data_laurea && matricoleArray.length === 0 && !matricoleText)    msg = 'inserisci le matricole';
        if (cdl && data_laurea && matricoleArray.length === 0 && matricoleText)     msg = 'i numeri delle matricole non sono validi.'
        if (!cdl && !data_laurea && matricoleArray.length !== 0)    msg = 'inserisci il CdL e la data di laurea.';
        if (!cdl && data_laurea && matricoleArray.length === 0)     msg = 'inserisci il CdL e le matricole.';
        if (cdl && !data_laurea && matricoleArray.length === 0)     msg = 'inserisci la data di laurea e le matricole.';
        if (!cdl && !data_laurea && matricoleArray.length === 0)    msg = 'inserisci CdL, la data di laurea e le matricole.';
        setStatus('warning', `Dati mancanti per la generazione dei prospetti: ${msg}`);
        return; // Ferma tutto
    }
    
    if (action === 'btn-apri' && !cdl) {
        setStatus('warning', "Seleziona un Corso di Laurea per aprire i prospetti.");
        return; // Ferma tutto
    }
    
    if (action === 'btn-invia' && !cdl) {
        setStatus('warning', "Seleziona un Corso di Laurea per inviare i prospetti.");
        return; // Ferma tutto
    }

    // --- 2. OPERAZIONE IN CORSO ---
    setStatus('loading', 'Operazione in corso…');

    const body = new FormData();
    body.append('action', action);
    body.append('cdl', cdl);
    body.append('data_laurea', data_laurea);
    // MODIFICA: Trasformo l'array pulito in stringa JSON prima di inviarlo
    body.append('matricole', JSON.stringify(matricoleArray));

    try {
        const res = await fetch('src/API/GestoreRichieste.php', { method: 'POST', body });
        const json = await res.json();

        // Se PHP manda un tipo, usiamo quello. Se per qualche motivo è vuoto, usiamo una logica di riserva.
        const tipoStatus = json.type || (json.success ? 'success' : 'error');
        
        // 2. Aggiorniamo la barra di stato
        setStatus(tipoStatus, json.message ?? 'Operazione completata con successo.');

        // 3. Se tutto è andato bene, svuotiamo i campi per la prossima operazione
        if (tipoStatus === 'success') {
            document.getElementById('cdl').value = '';
            document.getElementById('data-laurea').value = '';
            document.getElementById('matricole').value = '';
        }

    } catch (err) {
        // 3. Il catch scatta SOLO per errori catastrofici veri, ad esempio:
        // - (nessuna connessione)
        // - PHP è andato in "Fatal Error" o ha restituito HTML invece di JSON
        setStatus('error', 'Errore critico di comunicazione: ' + err.message);
        console.error(err);
    }
}

// Aggiornamento della barra di stato
function setStatus(type, msg) {
    const dot = document.getElementById('status-dot');
    const bar = document.getElementById('status-bar');
    const txt = document.getElementById('status-text');
    dot.className = `status-bar__dot status-bar__dot--${type}`;
    bar.className = `status-bar status-bar--${type}`;
    txt.textContent = msg;
}