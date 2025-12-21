<?php
    require_once "app/model/userModel.php";
    require_once "app/view/userView.php";
 class UserController{

    public function getAll(){
        $userModel =  new UserModel();
        $members = $userModel->getAll();
        return $members;
    }
    public function update_user(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id  = $_POST['user_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $profile_picture = $_POST['current_profile_picture'];
            if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK){
                $uploadDir = 'public/assets/';
                $filename = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
                $targetPath = $uploadDir . $filename;
                if(move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)){
                    $profile_picture = $targetPath;
                }
            }

            $cv = $_POST['current_cv'];
            if(isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK){
                $uploadDir = 'public/cv/';
                $filename = uniqid() . '_' . basename($_FILES['cv']['name']);
                $targetPath = $uploadDir . $filename;
                if(move_uploaded_file($_FILES['cv']['tmp_name'], $targetPath)){
                    $cv = $targetPath;
                }
            }
            $speciality  = $_POST['speciality'];
            $post  = $_POST['post'];
            $grade  = $_POST['grade'];            
            $bio  = $_POST['bio'];

        }
        $userModel = new UserModel();
        $userModel->updateUser($user_id, $first_name, $last_name, $email, $profile_picture, $speciality, $post, $grade, $bio, $cv);
        header("Location: index.php?page=profile");
        exit;
    }

    public function show_form(){
        $id = $_GET['id'];
        $userM = new UserModel();
        $user = $userM->getUserById($id);
        $userV =  new UserView();
        $userV->userForm($user);
    }

    public function show_users(){
        
    }
 }
?>
