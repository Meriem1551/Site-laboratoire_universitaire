<?php
require_once "BaseController.php";
require_once "app/view/dashboardView.php";

class DashboardController extends BaseController {

    public function show_dashboard() {
        $cards = [];

        foreach ($this->features as $key => $feature) {
            if ($this->perm->can($feature['permissions']['read'])) {
                $cards[$key] = [
                    'title' => $feature['title'],
                    'icon'  => $feature['icon'],
                    'url'   => $feature['url'],
                    'color' => $feature['color'],
                    'actions' => $this->getAllowedActions($key),
                ];
            }
        }

        $dashV = new DashboardView();
        $dashV->show_page($cards);
    }
}
?>



