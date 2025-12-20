<?php
class SideBar{
    public function render(){
        echo "
            <aside class='h-full fixed left-0'>
                <a href='index.php?page=profile'>Profile</a>
                <a href='index.php?page=dashboard'>Dashboard</a>
            </aside>
        ";
    }
}
?>