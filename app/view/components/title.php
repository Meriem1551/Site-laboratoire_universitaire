<?php
class Title {
    private $text;
    private $class;
    private $tag;
    public function __construct($text, $class, $tag) {
        $this->text = $text;
        $this->class = $class;
        $this->tag = $tag;
    }
    public function render() {
        return "<$this->tag class='$this->class'>$this->text</$this->tag>";
    }
}
?>