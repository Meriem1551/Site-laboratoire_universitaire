<?php
require_once "baseModel.php";
class PublicationModel extends BaseModel{

public function getAllPubs(){
    $con = $this->connection();
    $publication = $this->requet($con, 'pubs.getAll', []);
    $this->deconnexion($con);
    return $publication;
}

public function getAll(){
    $con = $this->connection();
    $publication = $this->requet($con, 'pubs.getPubs', []);
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
    public function getPubByUser($user_id){
        $con = $this->connection();
        $publications = $this->requet($con, 'pubs.getByUser', ['id' => $user_id]);
        $this->deconnexion($con);
        return $publications;
    }
    public function createPub($title,$doi,$abstract,$file_path,$publication_date,$type,$domain,$project_id, $creator){
        $con = $this->connection();
        $id = $this->insert($con, 'publications', ['title' => $title, 'doi' => $doi, 'abstract' => $abstract, 'file_path' => $file_path, 'publication_date' => $publication_date, 'type' => $type, 'domain' => $domain, 'project_id' => $project_id]);
        $this->insert($con, 'publication_authors', ['publication_id' => $id, 'user_id' => $creator]);
        $this->deconnexion($con);
    }
    public function updatePub($pub_id,$title,$doi,$abstract,$file_path,$publication_date,$type,$domain,$project_id){
        $con = $this->connection();
        $this->update($con, 'publications', ['title' => $title, 'doi' => $doi, 'abstract' => $abstract, 'file_path' => $file_path, 'publication_date' => $publication_date, 'type' => $type, 'domain' => $domain, 'project_id' => $project_id, 'status' => 'non-valide'], 'id', $pub_id);
        $this->deconnexion($con);
    }
    public function deleteAuthor($id_pub, $id_author){
        $con = $this->connection();
        $publications = $this->requet($con, 'pubs.deleteAuthor', ['id_pub' => $id_pub, 'id_user' => $id_author]);
        $this->deconnexion($con);
    }
    public function addAuthor($id_pub, $id_author){
        $con = $this->connection();
        $publications = $this->insert($con, 'publication_authors', ['publication_id' => $id_pub, 'user_id' => $id_author]);
        $this->deconnexion($con);
    }
    public function validate($id){
        $con = $this->connection();
        $this->update($con, 'publications', ['status' => 'valide'], 'id', $id);
        $this->deconnexion($con);
    }
    public function reject($id){
        $con = $this->connection();
        $this->update($con, 'publications', ['status' => 'rejete'], 'id', $id);
        $this->deconnexion($con);
    }
}
?>