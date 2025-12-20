<?php
class DashboardController{
    private function show_admin(){
        echo "<div class='px-12 py-24'>admin</div>";
    }
    private function show_user(){
        echo "<div class='px-12 py-24'>user</div>";
    }
    public function show_dashboard(){
        $page = $_GET['role'];
            if($page === 'admin'){
                $this->show_admin();
            }
            else {
                $this->show_user();
            }
    }
}
?>