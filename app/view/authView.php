<?php
require_once "components/form.php";
    class AuthView{
        private function create_login(){
             echo '<section class="min-h-screen w-full bg-blue-50 py-24 px-12">';
                echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 w-1/2">';
                    $form = new Form("", "POST", "Se connecter", "Se connecter","<p class='text-gray-600 text-sm my-8 text-center'>Entrez vos identifiants pour accéder à votre compte</p>", false);
                    $form->addField("username", "Nom d'utilisateur", "text");
                    $form->addField("pw", "Mot de passe", "password");
                    $form->render();
                echo "</div>";
            echo "</section>";
        }
        private function create_register(){
            $form = new Form("", "POST", "S'inscrire", "S'inscrire");
        }
        public function display_login(){
            $this->create_login();
        }
        public function display_register(){
            $this->create_register();
        }
    }
?>


