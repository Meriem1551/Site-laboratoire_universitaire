<?php
require_once "baseController.php";
require_once "app/model/partnersModel.php";
require_once "app/view/partnerView.php";
class PartnerController extends BaseController{
    private function get_partners(){
        $partnerModel =  new PartnersModel();
        $partners = $partnerModel->getPartners();
        return $partners;
    }
    private function get_project_partners(){
        $id_project = $_GET['id'];
        $partnerModel =  new PartnersModel();
        $partners = $partnerModel->getPartnersByProject($id_project);
        return $partners;
    }
     public function handle_partner() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            //handling add partner to the project
            $project_id = $_GET['id_project'];
            $partner_id = $_POST['partner_id'];
            $partnerModel =  new PartnersModel();
            $partnerModel->addPartnerToProject($project_id, $partner_id);
            header("Location: index.php?page=gestion_projet"); 
            exit;
        }
        $partners  = $this->get_partners();
        $projects_partners = $this->get_project_partners();
        $partnerView = new PartnerView();
        $partnerView->show_partners($partners, $projects_partners);
     }
    public function delete_partner_project() {
        $id_project = $_GET['id_project'];
        $id_partner = $_GET['id_partner'];
        $partnerModel =  new PartnersModel();
        $partnerModel->deletePartnerFromProject($id_project, $id_partner);
        header("Location: index.php?page=gestion_projet");
     }


     //gestion des projets page
     public function show_partners() {
         $allowed = $this->getAllowedActions('partners'); 
        $partners  = $this->get_partners();
        $partnerView = new PartnerView();
        $partnerView->show_all_partners($partners, $allowed);
     }

     public function partner_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $partM = new PartnersModel();
            $partner = $partM->getPartnerById($id);
        }
        else {
            //creating
            $partner = null;
        }
        $partnerV =  new PartnerView();
        $partnerV->create_update_form($partner);
    }



     public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $name = $_POST['name'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $logo_path = $_POST['current_logo'] ?? '';
    if (isset($_FILES['logo_path']) && $_FILES['logo_path']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/assets/partners/';
        $filename  = uniqid() . '_' . basename($_FILES['logo_path']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['logo_path']['tmp_name'], $targetPath)) {
            $logo_path = $targetPath;
        }
    }

    $partModel = new PartnersModel();

    if (isset($_POST['partner_id'])) {
        $partner_id = $_POST['partner_id'];

        $partModel->updatePartner(
            $partner_id,
            $name,
            $type,
            $description,
            $logo_path
        );

    } else {
        $partModel->createPartner(
            $name,
            $type,
            $description,
            $logo_path
        );
    }

    header("Location: index.php?page=gestion_partners");
    exit;
}


    public function delete_partner(){
        $id = $_GET['id'];
        $partnerM = new PartnersModel();
        $partnerM->deletePartner($id);
        header("Location: index.php?page=gestion_partners"); 
    }

}
?>