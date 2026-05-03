# 03 - CRC card

## Cenni di teoria per costruire le CRC card

Le schede CRC (Class, Responsibilities, Collaborators) sono uno strumento di brainstorming utilissimo durante la fase di *Analisi Orientata agli Oggetti*. Aiutano a capire quali classi servono al sistema, cosa devono fare e con chi devono interagire per farlo.

### Cosa contiene una CRC Card?

Una tipica scheda CRC è divisa in diverse sezioni:
1.  **Name (Nome della Classe)**: Sostantivo singolare.
2.  **Description (Descrizione)**: Breve spiegazione dello scopo della classe.
3.  **Attributes (Attributi)**: I dati che la classe deve "conoscere" o conservare al suo interno.
4.  **Responsibilities (Responsabilità)**: Cosa la classe sa fare (i verbi, le azioni).
5.  **Collaborators (Collaboratori)**: Altre classi a cui questa classe deve chiedere aiuto o informazioni per portare a termine le sue responsabilità.

## Prerequisiti

L’unico prerequisito è la stesura dei requisiti comprensiva di analisi testuale e individuazione di attori e casi d’uso

## Creazione delle CRC Card

1. Dal diagram navigator (se non è presente andare su View > Panes > Diagram Navigator) andare nella categoria Requirements Capturing, successivamente creiamo il diagramma contenente le CRC card, facendo tasto destro sulla voce CRC Card Diagram > New CRC Card Diagram

    ![image.png](./resources/03-img00.png)

    Se si vuole si può rinominare il diagramma appena creato

2. Una volta creato e aperto il file avremo un foglio bianco al cui interno è possibile inserire tutte le card. Per farlo è sufficiente o fare tasto destro sul foglio e cliccare New Card, oppure cliccare sull'icona della card (icona sotto il puntatore verde in alto a sinistra) e poi con il mouse cliccare in un punto qualunque del foglio per inserire la card.

    ![image.png](./resources/03-img01.png)

3. Adesso basterà aggiungere il contenuto alla CRC Card seguendo le indicazioni fornite nei cenni teorici qui sopra

## Esempio di CRC Card (CarrieraLaureando)

> **NOTA IMPORTANTE**: le CRC card andrebbero create in accordo con le classi candidate all'interno dell'analisi testuale. Non è detto che dobbiamo creare una CRC card per ogni classe candidata, ma laddove andiamo a svilupparne una quantomeno deve avere lo stesso nome.

1. **Nome della classe**: doppio click sul rettangolo azzurro con il nome della CRCCard > inserire il nome della classe che si vuole creare
    
    ![image.png](./resources/03-img02.png) 

    Nel mio caso la CRC card era per la classe CarrieraLaureando, che quindi sarà anche il nome della CRC card.

2. **Super Classes**: nell'esempio nessuno perché la classe CarrieraLaureando non è figlia di altre classi
3. **Sub Classes**: la classe CarrieraLaureando ha come sottoclasse derivata la classe CarrieraLaureandoInf (per il caso specifico di Ing. Informatica)
4. **Description**: "La classe CarrieraLaureando raccoglie le informazioni sull'anagrafica e sulla carriera del laureando, necessarie alla creazione del prospetto di laurea."
   
5. **Attributes**: per aggiungere un attributo (ovvero un'informazione che la classe conosce) composto dal suo nome e dalla sua descrizione, basta fare tasto destro nella casella grigia di "Attributes" > Add > Attribute

    ![image.png](./resources/03-img03.png)

    | **Name** | **Description** |
    | --- | --- |
    | nome | Nome del laureando |
    | cognome | Cognome del laureando |
    | matricola | Matricola del laureando |
    | email | Email istituzionale del laureando |
    | cdl | Corso di Laurea del laureando |
    | dataLaurea | Data in cui lo studente dovrà laurearsi |
    | esami | Elenco di esami che lo studente ha in carriera |

6. **Responsibilities**: come per il punto 5 ci basta fare tasto destro sul riquadro grigio (stavolta su Responsibilities e non su Attributes) > Add > Responsibility. Così fatto, impostiamo il nome e la classe Collaborator

    | **Name** | **Collaborator** |
    | --- | --- |
    | Recuperare le informazioni relative all'anagrafica e alla carriera dello studente | GestioneCarrieraStudente |
    | Calcolare la media pesata degli esami | Esame, FileConfigurazione |
    | Calcolo del totale crediti conseguiti | Esame |
    | Calcolo del totale dei crediti che fanno media | Esame, FileConfigurazione |

> **RISULTATO FINALE**
> ![image.png](./resources/03-img04.png)

Dopo aver fatto ciò si ripete il procedimento per tutte le CRC card, andando a chiedersi ogni volta, che informazioni deve conoscere la classe e quali sono le sue funzioni principali.

Un piccolo trucco può essere quello di scrivere tutte le CRC card all'inizio e successivamente andarle a riempire.