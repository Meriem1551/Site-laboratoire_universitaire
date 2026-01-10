<?php
// components/Pagination.php
class Pagination {
    private $currentPage;
    private $totalPages;
    private $urlPattern;
    private $maxVisible = 5;
    private $showFirstLast = true;
    private $showPrevNext = true;
    
    public function __construct($currentPage, $totalItems, $itemsPerPage, $urlPattern = '?page={page}') {
        $this->currentPage = max(1, (int)$currentPage);
        $this->totalPages = max(1, ceil($totalItems / $itemsPerPage));
        $this->urlPattern = $urlPattern;
    }
    
    public function setMaxVisible($max) {
        $this->maxVisible = $max;
        return $this;
    }
    
    public function showFirstLast($show) {
        $this->showFirstLast = $show;
        return $this;
    }
    
    public function showPrevNext($show) {
        $this->showPrevNext = $show;
        return $this;
    }
    
    private function getPageUrl($page) {
        return str_replace('{page}', $page, $this->urlPattern);
    }
    
    public function render() {
        if ($this->totalPages <= 1) {
            return '';
        }
        
        $output = '<div class="flex items-center justify-center mt-12">';
        $output .= '<nav class="flex items-center space-x-2" aria-label="Pagination">';
        
        // Première page
        if ($this->showFirstLast && $this->currentPage > 1) {
            $output .= $this->renderPageLink(1, 'Première', true);
        }
        
        // Page précédente
        if ($this->showPrevNext && $this->currentPage > 1) {
            $output .= $this->renderPageLink($this->currentPage - 1, 'Précédent', true);
        }
        
        // Pages numérotées
        $start = max(1, $this->currentPage - floor($this->maxVisible / 2));
        $end = min($this->totalPages, $start + $this->maxVisible - 1);
        
        // Ajuster le début si on est près de la fin
        if ($end - $start + 1 < $this->maxVisible) {
            $start = max(1, $end - $this->maxVisible + 1);
        }
        
        // Points de suspension avant
        if ($start > 1) {
            $output .= '<span class="px-3 py-2 text-gray-500">...</span>';
        }
        
        // Pages
        for ($i = $start; $i <= $end; $i++) {
            $output .= $this->renderPageLink($i, $i, false, $i == $this->currentPage);
        }
        
        // Points de suspension après
        if ($end < $this->totalPages) {
            $output .= '<span class="px-3 py-2 text-gray-500">...</span>';
        }
        
        // Page suivante
        if ($this->showPrevNext && $this->currentPage < $this->totalPages) {
            $output .= $this->renderPageLink($this->currentPage + 1, 'Suivant', true);
        }
        
        // Dernière page
        if ($this->showFirstLast && $this->currentPage < $this->totalPages) {
            $output .= $this->renderPageLink($this->totalPages, 'Dernière', true);
        }
        
        $output .= '</nav>';
        $output .= '</div>';
        
        return $output;
    }
    
    private function renderPageLink($page, $text, $isNav = false, $isActive = false) {
        $url = $this->getPageUrl($page);
        
        if ($isActive) {
            $classes = 'px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2';
        } else {
            $classes = 'px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2';
        }
        
        if ($isNav) {
            $classes .= ' flex items-center';
        }
        
        $icon = '';
        if ($text === 'Précédent') {
            $icon = '<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>';
        } elseif ($text === 'Suivant') {
            $icon = '<svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';
        }
        
        $output = '<a href="' . $url . '" class="' . $classes . ' transition-colors duration-200"';
        $output .= $isActive ? ' aria-current="page"' : '';
        $output .= '>';
        
        if ($text === 'Précédent') {
            $output .= $icon . '<span class="sr-only md:not-sr-only">Précédent</span>';
        } elseif ($text === 'Suivant') {
            $output .= '<span class="sr-only md:not-sr-only">Suivant</span>' . $icon;
        } elseif ($text === 'Première') {
            $output .= '<span class="sr-only md:not-sr-only">Première</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>';
        } elseif ($text === 'Dernière') {
            $output .= '<span class="sr-only md:not-sr-only">Dernière</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>';
        } else {
            $output .= $text;
        }
        
        $output .= '</a>';
        
        return $output;
    }
    
    public function getOffset() {
        return ($this->currentPage - 1) * $this->getItemsPerPage();
    }
    
    public function getItemsPerPage() {
        // Récupérer depuis la configuration ou utiliser une valeur par défaut
        return isset($_GET['limit']) ? (int)$_GET['limit'] : 9; // 3x3 grid
    }
    
    public static function renderInfo($currentPage, $totalItems, $itemsPerPage) {
        $start = (($currentPage - 1) * $itemsPerPage) + 1;
        $end = min($currentPage * $itemsPerPage, $totalItems);
        
        $output = '<div class="text-sm text-gray-600 mb-4">';
        $output .= '<p>Affichage de <span class="font-semibold">' . $start . '</span> à <span class="font-semibold">' . $end . '</span> sur <span class="font-semibold">' . $totalItems . '</span> projets</p>';
        $output .= '</div>';
        
        return $output;
    }
}