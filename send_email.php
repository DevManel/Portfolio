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
            // Paramétrage SMTP (ici avec Gmail)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;  // Votre adresse email
            $mail->Password = MAIL_PASSWORD;  // Mot de passe d'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Sécurisation de la connexion
            $mail->Port = 587;  // Port pour TLS

            // L'adresse de l'expéditeur (utilisateur qui remplit le formulaire)
            $mail->setFrom($email, $first_name.' '.$last_name);  // L'email de l'utilisateur comme expéditeur
            $mail->addAddress(MAIL_USERNAME);  // Le destinataire

            // Contenu du message
            $mail->isHTML(true);
            $mail->Subject = "Vous avez reçu un message de : " . $email;  // Email de l'utilisateur
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
    header("Location: index.html");  // Assurez-vous que vous redirigez vers la même page ou une autre page appropriée
    exit();
}
?>

