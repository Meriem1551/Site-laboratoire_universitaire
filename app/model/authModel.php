<?php
require_once "baseModel.php";
require_once __DIR__ . "/../controller/authController.php";
class AuthModel extends BaseModel{
    

    public function login($username, $pw){
        $connection = $this->connection();

        if ($username === '' || $pw === '') {
            die('Username and password are required.');
        }

        $user = $this->requet($connection, 'user.login', ['username'=> $username, 'password'=>$pw]);
        $this->deconnexion($connection);
        return $user;
}
public function register(){//pass infos
    // $baseModel = new BaseModel();
    // $connection = $baseModel->connection($this->db_name, $this->host, $this->username, $this->password);


    // $baseModel->requet($connection, 'user.login', ['username'=> $username, 'password'=>$pw]);
    // $baseModel->deconnexion($connection);
    // return $user;
}
}

?>