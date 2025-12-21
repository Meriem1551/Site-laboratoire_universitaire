<?php
require_once "baseModel.php";
class PermissionModel extends BaseModel{
    private $permissions = [];
    private $userId;

    public function __construct($user_id) {
        parent::__construct();
        $this->userId = $user_id;
        $this->loadPermissions();
    }

    private function loadPermissions() {
        $con = $this->connection();
        $this->permissions = $this->requet($con, 'permissions.getByUser', ['user_id' => $this->userId]);
        $this->deconnexion($con);
        $this->permissions = array_map(function($row) {
            return $row['name'];
        }, $this->permissions);
    }

    public function can($permissionName) {
        return in_array($permissionName, $this->permissions);
    }

}

?>