<!-- get the data to draw it with  function render dialgram-->
<?php
require_once "baseModel.php";
class OrgaModel extends BaseModel{
    
public function getData(){
    $con = $this->connection();
    $data = $this->requet($con, 'orga.getData', []);
    $this->deconnexion($con);
    return $data;
}

}
?>