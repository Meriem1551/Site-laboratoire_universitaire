<?php
require_once "app/model/permissionModel.php";
require_once "app/view/dashboardView.php";
class DashboardController {

    public function show_dashboard() {
        $user_id = $_SESSION['user'][0]['id'];
        $perm = new PermissionModel($user_id);

        $features = require __DIR__ . '/../../config/features.php';
        $cards = [];
        foreach ($features as $key => $feature) {
            if ($perm->can($feature['permissions']['read'])) {
                $cards[$key] = [
                    'title' => $feature['title']??'',
                    'icon' => $feature['icon']??'',
                    'url' => $feature['url']??'',
                    'color' => $feature['color']??'',
                    'actions' => []
                ];

                foreach ($feature['permissions'] as $action => $permName) {
                    if ($action === 'read') continue;
                    $cards[$key]['actions'][$action] = $perm->can($permName);
                }
            }
        }
        $dashV = new DashboardView();
        $dashV->show_page($cards);
    }
}
?>

<!-- require_once "BaseController.php";
require_once "app/view/dashboardView.php";
require_once "app/model/baseModel.php";
class DashboardController extends BaseController {
    public function show_dashboard() {
        // If no entity parameter → show cards
        $entity = $_GET['entity'] ?? null;
        $action = $_GET['action'] ?? 'read'; // default action

        if (!$entity) {
            $this->show_cards();
        } else {
            $this->handle_entity($entity, $action);
        }
    }

    private function show_cards() {
        $cards = [];

        foreach ($this->features as $key => $feature) {
            if ($this->perm->can($feature['permissions']['read'])) {
                $cards[$key] = [
                    'title' => $feature['title'] ?? '',
                    'icon'  => $feature['icon'] ?? '',
                    'url'   => $feature['url'] ?? '',
                    'color' => $feature['color'] ?? '',
                    'actions' => $this->getAllowedActions($key),
                ];
            }
        }

        $dashV = new DashboardView();
        $dashV->show_page($cards);
    }
    private function handle_entity($entity, $action) {
        // Check if entity exists in routes
        $routes = $this->features;
        if (!isset($routes[$entity])) {
            die('Entity not found');
        }

        $entityConfig = $routes[$entity];

        // Check permissions
        $perm = $entityConfig['permissions'][$action] ?? null;
        if ($action !== 'read' && !$this->perm->can($perm)) {
            die('Permission denied');
        }

        // Prepare data for view
        $data = $this->getEntityData($entity); // generic function to fetch data

        // Pass row_actions and global_actions to view
        $rowActions = $entityConfig['row_actions'] ?? [];
        $globalActions = $entityConfig['global_actions'] ?? [];
        $title = $entityConfig['title'] ?? ucfirst($entity);

        $dashV = new DashboardView();
        $dashV->show_entity_table($title, $data, $rowActions, $globalActions);
    }
    private function getEntityData($entity){
    switch ($entity) {        
        case 'users':
            require_once "app/model/UserModel.php";
            $model = new UserModel();
            return $model->getAll();  // returns array of users
        case 'projets':
            require_once "app/model/ProjectModel.php";
            $model = new ProjectModel();
            return $model->getProjects();  // returns array of projects
        case 'equipes':
            require_once "app/model/TeamModel.php";
            $model = new TeamModel();
            return $model->get_teams();
        case 'publications':
            require_once "app/model/PublicationModel.php";
            $model = new PublicationModel();
            return $model->getAll();
        case 'equipments':
            require_once "app/model/EquipmentModel.php";
            $model = new EquipmentModel();
            return $model->getAll();
        case 'evenements':
            require_once "app/model/EventModel.php";
            $model = new EventModel();
            return $model->getAll();
        case 'actualites':
            require_once "app/model/NewsModel.php";
            $model = new NewsModel();
            return $mode->getAll();
    }
    }
} -->
