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
}

?>