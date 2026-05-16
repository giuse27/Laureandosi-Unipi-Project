# 04 - Diagramma di classe

## Cenni di Teoria

Il Diagramma delle Classi è il cuore della modellazione orientata agli oggetti (UML). Mentre le CRC Card sono informali e servono per fare brainstorming, il Diagramma delle Classi è la mappa strutturale e formale del tuo software.
Esso mostra la struttura statica del sistema: quali classi esistono, come sono fatte internamente e come sono collegate tra loro.

Una Classe nel diagramma UML è rappresentata come un rettangolo diviso in tre scomparti:

1. **Nome della Classe**: Il nome dell'entità (es. Cliente, in alto).

2. **Attributi (Stato)**: Le informazioni che la classe "conosce" o possiede (es. nome, email, password). Derivano dalle responsabilità di "conoscenza" della tua CRC Card.

3. **Operazioni o Metodi (Comportamento)**: Le azioni che la classe sa fare (es. effettuaOrdine(), cambiaPassword()). Derivano dalle responsabilità di "azione" della tua CRC Card.

## Prerequisiti

Per la creazione del diagramma di classe è necessario aver completato le CRC card.

## Realizzazione del diagramma di classe

> Il tutorial indica solo gli step da fare, per comporre il diagramma bisogna rifarsi alla teoria

* Per realizzare il diagramma di classe, creare per prima cosa il file: dal Diagram Navigator andare nella sezione "UML Diagrams" e poi "Class Diagram", e infine tasto destro e poi "New Class Diagram".
* Così facendo ci si aprirà un nuovo file vuoto, al cui interno potremo inserire tutte le classi create tramite le CRC card, trascinandole dal pannello "Model Explorer" (si trova a fianco al pannello "Diagram Navigator", se non visibile andare su View -> Panes -> Model Explorer).
* Per ognuna delle classi (che possono essere state trascinate dal pannello, oppure essere create manualmente all'interno del diagramma stesso), dovremo adesso definire i suoi attributi e i suoi metodi.
* Infine, bisogna definire le relazioni tra ogni classe.
