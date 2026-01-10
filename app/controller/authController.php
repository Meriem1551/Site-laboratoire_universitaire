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
        $this->display_login("Utilisateur non trouvé");
        return;
        }

        if ($user[0]['status_user'] !== 'active') {
            $this->display_login("Vous ne pouvez pas vous connecter : compte suspendu ou inactif");
            return;
        }

        if (!password_verify($pw, $user[0]['password'])) {
            $this->display_login("Mot de passe incorrect");
            return;
        }
        print_r($user);

        $_SESSION['user'] = $user;
        header($user[0]['role'] === "admin" ? 'Location: index.php?page=dashboard&role=admin' : 'Location: index.php?page=accueil');
        exit;
    }
    public function logout(){
        session_start();
        $_SESSION = []; 
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
    public function display_login($error= null){
        $authView = new AuthView();
        $authView->display_login($error);
    }
    public function display_register(){
        $authView = new AuthView();
        $authView->display_register();
    }
    }
?>