
<?php
require_once "baseModel.php";
class ReservationModel extends BaseModel{
  
public function getAllreservations(){
    $con = $this->connection();
    $reservations = $this->requet($con, 'reservation.getReservation', []);
    $this->deconnexion($con);
    return $reservations;
}

public function addReservation($id_equip, $user_id, $s_date,$e_date, $purpose){
    $con = $this->connection();
    $reservation = $this->requet($con, 'reservation.addRes', ['e_id' => $id_equip, 'u_id' => $user_id, 'start' => $s_date, 'end' => $e_date, 'purpose' => $purpose]);
    $this->deconnexion($con);
}
public function update_status($status, $id, $equip_id){
    $con = $this->connection();
    $this->update($con, 'reservations', ['status_res' => $status], 'id', $id);
    if($status === 'confirme'){
        $this->update($con, 'equipment', ['status' => 'reserve'], 'id', $equip_id);
    }
    $this->deconnexion($con);
}



public function getById($id){
     $con = $this->connection();
    $reservation = $this->getByCol($con, 'reservations', 'id', $id);
    $this->deconnexion($con);
    return $reservation[0];
}
public function change_period($id, $start, $end){
      $con = $this->connection();
    $this->update($con, 'reservations',['start_datetime' => $start, 'end_datetime' => $end], 'id', $id);
    $this->deconnexion($con);
    return $reservation[0];
}
}
?>