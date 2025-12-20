<?php
require_once __DIR__ . '/../view/layouts/footer.php';

class FooterController {
    public function showFooter() {
        $footerView = new Footer();
        $footerView->display_footer();
    }
}
?>