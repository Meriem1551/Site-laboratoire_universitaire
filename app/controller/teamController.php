<?php
require_once "app/model/teamModel.php";
require_once "app/model/userModel.php";
require_once "app/model/publicationModel.php";
require_once "app/model/equipModel.php";
require_once "app/view/teamView.php";
class TeamController{
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

}

?>