<?php
require_once "baseModel.php";
class OpportModel extends BaseModel{
    public function getAll(){
        $con = $this->connection();
        $offers = $this->get_all($con, 'opportunities');
        $this->deconnexion($con);
        return $offers;
    }
}

?>