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
}

?>