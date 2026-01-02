<?php
require_once "button.php";
class Table {
    private $columns;
    private $data;  
    public function __construct($columns, $data){
        $this->columns = $columns;
        $this->data = $data;
    }

    private function render_header(){
        echo "<thead>";
            echo "<tr class='text-[var(--gray-dark)]'>";
                foreach($this->columns as $column){
                    echo "<th class='border-b border-b-1 border-b-gray-200 px-4 py-4 text-center'>{$column}</th>";
                }
            echo "</tr>";
        echo "</thead>";
    }

    private function render_body(){
        echo "<tbody>";
            foreach($this->data as $row){
                    echo "<tr class='text-[var(--gray)] cursor-pointer text-center'>";
                    foreach($row as $key => $cell){
                        echo "<td class='border-b border-b-1 border-b-gray-200 px-4 py-4'>{$cell}</td>";
                    }
                    echo "</tr>";
            }
            echo "</tbody>";
    }   

    public function render() {
        echo "<table class='w-full border-b border-b-1 border-b-gray-100 rounded-lg shadow-md bg-[var(--white)]'>";
        $this->render_header();
        $this->render_body();            
        echo "</table>";
    }
}
?>
