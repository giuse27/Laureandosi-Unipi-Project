# 1 - Intervista al cliente

Si tratta della fase precedente alla stesura e alla formalizzazione dei requisiti in cui intervistiamo il cliente e capiamo quelle che sono le sue esigenze. In questa fase prendiamo molti appunti e successivamente capiamo come scrivere dettagliatamente i requisiti.

# 2 - Trascrizione dei requisiti

## Requisiti non funzionali

#### Ambiente e produzione
```
N01) Il Sistema deve essere sviluppato in linguaggio PhP
N02) Il Sistema deve essere sviluppato su IDE PhpStorm
N03) Il Sistema deve essere messo in produzione su ambiente WordPress
```

#### Norme di ateneo e GDPR
```
N04) Il Sistema non deve contenere credenziali personali nel codice o nei file di 
	configurazione
N05) Il Sistema deve conservare dati personali lo stretto necessario (norma GDPR)
N06) Il Sistema deve tenere in memoria solo i dati dell'appello di laurea corrente
```

#### Sicurezza
```
N07) Il Sistema deve essere protetto da accessi non autorizzati
```

#### Sistemi di utilità e portabilità
```
N08) Il Sistema deve essere portabile su altri computer con il medesimo ambiente di 
	sviluppo e produzione
N09) Il Sistema deve avere un manuale di installazione, d’uso e di configurazione
```

#### Generazione dei prospetti
```
N10) Il Sistema deve creare il prospetto in formato PDF
```

#### Invio delle email
```
N11) Il Sistema deve inviare le email dall'indirizzo noreply-laureandosi@unipi.it
N12) Il Sistema deve inviare email con una velocità limitata (di circa 3 o 4 secondi 
	tra una mail e l'altra) per non incorrere nel blocco da parte del server di ateneo
```

#### Ricezione dei dati
```
N13) Il Sistema deve leggere i dati del laureando in formato json
```

## Requisiti funzionali

### MUST

**MUST HAVE (DEVE): REQUISITO FONDAMENTALE PER IL SISTEMA**


#### Requisiti generali
```
M01) Il Sistema deve consentire all'unità didattica di generare un prospetto di laurea 
	con tutti i laureandi per la commissione
M02) Il Sistema deve permettere all'unità didattica di aprire i prospetti di laurea
	appena generati
M03) Il Sistema deve permettere all'unità didattica di inviare il prospetto di laurea 
	appena generato
```

#### Interfaccia grafica
```
M04) Il Sistema deve fornire un'interfaccia grafica all'unità didattica (come mostrato 
	nella figura nell'allegato 1)
```

#### Ricezione dei dati
```
M05) Il Sistema deve consentire di prelevare l'anagrafica del singolo laureando dal
	sistema di Gestione Carriera Studente
M06) Il Sistema deve consentire di prelevare la carriera del singolo laureando dal
	sistema di Gestione Carriera Studente
```

#### Produzione di output
```
M07) Il Sistema deve fornire un report finale per la commissione (vedi allegato 2) e un
	report finale per lo studente (vedi allegato 3)
```

#### Gestione dei prospetti e invio delle email
```
M08) Il Sistema deve permettere all'unità didattica di generare una email (come da figura
	in allegato 4) contenente il prospetto da inviare al singolo laureando
M09) Il Sistema deve eliminare i prospetti generati precedentemente a ogni nuova 
	generazione
M10) Il Sistema deve inviare alla commissione anche una lista di tutti i laureandi
	dell'appello di laurea
M11) Il Sistema deve rendere configurabile il testo del messaggio e l'oggetto 
	dell'email inviata ai laureandi
```

#### Regole generali dei report
```
M12) Il Sistema deve inserire votazione '0' per gli esami che non compaiono nel calcolo 
	della media
M13) Il Sistema deve ordinare gli esami nel prospetto in base alla data in cui sono 
	stati sostenuti
M14) Il Sistema deve prevedere nei report per la commissione e per i laureandi una
	sezione con l'anagrafica del laureando, che comprende matricola, nome, cognome, e-mail
	di ateneo, la data dell'appello di laurea e l'assegnazione del bonus
```

