# 03 - Realizzazione del back-end

> [!caution] ATTENZIONE, questo non è un tutorial:
> Come già si poteva capire dal tutorial precedente, la parte di realizzazione del sito intesa come realizzazione di front-end e back-end è a questo punto affidata completamente alla persona che sta replicando il sistema. Fare un tutorial significherebbe spiegare javascript e php da zero quindi non mi sembra il caso...  
> Mi limiterò solo a **dare consigli basandomi sulla mia esperienza**.

## Tips per la scrittura del codice

Io ho realizzato il sito seguendo queste 3 fasi:

1. Realizzazione dell'interfaccia grafica (solo html e css)
2. Realizzazione del ponte tra front-end e back-end (javascript e GestoreRichieste.php)
3. Realizzazione del back-end (tutte le classi del sistema)

A mio parere la parte più complessa è stata la seconda in quanto più "tecnica" e che richiede un aggiornamento costante. Quando ho scritto il javascript all'inizio mi sono concentrato sul fare solo il meccanismo base che associa i pulsanti a una chiamata al file GestoreRichieste.php, solo dopo ho iniziato ad aggiungere controlli sui dati in input, logica di funzionamento per la generazione, apertura e invio prospetti. In questo senso, i due file verranno aggiornati lungo tutto l'arco della realizzazione del sito.

## Requisiti fondamentali da rispettare

Come il prof spiega a lezione è importante che il codice che noi scriviamo rispetti determinate caratteristiche. Fare un progetto per Ingegneria del Software significa fare un sistema che rispetti determinati requisiti di scalabilità e facile manutenzione.

### Scalabilità del sistema

Faccio un esempio con il filtro esami informatici: che succede se vogliamo aggiungere un nuovo esame all'elenco di esami informatici? Se ho progettato un buon sistema mi basterà modificare il file json e aggiungere un nuovo elemento, il tutto **senza mai modificare il codice sorgente**. Questo era un esempio semplice, ma se adesso consideriamo i casi di test che nel nostro progetto sono solo cinque, ci chiediamo subito: che succede se voglio aggiungere altri 1000 casi di test? In questo caso il discorso è decisamente diverso perché se non abbiamo adottato l'approccio tramite file di configurazione ci ritroviamo a dover modificare il codice sorgente un numero elevato di volte. Quando io ho fatto l'esame ho adottato proprio questo approccio e aggiungere 1, 2, 3, o 1000 casi di test per me è significato solo fare copia e incolla di un blocco matricola nel json e modificare i parametri. Altri che hanno adottato l'approccio con php (ovvero inserire tutti i test all'interno del file di test in php includendo li i parametri e i valori attesi) hanno ricevuto non poche critiche dal professore.

## Pulizia e la manutenzione del codice

Questo punto si ricollega al precedente. Qui faccio l'esempio di CarrieraLaureando e CarrieraLaureandoInf (le mie classi). Se si adotta un approccio meno strutturato si tende a fare solo una classe che considera un laureando generico e che ha come attributi anche il bonus la media degli esami informatici ecc. Questa scelta funziona ma è poco manutenibile. Il prof preferisce che siano due classi diverse (con CarrieraLaureandoInf extends CarrieraLaureando) per non sporcare la prima con attributi che non riguardano tutti i laureandi ma solo quelli di Ingegneria Informatica. Anche qui si riapplica la scalabilità, perché se in futuro aggiungiamo altri laureandi con attributi speciali il codice di CarrieraLaureando diventerebbe illeggibile e non manutenibile.

