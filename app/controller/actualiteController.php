<?php
require_once "app/model/actualiteModel.php";
require_once "app/view/actualiteView.php";
class ActualiteController{
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
}
?>