<?php
require_once "app/model/actualiteModel.php";
require_once "app/view/actualiteView.php";
require_once "baseController.php";
class ActualiteController extends BaseController{
    private function get_all_actuals(){
        $actualiteModel = new ActualiteModel();
        $actualites = $actualiteModel->getAllActuals();
        return $actualites;
    }
    public function show_actualite_page(){
        $actualites = $this->get_all_actuals();
        $actView = new ActualiteView();
        $actView->displayActualites($actualites);
    }
    public function show_news(){
        $news = $this->get_all_actuals();
        $view = new ActualiteView();
        $allowed = $this->getAllowedActions('actualites');
        $view->show_news($news, $allowed);
    }

    public function new_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $newM = new ActualiteModel();
            $new = $newM->getNewById($id);
        }
        else {
            //creating
            $new = null;
        }
        $newV =  new ActualiteView();
        $newV->create_update_form($new);
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

    $newM = new ActualiteModel();

    if (isset($_POST['new_id'])) {
        $new_id = $_POST['new_id'];


        $newM->updateNew(
            $new_id,
            $title,
            $description,
            $image
        );

    } else {
        $newM->createNew(
            $title,
            $description,
            $image
        );
    }

    header("Location: index.php?page=gestion_actualites");
    exit;
}
 public function delete_new(){
        $id = $_GET['id'];
        $newM = new ActualiteModel();
        $newM->deleteNew($id);
        header("Location: index.php?page=gestion_actualites"); 
    }
}
?>