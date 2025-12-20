<?php
require_once "app/view/profileView.php";
require_once "app/model/userModel.php";

class ProfileController{
    private function get_user(){
        $id = $_SESSION['user'][0]['id'];
        $userM = new UserModel();
        return $userM->getUserById($id);
    }
    public function show_profile(){
        $user = $this->get_user();
        $profile = new ProfileView();
        $profile->show_page($user);
    }
}

?>