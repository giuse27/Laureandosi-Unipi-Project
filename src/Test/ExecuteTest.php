<?php

namespace Laureandosi\Test;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;
use Laureandosi\Core\CarrieraLaureando;
use Laureandosi\Core\CarrieraLaureandoInf;

$config = new FileConfigurazione();

function formulaExist(string $cdl): string
{
    global $config;
    $data = $config->fileMediaEEmail->getJsonData();
    if (!isset($data['corsi'][$cdl])) return 'No';
    return 'Si';
}

function controlloMediaPesata(string $cdl, string $matr, string $dataLaurea): string {
    if($cdl==="TInf") {
        $carriera = new CarrieraLaureandoInf($matr, $cdl, $dataLaurea);
    } else {
        $carriera = new CarrieraLaureando($matr, $cdl, $dataLaurea);
    }
    return round($carriera->getMedia(), 3);
}

function controlloCFUMedia(string $cdl, string $matr, string $dataLaurea): int {
    if($cdl==="TInf") {
        $carriera = new CarrieraLaureandoInf($matr, $cdl, $dataLaurea);
    } else {
        $carriera = new CarrieraLaureando($matr, $cdl, $dataLaurea);
    }
    return $carriera->getCFUMedia();
}

function controlloCFUTotali(string $cdl, string $matr, string $dataLaurea): int {
    if($cdl==="TInf") {
        $carriera = new CarrieraLaureandoInf($matr, $cdl, $dataLaurea);
    } else {
        $carriera = new CarrieraLaureando($matr, $cdl, $dataLaurea);
    }
    return $carriera->getTotaleCfu();
}

function Bonus( string $cdl, string $matr, string $dataLaurea): string {

    $carriera = new CarrieraLaureandoInf($matr, $cdl, $dataLaurea);
    return ($carriera->isBonus()) ? 'Si' : 'No';

}

function controlloMediaInf( string $cdl, string $matr, string $dataLaurea): float {

    $carriera = new CarrieraLaureandoInf($matr, $cdl, $dataLaurea);
    return round($carriera->getMediaEsamiInformatici(), 3);

}

function Risultato(array $matricola, string $dataLaurea): string {
    if (formulaExist($matricola['cdl']) === 'Si') {
        $mediaCalcolata = controlloMediaPesata($matricola['cdl'], $matricola['matr'], $dataLaurea);
        $cfuMediaCalcolati = controlloCFUMedia($matricola['cdl'], $matricola['matr'], $dataLaurea);
        $cfuTotaliCalcolati = controlloCFUTotali($matricola['cdl'], $matricola['matr'], $dataLaurea);
        $bonusCalcolato = ($matricola['cdl'] === 'TInf') ? Bonus($matricola['cdl'], $matricola['matr'], $dataLaurea) : ' ';
        $mediaInfCalcolata = ($matricola['cdl'] === 'TInf') ?controlloMediaInf($matricola['cdl'], $matricola['matr'], $dataLaurea): ' ';

        $testPassed = true;

        // Controlla i parametri a comune per tutti i corsi
        if (round($mediaCalcolata, 3) != round($matricola['expected']['media'], 3) ||
            $cfuMediaCalcolati != $matricola['expected']['cfuMedia'] ||
            $cfuTotaliCalcolati != $matricola['expected']['cfuTotali']) {
            $testPassed = false;
        }

        // Controlli solo per T. Ing. Informatica se presente
        if (isset($matricola['expected']['bonus'])) {
            if (($bonusCalcolato === 'Si') !== ($matricola['expected']['bonus'] === true)) {
                $testPassed = false;
            }
        }

        if (isset($matricola['expected']['mediaInf']) && is_numeric($mediaInfCalcolata)) {
            if (round($mediaInfCalcolata, 3) != round($matricola['expected']['mediaInf'], 3)) {
                $testPassed = false;
            }
        }

        if ($testPassed) {
            return '<p class="test-passed">Test superato</p>';
        } else {
            return '<p class="test-failed">Test fallito</p>';
        }
    } else {
        return '<p class="test-failed">Test Fallito</p>';
    }
}