<?php

namespace Laureandosi\API;

class GestioneCarrieraStudente
{

    public static function RestituisciAnagraficaStudente(string $matricola): array
    {
        // Prendo il file json che contiene l'anagrafica degli studenti
        $json = file_get_contents(dirname(__DIR__, 2) . "/resources/AnagraficaStudenti.json");
        $data = json_decode($json, true);

        //Recupero i dati relativi alla matricola e li salvo
        return[
            'nome' => $data[$matricola]['Entries']['Entry']['nome'],
            'cognome' => $data[$matricola]['Entries']['Entry']['cognome'],
            'EmailAteneo' => $data[$matricola]['Entries']['Entry']['emailAte']
        ];

    }
    public static function RestituisciCarrieraStudente(string $matricola): string
    {
        //Recupero qualsiasi esame sostenuto dallo studente, con relativo voto e CFU, dal file json
        $json = file_get_contents(dirname(__DIR__, 2) . "/resources/CarrieraStudenti.json");
        $data = json_decode($json, true);
        return json_encode($data[$matricola]);
    }

}