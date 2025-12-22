<?php
require_once "app/model/roleModel.php";
require_once "app/view/roleView.php";
require_once "baseController.php";
class RoleController extends BaseController{
    public function getRoles(){
        $roleM = new RoleModel();
        return $roleM->getRoles();
    }
    public function show_roles(){
        $allowed = $this->getAllowedActions('roles');
        $roles = $this->getRoles();
        $roleV = new RoleView();
        $roleV->show_roles($roles, $allowed);
    }
    public function add_role(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        if (empty($name)) {
            die("Le nom du rôle ne peut pas être vide");
        }

        $roleM = new RoleModel();
        $roleM->add_role($name);
        header('Location: index.php?page=roles');
        exit;
    }
    }
    public function delete_role(){
       $id = $_GET['id'];
       $roleM = new RoleModel();
       $roleM->delete_role($id);
       header('location: index.php?page=roles');
    }
}
?>