<?php
require_once "baseModel.php";
class RoleModel extends BaseModel{
    public function getRoles(){
        $con = $this->connection();
        $roles = $this->requet($con, 'roles.getAll', []);
        $this->deconnexion($con);
        return $roles;
    }
    public function delete_role($id){
        $con = $this->connection();
        $this->requet($con, 'roles.delete', ['id' => $id]);
        $this->deconnexion($con);
    }
    public function add_role($name){
        $con = $this->connection();
        $this->requet($con, 'roles.add', ['name' => $name]);
        $this->deconnexion($con);
    }
}
?>