# Laureandosi-Unipi-Project

[![GitHub stars](https://img.shields.io/github/stars/giuse27/Laureandosi-Unipi-Project?style=social)](https://github.com/giuse27/Laureandosi-Unipi-Project) ![License](https://img.shields.io/github/license/giuse27/Laureandosi-Unipi-Project) ![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg) [![GitHub giuse27](https://img.shields.io/badge/GitHub-giuse27-blue?logo=github)](https://github.com/giuse27)

- [Laureandosi-Unipi-Project](#laureandosi-unipi-project)
  - [Descrizione del progetto](#descrizione-del-progetto)
  - [Struttura del progetto](#struttura-del-progetto)
  - [Documentazione](#documentazione)
    - [Documentazione del progetto](#documentazione-del-progetto)
    - [Manuale Utente](#manuale-utente)
    - [Manuale di Installazione](#manuale-di-installazione)
    - [Manuale di Configurazione](#manuale-di-configurazione)
    - [Manuale di Test](#manuale-di-test)
  - [Tutorial per ISW e per Laureandosi](#tutorial-per-isw-e-per-laureandosi)
  - [💖 Supporta il progetto](#-supporta-il-progetto)

## Descrizione del progetto

Progetto Laureandosi di Giuseppe Vaglica, svolto per l'esame di Ingegneria del Software del professore Cimino (Università di Pisa), per l'anno accademico 2025/2026.

Esame sostenuto il 09/06/2026 con valutazione 29/30.

Laureandosi-Unipi-Project è un simulatore di **prospetti di laurea** che **genera** dei prospetti di laurea per i laureandi e per la commissione e permette di **aprire** i prospetti per la commissione e **inviare** i prospetti generati ai rispettivi laureandi. Presenta inoltre, una pagina di **test** che fa riferimento ad alcuni esempi noti e configurabili per verificare le funzionalità del sistema.

## Struttura del progetto

```md
└── 📁Laureandosi-Unipi-Project         (root del progetto)    
    ├── 📁config                        (file di configurazione json)
    ├── 📁docs                          
    |   ├── 📁export                    (storico esportazioni)
    |   ├── 📁risorse-fasi-progetto     (risorse della documentazione)         
    |   ├── 📁tutorial                  (tutorial per il progetto e per isw)         
    |   ├── registro.md                     (REGISTRO ISW)                 
    |   └── Vaglica.pdf                     (DOCUMENTAZIONE)
    ├── 📁frontend                             
    |   ├── 📁home                      (frontend sito)
    |   └── 📁test                      (frontend pagina di test)
    ├── 📁prospetti                     (output generazione prospetti)
    ├── 📁resources                     (simulazione GestioneCarrieraStudente e test)
    ├── 📁src                           (backend)                  
    |   ├── 📁API                       (GCS e ponte frontend-backend)
    |   ├── 📁Config                    (accesso ai file di configurazione)  
    |   ├── 📁Core                      (classi principali di backend)
    |   └── 📁Test                      (funzionalità di test)
    ├── 📁vendor                        (librerie)
    ├── 📁visual-paradigm-prj           (progetto visual paradigm)
    |   └── laurendosi_vaglica.vpp          (PROGETTO VPP)         
    ├── composer.json                       
    ├── composer.lock    
    ├── index.php                           (PAGINA SITO)
    ├── LICENSE                         
    ├── PaginaTest.php                      (PAGINA TEST)
    └── README.md                           
```

## Documentazione

La documentazione è presente nella cartella `docs/` ma per semplicità riporto qui sotto i link diretti ai pdf

### Documentazione del progetto

[**Clicca qui per aprire la documentazione del progetto**](docs/Vaglica.pdf)

### Manuale Utente

[**Clicca qui per aprire il manuale utente**](docs/risorse-fasi-progetto/5.%20manuali/Manuale%20Utente.pdf)

### Manuale di Installazione

[**Clicca qui per aprire il manuale di installazione**](docs/risorse-fasi-progetto/5.%20manuali/Manuale%20di%20Installazione.pdf)

### Manuale di Configurazione

[**Clicca qui per aprire il manuale di configurazione**](docs/risorse-fasi-progetto/5.%20manuali/Manuale%20di%20Configurazione.pdf)

### Manuale di Test

[**Clicca qui per aprire il manuale di test**](docs/risorse-fasi-progetto/5.%20manuali/Manuale%20di%20Test.pdf)

## Tutorial per ISW e per Laureandosi

Data la natura didattica del progetto e le difficoltà che personalmente ho trovato lungo la realizzazione, ho deciso di realizzare una raccolta di tutorial per ingegneria del software e per la replica del progetto stesso in autonomia.

Trovi i tutorial in `docs/tutorial/` oppure [**clicca qui per aprire l'indice della raccolta**](docs/tutorial/TUTORIAL.md).

## 💖 Supporta il progetto

Se questo strumento ti è stato utile, ti ha fatto risparmiare tempo o semplicemente ti piace, considera di lasciarmi una ⭐️ su [GitHub](https://github.com/giuse27/Laureandosi-Unipi-Project). 
È un piccolo gesto gratuito che mi aiuta tantissimo a mantenere il progetto attivo e visibile!
