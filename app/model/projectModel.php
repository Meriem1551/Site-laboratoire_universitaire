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

    public function updateProject($project_id,$title,$description,$theme,$start_date,$end_date,$funding_type,$image, $status, $supervisor_id){
        $con = $this->connection();
        $project = $this->update($con, 'projects', [
            'title' => $title, 
            'description' => $description, 
            'theme' => $theme, 
            'start_date' => $start_date, 
            'end_date' => $end_date, 
            'funding_type' => $funding_type, 
            'image' => $image,
            'status' => $status,
            'supervisor_id' => $supervisor_id
        ], 'id', $project_id,);
        $this->deconnexion($con);
    }   

    public function createProject($title,$description,$theme,$start_date,$end_date,$funding_type,$image, $status, $supervisor_id){
        $con = $this->connection();
        $this->insert($con, 'projects', [
            'title' => $title, 
            'description' => $description, 
            'theme' => $theme, 
            'start_date' => $start_date, 
            'end_date' => $end_date, 
            'funding_type' => $funding_type, 
            'image' => $image,
            'status' => $status,
            'supervisor_id' => $supervisor_id
        ]);
        $this->deconnexion($con);
    }
    public function deleteProject($id){
        $con = $this->connection();
        $this->delete($con, 'projects', 'id', $id);
        $this->deconnexion($con);
    }
}
?>