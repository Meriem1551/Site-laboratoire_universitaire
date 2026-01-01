<?php
require_once "app/model/publicationModel.php";
require_once "app/view/publicationView.php";
require_once "app/model/userModel.php";
require_once "app/model/projectModel.php";
require_once "baseController.php";
class PublicationController extends BaseController{

    private function get_all_pubs(){
        $publicationModel = new PublicationModel();
        $publications = $publicationModel->getAllPubs();
        return $publications;
    }
    private function get_all(){
        $publicationModel = new PublicationModel();
        $publications = $publicationModel->getAll();
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
     private function getPubByUser($id){
        $publicationModel = new PublicationModel();
        $publications = $publicationModel->getPubByUser($id);
        return $publications;
     }



    public function show_pubs(){
        if($_SESSION['user'][0]['role'] !=='admin'){
            $pubs = $this->getPubByUser($_SESSION['user'][0]['id']);
        }
        else{
            $pubs = $this->get_all();
        }
        foreach($pubs as &$pub){
                $pub['authors'] = [$pub['first_name'].' '.$pub['last_name']];
        }
        $allowed = $this->getAllowedActions('publications');
        $publicationView = new PublicationView();
        $publicationView->show_pubs_admin($pubs, $allowed);
    }



     public function  pub_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $pub = $this->getPublicationById($id);
        }
        else {
            //creating
            $pub = null;
        }
        $pubV = new PublicationView();
        $projects = (new ProjectModel())->getProjects();
        $pubV->create_update_form($pub, $projects);
    }



    public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?page=gestion_publications");
        exit;
    }

    $title = $_POST['title'];
    $doi  = $_POST['doi'];
    $abstract      = $_POST['abstract'];
    $file_path   = $_POST['file_path'];
    $publication_date     = $_POST['publication_date'];
    $type = $_POST['type'];
    $domain = $_POST['domain'];
    $project_id = $_POST['project'];
   

    $pubM = new PublicationModel();

    if (isset($_POST['pub_id'])) {
        $pub_id = $_POST['pub_id'];
         $pubM->updatePub(
            $pub_id,
            $title,
            $doi,
            $abstract,
            $file_path,
            $publication_date,
            $type,
            $domain,
            $project_id
        );

    } else {
        $creator = $_SESSION['user'][0]['id'];
         $pubM->createPub(
            $title,
            $doi,
            $abstract,
            $file_path,
            $publication_date,
            $type,
            $domain,
            $project_id,
            $creator
         );
    }
    header("Location: index.php?page=gestion_publications");
    exit;
}
private function getAllUsers(){
    $userModel = new UserModel();
    $users = $userModel->getAll();
    return $users;
}
public function handle_authors(){
    $id_pub = $_GET['id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            //handle the form
            $id_author = $_POST['user_id'];
             $pubM = new PublicationModel();
            $pubM->addAuthor($id_pub, $id_author);
            header("Location: index.php?page=gestion_publications"); 
            exit;
    }
    $pub_authors = $this->get_authors_pub($id_pub);
    $authors = $this->getAllUsers();
    $pubV = new PublicationView();
    $pubV->show_authors($pub_authors, $authors);
}
public function delete_author(){
     $id_pub = $_GET['id_pub'];
    $id_author = $_GET['id_author'];
    $pubM = new PublicationModel();
    $pubM->validate($id_pub);
    header('Location: index.php?page=gestion_publications');
    exit;
}
public function validate(){
    $id_pub = $_GET['id'];
    $pubM = new PublicationModel();
    $pubM->validate($id_pub);
 header('Location: index.php?page=gestion_publications');
    exit;
}
public function reject(){
 $id_pub = $_GET['id'];
    $pubM = new PublicationModel();
    $pubM->reject($id_pub);
 header('Location: index.php?page=gestion_publications');
    exit;
}
}

?>