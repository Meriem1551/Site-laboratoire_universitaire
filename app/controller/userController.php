<?php
    require_once "app/model/userModel.php";
    require_once "app/model/roleModel.php";
    require_once "app/model/publicationModel.php";
    require_once "app/view/userView.php";
    require_once "baseController.php";
 class UserController extends BaseController{

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
        $userModel->updateProfile($user_id, $first_name, $last_name, $email, $profile_picture, $speciality, $post, $grade, $bio, $cv);
        header("Location: index.php?page=profile");
        exit;
    }
//profile form
    public function show_form(){
        $id = $_GET['id'];
        $userM = new UserModel();
        $user = $userM->getUserById($id);
        $userV =  new UserView();
        $userV->userForm($user);
    }

    private function getNbPub($id_user){
        $pubM = new PublicationModel();
        $pubs = $pubM->getPubsByUser($id_user);
        return count($pubs);
    }

    public function show_users(){
        $allowed = $this->getAllowedActions('users');        
        $allowedRoles = $this->getAllowedActions('roles');

        $userV = new UserView();
        $users = $this->getAll();
        foreach($users as &$user){
            $user['nb_pubs'] = $this->getNbPub($user['id']);
        }
        $userV->show_users($allowed, $users, $allowedRoles);
    }

    
private function getRoles(){
    $roleM = new RoleModel();
    return $roleM->getRoles();
}

    public function user_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $userM = new UserModel();
            $user = $userM->getUserById($id);
        }
        else {
            //creating
            $user = null;
        }
        $roles = $this->getRoles();
        $userV =  new UserView();
        $userV->create_update_form($user, $roles);
    }


    public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $username   = $_POST['username'];
    $role       = $_POST['role'];
    $status     = isset($_POST['status']) ? 'active' : 'suspendu';

    $pw           = $_POST['pw'] ?? '';
    $confirmePw   = $_POST['confirme'] ?? '';
    $passwordHash = null;

    if (!empty($pw)) {
        if ($pw !== $confirmePw) {
            die("Les mots de passe ne correspondent pas");
        }
        $passwordHash = password_hash($pw, PASSWORD_DEFAULT);
    }

    $speciality = $_POST['speciality'] ?? '';
    $post       = $_POST['post'] ?? '';
    $grade      = $_POST['grade'] ?? '';
    $bio        = $_POST['bio'] ?? '';

    $profile_picture = $_POST['current_profile_picture'] ?? '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/assets/';
        $filename  = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
            $profile_picture = $targetPath;
        }
    }

    $cv = $_POST['current_cv'] ?? '';
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/cv/';
        $filename  = uniqid() . '_' . basename($_FILES['cv']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $targetPath)) {
            $cv = $targetPath;
        }
    }

    $userModel = new UserModel();

    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        if ($passwordHash === null) {
            $currentUser = $userModel->getUserById($user_id);
            $passwordHash = $currentUser['password'];
        }

        $userModel->updateUser(
            $user_id,
            $first_name,
            $last_name,
            $email,
            $profile_picture,
            $speciality,
            $post,
            $grade,
            $bio,
            $cv,
            $username,
            $passwordHash,
            $status,
            $role
        );

    } else {
        if ($passwordHash === null) {
            die("Le mot de passe est requis pour créer un utilisateur.");
        }

        $userModel->createUser(
            $first_name,
            $last_name,
            $email,
            $profile_picture,
            $speciality,
            $post,
            $grade,
            $bio,
            $cv,
            $username,
            $passwordHash,
            $status,
            $role
        );
        $eventM = new EventModel();
        $events = $eventM->getAllEvents();
        $newUser = ['email' => $email];
        foreach ($events as $event) {
            createGoogleCalendarEventWithUsers($event, [$newUser]);
        }
    }

    header("Location: index.php?page=gestion_users");
    exit;
}


    public function delete_user(){
        $id = $_GET['id'];
        $userM = new UserModel();
        $userM->deleteUser($id);
        header("Location: index.php?page=gestion_users"); 
    }

    public function get_project_members($id_project){
        $userModel =  new UserModel();
        $members = $userModel->getMembersByProject($id_project);
        return $members;
    }
public function get_team_members($id_team){
    $userModel =  new UserModel();
        $members = $userModel->getMembers($id_team);
        return $members;
}
    public function handle_member() {
        $id_project = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $project_id = $_GET['id_project'];
            $member_id = $_POST['member_id'];
            $userModel =  new UserModel();
            $userModel->addMembersToProject($project_id, $member_id);
            header("Location: index.php?page=gestion_projet"); 
            exit;
        }
        $users  = $this->getAll();
        $project_members = $this->get_project_members($id_project);
        $userView = new UserView();
        $userView->show_members($users, $project_members);
     }

     public function handle_team_member() {
        $id_team = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $team_id = $_GET['id_team'];
            $member_id = $_POST['member_id'];
            $userModel =  new UserModel();
            $userModel->addMembersToTeam($team_id, $member_id);
            header("Location: index.php?page=gestion_equipes"); 
            exit;
        }
        $users  = $this->getAll();
        $team_members = $this->get_team_members($id_team);
        $userView = new UserView();
        $userView->show_team_members($users, $team_members);
     }
    public function delete_member() {
        $id_project = $_GET['id_project'];
        $id_member = $_GET['id_member'];
        $userM =  new UserModel();
        $userM->deleteMemberFromProject($id_project, $id_member);
        header("Location: index.php?page=gestion_projet");
    }
    public function delete_team_member() {
        $id_team = $_GET['id_team'];
        $id_member = $_GET['id_member'];
        $userM =  new UserModel();
        $userM->deleteMemberFromTeam($id_team, $id_member);
        header("Location: index.php?page=gestion_equipes");
    }
   public function show_member(){
    $id = $_GET['id'];
    $userM = new UserModel();
    $pubM  = new PublicationModel();
    $user = $userM->getUserById($id);
    if (!$user) {
        return null;
    }
    $user['publications'] = array_filter(
    $pubM->getPubsByUser($id) ?? [],
    function($pub) {
        return isset($pub['status']) && $pub['status'] === 'valide';
    }
    );
    $view = new UserView();
    $view->show_member($user);
}

 }
?>
