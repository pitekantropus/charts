<?php
namespace Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/libs/mailer/Exception.php';
require '/libs/mailer/PHPMailer.php';
require '/libs/mailer/SMTP.php';

function sendNoreply($to, $subject, $content, $alt_content) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'serwer2065161.home.pl';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply@dobrejzabawy.pl';
    $mail->Password   = 'Mastodont24!';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->setFrom('noreply@dobrejzabawy.pl', 'DobrejZabawy NoReply');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->AddEmbeddedImage('../images/logo/logo_header.png', 'logo');
    $mail->CharSet    = 'utf-8';
    $mail->Subject    = $subject;
    $mail->Body       = $content;
    $mail->AltBody    = $alt_content;

    $mail->send();
}

function sendFromUser($user, $userEmail, $content, $alt_content) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'serwer2065161.home.pl';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply@dobrejzabawy.pl';
    $mail->Password   = 'Mastodont24!';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->setFrom('noreply@dobrejzabawy.pl', "$user z DobrejZabawy");
    $mail->addAddress('kontakt@dobrejzabawy.pl');
    $mail->addReplyTo($userEmail);
    $mail->isHTML(true);
    $mail->CharSet    = 'utf-8';
    $mail->Subject    = "Wiadomość od użytkownika $user";
    $mail->Body       = $content;
    $mail->AltBody    = $alt_content;

    $mail->send();
}
?>