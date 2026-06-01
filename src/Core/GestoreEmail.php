<?php

namespace Laureandosi\Core;

// Carico l'autoloader di Composer per far funzionare i namespace
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class GestoreEmail
{
    private FileConfigurazione $fileConfigurazione;

    private int $delaySpam; // Tempo in secondi per evitare spam
    private string $nomeMittente;
    private string $mittente;
    private string $oggettoEmail;
    private string $corpoEmail;
    private string $host;
    private string $cdl;

    /**
     * Costruttore che accetta il corso di laurea per cui si vogliono inviare le email. 
     * Carica la configurazione email dal file di configurazione e imposta i parametri necessari per l'invio delle email.
     */
    public function __construct(string $cdl)
    {   
        // accedo al file di configurazione per caricare i parametri email
        $this->fileConfigurazione = new FileConfigurazione();
        $config = $this->fileConfigurazione->getEmailConfig();

        // configurazione dei parametri email
        $this->nomeMittente = $config['email']['fromName'];
        $this->mittente = $config['email']['fromMail'];
        $obj = $config['email']['subject'];
        $this->oggettoEmail = str_replace('INSERISCI_CDL', $config['corsi'][$cdl]['cdl'], $obj);
        $this->corpoEmail = $config['email']['body'];
        $this->host = $config['email']['host'];
        $this->cdl = $cdl;

        // imposto infine il tempo di delay per evitare spam (def. 13 secondi)
        $this->delaySpam = 13;
    }

    /**
     * Invia un'email con allegato al destinatario specificato. 
     * Restituisce un array con i risultati dell'operazione, inclusi eventuali errori.
     */
    public function InviaEmailConAllegato(string $destinatario, string $allegato = ''): array
    {
        $risultati = [];

        $mail = new PHPMailer(true);

        $pathAllegato = dirname(__DIR__, 2) . '/prospetti/' . $this->cdl . '/' . $allegato;
        if (!file_exists($pathAllegato)) {
            $risultati['success'] = false;
            $risultati['type'] = 'error';
            $risultati['message'] = "Errore: allegato non trovato ($allegato).";
            return $risultati;
        }
        
        try {

            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 25;

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom($this->mittente, $this->nomeMittente);
            $mail->addAddress($destinatario);

            $mail->Subject = $this->oggettoEmail;
            $mail->Body = $this->corpoEmail;

            $mail->addAttachment($pathAllegato);

            $mail->send();
            $mail->smtpClose();

            $risultati['success'] = true;
            $risultati['type'] = 'success';
            $risultati['message'] = "Email inviata con successo a $destinatario.";
            return $risultati;

        } catch (Exception $e) {
            $risultati['success'] = false;
            $risultati['type'] = 'error';
            $risultati['message'] = "Errore durante l'invio dell'email: " . $e->getMessage();
            return $risultati;
        }
    }
}