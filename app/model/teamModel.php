<?php
require_once "baseModel.php";
class TeamModel extends BaseModel{

public function get_teams(){
    $con = $this->connection();
    $teams = $this->requet($con, 'teams.getAll', []);
    $this->deconnexion($con);
    return $teams;
}
public function get_team_by_id($id){
    $con = $this->connection();
    $team = $this->requet($con, 'teams.getById', ['id' => $id]);
    $this->deconnexion($con);
    return $team[0];
}

public function updateTeam($team_id,$name,$description,$research_themes,$team_leader_id){
    $con = $this->connection();
    $params = [
        'name' => $name, 
        'description' => $description, 
        'research_themes' => $research_themes, 
        'team_leader_id' => $team_leader_id, 
    ];


    $team = $this->update($con, 'teams', $params, 'id', $team_id);

    if(!$team){
        echo "error";
    }

    $this->deconnexion($con);
}

public function createTeam($name,$description,$research_themes,$team_leader_id){
    $con = $this->connection();
    $params = [
        'name' => $name, 
        'description' => $description, 
        'research_themes' => $research_themes, 
        'team_leader_id' => $team_leader_id, 
    ];


    $team = $this->insert($con, 'teams', $params);

    if(!$team){
        echo "error";
    }

    $this->deconnexion($con);
}
public function delete_team($id){
        $con = $this->connection();
        $this->delete($con, 'teams', 'id', $id);
        $this->deconnexion($con);
    }
}
?>