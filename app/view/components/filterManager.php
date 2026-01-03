<?php
require_once "filter.php";
class FilterManager {
    private static $instance = null;
    private $filters = [];
    
    private function __construct() {}
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new FilterManager();
        }
        return self::$instance;
    }
    
    public function addFilter($id, $label, $options, $placeholder = "", $icon = "") {
        $this->filters[$id] = [
            'label' => $label,
            'options' => $options,
            'placeholder' => $placeholder,
            'icon' => $icon
        ];
    }
    
    public function renderFilterSection($title = "Filtrer", $description = "Sélectionnez vos critères de filtrage") {
        echo '<div class="filter-section mb-8">';
        echo '<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-6 bg-white rounded-xl shadow-sm border border-gray-200">';
        
        echo '<div class="flex flex-col gap-2">';
        echo '<h3 class="text-lg font-semibold text-gray-800">' . $title . '</h3>';
        if ($description) {
            echo '<p class="text-sm text-gray-600">' . $description . '</p>';
        }
        echo '</div>';
        
        echo '<div class="flex flex-wrap items-end gap-4">';
        
        foreach ($this->filters as $id => $filter) {
            $dropdown = new FilterDropdown(
                $id,
                $filter['label'],
                $filter['options'],
                $filter['placeholder'],
                $filter['icon']
            );
            $dropdown->render();
        }
        
        echo '<button id="clearFilters" class="filter-clear-btn px-2 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center gap-2">';
        echo '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        echo '</svg>';
        echo 'Effacer';
        echo '</button>';
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    public function getFilterJS($containerId, $itemSelector = '.filterable-item', $noResultsId = 'noResults') {
        return '
        <script>
        class FilterSystem {
            constructor(containerId, itemSelector, noResultsId) {
                this.container = document.getElementById(containerId);
                this.items = document.querySelectorAll(itemSelector);
                this.noResults = document.getElementById(noResultsId);
                this.activeFilters = {};
                
                this.init();
            }
            
            init() {
                document.querySelectorAll(".filter-select").forEach(select => {
                    select.addEventListener("change", (e) => {
                        this.activeFilters[e.target.id] = e.target.value;
                        this.applyFilters();
                    });
                });
                
                document.getElementById("clearFilters").addEventListener("click", () => {
                    this.clearFilters();
                });
            }
            
            applyFilters() {
                let visibleCount = 0;
                
                this.items.forEach(item => {
                    const itemData = JSON.parse(item.getAttribute("data-filter-info"));
                    let shouldShow = true;
                    
                    for (const [filterId, filterValue] of Object.entries(this.activeFilters)) {
                        if (filterValue && itemData[filterId] !== undefined) {
                            if (Array.isArray(itemData[filterId])) {
                                if (!itemData[filterId].includes(filterValue)) {
                                    shouldShow = false;
                                    break;
                                }
                            } else {
                                if (itemData[filterId] !== filterValue) {
                                    shouldShow = false;
                                    break;
                                }
                            }
                        }
                    }
                    
                    if (shouldShow) {
                        item.style.display = "table-row";
                        item.style.opacity = "1";
                        visibleCount++;
                    } else {
                        item.style.display = "none";
                        item.style.opacity = "0";
                    }
                });
                
                if (visibleCount === 0) {
                    this.noResults?.classList.remove("hidden");
                } else {
                    this.noResults?.classList.add("hidden");
                }
                
                return visibleCount;
            }
            
            clearFilters() {
                document.querySelectorAll(".filter-select").forEach(select => {
                    select.selectedIndex = 0;
                });
                this.activeFilters = {};
                this.applyFilters();
            }
            
            getActiveFilters() {
                return this.activeFilters;
            }
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            window.filterSystem = new FilterSystem("' . $containerId . '", "' . $itemSelector . '", "' . $noResultsId . '");
        });
        </script>';
    }
    
    public function reset() {
        $this->filters = [];
    }
}