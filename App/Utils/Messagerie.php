<?php
namespace App\Utils;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Messagerie{
    public static function sendEmail($destinataire, $objet, $contenu){
        require './env.php';
        $mail = new PHPMailer(true);

        try {
            //!Paramètre du serveur de messagerie
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output = mettre 0 en pratique pour enlever les traces de debug
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $serveur_messagerie;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $login_messagerie;                     //SMTP username
            $mail->Password   = $password_messagerie;                   //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $port_messagerie;                       //ou 587 si 465 ne fonctionne pas. TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //!Recipients
            $mail->setFrom($login_messagerie, 'Administrateur Share&cook');
            $mail->addAddress($destinataire);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional -> ici boucle pour faire une newsletter
            // $mail->addReplyTo('info@example.com', 'Information'); //Pour permettre au client de répondre, sinon l'enlever
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //!Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $objet;
            $mail->Body    = $contenu;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();

        } catch (Exception $e) {
            die ("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
?>