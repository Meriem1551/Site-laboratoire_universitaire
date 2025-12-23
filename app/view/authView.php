<?php
require_once "components/form.php";

class AuthView {
    private function create_login() {
        echo '<section class="min-h-screen w-full bg-blue-50 py-24 px-12">';
        echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 w-1/2">';
        
        $form = new Form(
            "", 
            "POST", 
            "Se connecter", 
            "Se connecter", 
            "<p class='text-gray-600 text-sm my-8 text-center'>Entrez vos identifiants pour accéder à votre compte</p>", 
            false
        );

        $form->addInput("username", "Nom d'utilisateur", "", "Entrez votre username", "text");
        $form->addInput("pw", "Mot de passe", "", "Entrez votre mot de passe", "password");

        $form->render();
        
        echo "</div>";
        echo "</section>";
    }

    public function display_login() {
        $this->create_login();
    }
}
?>
