<?php 
session_start();
require 'vendor/autoload.php'; // Charge le fichier autoload de Composer

require 'config/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['envoyer'])) {
    // Extraction des variables de manière sécurisée
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Vérification que les champs sont remplis
    if ($first_name != "" && $last_name != "" && $email != "" && $message != "") {
        // Création de l'objet PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Paramétrage SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // L'adresse de l'expéditeur
            $mail->setFrom($email, $first_name.' '.$last_name);
            $mail->addAddress(MAIL_USERNAME);

            // Contenu du message
            $mail->isHTML(true);
            $mail->Subject = "Vous avez reçu un message de : " . $email;
            $mail->Body = "
                <p>Vous avez reçu un message de <strong>" . $email . "</strong></p>
                <p><strong>Nom : </strong>" .$first_name.' '.$last_name."</p>
                <p><strong>Message : </strong>" . nl2br($message) . "</p>
            ";

            // Envoi du mail
            $mail->send();
            $_SESSION['succes_message'] = "Message envoyé avec succès !";
        } catch (Exception $e) {
            $_SESSION['erreur_message'] = "Le message n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['erreur_message'] = "Veuillez remplir tous les champs.";
    }

    // Rediriger après l'envoi
    header("Location: index.html");
    exit();
}
?>

