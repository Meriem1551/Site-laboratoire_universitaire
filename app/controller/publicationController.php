<?php
require_once "app/model/publicationModel.php";
require_once "app/view/publicationView.php";
require_once "app/model/userModel.php";
class PublicationController{

    private function get_all_pubs(){
        $publicationModel = new PublicationModel();
        $publications = $publicationModel->getAllPubs();
        return $publications;
    }

    private function getPublicationById($id){
        $publicationModel = new PublicationModel();
        $publication = $publicationModel->getPublicationById($id);
        return $publication;
     }

     public function get_pubs_project($id_project){
        $publicationModel = new PublicationModel();
        $publications = $publicationModel->getPublicationsByProjectId($id_project);
        return $publications;
    }

    public function get_authors_pub($id_pub){
        $userModel = new UserModel();
        $authors = $userModel->getAuthors($id_pub);
        return $authors;
    }

    public function list_publications(){
        $publications = $this->get_all_pubs();
        $publicationView = new PublicationView();
        $publicationView->show_publications($publications);
    }
     
     public function view_publication($id){
        $publication = $this->getPublicationById($id);
        $authors = $this->get_authors_pub($id);
        $publicationView = new PublicationView();
        $publicationView->show_publication($publication, $authors);
     }


   
}

?>