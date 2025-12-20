<?php
class AdminController{
    public function show(){
        $name = $_SESSION['user'][0]['username'];
        echo "hello {$name}";
    }
}

?>