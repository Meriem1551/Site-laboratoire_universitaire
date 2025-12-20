<?php

class Button{
    private $text;
    private $type;
    private $class;
    public function __construct(string $text, $type='', $class=''){
        $this->text = $text;
        $this->type = $type;
        $this->class = $class;
    }
    public function render(){
        return "
            <button type='{$this->type}' class='$this->class'>
                {$this->text}
            </button>";
    }
}

?>