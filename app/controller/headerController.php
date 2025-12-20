<?php
require_once __DIR__ . '/../view/layouts/header.php';

class HeaderController {

    public function showHeader() {
        $HeaderView = new Header();
        $HeaderView->display_header();
        
    }
}
?>