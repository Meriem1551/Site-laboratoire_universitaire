<?php
require_once "app/model/teamModel.php";
require_once "app/model/userModel.php";
require_once "app/model/publicationModel.php";
require_once "app/model/equipModel.php";
require_once "app/view/teamView.php";
require_once "baseController.php";
class TeamController extends BaseController{
    private function getTeam($id){
        $teamM = new TeamModel();
        return $teamM->get_team_by_id($id);
    }
    private function getPublications($id_author){
         $pubM = new PublicationModel();
        return $pubM->getPubsByUser($id_author)
;

    }
    private function getMembers($id){
        $userModel = new UserModel();
        $members = $userModel->getMembers($id);
        return $members;
    }

    private function getEquip($id_user){
        $equipModel = new EquipmentModel();
        $equip = $equipModel->getEquipReserve($id_user);
        return $equip;
    }

    public function show_team($id_team){
        $team = $this->getTeam($id_team);
        $members = $this->getMembers($id_team);
        $publications = [];
        foreach($members as $member){
            $memberPubs = $this->getPublications($member['id']);
            foreach($memberPubs as $pub){
                $publications[] = $pub;
            }
        }
        $equips = [];
        foreach($members as $member){
            $memberEquips = $this->getEquip($member['id']);
            foreach($memberEquips as $equip){
                $equips[] = $equip;
            }
        }
        $teamV = new TeamView();
        $teamV->show_team($team, $members, $publications, $equips);
    }
     private function getTeams(){
        $teamModel  = new TeamModel();
        $teams= $teamModel->get_teams();
        return $teams;
    }

    public function show_teams(){
        $teams = $this->getTeams();
        $allowed = $this->getAllowedActions('equipes'); 
        $view = new TeamView();
        $view->show_teams($teams, $allowed);
    }
    public function team_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $teamM = new TeamModel();
            $team = $teamM->get_team_by_id($id);
        }
        else {
            //creating
            $team = null;
        }
        $teamV = new TeamView();
        $users = (new UserModel())->getAll();
        $teamV->create_update_form($team, $users);
    }


    public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?page=gestion_equipes");
        exit;
    }

    $name = $_POST['name'];
    $description  = $_POST['description'];
    $research_themes      = $_POST['research_themes'];
    $team_leader_id = $_POST['team_leader_id'];
   


    $teamM = new TeamModel();

    if (isset($_POST['team_id'])) {
        $team_id = $_POST['team_id'];
         $teamM->updateTeam(
            $team_id,
            $name,
            $description,
            $research_themes,
            $team_leader_id
         );

    } else {
         $teamM->createTeam(
            $name,
            $description,
            $research_themes,
            $team_leader_id
         );
    }
    header("Location: index.php?page=gestion_equipes");
    exit;
}
public function delete_team(){
     $id = $_GET['id'];
    $teamM = new TeamModel();
    $teamM->delete_team($id);
    header("Location: index.php?page=gestion_equipes"); 
}

}

?>