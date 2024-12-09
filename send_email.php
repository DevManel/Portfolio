<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        //l'adresse mail du destinataire
        $to = 'manel-mokhtari@hotmail.com';
        $subject = 'Nouveau message de formulaire';

        //corps du message
        $body = "Prénom: $firstName\nNom: $lastName\nEmail: $email\n\nMessage: \n$message";

        //En-tête
        $headers = "From: $email";

        //Envoi du message
        if(mail($to, $subject, $body, $headers)){
            echo "Votre message a été envoyé avec succès";
    } else {
        echo "Une erreur s'est produite. Essayez à nouveau.";
    }
}