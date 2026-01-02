<?php
require_once "app/model/eventModel.php";
require_once "app/model/UserModel.php";
require_once "app/view/eventView.php";
require_once "baseController.php";
require_once __DIR__ . '/../../utils/helpers/events_reminder.php';
class EventController extends BaseController{

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
    public function getAll(){
        $model = new EventModel();
        $events = $model->getAll();
        return $events;
    }

    public function list_events(){
        $page = $_GET['eventPage'] ?? 1; 
        $events = $this->get_events($page);
        $eventView = new EventView();
        $eventView->show_events($events);
    }
    public function show_events(){
        $events = $this->getAll();
        $view = new EventView();
        $allowed = $this->getAllowedActions('evenements');
        $view->show_events_admin($events, $allowed);
    }


    public function event_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $eventM = new EventModel();
            $event = $eventM->getEventById($id);
        }
        else {
            //creating
            $event = null;
        }
        $eventV =  new EventView();
        $eventV->create_update_form($event);
    }


    public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    
    $title = $_POST['title'];
    $description  = $_POST['description'];
    $type = $_POST['type'];
    $date = $_POST['event_date'];
    $open = $_POST['registerOpen'];
    $extern = isset($_POST['isExtern']) ? 1 : 0;
    $by = $_SESSION['user'][0]['first_name'].' '.$_SESSION['user'][0]['last_name'];
    $image = $_POST['current_image'] ?? '';
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/assets/';
        $filename  = uniqid() . '_' . basename($_FILES['image_path']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image_path']['tmp_name'], $targetPath)) {
            $image = $targetPath;
        }
    }

    $eventM = new EventModel();

    if (isset($_POST['event_id'])) {
        $event_id = $_POST['event_id'];


        $eventM->updateEvent(
            $event_id,
            $title,
            $description,
            $type,
            $date,
            $image,
            $open,
            $extern
        );

    } else {
        $event_id = $eventM->createEvent(
            $title,
            $description,
            $type,
            $date,
            $image,
            $by,
            $open,
            $extern
        );

    }
    // $eventM = new EventModel();
    // $userM = new UserModel();
    // $event = $eventM->getEventById($event_id);
    // $users = $userM ->getAll();
    // createGoogleCalendarEventWithUsers($event, $users);
    header("Location: index.php?page=gestion_evenements");
    exit;
}
 public function delete_event(){
        $id = $_GET['id'];
        $eventM = new EventModel();
        $eventM->deleteEvent($id);
        header("Location: index.php?page=gestion_evenements"); 
    }
}
?>