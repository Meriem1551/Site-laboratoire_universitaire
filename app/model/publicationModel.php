<?php
require_once "baseModel.php";
class PublicationModel extends BaseModel{

public function getAllPubs(){
    $con = $this->connection();
    $publication = $this->requet($con, 'pubs.getAll', []);
    $this->deconnexion($con);
    return $publication;
}


public function getPublicationById($id) {
        $con = $this->connection();
        $publication = $this->requet($con, 'pubs.getById', ['id' => $id]);
        $this->deconnexion($con);
        return $publication[0];
    }

public function getPubsByUser($id_user){
    $con = $this->connection();
        $publications = $this->requet($con, 'pubs.getPubsUser', ['id_user' => $id_user]);
        $this->deconnexion($con);
        return $publications;
}

    public function getPublicationsByProjectId($projectId) {
        $con = $this->connection();
        $publications = $this->requet($con, 'pubs.getByProjectId', ['project_id' => $projectId]);
        $this->deconnexion($con);
        return $publications;
    }
}
?>