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
}

?>