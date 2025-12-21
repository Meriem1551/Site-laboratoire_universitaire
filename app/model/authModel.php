<?php
require_once "baseModel.php";
require_once __DIR__ . "/../controller/authController.php";
class AuthModel extends BaseModel{
    

    public function login($username, $pw){//remove the password
        $connection = $this->connection();

        if ($username === '' || $pw === '') {
            die('Username and password are required.');
        }

        $user = $this->requet($connection, 'user.login', ['username'=> $username, 'password'=>$pw]);
        $this->deconnexion($connection);
        return $user;
}
}

?>