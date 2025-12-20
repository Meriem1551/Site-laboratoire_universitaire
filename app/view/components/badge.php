<?php
class Badge{
    private $color;
    private $value;
    private $bgColor;
    public function __construct($value, $color, $bgColor){
        $this->color = $color;
        $this->value = $value;
        $this->bgColor = $bgColor;
    }

    public function render(){
        return "<div class='p-1 rounded-3xl font-medium' style='background-color: {$this->bgColor}; border: 1.5px solid {$this->color};'>
        <p style='color: {$this->color};' class='text-center'>
            $this->value
        </p>
      </div>";

    }
}

?>