<?php
require_once "app/model/permissionModel.php";
require_once "app/view/permissionView.php";
class PermissionController{
    public function show_form(){
        $id_user = $_GET['id'];
        $permM = new PermissionModel($id_user);
        $permissions = $permM->getPermissions($id_user);
        $permissionV = new PermissionView();
        $permissionV->show_perm_form($permissions, $id_user);
    }
    public function handle_submit(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submitted = $_POST['permissions'] ?? [];
            $user_id = $_POST['user_id'];
            echo "<section class='px-12 py-24'>";
            
            $permissionM = new PermissionModel($user_id);
            $permissions = $permissionM->getPermUsers($user_id);
            $currentPerm = [];
            foreach($permissions as $permission){
                $currentPerm[] = $permission['id'];
            }

            foreach($submitted as $permId){
                if(!in_array($permId, $currentPerm)){
                    $permissionM->add_permission($permId, $user_id);
                }
            }
            foreach($currentPerm as $permId){
                if(!in_array($permId, $submitted)){
                    $permissionM->remove_permission($permId, $user_id);
                }
            }
            header('location: index.php?page=gestion_users');
        }
    }
}
?>