# Tutorial per Ingegneria del Software

- [Tutorial per Ingegneria del Software](#tutorial-per-ingegneria-del-software)
  - [Introduzione](#introduzione)
  - [Struttura della raccolta](#struttura-della-raccolta)
    - [Modulo "Analisi"](#modulo-analisi)
    - [Modulo "Progetto"](#modulo-progetto)
    - [Ultimi step del Progetto](#ultimi-step-del-progetto)

## Introduzione

Questa raccolta di Tutorial per la realizzazione del progetto di Ingegneria del Software si prefigge l'obiettivo di scavalcare la *barriera data dal software Visual Paradigm*, e di aiutare lo studente laddove ci siano *parti non chiare* o "blocchi" dovuti alla *mancata comprensione di quello che è il workflow del progetto*. 

I tutorial sono stati realizzati dallo studente **Giuseppe Vaglica** (io XD) durante l'edizione del corso di Ingegneria del Software (ISW da qui in avanti) per l'**A.A. 2025/2026**.

> La raccolta di tutorial **non va a sostituire la frequentazione del corso**, in quanto secondo il mio consiglio è importante seguire soprattutto la prima parte del corso in cui viene spiegato il software Laureandosi che si deve realizzare, e in cui avviene assieme al professore e mediante lavoro autonomo e confronto con i colleghi la stesura dei requisiti e in generale il primo checkpoint su requisiti e registro. Ciò nonostante, la raccolta (a mio dire), costituisce un ottimo **materiale integrativo** per tutte quelle parti più meccaniche, non spiegate dal prof. Cimino, **essenziali per la realizzazione del progetto**.

## Struttura della raccolta

Nei seguenti paragrafi sono elencati i tutorial che ho realizzato. Ogni tutorial è numerato in base alla sequenza che idealmente bisognerebbe seguire, e presenta al suo interno (nella maggior parte dei casi) tutto ciò che bisogna sapere su un dato argomento (**cenni di teoria**), i **prerequisiti** per seguire quel tutorial, e il **tutorial step by step**.

> Sia chiaro che i tutorial **non servono per replicare step by step il progetto**, ma sono da utilizzare con l'obiettivo di capire ciò che si sta facendo e come replicare in autonomia. Sono presenti i concetti teorici essenziali, ma anche diversi esempi e guide pratiche. Il tutto è affiancato dal mio progetto per il software Laureandosi presente nella repo: [**repo GitHub con il mio progetto**](https://github.com/giuse27/Laureandosi-Unipi-Project).

> **NOTA BENE**  
> Allo stato attuale tra i vari moduli **non è presente il modulo sui requisiti** in quanto come anticipato nell'introduzione, quel modulo è stato realizzato in aula mediante le spiegazioni del prof e il confronto con i colleghi.

### Modulo "Analisi"

* [**01 - Diagramma dei casi d'uso.md**](analisi/01%20-%20Diagramma%20dei%20casi%20d’uso.md)
* [**02 - Casi d'uso dettagliati.md**](analisi/02%20-%20Casi%20d’uso%20dettagliati.md)
* [**03 - CRC card.md**](analisi/03%20-%20CRC%20card.md)
* [**04 - Diagramma di classe.md**](analisi/04%20-%20Diagramma%20di%20classe.md)
* [**05 - Diagrammi di sequenza.md**](analisi/05%20-%20Diagrammi%20di%20sequenza.md)

### Modulo "Progetto"

* [**01 - Creazione iniziale del sito**](progetto/01%20-%20Creazione%20iniziale%20del%20sito.md)
* [**02 - Front-end del sito**](progetto/02%20-%20Front-end%20del%20sito.md)
* [**03 - Realizzazione del back-end**](progetto/03%20-%20Realizzazione%20del%20back-end.md)

### Ultimi step del Progetto

> Dopo il tutorial 03 del modulo di progetto non ho più realizzato tutorial in quanto a questo punto ogni progetto sarà diverso (più o meno) e soprattutto, arrivati a questo punto non ci sono parti insidiose o che necessitano di una guida, visto che ormai si procede abbastanza spediti.

Riepilogo qui gli ultimi step per concludere il progetto:

* **Diagramma di classe di progetto** (modulo progetto). Si realizza a partire dal tool sul sito del prof. cimino (**phUML**), basta solo generarlo con quel tool ed esportarlo nella documentazione.
* **Diagrammi di sequenza di progetto** (modulo progetto). Sono concettualmente simili a quelli già visti nell'analisi ma si realizzano a partire dal codice (e quindi sulle freccette ci saranno i nomi delle funzioni per esempio). Per questi è sufficiente aprire PHP Storm, considerare un caso d'uso e risalire a tutte le chiamate di funzione o azioni che vengono eseguite.
* **Diagramma di dislocazione** (modulo implementazione). Questo diagramma è semplice da realizzare ed è molto intuitivo, basta seguire un [**esempio come il mio**](../risorse-fasi-progetto/4.%20implementazione/diagramma_di_dislocazione.svg) e adattarlo alla struttura del proprio progetto.
* **Manuali** (modulo manuali). Si tratta solo di scrivere i manuali del sistema: manuale Utente, di Installazione, di Configurazione e di Test. 