<?php
class FilterDropdown {
    private $id;
    private $label;
    private $options;
    private $placeholder;
    private $icon;
    
    public function __construct($id, $label, $options, $placeholder = "", $icon = "") {
        $this->id = $id;
        $this->label = $label;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->icon = $icon;
    }
    
    public function render() {
        echo '<div class="filter-group">';
        
        if ($this->label) {
            echo '<label for="' . $this->id . '" class="block text-sm font-medium text-gray-700 mb-1">' . $this->label . '</label>';
        }
        
        echo '<div class="relative">';
        echo '<select id="' . $this->id . '" class="filter-select w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all appearance-none bg-white cursor-pointer">';
        
        if ($this->placeholder) {
            echo '<option value="">' . $this->placeholder . '</option>';
        }
        
        foreach ($this->options as $value => $label) {
            if (is_numeric($value)) {
                echo '<option value="' . htmlspecialchars($label) . '">' . htmlspecialchars($label) . '</option>';
            } else {
                echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($label) . '</option>';
            }
        }
        
        echo '</select>';
        
        if ($this->icon) {
            echo $this->icon;
        }
        
        echo '</div>';
        echo '</div>';
    }
}