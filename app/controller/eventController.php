<?php
require_once "app/model/eventModel.php";
require_once "app/view/eventView.php";
class EventController{

    public function get_events($eventPage = 1){
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

    public function list_events(){
        $page = $_GET['eventPage'] ?? 1; 
        $events = $this->get_events($page);
        $eventView = new EventView();
        $eventView->show_events($events);
    }
}
?>