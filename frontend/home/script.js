/**
 * frontend/home/script.js
 * Logica di front-end in javascript.
 */

// ==========================================
// 1. INIZIALIZZAZIONE
// ==========================================

// Esegue il caricamento dei CdL e imposta i listener sui bottoni
document.addEventListener('DOMContentLoaded', async () => {

    await caricaCdl();

    document.getElementById('btn-crea').addEventListener('click', () => eseguiAzione('btn-crea'));
    document.getElementById('btn-apri').addEventListener('click', () => eseguiAzione('btn-apri'));
    document.getElementById('btn-invia').addEventListener('click', () => eseguiAzione('btn-invia'));

});

// ==========================================
// 2. FUNZIONI PRINCIPALI
// ==========================================

// coordina la lettura, la validazione, fetch e reset
async function eseguiAzione(action) {

    // 1. Prelevo i dati puliti
    const formData = getFormData();

    // 2. Valido i dati
    const validation = validateForm(action, formData);
    if (!validation.valid) {
        setStatus('warning', validation.message);
        return; // Ferma tutto se la validazione fallisce
    }

    // 3. Preparo l'operazione
    setStatus('loading', 'Operazione in corso…');

    const body = new FormData();
    body.append('action', action);
    body.append('cdl', formData.cdl);
    body.append('data_laurea', formData.data_laurea);
    body.append('matricole', JSON.stringify(formData.matricoleArray));

    // 4. Eseguo la chiamata al server
    try {
        const res = await fetch('src/API/GestoreRichieste.php', { method: 'POST', body });
        const json = await res.json();

        const tipoStatus = json.type || (json.success ? 'success' : 'error');
        setStatus(tipoStatus, json.message ?? 'Operazione completata con successo.');

        // 5. Apertura prospetti in nuova scheda
        if (action === 'btn-apri' && tipoStatus === 'success' && json.data?.pdfUrl) {
            window.open(json.data.pdfUrl, '_blank');
        }

        // 6. Reset condizionale
        if (tipoStatus === 'success') {
            resetForm();
        }

    } catch (err) {
        setStatus('error', 'Errore critico di comunicazione: ' + err.message);
        console.error(err);
    }
}

async function caricaCdl() {

    try {
        const richiesta = await fetch('src/API/GestoreRichieste.php?action=get_elenco_cdl');
        const cdl_json = await richiesta.json();

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

// Invia UNA mail per richiesta, aggiorna messaggio, e ripete finché finished=true o error=true
async function sendNext(form, msgElem) {
  const fd = new FormData(form);
  fd.set("action", "btn-invia");
  fd.set("ajax", "1");

  const res = await fetch("./API/GestoreRichieste.php", { method: "POST", body: fd });

  // Se il server non risponde JSON valido, catturiamo la risposta testuale per debug
  let data;
  try {
    data = await res.json(); // {error, message, finished}
    } catch (err) {
      const text = await res.text();
      console.error('Invalid JSON from server:', text);
      if (msgElem) {
        msgElem.textContent = 'Risposta server non valida: ' + text;
      }
      throw new Error('Invalid JSON from server');
    }

  if (msgElem) {
    msgElem.textContent = (data.message || "").trim();
  }

  if (data.error) return data;
  if (data.finished) return data;

  // attendo 15 secondi prima del prossimo invio
  await new Promise((r) => setTimeout(r, 15000));
  return await sendNext(form, msgElem);
}

// ==========================================
// 3. FUNZIONI DI SUPPORTO (HELPERS)
// ==========================================

/**
 * Estrae e pulisce tutti i dati dal form HTML
 */
function getFormData() {
    const cdl = document.getElementById('cdl').value;
    const data_laurea = document.getElementById('data-laurea').value;
    const matricoleText = document.getElementById('matricole').value;

    const matricoleArray = matricoleText
        .split(/[\n, ]+/)
        .map(m => m.trim())
        .filter(m => m !== "")
        .map(m => Number(m))
        .filter(m => !isNaN(m));

    return { cdl, data_laurea, matricoleText, matricoleArray };
}

/**
 * Controlla che i dati siano sufficienti per l'azione richiesta
 * Ritorna un oggetto { valid: boolean, message: string }
 */
function validateForm(action, data) {
    const { cdl, data_laurea, matricoleText, matricoleArray } = data;

    if (action === 'btn-crea' && (!cdl || !data_laurea || matricoleArray.length === 0)) {
        let msg = ''; // Aggiunto 'let' per evitare di creare una variabile globale
        
        if (!cdl && data_laurea && matricoleArray.length !== 0)  msg = 'inserisci il CdL.';
        if (cdl && !data_laurea && matricoleArray.length !== 0)  msg = 'inserisci la data di laurea.';
        if (cdl && data_laurea && matricoleArray.length === 0 && !matricoleText) msg = 'inserisci le matricole.';
        if (cdl && data_laurea && matricoleArray.length === 0 && matricoleText)  msg = 'i numeri delle matricole non sono validi.';
        if (!cdl && !data_laurea && matricoleArray.length !== 0) msg = 'inserisci il CdL e la data di laurea.';
        if (!cdl && data_laurea && matricoleArray.length === 0)  msg = 'inserisci il CdL e le matricole.';
        if (cdl && !data_laurea && matricoleArray.length === 0)  msg = 'inserisci la data di laurea e le matricole.';
        if (!cdl && !data_laurea && matricoleArray.length === 0) msg = 'inserisci CdL, la data di laurea e le matricole.';
        
        return { valid: false, message: `Dati mancanti per la generazione dei prospetti: ${msg}` };
    }
    
    if (action === 'btn-apri' && !cdl) {
        return { valid: false, message: "Seleziona un Corso di Laurea per aprire i prospetti." };
    }
    
    if (action === 'btn-invia' && !cdl) {
        return { valid: false, message: "Seleziona un Corso di Laurea per inviare i prospetti." };
    }

    return { valid: true, message: '' };
}

/**
 * Svuota i campi di input
 */
function resetForm() {
    document.getElementById('cdl').value = '';
    document.getElementById('data-laurea').value = '';
    document.getElementById('matricole').value = '';
}

/**
 * Aggiorna visivamente la barra di stato
 */
function setStatus(type, msg) {
    const dot = document.getElementById('status-dot');
    const bar = document.getElementById('status-bar');
    const txt = document.getElementById('status-text');
    dot.className = `status-bar__dot status-bar__dot--${type}`;
    bar.className = `status-bar status-bar--${type}`;
    txt.textContent = msg;
}