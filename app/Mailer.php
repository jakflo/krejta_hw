<?php
namespace App;

use \PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public function getMailer(): PHPMailer
    {
        $conf = new \Config\Loader('mailer');
        
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $conf->getProp('host');
        $mail->SMTPAuth = true;
        $mail->Username = $conf->getProp('userName');
        $mail->Password = $conf->getProp('password');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $conf->getProp('port');
        $mail->setFrom($conf->getProp('fromEmail'), $conf->getProp('fromName'));
        $mail->CharSet = "UTF-8";
        
        return $mail;
    }
    
    public function send(string|array $recipients, string $subject, string $body)
    {
        $mail = $this->getMailer();
        
        $recipientsArray = is_array($recipients) ? $recipients : [$recipients];
        foreach ($recipientsArray as $recipient) {
            $mail->addAddress($recipient);
        }
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        $mail->send();
    }
    
}
