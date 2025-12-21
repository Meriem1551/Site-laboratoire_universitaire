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
                    'title' => $feature['title'],
                    'icon' => $feature['icon'],
                    'url' => $feature['url'],
                    'color' => $feature['color'],
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