<?php
require_once "app/model/orgaModel.php";
require_once "app/model/teamModel.php";
require_once "app/view/presentationView.php";
require_once "app/model/userModel.php";
require_once "app/model/projectModel.php";
require_once "app/model/publicationModel.php";
require_once "app/model/partnersModel.php";

class PresController{

    private function getData(){
        $model = new OrgaModel();
        $data = $model->getData();
        return $data;
    }
    private function getLeader($id){
        $userModel = new UserModel();
        $leader = $userModel->getUserById($id);
        return $leader;
    }
    private function getDirector(){
         $userModel = new UserModel();
        $dir = $userModel->getDirector();
        return $dir;
    }
    private function getMembers($id){
        $userModel = new UserModel();
        $members = $userModel->getMembers($id);
        return $members;
    }

    private function create_full_data(){
    $orgData = [];

    $director = $this->getDirector(); 
    $orgData[] = [
        'id' => $director['id'],
        'name' => $director['first_name']." ".$director['last_name'],
        'post' => $director['post'],
        'picture' => $director['profile_picture'],
        'parent_id' => null
    ];

    $teams = $this->getData();

    foreach($teams as $team) {
        $teamId = 'team_'.$team['id'];

        $orgData[] = [
            'id' => $teamId,
            'name' => $team['name'],
            'post' => null,
            'picture' => null,
            'parent_id' => $director['id'],
            'collapsed' => true
        ];

        $leader = $this->getLeader($team['team_leader_id']);
        $orgData[] = [
            'id' => $leader['id'],
            'name' => $leader['first_name']." ".$leader['last_name'],
            'post' => $leader['post'],
            'picture' => $leader['profile_picture'],
            'parent_id' => $teamId,
            'collapsed' => true 
        ];

        $members = $this->getMembers($team['id']); 
        foreach($members as $member){
            if($member['id'] !== $leader['id']){
                $orgData[] = [
                    'id' => $member['id'],
                    'name' => $member['first_name']." ".$member['last_name'],
                    'post' => $member['post'],
                    'picture' => $member['profile_picture'],
                    'parent_id' => $leader['id'] 
                ];
            }
        }
    }

    return $orgData;
}

    private function translateToJsonFullData(){
        $data = $this->create_full_data();
        $jsonData = json_encode(array_map(function($item) {
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'post' => $item['post'],
                'img' => $item['picture'],
                'pid' => $item['parent_id'] ?: null
            ];
        }, $data));
        return $jsonData;
    }

    private function getOrga(){
            $orga = $this->translateToJsonFullData();
            return $orga;
    }
    private function getTeams(){
        $teamModel  = new TeamModel();
        $teams= $teamModel->get_teams();
        $userM = new UserModel();
        foreach ($teams as &$team) {
            $team['members'] = $userM->getMembers($team['team_id']); 
        }
    return $teams;
    }


    private function getNbUsers(){
        $userM = new UserModel();
        return count($userM->getAll());
    }
    private function getNbProject(){
        $projM = new ProjectModel();
        return count($projM->getProjects());
    }
    private function getNbPub(){
         $pubM = new PublicationModel();
        return count($pubM->getAllPubs());
    }
    private function getNbPart(){
         $partM = new PartnersModel();
        return count($partM->getPartners());
    }

    private function getTeam($id){
        $teamM = new TeamModel();
        return $teamM->get_team_by_id($id);
    }
   


    public function show_page(){
        $data = $this->getOrga();
        $teams = $this->getTeams();
        $stats = [
            'membres' => $this->getNbUsers(),
            'projets' => $this->getNbProject(),
            'pubs' => $this->getNbPub(),
            'parts' => $this->getNbPart()
        ];
        $presentationView = new PresentationView();
        $presentationView->show_page($data, $teams, $stats);
    }

}

?>