#### Report per la commissione
```
M15) Il Sistema deve fornire nel report per la commissione, la simulazione del voto di 
	laurea
M16) Il Sistema deve fornire nel report per la commissione una descrizione dettagliata
	su come svolgere la simulazione del voto di laurea
```

#### Report per lo studente
```
M17) Il Sistema deve inserire voto '0' nel voto di tesi per il prospetto del laureando
```

#### Parametri e formule di calcolo del voto di laurea
```
M18) Il Sistema deve permettere all'amministratore di configurare i parametri T e C e le 
	formule di calcolo del voto di laurea (vedi allegato 5) tramite un file di 
	configurazione
```

#### File di configurazione
```
M19) Il Sistema deve consentire all’amministratore di aggiungere un nuovo corso di laurea
	tramite file di configurazione
M20) Il Sistema deve consentire all’amministratore di configurare i parametri di	
	calcolo del voto di laurea e di reportistica tramite il file di configurazione
M21) Il Sistema deve consentire all’amministratore di configurare il filtro esami 
	tramite il file di configurazione
M22) Il Sistema deve consentire all’amministratore di configurare gli esami informatici 
	tramite il file di configurazione
****M23) Il Sistema deve consentire di configurare il filtro esami sovrannumerari o 
	extracurricolari ed esami non contribuenti alla media tramite file di configurazione
M24) Il Sistema deve permettere all'unità didattica di inserire il numero di CFU 
	curriculari richiesti per corso di laurea tramite file di configurazione
```

#### Componenti della media
```
M25) Il Sistema deve prevedere il calcolo del bonus per i corsi di laurea che lo 
	prevedono
M26) Il Sistema deve consentire all'amministratore o all'unità didattica di filtrare 
	manualmente alcuni esami, per tutti i laureandi o specifiche matricole, per non
	includerli nel calcolo della media
```

#### Caso specifico di Ingegneria Informatica
```
M27) Il Sistema deve prevedere all’interno del prospetto di laurea, e per i corsi di 
	laurea che lo prevedono, il calcolo della media considerando unicamente gli esami 
	informatici
M28) Il Sistema deve applicare un bonus, che nel caso del corso di laurea in Ingegneria
	Informatica e nel caso in cui un laureando si laurei in tempo, ovvero entro maggio 
	del terzo anno
M29) Il Sistema deve distinguere che, se la laurea è in Ingegneria Informatica, allora 
	il bonus consisterà nella rimozione del voto minore dalla media pesata degli esami, e
	a parità di voto verrà rimosso quello con più CFU
```

### SHOULD

**SHOULD HAVE (DOVREBBE): REQUISITO IMPORTANTE CHE PERO' PUO' ESSERE OMESSO**

```
S01) Il Sistema dovrebbe consentire all'amministratore di configurare il valore della 
	lode per ogni corso di laurea (predefinito 33)
S02) Il Sistema dovrebbe consentire all'unità didattica o all'amministratore la 
	cancellazione manuale di tutti i dati relativi all'appello di laurea
```

### COULD

**COULD HAVE (POTREBBE): REQUISITO OPZIONALE (DA REALIZZARE SE C'E' TEMPO)**

```
C01) Il Sistema potrebbe consentire all'unità didattica di proseguire l'invio dei 
	prospetti di laurea dopo una interruzione
C02) Il Sistema potrebbe fornire una interfaccia grafica all'amministratore per 
	accedere ai file di configurazione
```

**WANT TO HAVE (VORREBBE): REQUISITO CHE PUO' ESSERE REALIZZATO IN SUCCESSIVE RELEASE**

```
W01) Il Sistema vorrebbe consentire all'unità didattica di ricevere una email con la 
	conferma di invio dei prospetti
W02) Il Sistema vorrebbe consentire all'unità didattica di generare un prospetto con 
	le statistiche dell'appello di laurea
```