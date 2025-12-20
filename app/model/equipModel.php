<?php
require_once "baseModel.php";
class EquipmentModel extends BaseModel{
    
    public function getEquipment(){
        $con = $this->connection();
        $equipments = $this->requet($con, 'equip.getAll');
        $this->deconnexion($con);
        return $equipments;
    }
    public function getEquipById($id){
        $con = $this->connection();
        $equipment = $this->requet($con, 'equip.getById', ['id' => $id]);
        $this->deconnexion($con);
        return $equipment[0];
    }
    public function getEquipReserve($id_user){
        $con = $this->connection();
        $equipments = $this->requet($con, 'equip.getEquipReserve', ['id_user' => $id_user]);
        $this->deconnexion($con);
        return $equipments;
    }

}
?>