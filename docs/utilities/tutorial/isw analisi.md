# Copilot Chat Conversation Export: ISW Analisi Cambria

**User:** @giuse27
**Thread URL:** https://github.com/copilot/c/8de832f5-0d3a-4566-be6f-78ffc1a6cfd5

## @giuse27

Questo è il progetto di un mio collega per il corso di ingegneria del software. Considera che sto iniziando ad affrontare questo corso anche io. Spiegami tutto il workflow di analisi di questo progetto, fornendomi cenni teorici di ciò che viene fatto, creami inoltre una scaletta in cui mi spieghi step by step tutte le cose che devo fare per replicare il workflow di analisi di questo progetto.

## Copilot

Ciao! Affrontare il corso di Ingegneria del Software (spesso basato su metodologie object-oriented come RUP - *Rational Unified Process* o affini) richiede molta metodicità. Guardando il repository del tuo collega (in particolare il `README.md` e la documentazione prodotta), il progetto segue fedelmente il ciclo di vita tipico del software insegnato a livello accademico.

Ecco una spiegazione completa del **Workflow di Analisi** adottato in questo progetto, arricchita dai cenni teorici, seguita dalla scaletta pratica per replicarlo.

---

### 1. Spiegazione del Workflow di Analisi (con cenni teorici)
Il processo di analisi nel software non si preoccupa di *come* il sistema verrà implementato (tecnologia, framework, database), ma si concentra sul **cosa** il sistema deve fare e su come modellare concettualmente il dominio del problema. 
Nel progetto del tuo collega, l'analisi è preceduta da un **Workflow dei Requisiti** e sfocia poi in un **Workflow di Progetto (Design)**.

#### Fase A: Workflow dei Requisiti (La Fondazione)
*   **Cenno teorico**: L'Ingegneria dei Requisiti serve a comprendere i bisogni degli *stakeholder* (chi ha interesse nel sistema) e tradurli in specifiche formali.
*   **Cosa è stato fatto nel progetto**:
    *   **Identificazione di Attori e Casi d'Uso**: Gli attori (es. *Unità didattica*) sono chi/cosa interagisce con il sistema. I casi d'uso (es. *GeneraProspettiLaurea*) sono le funzionalità offerte.
    *   **Classificazione MoSCoW**: I requisiti sono stati divisi in funzionali (cosa fa il sistema) e non funzionali (vincoli di qualità come sicurezza, privacy GDPR, linguaggio PHP). Il metodo **MoSCoW** li divide in *Must* (obbligatori), *Should* (importanti ma non vitali), *Could* (desiderabili), *Want/Won't* (rinviati/opzionali).
    *   **Glossario**: Un dizionario dei termini (es. *Prospetto*, *Esame extracurricolare*) per evitare ambiguità e creare un linguaggio comune ("*Ubiquitous Language*").

#### Fase B: Workflow di Analisi (La Modellazione)
*   **Cenno teorico**: L'analisi trasforma i requisiti testuali in modelli concettuali usando il linguaggio UML (Unified Modeling Language). Si usa tipicamente il pattern **BCE (Boundary, Control, Entity)** per separare le responsabilità:
    *   *Boundary (Interfacce)*: Classi che gestiscono l'interazione tra attore e sistema (es. schermate UI, API esterne).
    *   *Control (Controllori)*: Classi che incapsulano la logica applicativa del singolo caso d'uso.
    *   *Entity (Entità)*: Classi che rappresentano i dati di dominio e la logica di business (es. Studente, Esame).
*   **Cosa è stato fatto nel progetto**:
    *   **Specifica dei Casi d'Uso**: Per ogni caso d'uso è stato scritto uno scenario *step-by-step* (es. "1. Unità Didattica seleziona il CdL, 2. SYSTEM mostra il CdL..."), definendo *Precondizioni* e *Postcondizioni*.
    *   **Analisi CRC (Class-Responsibility-Collaborator)**: È una tecnica di *brainstorming*. Per ogni classe individuata, si crea una "scheda" (spesso un post-it) in cui si definisce il nome della classe, le sue Responsabilità (cosa sa e cosa sa fare) e i suoi Collaboratori (quali altre classi le servono per funzionare).
    *   **Diagramma di Classe di Analisi**: Una mappa statica che mostra le classi BCE individuate e le loro relazioni (associazioni, aggregazioni, ecc.) senza entrare nei dettagli implementativi dei tipi di dato o dei costruttori.
    *   **Realizzazione dei Casi d'Uso (Diagrammi di Sequenza)**: Per ogni caso d'uso descritto testualmente, è stato disegnato un Diagramma di Sequenza di analisi. Mostra, sull'asse del tempo (verticale), i messaggi (orizzontali) che si scambiano l'attore e gli oggetti BCE per portare a termine quello specifico scenario.

---

### 2. Scaletta Step-by-Step per replicare il Workflow

Per superare l'esame e sviluppare il tuo progetto, dovrai seguire questa esatta "ricetta". Ti consiglio di usare un software di modellazione UML come *Visual Paradigm* (usato nel progetto del tuo collega, vedi il file `progettoISW.vpp`).

