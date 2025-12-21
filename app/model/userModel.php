<?php
require_once "baseModel.php";
class UserModel extends BaseModel{
 
    public function getMembersByProject($id_project){
        $con = $this->connection();
        $members = $this->requet($con, 'members.getMembersByProjectId', ['project_id' => $id_project]);
        $this->deconnexion($con);
        return $members;
    }
    public function getAuthors($id_pub){
        $con = $this->connection();
        $authors = $this->requet($con, 'users.getAuthorByPub', ['publication_id' => $id_pub]);
        $this->deconnexion($con);
        return $authors;
    }
    public function getUserById($id){
    $con = $this->connection();
    $user = $this->requet($con, 'users.getById', ['id' => $id]);
    $this->deconnexion($con);
    return $user[0];
    }
    public function getMembers($id_team){
        $con = $this->connection();
        $members = $this->requet($con, 'users.getMembers', ['id' => $id_team]);
        $this->deconnexion($con);
        return $members;
    }
    public function getDirector(){
        $con = $this->connection();
        $dir = $this->requet($con, 'users.getDir', []);
        $this->deconnexion($con);
        return $dir[0];
    }
    public function getAll(){
        $con = $this->connection();
        $users = $this->requet($con, 'users.getAll', []);
        $this->deconnexion($con);
        return $users;
    }


    public function updateProfile($user_id, $first_name, $last_name, $email, $profile_picture, $speciality, $post, $grade, $bio, $cv){
        $con = $this->connection();
        $user = $this->requet($con, 'users.updateProfile', [
            'first_name' => $first_name, 
            'last_name' => $last_name, 
            'email' => $email, 
            'pp' => $profile_picture, 
            'speciality' => $speciality, 
            'post' => $post, 
            'grade' => $grade,
            'user_id' => $user_id, 
            'bio' => $bio,
            'cv'=> $cv
        ]);
        if(!$user){
            echo "error";
        }
        $this->deconnexion($con);
    }


    public function updateUser($user_id, $first_name, $last_name, $email, $profile_picture, $speciality, $post, $grade, $bio, $cv, $username, $pw, $status, $role){
        $con = $this->connection();
        $user = $this->requet($con, 'users.updateUser', [
            'first_name' => $first_name, 
            'last_name' => $last_name, 
            'email' => $email, 
            'pp' => $profile_picture, 
            'speciality' => $speciality, 
            'post' => $post, 
            'grade' => $grade,
            'bio' => $bio,
            'cv'=> $cv,
            'user_id' => $user_id,
            'username' => $username,
            'pw' => $pw,
            'status' => $status, 
            'role' => $role
        ]);
        if(!$user){
            echo "error";
        }
        $this->deconnexion($con);
    }

    public function createUser($first_name, $last_name, $email, $profile_picture, $speciality, $post, $grade, $bio, $cv, $username, $pw, $status, $role){
        $con = $this->connection();
        $user_id = $this->insert($con, 'users.createUser', [
            'first_name' => $first_name, 
            'last_name' => $last_name, 
            'email' => $email, 
            'pp' => $profile_picture, 
            'speciality' => $speciality, 
            'post' => $post, 
            'grade' => $grade,
            'bio' => $bio,
            'cv'=> $cv,
            'username' => $username,
            'pw' => $pw,
            'status' => $status, 
            'role' => $role
        ]);
        $this->deconnexion($con);
        return $user_id;
    }

    public function deleteUser($id){
        $con = $this->connection();
        $this->requet($con, 'users.deleteUser', ['id' => $id]);

        $this->deconnexion($con);
    }
    public function getRoles(){
        $con = $this->connection();
        $roles = $this->requet($con, 'roles.getAll', []);
        $this->deconnexion($con);
        return $roles;
    }
}

?>