<?php
require_once "app/model/opportModel.php";
require_once "app/view/opportView.php";
require_once "baseController.php";
class OpportController extends BaseController{
    private function getAll(){
        $model = new OpportModel();
        $offers = $model->getAll();
        return $offers;
    }

    public function list_opport(){
        $offers = $this->getAll();
        $view = new OpportView();
        $view->show_offers($offers);
    }
    public function show_offres(){
         $offers = $this->getAll();
         $allowed = $this->getAllowedActions('offres');
        $view = new OpportView();
        $view->show_offers_admin($offers, $allowed);
    }

    public function offre_form(){
        if (isset($_GET['id'])){
            $id = $_GET['id'];
            $opportM = new OpportModel();
            $offer = $opportM->getOfferById($id);
        }
        else {
            //creating
            $offer = null;
        }
        $opportV =  new OpportView();
        $opportV->create_update_form($offer);
    }


    public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    
    $title = $_POST['title'];
    $description  = $_POST['description'];
    $type = $_POST['type'];
    $deadline = $_POST['deadline'];
    $requirements = $_POST['requirements'];
    $contact_email = $_POST['contact_email'];
    $status = $_POST['status'] ?? '';

    $opportM = new OpportModel();
    if (isset($_POST['offer_id'])) {
        $offer_id = $_POST['offer_id'];


        $opportM->updateOffer(
            $offer_id,
            $title,
            $description,
            $type,
            $requirements,
            $deadline,
            $contact_email,
            $status
        );

    } else {
        $offer_id = $opportM->createOffer(
            $title,
            $description,
            $type,
            $requirements,
            $deadline,
            $contact_email,
            $status
        );
    }
    header('location: index.php?page=gestion_offres');
    exit;
}
 public function delete_offre(){
        $id = $_GET['id'];
        $opportM = new OpportModel();
        $opportM->deleteOpport($id);
        header("Location: index.php?page=gestion_offres"); 
    }

}

?>