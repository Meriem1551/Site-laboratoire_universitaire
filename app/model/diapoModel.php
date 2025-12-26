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
    public function getSlide($id){
         $con = $this->connection();
        $diapo = $this->getByCol($con, 'diaporama', 'id', $id);
        $this->deconnexion($con);
        if(!$diapo){
            die("Pas de diapo a afficher");
        }
        return $diapo[0];
    }
    public function createNew($title, $description, $image){
        $con = $this->connection();
        $this->insert($con, 'diaporama',[
            'title' => $title,
            'description'=> $description,
            'image' => $image
        ]);
         $this->deconnexion($con);

    }
    public function updateNew($slide_id,$title,$description,$image){
        $con = $this->connection();
        $this->update($con, 'diaporama',[
            'title' => $title,
            'description' => $description,
            'image' => $image
        ], 'id', $slide_id);
        $this->deconnexion($con);
    }
    public function deleteSlide($id){
        $con = $this->connection();
        $this->delete($con, 'diaporama','id', $id);
        $this->deconnexion($con);
    }
}
?>