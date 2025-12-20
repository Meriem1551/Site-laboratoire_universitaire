<?php
require_once "baseModel.php";
class DiapoModel extends BaseModel{
    public function getDiaporama(){
        $con = $this->connection();
        $diapo = $this->requet($con, 'diapo.getAll');
    $this->deconnexion($con);

        if(!$diapo){
            die("Pas de diapo a afficher");
        }
        return $diapo;
    }
}
?>