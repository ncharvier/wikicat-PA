<?php
namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Lib/PHPMailer/src/Exception.php';
require 'Lib/PHPMailer/src/PHPMailer.php';
require 'Lib/PHPMailer/src/SMTP.php';

/*

Usage example :

$email = new PHPMailerManager();
$retour = $email->send('teddy.gauthier@outlook.com', 'email de test', 'je suis un email de test');
echo $retour ? 'email envoyer' : 'erreur';

*/

class PHPMailerManager 
{
    private static $instance = null;

    private $mail;

    private function __construct()
    {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = 1;
        $this->mail->Host = MAILHOST;
        $this->mail->Port = MAILPORT;
        $this->mail->SMTPAuth = MAILSMTPAUTH;

        if ($this->mail->SMTPAuth) {
            $this->mail->SMTPSecure = MAILSECURE;
            $this->mail->Username = MAILUSERNAME;
            $this->mail->Password = MAILPWD;
        }
    }

    public function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new PHPMailerManager();
        }

        return self::$instance;
    }

    /**
     * send an email
     * 
     * @param String to : email
     * @param String subject : subject of email
     * @param String body : content of email
     * @return bool : false on error
     */
    public function send(string $to, string $subject, string $body): bool
    {
        $this->mail->SetFrom(MAILUSERNAME, MAILNAME);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->AddAddress($to);

        return $this->mail->send();
    }
}
