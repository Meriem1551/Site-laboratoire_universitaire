<?php
require_once 'title.php';
require_once "badge.php";
class Card {
    private $header;
    private $body;
    private $footer;
    private $class;
    public function __construct($header = [], $body = [], $footer = [], $class="") {
        $this->header = $header;
        $this->body = $body;
        $this->footer = $footer;
        $this->class = $class;
    }

    private function renderSection($sectionArray) {
        foreach ($sectionArray as $item) {
            echo $item;
        }
    }

    public function render() {
        echo "<div class='{$this->class}'>";
        if (!empty($this->header)) {
            $this->renderSection($this->header);
        }
        if (!empty($this->body)) {
            echo "<div class='text-start'>";
            $this->renderSection($this->body);
            echo "</div>";
        }
        if (!empty($this->footer)) {
            $this->renderSection($this->footer);
        }

        echo "</div>";
    }
}
  
?>

