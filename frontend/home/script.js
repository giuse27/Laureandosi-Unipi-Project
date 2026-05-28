/**
 * Logica di front-end in javascript.
 *
 * punti salienti:
 * 1. lettura dello stato dei pulsanti e esecuzione delle rispettive azioni
 * 2. caricamento dell'elenco dei CdL
 * 3. aggiornamento della barra di stato
 */

// Aggiungo un EventListener per ricevere le richieste mandate dai pulsanti
document.addEventListener('DOMContentLoaded', async () => {
    await caricaCdl();

    document.getElementById('btn-crea').addEventListener('click', () => eseguiAzione('genera_prospetti'));
    document.getElementById('btn-apri').addEventListener('click', () => eseguiAzione('apri_prospetti'));
    document.getElementById('btn-invia').addEventListener('click', () => eseguiAzione('invia_prospetti'));
});

// La funzione caricaCdl restituisce l'elenco dei corsi di laurea, printi per essere mostrati nel menù a tendina
async function caricaCdl() {

    try {

        const richiesta = await fetch('src/API/GestoreRichieste.php?action=get_elenco_cdl');
        const cdl_json = await richiesta.json();

        if (!cdl_json.success) throw new Error(cdl_json.error);

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

// esegue le azioni dei pulsanti
async function eseguiAzione(action) {
    const cdl        = document.getElementById('cdl').value;
    const dataLaurea = document.getElementById('data-laurea').value;
    const matricole  = document.getElementById('matricole').value;

    if (!cdl || !dataLaurea) {
        setStatus('warning', 'Seleziona CdL e data laurea prima di procedere.');
        return;
    }

    setStatus('loading', 'Operazione in corso…');

    const body = new FormData();
    body.append('action',      action);
    body.append('cdl',         cdl);
    body.append('data_laurea', dataLaurea);
    body.append('matricole',   matricole);

    try {
        const res  = await fetch('src/API/GestoreRichieste.php', { method: 'POST', body });
        const json = await res.json();

        if (!json.success) throw new Error(json.error);
        setStatus('success', json.message ?? 'Operazione completata.');

    } catch (err) {
        setStatus('error', err.message);
    }
}

// aggiornamento della barra di stato
function setStatus(type, msg) {
    const dot = document.getElementById('status-dot');
    const txt = document.getElementById('status-text');
    dot.className = `status-bar__dot status-bar__dot--${type}`;
    txt.textContent = msg;
}