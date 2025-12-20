<?php
require_once 'button.php';
class Pagination{
    private $currentPage;
    private $total;
    private $baseUrl;
    public function __construct($currentPage, $total, $baseUrl){
        $this->currentPage = $currentPage;
        $this->total = $total;
        $this->baseUrl = $baseUrl;
    }
    public function render() {
        if ($this->total <= 1) return; 
        echo '<div class="pagination flex gap-2 mt-4">';
        for ($i = 1; $i <= $this->total; $i++) {
            $class = ($i === (int)$this->currentPage) 
                ? 'px-4 py-2 text-white bg-[var(--primary)] rounded-full' 
                : 'px-4 py-2 text-[var(--gray)] bg-[var(--white)] shadow-md rounded-full hover:bg-[var(--gray)] hover:text-white';

            echo "<a href='{$this->baseUrl}&eventPage={$i}'>";
            $button = (new Button($i, '', $class))->render();
            echo $button;
            echo "</a>";
        }

        echo '</div>';
    }
}
?>