# 02 - Front-end del sito

- [02 - Front-end del sito](#02---front-end-del-sito)
  - [Prerequisiti](#prerequisiti)
  - [Come vanno gestiti i file? (domanda per neofiti come me)](#come-vanno-gestiti-i-file-domanda-per-neofiti-come-me)
  - [Generazione dell'interfaccia grafica di Laureandosi](#generazione-dellinterfaccia-grafica-di-laureandosi)

---

> [!caution] **NOTA BENE**  
> Questo tutorial ha validità solo se si è scelto di seguire il mio stesso approccio, ovvero mediante l'utilizzo di uno stile personalizzato e l'abbandono di WordPress.

## Prerequisiti

Il prerequisito per questo tutorial è di aver seguito il precedente, ovvero [**01 - Creazione iniziale del sito**](./01%20-%20Creazione%20iniziale%20del%20sito.md)

## Come vanno gestiti i file? (domanda per neofiti come me)

Se sai le basi di PWEB puoi tranquillamente saltare questo paragrafo XD.  
Seguendo l'approccio alla creazione personalizzata del sito, per la sola parte di front-end di laureandosi e quindi l'interfaccia utente del portale, ci ritroveremo a dover implementare alcuni file. Nello specifico:

* `index.php` è l'entry point del nostro sito, all'interno del file php in realtà andremo ad inserire del linguaggio `html` che contiene lo scheletro (il layout) della pagina web. Qui saranno quindi descritti i blocchi elementari come campo data, campo di testo per le matricole, menù a tendina per la scelta del cdl, i tre pulsanti ecc.
* `frontend/home/style.css` (scelta del percorso arbitaria) conterrà lo stile (file .css) della nostra interfaccia grafica e ci permetterà di personalizzare per esempio colori e forme.
* `frontend/home/script.js` (scelta del percorso arbitaria) contiene tutta la logica elementare: cosa succede quando premo i pulsanti; come traformo una stringa di matricole in un'array di interi?

Se adottiamo queste convenzioni la struttura file del progetto che abbiamo introdotto nello scorso tutorial diventa:

```text
Laureandosi-Unipi-Project/
│
├── le_tue_cartelle_del_progetto/  
|
├── frontend/                      
│   └── home/                       
|       ├── style.cs                # grafica
|       └── script.js               # logica
|
├── vendor/                         
|   ├── [serie di librerie]         
│   └── autoload.php                
|
├── composer.json                   
├── composer.lock                   
└── index.php                       # layout  
```

## Generazione dell'interfaccia grafica di Laureandosi

In questa prima fase potete dare sfogo alla creatività e creare il sito nel modo che più vi piace. Io non ho esperienza con la creazione di pagine web anche semplici, perciò ho fatto fare l'interfaccia di laureandosi a Claude, e ho usato il seguente prompt. Ovviamente, se decidete di utilizzare anche voi lo stesso approccio, vi consiglio vivamente, come ho fatto io, di personalizzare il sito e come minimo capire come è stato realizzato.

```text
Agisci come uno sviluppatore web esperto. Devo costruire l'interfaccia grafica per un sistema web chiamato 'Laureandosi' (un Generatore di Prospetti di Laurea per le segreterie universitarie). Voglio utilizzare il mio file index.php come punto di partenza.
Regole architetturali: Voglio un codice pulito, modulare e manutenibile. Devi mantenere rigorosamente separati:
Il Layout e la struttura HTML (nel file index.php).
Lo Stile (in un file .css separato, es. style.css).
La Logica di interazione (in un file .js separato, es. script.js).
Descrizione degli elementi dell'interfaccia: L'interfaccia è utilizzata dall'Unità Didattica per generare, visualizzare e inviare i PDF dei laureandi. Sulla base delle specifiche del progetto, la pagina deve obbligatoriamente contenere questi elementi:
Un Titolo/Intestazione (es. 'Gestione Prospetti di Laurea').
Un Menù a tendina (Select) denominato 'CdL:' (Corso di Laurea) con un'opzione di default tipo 'Seleziona un CdL'.
Un Campo per l'inserimento della data (Date picker) denominato 'Data Laurea:'.
Una Textarea capiente denominata 'Matricole:', destinata ad accogliere una sequenza di numeri di matricola che l'utente incollerà (separati da spazi o a capo).
Una Zona per i messaggi di stato (es. un div o uno span) che servirà al sistema per mostrare all'utente feedback testuali come 'Prospetti creati' o messaggi di avanzamento come 'Inviato prospetto 1 di 10'.
Tre pulsanti/azioni principali:
'Crea Prospetti'
'Apri Prospetti'
'Invia Prospetti'
NOTA IMPORTANTE SUL LAYOUT E STILE: Non voglio una replica esatta e fedele del mockup originale obsoleto; sentiti libero di creare un design moderno, pulito e user-friendly. Tuttavia, il design deve presentare tutti gli elementi sopra elencati e ho una preferenza specifica per il layout: i tre pulsanti di azione ('Crea', 'Apri', 'Invia') devono essere posizionati in basso, sotto agli altri elementi, e allineati orizzontalmente tra loro.
Per favore, generami il codice di base per index.php, style.css e script.js rispettando queste indicazioni.
```

> [!warning] **NOTA BENE**  
> Sottolineo che è meglio non affidarsi al 100% all'AI. Il prompt per esempio non considera la struttura file del mio progetto quindi di sicuro devo modificare manualmente alcune cose.