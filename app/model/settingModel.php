<?php
require_once "baseModel.php";
class SettingModel extends BaseModel{
    public function getAll(){
        $con = $this->connection();
        $settings = $this->get_all($con, 'settings');
        $this->deconnexion($con);
        return $settings;
    }
    public function update_setting($value, $col){
        $con = $this->connection();
        $this->update($con, 'settings', ['value' => $value], 'key_name', $col);
        $this->deconnexion($con);
    }
}
?>