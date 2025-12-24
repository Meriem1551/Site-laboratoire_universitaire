<?php
require_once "baseModel.php";
require_once __DIR__ . "/../controller/authController.php";
class AuthModel extends BaseModel{
    

    public function login($username){
        $connection = $this->connection();

        if ($username === '') {
            die('Username and password are required.');
        }

        $user = $this->getByCol($connection, 'users', 'username', $username);
        $this->deconnexion($connection);
        return $user;
}
}

?>