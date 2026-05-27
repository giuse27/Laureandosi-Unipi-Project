<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laureandosi</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎓</text></svg>">
    <link rel="stylesheet" href="frontend/home/style.css">
</head>
<body>

<div class="page-wrapper">
    <div class="card">

        <!-- Intestazione -->
        <header class="card_header">
            <div class="card_logo" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                    <line x1="9" y1="9" x2="10" y2="9"/>
                    <line x1="9" y1="13" x2="15" y2="13"/>
                    <line x1="9" y1="17" x2="15" y2="17"/>
                </svg>
            </div>
            <div>
                <h1 class="card_title">Gestione Prospetti di Laurea</h1>
                <p class="card_subtitle">Laureandosi &middot; Unità Didattica</p>
            </div>
        </header>

        <!-- Campi del form -->
        <div class="form-grid">

            <div class="form-field">
                <label class="form-label" for="cdl">CdL</label>
                <select id="cdl" name="cdl">
                    <option value="">Seleziona un CdL...</option>
                </select>
            </div>

            <div class="form-field">
                <label class="form-label" for="data-laurea">Data Laurea</label>
                <input type="date" id="data-laurea" name="data_laurea">
            </div>

            <div class="form-field form-field--full">
                <label class="form-label" for="matricole">Matricole</label>
                <textarea
                        id="matricole"
                        name="matricole"
                        placeholder="Incolla qui le matricole, separate da virgole e/o spazi&#10;es. 123456, 789012, 345678…"
                ></textarea>
            </div>

        </div>

        <!-- Azioni principali -->
        <div class="actions">
            <button class="btn btn--create" id="btn-crea" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                    <line x1="12" y1="10" x2="12" y2="16"/><line x1="9" y1="13" x2="15" y2="13"/>
                </svg>
                Crea Prospetti
            </button>
            <button class="btn btn--open" id="btn-apri" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 19l2 -7h13l-2 7z"/>
                    <path d="M5 19h-2a1 1 0 0 1 -1 -1v-11a1 1 0 0 1 1 -1h4l2 3h7a1 1 0 0 1 1 1v2"/>
                </svg>
                Apri Prospetti
            </button>
            <button class="btn btn--send" id="btn-invia" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="10" y1="14" x2="21" y2="3"/>
                    <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"/>
                </svg>
                Invia Prospetti
            </button>
        </div>

        <!-- Zona messaggi di stato -->
        <div class="status-bar" id="status-bar" role="status" aria-live="polite">
            <span class="status-bar__dot" id="status-dot"></span>
            <span class="status-bar__text" id="status-text">[SYSTEM] In attesa di un&rsquo;azione da parte dell&rsquo;unità didattica&hellip;</span>
        </div>

    </div>
</div>

<script src="frontend/home/script.js"></script>
</body>
</html>