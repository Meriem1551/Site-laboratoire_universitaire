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
    public function createEquip($name,$description,$category,$status,$quantity){
        $con = $this->connection();
        $this->insert($con, 'equipment', [
            'name' => $name,
            'category' => $category,
            'description' => $description,
            'status' => $status,
            'quantity' => $quantity
        ]);
        $this->deconnexion($con);
    }
    public function updateEquip($id, $name,$description,$category,$status,$quantity){
        $con = $this->connection();
        $this->update($con, 'equipment', [
            'name' => $name,
            'category' => $category,
            'description' => $description,
            'status' => $status,
            'quantity' => $quantity
        ], 'id', $id);
        $this->deconnexion($con);
    }
    public function deleteEquip($id){
        $con = $this->connection();
        $this->delete($con, 'equipment','id', $id);
        $this->deconnexion($con);
    }
    public function update_quantity($id){
        $con = $this->connection();
        $this->requet($con, 'equipment.updateQ', ['id' => $id]);
        $this->deconnexion($con);
    }

}
?>