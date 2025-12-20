<?php
require_once "baseModel.php";
class ActualiteModel extends BaseModel{

    public function getActualitesHome(){
        $con = $this->connection();
        $actualites = $this->requet($con, 'news.getByLimit');
        $this->deconnexion($con);

        if(!$actualites){
            echo "Pas d'actualites a afficher";
        }
        return $actualites;
    }

    public function getAllActuals(){
        $con = $this->connection();
        $actualites = $this->requet($con, 'news.getAll');
        if(!$actualites){
            echo "Pas d'actualites a afficher";
        }
        return $actualites;
    }
}
?>