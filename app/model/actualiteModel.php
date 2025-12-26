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
        $this->deconnexion($con);
        return $actualites;
    }
    public function getNewById($id){
        $con = $this->connection();
        $new = $this->getByCol($con, 'news', 'id', $id);
        if(!$new){
            echo "Pas d'actualites a afficher";
        }
        $this->deconnexion($con);
        return $new[0];
    }
    public function createNew($title, $description, $image){
        $con = $this->connection();
        $this->insert($con, 'news',[
            'title' => $title,
            'description'=> $description,
            'image' => $image
        ]);
        if(!$new){
            echo "Erreur lors d'ajout d'une actualite";
        }
         $this->deconnexion($con);

    }
    public function updateNew($new_id,$title,$description,$image){
        $con = $this->connection();
        $new = $this->update($con, 'news',[
            'title' => $title,
            'description' => $description,
            'image' => $image
        ], 'id', $new_id);
        $this->deconnexion($con);
    }
    public function deleteNew($id){
        $con = $this->connection();
        $this->delete($con, 'news','id', $id);
        $this->deconnexion($con);
    }
}
?>