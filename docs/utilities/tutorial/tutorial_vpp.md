Autore del file: Gabriele Domenico Cambria

Scaricare il tar

aprire la cartella bin

Aprire visual-paradigm-for-uml

_free-licence_ & _enterprise_

se propone uno spazio di lavoro lasciare quello suggerito: su linux `/home/<user>/vpworkspace`, su windows `C:\\User\<username>\vpworkspace`

Sulla sinistra ci sono i diagrammi UML che utilizzeremno come secondo step dopo aver scritto i requisiti

Per l'analisi:
> Requirements-capturing -> tasto dx textual analysis -> new textual analysis
>
> Scrivere i requisiti
>
> Individuare un attore, evidenziarlo -> tasto dx -> actor (modificare il nome della classe candidata in CamelCase)
> Individuare un caso d'uso, evidenziarlo -> tasto dx -> use case (modificare il nome della classe candidata in CamelCase)
>
> Per creare elementi grafici: tasto dx sulla riga -> create .... element ->
>
> Per il glossario: selezionare la parola e evidenziaarla -> add to glossary. Successivamente doppio click sul record
>
> Per i casi d'uso dettagliati, dalla visualizzazione grafica dei casi d'uso: tasto dx sul caso d'uso -> open use case details -> flow of events
> Per il wireframe cilccare apri new wireframe -> dispositivo
> Per generare il diagramma di sequenza nella barra in alto si trova il pulsante: syncronize to diagram -> Syncronize to Sequence Diagram
>
> Per le card CRC è possibile descrivere le resposnsabilità delle classi. Andrebbe fatto prima di generare il class-diagram
>
> Per esportare tutto fare: tools -> report -> 
>
> Se vogliamo esportare un diagramma senza filligrana: file -> export -> export active diagram/diagrams as an image -> SVG files 


Per rimuovere la filigrana aprire l'immagine con un editor di testo e rimuoverle manualmente

Disattivare gli aggiornamenti automatici (`tools application option -> general -> update never`)
Disattivare l'autosave (`tools -> application option -> autosave off`)

Per resettare la licenza su Linux:
- Rimuovere la cartella `$HOME/vpworkspace`
- Rimuovere la cartella `$HOME/.config/VisualParadigm`

Per resettare la licenza su Windows:
- Rimuovere la cartella: `C:\Users\<username>\vpworkspace`
- Rimuovere la cartella: `C:\Users\<username>\AppData\Local\VisualParadigm` (per accadervi: `Windows+R -> %appdata%`)

Per resettare la licenza su MacOS:
- Aprire finder con il maus e cliccare su `vai`
- Premere il tasto `alt + libreria`