#### Step 1: Ingegneria dei Requisiti
1.  **Definisci il dominio**: Scrivi un breve riassunto di ciò che farà il tuo sistema.
2.  **Stila il Glossario**: Crea una tabella con Termine, Sinonimi (Aliases) e Definizione. Fallo subito, ti salverà da incongruenze.
3.  **Elenca i Requisiti**: Usa il metodo MoSCoW. Dividili tra Funzionali (Must, Should, Could, Want) e Non Funzionali (tecnologici, normativi, prestazioni).
4.  **Identifica Attori e Casi d'Uso**: Chi usa il sistema? Cosa deve poterci fare?

#### Step 2: Modellazione Comportamentale (Use Cases)
5.  **Disegna il Diagramma dei Casi d'Uso (UML)**: Disegna gli "omini" (attori) e gli ovali (casi d'uso) collegati tra loro. Usa le relazioni *include* ed *extend* se necessario.
6.  **Scrivi le Specifiche (Scenari)**: Per *ogni* caso d'uso scrivi testualmente:
    *   Nome del caso d'uso
    *   Precondizioni (cosa deve essere vero prima di iniziare)
    *   Scenario principale (flusso base "botta e risposta" tra Attore e Sistema)
    *   Flussi alternativi (cosa succede se c'è un errore o una scelta diversa)
    *   Postcondizioni (stato del sistema alla fine)

#### Step 3: Modellazione Strutturale di Analisi
7.  **Fai l'Analisi CRC**: Leggi i tuoi scenari. I sostantivi diventano spesso *Entità* o *Boundary*, i verbi o le azioni diventano le responsabilità dei *Control*. Crea le schede CRC per capire chi fa cosa e con chi parla.
8.  **Disegna il Diagramma di Classe di Analisi (UML)**: Prendi le classi nate dai CRC e mettile in un diagramma. Identificale visivamente tramite stereotipi (`<<boundary>>`, `<<control>>`, `<<entity>>`). Disegna le linee di associazione tra di esse. Non preoccuparti ancora di metodi con tipi di ritorno specifici o visibilità (`+`, `-`, `#`), mantienilo ad alto livello concettuale.

#### Step 4: Realizzazione dei Casi d'Uso (Analisi)
9.  **Disegna i Diagrammi di Sequenza di Analisi (UML)**: Per ogni tuo scenario (Step 6), disegna la linea della vita dell'attore.
    *   L'attore invia un messaggio a un oggetto *Boundary* (interfaccia).
    *   Il *Boundary* inoltra la richiesta a un *Control* (il coordinatore).
    *   Il *Control* interroga o modifica una o più *Entity* (i dati).
    *   Il flusso torna indietro fino al Boundary che mostra il risultato all'attore.

#### Cosa viene dopo (Workflow di Progetto e Implementazione)?
Una volta che la tua Analisi ha retto (cioè i diagrammi di sequenza riescono a compiere i casi d'uso usando solo le classi del diagramma di classi), passerai al **Design (Progetto)**. Qui il diagramma di classi diventerà dipendente dalla tecnologia (es. aggiungendo tipi specifici PHP, pattern architetturali come MVC, pattern GoF come Singleton o Factory, e framework), e di conseguenza adatterai i diagrammi di sequenza a queste nuove classi tecniche, per poi procedere a scrivere il codice reale e testarlo.

## @giuse27

spiegami a partire dalla repo @Gabriele-D-Cambria/Laureandosi-a-isw-project come replicare le CRC card

## Copilot

Le schede CRC (Class, Responsibilities, Collaborators) sono uno strumento di brainstorming utilissimo durante la fase di *Analisi Orientata agli Oggetti*. Aiutano a capire quali classi servono al sistema, cosa devono fare e con chi devono interagire per farlo.

Nel progetto `@Gabriele-D-Cambria/Laureandosi-a-isw-project`, le schede CRC sono state usate esattamente a questo scopo. Dall'esame del file SVG del progetto, possiamo ricavare un esempio pratico e capire il metodo esatto per replicarle nel tuo progetto per l'esame.

### Cosa contiene una CRC Card?
Una tipica scheda CRC è divisa in diverse sezioni (come si nota anche dallo standard usato in Visual Paradigm dal tuo collega):
1.  **Name (Nome della Classe)**: Sostantivo singolare.
2.  **Description (Descrizione)**: Breve spiegazione dello scopo della classe.
3.  **Attributes (Attributi)**: I dati che la classe deve "conoscere" o conservare al suo interno.
4.  **Responsibilities (Responsabilità)**: Cosa la classe sa fare (i verbi, le azioni).
5.  **Collaborators (Collaboratori)**: Altre classi a cui questa classe deve chiedere aiuto o informazioni per portare a termine le sue responsabilità.

---

### Esempio reale tratto dal progetto `Laureandosi-a-isw-project`

Guardando i dati estratti dal file `crcCardDiagram.svg`, ecco come è stata costruita la scheda CRC per la classe entità **FormulaMedia**:

*   **Nome**: `FormulaMedia`
*   **Descrizione**: "Conserva le informazioni per poter calcolare correttamente un voto di laurea dati la media pesata e un parametro"
*   **Attributi** (ciò che conosce):
    *   `formulaVoto`: indica la formula da seguire
    *   `minParametro`: minimo valore assumibile dal parametro
    *   `maxParametro`: massimo valore assumibile dal parametro
    *   `stepParametro`: step da far effettuare per fariare il parametro
    *   `parametro`: indica qual è il parametro da considerare
*   **Responsabilità** (ciò che sa fare):
    *   "Calcolare il voto data la media"
*   **Collaboratori** (a chi chiede aiuto per farlo):
    *   *(Nessuno esplicito per questa specifica operazione interna, è autosufficiente).*

Altre classi avranno collaboratori espliciti. Ad esempio, un ipotetico `GeneraProspettiControl` avrà come responsabilità "Avviare la generazione del prospetto" e come collaboratori `GestioneCarrieraStudente` (per prendere i dati) e `ProspettoLaureando` (per visualizzarli).

---

### Come Replicare le CRC Card per il tuo progetto (Step-by-Step)

Per creare le CRC Card per il tuo esame di Ingegneria del Software, devi partire dai **Casi d'Uso** che hai scritto nel Workflow dei Requisiti.

#### Step 1: Estrazione dei Sostantivi (Individuare le Classi)
Prendi la descrizione di un caso d'uso. Nel progetto del tuo collega, per "GeneraProspettiLaurea", lo scenario dice:
> "1. UnitaDidattica seleziona il **CdL**... 3. UnitaDidattica seleziona la **Data Laurea**... 5. Inserisce la sequenza di **matricole**..."

I sostantivi in grassetto suggeriscono l'esistenza di entità o informazioni che il sistema deve gestire. Identifica le potenziali classi:
*   `UnitaDidattica` (Attore/Interfaccia utente)
*   `CorsoDiLaurea` (Entità)
*   `Studente/Laureando` (Entità)

#### Step 2: Estrazione dei Verbi (Individuare le Responsabilità)
Cerca le azioni.
> "... il sistema **Azzera** tutti i campi e **visualizza** il messaggio... Il sistema ha **generato**... i prospetti di laurea..."

Da qui derivano le responsabilità che devi assegnare alle tue classi:
*   Quale classe è responsabile di "generare il prospetto"? (Es. `GeneratoreProspettiControl`).
*   Quale classe è responsabile di "visualizzare il messaggio"? (Es. `PaginaProspettiBoundary`).

#### Step 3: Compilare la Scheda (Definire i Collaboratori)
Prendi un foglio (o usa uno strumento come Visual Paradigm, proprio come ha fatto il tuo collega) e inizia a compilare. Chiediti:
*"Per generare un prospetto (responsabilità del Control), cosa mi serve?"*
Ti serve sapere gli esami passati dallo studente e i suoi dati anagrafici. Quindi la tua classe *Control* dovrà collaborare con le entità `AnagraficaLaureando` e `CarrieraLaureando`. Scrivilo nella colonna "Collaboratori".

#### Step 4: Simulazione (Walkthrough)
Questo è il passaggio fondamentale. Metti le carte (o i riquadri a schermo) davanti a te e simula a voce alta l'esecuzione del caso d'uso:
1. "Il Boundary *InterfacciaUtente* raccoglie la matricola e la passa al Control *GestoreProspetto*."
2. "Il *GestoreProspetto* non ha i dati della matricola. Guarda i suoi collaboratori... ah, può chiederli a *GestioneCarrieraStudente* (l'API dell'università)."
3. "Ricevuti i dati, il *GestoreProspetto* chiede a *FormulaMedia* di calcolare il voto."

Se durante questo racconto ad alta voce ti accorgi che a una classe manca un'informazione e non ha nessun collaboratore a cui chiederla, **hai trovato una lacuna nella tua analisi**. Aggiungi l'attributo mancante o aggiungi un nuovo collaboratore.

### Come scriverle praticamente per il progetto
Puoi disegnarle su Visual Paradigm (strumento usato da Gabriele) usando il modulo "CRC Card Diagram", oppure puoi scriverle semplicemente in Markdown nel tuo `README.md` o file di documentazione in questo modo:

```markdown
### Classe: CarrieraLaureando
**Descrizione**: Mantiene la lista degli esami sostenuti dal laureando.

| Attributi |
| :--- |
| - listaEsami<br>- cfuTotali<br>- mediaPesata |

| Responsabilità | Collaboratori |
| :--- | :--- |
| Ottenere il totale dei CFU per materie specifiche | Nessuno |
| Fornire la lista degli esami | Nessuno |
```

Il professore valuterà non tanto il tool che hai usato, ma **la coerenza**: le classi nelle schede CRC devono essere *esattamente* le stesse che poi appariranno nel Diagramma di Classe di Analisi e che comunicheranno tra loro nei Diagrammi di Sequenza!
