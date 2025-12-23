<?php
require_once "app/model/authModel.php";
require_once "app/view/authView.php";
class AuthController{
    
    public function handle_login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->login();
        } else {
            $this->display_login();
        }
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $pw = $_POST['pw'] ?? '';
        }

        $authModel = new AuthModel();

        $user = $authModel->login($username);
         if (!$user) {
            echo "<p style='color:red;'>Utilisateur non trouvé</p>";
            $this->display_login();
            return;
        }
        if (password_verify($pw, $user[0]['password'])) {
        $_SESSION['user'] = $user;
        if ($user[0]['role'] === "admin") {
            header('Location: index.php?page=dashboard&role=admin');
        } else {
            header('Location: index.php?page=accueil');
        }
        exit;
        } else {
            echo "<p style='color:red;'>Mot de passe incorrect</p>";
            $this->display_login();
        }
    }
    public function logout(){
        session_start();
        $_SESSION = []; 
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
    public function display_login(){
        $authView = new AuthView();
        $authView->display_login();
    }
    public function display_register(){
        $authView = new AuthView();
        $authView->display_register();
    }
    }
?>