
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
}
?>