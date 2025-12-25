<?php
require_once __DIR__ . '/../model/permissionModel.php';
class BaseController {
    protected $perm;
    protected $features;

    public function __construct() {
        $userId = $_SESSION['user'][0]['id'] ?? null;
        $this->perm = new PermissionModel($userId);
        $this->features = require __DIR__ . '/../../config/features.php';
    }

    protected function getAllowedActions($featureKey) {
        if (!isset($this->features[$featureKey])) return [];

        $actions = [];
        foreach ($this->features[$featureKey]['permissions'] as $action => $permName) {
            // if ($action === 'read') continue;
            $actions[$action] = $this->perm->can($permName);
        }

        return $actions;
    }


    // public function getAll(){
    //     $model = new BaseModel();
    //     $db = $model->connection();
    //     $data = $model->getAll($db, 'projects');
    //     return $data;
    // }

    // public function index() {
    //     $allowedActions = $this->getAllowedActions('projects');
    //     $data = $this->getAll();
    //     $view = new baseView();
    //     $view->index($allowedActions, $data);
    // }
    // protected function insert($table, $data){

    // }
}
