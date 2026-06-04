<?php

// recupero il file json con i risultati attesi per i test
$file_json = __DIR__ . '/resources/TestExpectedOutput.json';
$contenuto_json = file_get_contents($file_json);
$dati = json_decode($contenuto_json, true);

// salvo matricole da testare in un array
// ogni elemento dell'array contiene le info attese
$elenco_matricole_test = $dati['matricole'];

$data_laurea = $dati['dataLaurea'];

// ExecuteTest.php esegue i test e restituisce i risultati in formato stringa da visualizzare nella tabella
require_once __DIR__ . '/src/Test/ExecuteTest.php';
use function Laureandosi\Test\formulaExist;
use function Laureandosi\Test\Bonus;
use function Laureandosi\Test\controlloCFUMedia;
use function Laureandosi\Test\controlloCFUTotali;
use function Laureandosi\Test\controlloMediaInf;
use function Laureandosi\Test\controlloMediaPesata;
use function Laureandosi\Test\Risultato;

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina di Test</title>
    <link rel="stylesheet" href="frontend/test/style.css">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🛠️</text></svg>">
</head>
<body>
<div class="card">

    <div class="card-header">
        <div class="card-header__logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 3H5a2 2 0 0 0-2 2v4"/><path d="M9 3h6"/><path d="M15 3h4a2 2 0 0 1 2 2v4"/>
                <rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 16h2"/><path d="M12 16h2"/>
            </svg>
        </div>
        <div>
            <h1>Laureandosi - Pagina di Test</h1>
            <p style="font-size:0.8rem; color:var(--color-text-muted); margin:0;">
                Verifica automatica del sistema di calcolo
            </p>
        </div>
    </div>

    <div class="desc-box">
        <p>Questa pagina serve a verificare il corretto funzionamento del sistema di calcolo del portale Laureandosi.</p>
        <p>I test qui effettuati confrontano il valore calcolato con quello atteso, in riferimento a un elenco di matricole
            appartenti ai rispettivi cdl. I test verificano i seguenti parametri: Media Pesata, CFU Media, CFU Totali, e per
            il caso specifico del CdL triennale in Ing. Informatica viene effettuato un controllo anche sul Bonus e sulla
            Media degli esami Informatici.</p>
    </div>

    <div class="table-wrapper">
        <table class="test">
            <thead>
            <tr>
                <th>Matricola</th>
                <th>CDL</th>
                <th>Formula Presente</th>
                <th>Media Pesata attesa</th>
                <th>Media Pesata calcolata</th>
                <th>CFU media attesa</th>
                <th>CFU media calcolata</th>
                <th>CFU totali attesi</th>
                <th>CFU totali calcolati</th>
                <th>Bonus Atteso</th>
                <th>Bonus Calcolato</th>
                <th>Media Inf. attesa</th>
                <th>Media Inf. calcolata</th>
                <th>Risultato</th>
            </tr>
            </thead>
            <tbody id="test-body">
                <?php
                    foreach ($elenco_matricole_test as $matricola) {
                        echo '<tr><td class="mat">';
                        echo $matricola['matr'];
                        echo '</td><td>';
                        echo $matricola['cdl'];
                        echo '</td><td>';
                        echo formulaExist($matricola['cdl']);
                        echo '</td><td>';
                        echo (formulaExist($matricola['cdl']) === 'Si') ? $matricola['expected']['media'] : '-';
                        echo '</td><td class="got">';
                        echo (formulaExist($matricola['cdl']) === 'Si') ? controlloMediaPesata($matricola['cdl'], $matricola['matr'], $data_laurea) : '-';
                        echo '</td><td>';
                        echo (formulaExist($matricola['cdl']) === 'Si') ?$matricola['expected']['cfuMedia']:'-';
                        echo '</td><td class="gotCfu">';
                        echo (formulaExist($matricola['cdl']) === 'Si') ?controlloCFUMedia($matricola['cdl'], $matricola['matr'], $data_laurea):'-';
                        echo '</td><td>';
                        echo (formulaExist($matricola['cdl']) === 'Si') ?$matricola['expected']['cfuTotali']:'-';
                        echo '</td><td class="gotCfuTot">';
                        echo (formulaExist($matricola['cdl']) === 'Si') ?controlloCFUTotali($matricola['cdl'], $matricola['matr'], $data_laurea):' -';
                        echo '</td><td>';
                        echo (formulaExist($matricola['cdl']) === 'Si'&& $matricola['cdl']==='TInf')? (($matricola['expected']['bonus'])? 'Si':'No'): ' ';
                        echo '</td><td class="gotBonus">';
                        echo (formulaExist($matricola['cdl']) === 'Si'&& $matricola['cdl']==='TInf') ?Bonus($matricola['cdl'], $matricola['matr'], $data_laurea) :' ';
                        echo '</td><td>';
                        echo (formulaExist($matricola['cdl']) === 'Si'&& $matricola['cdl']==='TInf')? $matricola['expected']['mediaInf']: ' ';
                        echo '</td><td class="gotMediaInf">';
                        echo (formulaExist($matricola['cdl']) === 'Si'&& $matricola['cdl']==='TInf') ?controlloMediaInf($matricola['cdl'], $matricola['matr'], $data_laurea) :' ';
                        echo '</td><td>';
                        echo Risultato($matricola, $data_laurea);
                        echo '</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>