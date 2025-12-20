<?php
require_once "baseModel.php";
class ProjectModel extends BaseModel{
   
    public function getProjects(){
        $con = $this->connection();
        $projects = $this->requet($con, 'projects.getAll');
        $this->deconnexion($con);
        return $projects;
    }
    public function getProjectById($id){
        $con = $this->connection();
        $project = $this->requet($con, 'projects.getById', ['id' => $id]);
        $this->deconnexion($con);
        return $project[0];
    }
}
?>