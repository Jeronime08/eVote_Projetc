<?php
// debug errors (en dev seulement)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// autoload composer
require_once __DIR__ . '/../vendor/autoload.php';


// --- CONFIG SMTP (remplace par tes infos) ---
$mailConfig = [
    'host' => 'smtp.gmail.com',
    'username' => 'jeronimetestsonou@gmail.com',       // <-- ton email SMTP
    'password' => 'test@sonouSIL3',     // <-- mot de passe d'application (Gmail) ou mot de passe SMTP
    'port' => 587,
    'secure' => 'tls',
    'from_email' => 'no-reply@evote.com',
    'from_name' => 'eVote Bénin'
];

// destinataire de test
$toEmail = 'todofonjeronime@gmail.com'; // <-- mets ton email de test ici
$toName  = 'Moi Test';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // configuration SMTP
    $mail->isSMTP();
    $mail->Host       = $mailConfig['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $mailConfig['username'];
    $mail->Password   = $mailConfig['password'];
    $mail->SMTPSecure = $mailConfig['secure'];
    $mail->Port       = $mailConfig['port'];

    // expéditeur & destinataire
    $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
    $mail->addAddress($toEmail, $toName);

    // contenu
    $mail->isHTML(true);
    $mail->Subject = 'Test PHPMailer - eVote';
    $mail->Body    = '<p>Bonjour — ceci est un test d\'envoi via PHPMailer.</p><p>Si tu vois ce mail, PHPMailer fonctionne.</p>';

    // envoi
    $mail->send();
    echo "Email envoyé avec succès à $toEmail";
} catch (Exception $e) {
    echo "Erreur lors de l'envoi : " . $mail->ErrorInfo;
}
