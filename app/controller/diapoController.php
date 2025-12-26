<?php
require_once "app/view/diapoView.php";
require_once "app/model/diapoModel.php";
require_once "baseController.php";
class DiapoController extends BaseController{
    private function getAll(){
        $diapoModel = new DiapoModel();
        $diapo = $diapoModel->getDiaporama();
        return $diapo;
    }
    public function show_diapo(){
        $diaporama = $this->getAll();
        $view = new DiapoView();
        $allowed = $this->getAllowedActions('diaporama');
        $view->show_diapo($diaporama, $allowed);
    }
    public function diapo_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $diapoM = new DiapoModel();
            $slide = $diapoM->getSlide($id);
        }
        else {
            //creating
            $slide = null;
        }
        $diapoV =  new DiapoView();
        $diapoV->create_update_form($slide);
    }

    public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
    $title = $_POST['title'];
    $description  = $_POST['description'];
    $image = $_POST['current_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/assets/';
        $filename  = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = $targetPath;
        }
    }

    $diapoM = new DiapoModel();

    if (isset($_POST['slide_id'])) {
        $slide_id = $_POST['slide_id'];


        $diapoM->updateNew(
            $slide_id,
            $title,
            $description,
            $image
        );

    } else {
        $diapoM->createNew(
            $title,
            $description,
            $image
        );
    }

    header("Location: index.php?page=gestion_diaporama");
    exit;
}
public function delete_diapo(){
        $id = $_GET['id'];
        $diapoM = new DiapoModel();
        $diapoM->deleteSlide($id);
        header("Location: index.php?page=gestion_diaporama"); 
    }
}

?>