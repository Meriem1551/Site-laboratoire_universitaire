<?php
require_once "app/view/projectView.php";
require_once "app/model/projectModel.php";
require_once "app/model/userModel.php";
require_once "app/model/partnersModel.php";
require_once "app/model/publicationModel.php";
 class ProjectController{
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

 }
?>
