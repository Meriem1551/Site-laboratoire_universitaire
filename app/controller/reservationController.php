<?php
require_once "app/model/reservationModel.php";
require_once "app/model/equipModel.php";

class ReservationController{
    public function submit_reservation(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $equip_id = $_POST['equip_id'];
            $user_id  = $_POST['user_id'];
            $start    = $_POST['start_datetime'];
            $end      = $_POST['end_datetime'];
            $purpose  = $_POST['purpose'];
        }
        if (!$equip_id || !$user_id || !$start || !$end || !$purpose) {
            die("Tous les champs sont obligatoires !");
        }
        $reservationModel = new ReservationModel();
        
        $reservationModel->addReservation($equip_id, $user_id, $start, $end, $purpose);
        header("Location: index.php?page=equipements");
        exit;
    }
    public function change_status(){
        $id = $_GET['id'];
        $status = $_GET['status'];
        $equip_id= $_GET['equip_id'];
        $resM = new ReservationModel();
        $resM->update_status($status, $id, $equip_id);
        $equipM = new EquipmentModel();
        $equipM->update_quantity($equip_id);
        header('location: index.php?page=gestion_equipements');
    }
}

?>