<?php
require_once "app/model/equipModel.php";
require_once "app/view/equipView.php";
require_once "reservationController.php";
require_once "app/model/reservationModel.php";
class EquipmentController{
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


}
?>