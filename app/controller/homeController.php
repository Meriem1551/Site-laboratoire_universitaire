<?php
require_once "app/model/diapoModel.php";
require_once "app/model/actualiteModel.php";
require_once "app/model/orgaModel.php";
require_once "app/model/eventModel.php";
require_once "app/model/partnersModel.php";
require_once "app/model/userModel.php";
require_once "app/view/homeView.php";

    class HomeController {
        private function getDiapo(){
            $diapoModel = new DiapoModel();
            $diapo = $diapoModel->getDiaporama();
            return $diapo;
        }
        private function getActualites(){
            $actualiteModel = new ActualiteModel();
            $actualites = $actualiteModel->getActualitesHome();
            return $actualites;
        }
        private function getEvents($eventPage){
            $eventsPerPage = 5;
            $offset = ($eventPage - 1) * $eventsPerPage;

            $eventModel = new EventModel();
            if(!isset($_SESSION['user'])){
                $events = $eventModel->getEvent_public($eventsPerPage, $offset);
                $totalEvents = $eventModel->getTotal_public();
            }
            else{
                $events = $eventModel->getEvents($eventsPerPage, $offset);
                $totalEvents = $eventModel->getTotal();
            }
            $totalPages = ceil($totalEvents[0]['total'] / $eventsPerPage);
            return [
                'events' => $events,
                'total' => $totalPages,
                'currentPage' => $eventPage
            ];
        }
        private function getPartners(){
             $partnermodel = new PartnersModel();
            $partners = $partnermodel->getPartners();
            return $partners;
        }


        private function getData(){
            $model = new OrgaModel();
            $data = $model->getData();
            return $data;
        }

        private function getDirector(){
            $userModel = new UserModel();
            $dir = $userModel->getDirector();
            return $dir;
        }

        private function createData() {
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
                }

            return $orgData;
        }

        private function translateToJson(){
            $data = $this->createData();
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
            $orga = $this->translateToJson();
            return $orga;
        }
        public function show_home_page() {
            $page = $_GET['eventPage'] ?? 1; 
            $diaporamas = $this->getDiapo();
            $actualites = $this->getActualites();
            $orga = $this->getOrga();
            $partners = $this->getPartners();
            $eventsData = $this->getEvents($page);
            $homeView = new HomeView();
            $homeView->show_home($diaporamas, $actualites, $orga, $eventsData, $partners);
        }
    }
?>