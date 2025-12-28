<?php
require_once "app/model/equipModel.php";
require_once "app/view/equipView.php";
require_once "reservationController.php";
require_once "app/model/reservationModel.php";
require_once 'baseController.php';
class EquipmentController extends BaseController{
    private function getEquip(){
       $equipModel = new EquipmentModel();
       $equipments = $equipModel->getEquipment();
       return $equipments;
    }
    private function getReservations(){
        $model = new ReservationModel();
        $reservations = $model->getAllreservations();
        return $reservations;
    }

    private function getEquipById($id){
        $equipModel = new EquipmentModel();
       $equipment = $equipModel->getEquipById($id);
       return $equipment;
    }
    private function get_reserv_per_month(){
        $reservations = $this->getReservations();
        $reservations_by_month = array_fill(1, 12, 0); 

        foreach ($reservations as $r) {
            $month = (int)date('n', strtotime($r['start_datetime']));
            $reservations_by_month[$month]++;
        }

        $data = array_values($reservations_by_month); 
        return $data;
    }


    private function nbEquipReserve(){
        $equipments = $this->getEquip();
        $reservations = $this->getReservations();

        $reservationsCount = [];
        $labels = [];

        foreach ($equipments as $equip) {
            $reservationsCount[$equip['name']] = 0;
            $labels[] = $equip['name'];
        }

        foreach ($reservations as $res) {
            foreach ($equipments as $equip) {
                if ($equip['id'] == $res['equipment_id']) {
                    $reservationsCount[$equip['name']]++;
                    break;
                }
            }
        }

        $data = array_values($reservationsCount);
        return [$labels, $data];

    }

    public function list_equip(){
        $equipments = $this->getEquip();
        $reservations = $this->getReservations();
        $data = $this->get_reserv_per_month();
        [$equipReserve, $labels] = $this->nbEquipReserve();
        $view = new EquipmentView();
        $view->show_equipments($equipments, $reservations, $data, $equipReserve, $labels);
    }

    public function show_form_reservation($id){
        $equip = $this->getEquipById($id);
        $view = new EquipmentView();
        $view->show_res_form($equip);
    }


//bashboard side
    public function show_equip(){
        $role = $_SESSION['user'][0]['role'];
        $id = $_SESSION['user'][0]['id'];
        $equips = $this->getEquip();
        $reservations = $this->getReservations();
        $view = new EquipmentView();
        $allowed = $this->getAllowedActions('equipments');

        if ($role !== 'admin') {
        $equip_reserve_user = array_filter($reservations, function ($res) use ($id) {
            return $res['user_id'] == $id&& $res['status_res'] === 'confirme';
        });
        $view->show_equip_reserve($equip_reserve_user);
        return;
        }

        foreach ($reservations as &$res) {
            $res['has_conflict'] = $this->hasConflict($res, $reservations);
        }
        $view->show_equip($equips, $allowed, $reservations);
        
    }

    public function equip_form(){
        if (isset($_GET['id'])){
            //updating
            $id = $_GET['id'];
            $equipM = new EquipmentModel();
            $equip = $equipM->getEquipById($id);
        }
        else {
            //creating
            $equip = null;
        }
        $equipV =  new EquipmentView();
        $equipV->create_update_form($equip);
    }

    public function handle_submit_create_update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    
    $name = $_POST['name'];
    $description  = $_POST['description'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $quantity = $_POST['quantity'];

    $equipM = new EquipmentModel();

    if (isset($_POST['equip_id'])) {
        $equip_id = $_POST['equip_id'];


        $equipM->updateEquip(
            $equip_id,
            $name,
            $description,
            $category,
            $status,
            $quantity
        );

    } else {
        $equipM->createEquip(
            $name,
            $description,
            $category,
            $status,
            $quantity
        );
    }

    header("Location: index.php?page=gestion_equipements");
    exit;
}

 public function delete_equip(){
        $id = $_GET['id'];
        $equipM = new EquipmentModel();
        $equipM->deleteEquip($id);
        header("Location: index.php?page=gestion_equipements"); 
    }

private function hasConflict($res, $allReservations) {
    if ($res['status_res'] === 'refuse') return false;
    $resStart = strtotime($res['start_datetime']);
    $resEnd   = strtotime($res['end_datetime']);
    foreach ($allReservations as $other) {
        if ($res['r_id'] === $other['r_id'] || $other['status_res'] === 'refuse') continue;
        if ($res['equipment_id'] === $other['equipment_id']) {
            $otherStart = strtotime($other['start_datetime']);
            $otherEnd   = strtotime($other['end_datetime']);
            if (!($resEnd <= $otherStart || $resStart >= $otherEnd)) {
                return true;
            }
        }
    }
    return false;
}

    private function getConflicts() {
    $conflictsByEquip = [];
    $reservations = $this->getReservations();
    foreach ($reservations as $res) {
        if ($res['status_res'] === 'refuse') continue;
        if ($this->hasConflict($res, $reservations)) {
            $equipId = $res['equipment_id'];
            if (!isset($conflictsByEquip[$equipId])) {
                $conflictsByEquip[$equipId] = [
                    'equipment_name' => $res['name'],
                    'reservations' => []
                ];
            }
            $conflictsByEquip[$equipId]['reservations'][] = $res;
        }
    }
    return $conflictsByEquip;
}


    public function show_conflicts(){
        $conflicts = $this->getConflicts();
        $view = new EquipmentView();
        $view->show_conflicts($conflicts);
    }

public function handle_res_period(){
    $id = $_GET['id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        //submitting the form
        $id = $_POST['r_id'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $resM = new ReservationModel();
        $reservation = $resM->change_period($id, $start, $end);
        header('location: index.php?page=gestion_conflicts');
        exit;
    }
    $resM = new ReservationModel();
    $reservation = $resM->getById($id);
    $view = new EquipmentView();
    $view->show_form_conflicts($reservation);
}

}
?>