<?php
require_once "app/model/permissionModel.php";
require_once "app/view/projectView.php";
require_once "app/model/projectModel.php";
require_once "app/model/userModel.php";
require_once "app/model/partnersModel.php";
require_once "app/model/publicationModel.php";
require_once "baseController.php";
 class ProjectController extends BaseController{
    private function get_projects(){
        $projectModel =  new ProjectModel();
        $projects = $projectModel->getProjects();
        return $projects;
    }
     public function list_projects() {
        $projects  = $this->get_projects();
         $projectView = new ProjectView();
         $projectView->show_projects($projects);
     }
     private function getProjectById($id){
        $projectModel = new ProjectModel();
        $project = $projectModel->getProjectById($id);
        return $project;
     }
     private function get_members_project($id_project){
        $userModel =  new UserModel();
        $members = $userModel->getMembersByProject($id_project);
        return $members;
     }
     private function getProjectSupervisor($supervisor_id){
        $userModel = new UserModel();
        $supervisor = $userModel->getUserById($supervisor_id);
         return $supervisor;
       }
     private function get_partners_project($id_project){
        $partnermodel = new PartnersModel();
        $partners = $partnermodel->getPartnersByProject($id_project);
        return $partners;
     }
     private function get_publications_project($id_project){
       $publicationModel = new PublicationModel();
        $publications = $publicationModel->getPublicationsByProjectId($id_project);
        return $publications;
     }
     public function view_project($id){
        $project = $this->getProjectById($id);
        $members = $this->get_members_project($id);
        $partners = $this->get_partners_project($id);
        $publications = $this->get_publications_project($id);
        $projectView = new ProjectView();
        $projectView->show_project($project, $members, $partners, $publications);
     }



   public function show_projects(){
      $allowed = $this->getAllowedActions('projets');        
       $projects = $this->get_projects();
       foreach($projects as &$project){
         $project['members'] = $this->get_members_project($project['id']);
         $project['partners'] = $this->get_partners_project($project['id']);
         $project['publications'] = $this->get_publications_project($project['id']);
         $project['supervisor'] = $this->getProjectSupervisor($project['supervisor_id'])??'';
       }
       if($_SESSION['user'][0]['role'] != 'admin'){
            $projects = array_filter($projects, function($proj){
                 return 
                        (!empty($proj['supervisor']) && $proj['supervisor']['id'] == $_SESSION['user'][0]['id']) ||
                        (!empty($proj['members']) && in_array($_SESSION['user'][0]['id'], array_column($proj['members'], 'id')));
                });
       }
       $projectView = new ProjectView();
       $projectView->show_projects_admin($projects, $allowed);
   }

   public function  project_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $projM = new ProjectModel();
            $project = $projM->getProjectById($id);
        }
        else {
            //creating
            $project = null;
        }
        $projectView = new ProjectView();
        $users = (new UserModel())->getAll();
        $projectView->create_update_form($project, $users, $publications = [], $partners = []);
    }


   public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?page=gestion_projet");
        exit;
    }

    $title = $_POST['title'];
    $description  = $_POST['description'];
    $theme      = $_POST['theme'];
    $start_date   = $_POST['start_date'];
    $end_date     = $_POST['end_date'];
    $funding_type = $_POST['funding_type'];
    $status = $_POST['status'];
    $supervisor_id = $_POST['supervisor'];
   
    $image = $_POST['current_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/assets/';
        $filename  = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = $targetPath;
        }
    }


    $projM = new ProjectModel();

    if (isset($_POST['project_id'])) {
        $project_id = $_POST['project_id'];
         $projM->updateProject(
            $project_id,
            $title,
            $description,
            $theme,
            $start_date,
            $end_date,
            $funding_type,
            $image,
            $status,
            $supervisor_id
         );

    } else {
         $projM->createProject(
            $title,
            $description,
            $theme,
            $start_date,
            $end_date,
            $funding_type,
            $image,
            $status,
            $supervisor_id
         );
    }
    header("Location: index.php?page=gestion_projet");
    exit;
}

   public function delete_project(){
        $id = $_GET['id'];
        $projM = new ProjectModel();
        $projM->deleteProject($id);
        header("Location: index.php?page=gestion_projet"); 
    }
}
?>
