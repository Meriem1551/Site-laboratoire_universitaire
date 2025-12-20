<?php
require_once "app/view/contactView.php";
class ContactController{
    
    private function show_contact_form(){
        $contactV = new ContactView();
        $contactV->show_form();
    }
    private function send_message() {
    $name = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $to = "mm_boussaid@esi.dz";
    $subject = "Message de contact de $name $prenom";
    $body = "Nom: $name $prenom\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email\r\nReply-To: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        header('Location: index.php?page=contact&success=1');
        exit;
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}


    public function handle_contact(){
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->send_message();
         }
         else {
            $this->show_contact_form();
         }
    }
}


?>