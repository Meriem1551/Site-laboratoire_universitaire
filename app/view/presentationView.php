<?php
require_once "components/orga.php";
require_once "components/title.php";
require_once "components/card.php";
require_once "components/badge.php";
require_once "components/filterManager.php";

class PresentationView {
    private function print_labo_pres($teams) { 
        $header = [
            '<h3 class="text-2xl font-bold text-[var(--gray-dark)] mb-6">Le Laboratoire de Recherche Avancée</h3>'
        ];

        $body = [
            '<p class="text-[var(--gray)] leading-relaxed mb-6">Le Laboratoire de Recherche en Sciences et Technologies est un centre d\'excellence dédié à l\'innovation scientifique et technologique. Nous rassemblons des chercheurs, enseignants-chercheurs et étudiants autour de projets multidisciplinaires visant à développer des solutions novatrices dans les domaines de l\'informatique avancée, la biotechnologie, l\'ingénierie des matériaux et l\'intelligence artificielle.</p>',
            '<p class="text-[var(--gray)] leading-relaxed">Le laboratoire est organisé en équipes de recherche, chacune dirigée par un responsable scientifique et structurée autour de thèmes de recherche spécifiques.</p>',
        ];

        foreach ($teams as $team) {
    $body[] = "
        <div class='mt-6'>
            <h4 class='text-lg font-semibold text-[var(--gray-dark)]'>
                {$team['name']}
            </h4>
            <p>{$team['description']}<p>
            <p class='text-sm text-[var(--gray)] mt-1'>
                Responsable : <span class='font-medium'>{$team['first_name']} {$team['last_name']}</span>
            </p>
            <p class='text-sm text-[var(--gray)] mt-2'>
                Thèmes de recherche :
                <span class='italic'>{$team['research_themes']}</span>
            </p>
        </div>
    ";
}
        $card = new Card($header, $body, [], "bg-[var(--white)] p-8 rounded-2xl border border-gray-200");
        $card->render();
    
    }

  private function list_teams($teams) {
    echo '<section class="px-8">';
    echo '<div class="mx-auto px-4">';
    
    echo '<div class="text-center mb-12">';
    echo '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">Équipes de Recherche</span>';
    $title = (new Title("Nos Équipes Scientifiques", "text-3xl font-bold text-[var(--gray-dark)] mb-4", 'h2'))->render();
    echo $title;
    echo '<p class="text-[var(--gray)] max-w-3xl mx-auto">Découvrez nos équipes de recherche spécialisées, chacune dédiée à un domaine d\'expertise spécifique</p>';
    echo '</div>';
    
    $teamNames = [];
    $supervisors = [];
    $themes = [];
    
    foreach($teams as $team) {
        $teamNames[$team['name']] = $team['name'];
        
        $supervisor = $team['first_name'] . " " . $team['last_name'];
        $supervisors[$supervisor] = $supervisor;
        
        $teamThemes = explode(',', $team['research_themes']);
        foreach ($teamThemes as $theme) {
            $theme = trim($theme);
            if ($theme) {
                $themes[$theme] = $theme;
            }
        }
    }
    
    $filterManager = FilterManager::getInstance();
    $filterManager->reset(); 
    
    $filterManager->addFilter(
        'teamName',
        'Nom d\'équipe',
        $teamNames,
        'Toutes les équipes',
        '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>'
    );
    
    $filterManager->addFilter(
        'supervisor',
        'Responsable',
        $supervisors,
        'Tous les responsables',
        '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
        </svg>'
    );
    
    $filterManager->addFilter(
        'theme',
        'Domaine',
        $themes,
        'Tous les domaines',
        '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
        </svg>'
    );
    
    $filterManager->renderFilterSection("Filtrer les équipes", "Sélectionnez vos critères de filtrage");
    
    if(!empty($teams)) {
        echo '<div class="relative mb-12 grid">';
            echo '<button id="prevTeam" class="carousel-nav prev">';
            echo '<svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>';
            echo '</svg>';
            echo '</button>';
            
            echo '<button id="nextTeam" class="carousel-nav next">';
            echo '<svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
            echo '</svg>';
            echo '</button>';
        
            echo '<div class="overflow-x-auto pb-6 scrollbar-hide" id="teamsCarousel">';
            echo '<div class="flex gap-8 min-w-max px-4" id="teamsContainer">';
        
        foreach($teams as $team) {
            $teamLead = $team['first_name']." ".$team['last_name'];
            $researchDomain = $team['research_themes'];
            $description = $team['description'];
            
            if(strlen($description) > 120) {
                $description = substr($description, 0, 120) . '...';
            }
            
            $teamThemes = array_map('trim', explode(',', $researchDomain));
            
            $filterData = [
                'teamName' => $team['name'],
                'supervisor' => $teamLead,
                'theme' => $teamThemes
            ];
            
            $header = [
                "<div class='p-6 border-b border-gray-200'>
                    <div class='w-12 h-12 rounded-xl bg-gradient-to-r from-blue-100 to-blue-50 flex items-center justify-center'>
                        <svg class='w-6 h-6 text-[var(--primary)]' fill='currentColor' viewBox='0 0 20 20'>
                            <path d='M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z'/>
                        </svg>
                    </div>
                    <h3 class='text-xl font-bold text-[var(--gray-dark)] mb-2'>{$team['name']}</h3>
                    <span class='inline-flex items-center text-sm text-gray-600 gap-2'>
                        <img src='{$team['profile_picture']}' class='w-8 h-8 rounded-full'>
                        {$teamLead}
                    </span>
                </div>"
            ];
            
            $body = [
                "<div class='p-6'>
                    <div class='mb-4'>
                        <h4 class='text-sm font-medium text-[var(--gray)] mb-1'>Domaines de recherche</h4>
                        <div class='flex flex-wrap gap-2 mt-2'>"
            ];
            
            foreach ($teamThemes as $theme) {
                if (!empty(trim($theme))) {
                    $body[] = "<span class='inline-flex px-3 py-1 text-xs font-medium bg-blue-50 text-[var(--primary)] rounded-full border border-blue-100'>" . htmlspecialchars($theme) . "</span>";
                }
            }
            
            $body[] = "</div></div>";
            $body[] = "<p class='text-[var(--gray)] text-sm leading-relaxed mt-4'>{$description}</p>";
            $body[] = "<div class='mt-6'>";
            $body[] = "<h4 class='text-sm font-medium text-[var(--gray-dark)] mb-2'>Membres</h4>";
            $body[] = "<div class='grid gap-2'>";

            foreach ($team['members'] as $member) {
                if($member['id'] !== $team['team_leader_id']){
                    $body[] ="
                    <p class='text-[var(--gray-dark)] text-sm leading-relaxed flex gap-2 items-center'>
                        <img src='{$member['profile_picture']}' class='rounded-full w-10 h-10'>
                        {$member['first_name']} {$member['last_name']}
                    </p>";
                }
            }
            
            $body[] = "</div></div></div>";
            
            $footer = [
                "<div class='px-6 pb-6 pt-0'>
                    <a href='index.php?page=team&id={$team['team_id']}' class='inline-flex items-center text-[var(--primary)] hover:text-[var(--primary-light)] font-medium text-sm'>
                        Voir l'équipe
                        <svg class='w-4 h-4 ml-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M14 5l7 7m0 0l-7 7m7-7H3'/>
                        </svg>
                    </a>
                </div>"
            ];
            
            $card = new Card(
                $header,
                $body,
                $footer,
                'bg-[var(--white)] rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex-shrink-0 w-96'
            );
            
            echo '<div class="filterable-item transform transition-all duration-300 hover:-translate-y-2 flex-shrink-0" data-filter-info=\'' . htmlspecialchars(json_encode($filterData), ENT_QUOTES, 'UTF-8') . '\'>';
            $card->render();
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
        echo '</div>'; 
        
        echo '<div id="noResults" class="hidden text-center py-12">';
        echo '<div class="w-24 h-24 mx-auto mb-6 text-gray-300">';
        echo '<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
        echo '</svg>';
        echo '</div>';
        echo '<h3 class="text-xl font-semibold text-gray-600 mb-2">Aucune équipe trouvée</h3>';
        echo '<p class="text-gray-500">Aucune équipe ne correspond à vos critères de filtrage</p>';
        echo '</div>';
        
    } else {
        echo '<div class="text-center py-12">';
        echo '<p class="text-gray-500">Aucune équipe disponible pour le moment.</p>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</section>';
    
    echo $filterManager->getFilterJS('teamsContainer', '.filterable-item', 'noResults');
    
    echo '
    <style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 9999px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .carousel-nav:hover:not(:disabled) {
        background-color: #f9fafb;
        transform: translateY(-50%) scale(1.05);
    }
    
    .carousel-nav:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    
    .carousel-nav.prev {
        left: 0;
        transform: translate(-50%, -50%);
    }
    
    .carousel-nav.prev:disabled {
        transform: translate(-50%, -50%) scale(1);
    }
    
    .carousel-nav.prev:hover:not(:disabled) {
        transform: translate(-50%, -50%) scale(1.05);
    }
    
    .carousel-nav.next {
        right: 0;
        transform: translate(50%, -50%);
    }
    
    .carousel-nav.next:disabled {
        transform: translate(50%, -50%) scale(1);
    }
    
    .carousel-nav.next:hover:not(:disabled) {
        transform: translate(50%, -50%) scale(1.05);
    }
    
    .filter-group {
        min-width: 200px;
    }
    
    .filter-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3e%3cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M6 8l4 4 4-4\'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .filter-select:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
    }
    
    .filter-clear-btn {
        height: fit-content;
        transition: all 0.2s;
    }
    
    .filter-clear-btn:hover {
        background-color: #e5e7eb;
    }
    
    .filterable-item {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    #teamsCarousel {
        scroll-behavior: smooth;
    }
    </style>';
}

    private function print_organigramme($orgaData){
         echo '<div class="mb-16">';
            $subtitle = (new Title("Structure Organisationnelle", "text-3xl font-bold text-[var(--gray-dark)] mb-6", 'h3'))->render();
            echo $subtitle;
            echo '<p class="text-[var(--gray)] mb-8 max-w-3xl">Notre laboratoire est structuré de manière à optimiser la collaboration entre les différentes équipes de recherche et à favoriser l\'innovation transversale.</p>';
            echo '<div class="bg-[var(--white)] p-8 rounded-2xl border border-gray-200">';
            $orga = new Organigramme();
            $orga->render($orgaData);
            echo '</div>';
        echo '</div>';
    }

    private function print_stat($nbEns, $nbProj, $nbPub, $nbpart){
        echo '<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">';
        
        $stats = [
            ['value' => $nbEns, 'label' => 'Membres', 'icon' => 'users', 'color' => 'blue'],
            ['value' => $nbProj, 'label' => 'Projets', 'icon' => 'lightning-bolt', 'color' => 'green'],
            ['value' => $nbPub, 'label' => 'Publications', 'icon' => 'document-text', 'color' => 'purple'],
            ['value' => $nbpart, 'label' => 'Partenaires', 'icon' => 'handshake', 'color' => 'orange'],
        ];
        
        foreach ($stats as $stat) {
            $colorClasses = [
                'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
                'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
            ];
            
            $color = $colorClasses[$stat['color']];
            
            echo '<div class="bg-[var(--white)] p-6 rounded-xl border border-gray-200 text-center">';
            echo '<div class="' . $color['bg'] . ' w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4">';
            echo '<svg class="w-7 h-7 ' . $color['text'] . '" fill="currentColor" viewBox="0 0 20 20">';
            switch($stat['icon']) {
                case 'users':
                    echo '<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>';
                    break;
                case 'lightning-bolt':
                    echo '<path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>';
                    break;
                case 'document-text':
                    echo '<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>';
                    break;
                case 'handshake':
                    echo '<path fill-rule="evenodd" d="M16 7.5a4 4 0 11-8 0 4 4 0 018 0zm-8 5.5a5.5 5.5 0 1111 0v2.5a.5.5 0 01-1 0V13a4.5 4.5 0 10-9 0v2.5a.5.5 0 01-1 0V13z" clip-rule="evenodd"/>';
                    break;
            }
            echo '</svg>';
            echo '</div>';
            echo '<div class="text-3xl font-bold text-[var(--gray-dark)] mb-2">' . $stat['value'] . '</div>';
            echo '<div class="text-[var(--gray)]">' . $stat['label'] . '</div>';
            echo '</div>';
        }
        
        echo '</div>';

    }

    public function show_page($orga, $teams,$stat) {
        echo '<section class="py-24 px-12">';
            echo '<div class="container mx-auto px-4 max-w-7xl flex flex-col gap-8">';
            
                echo '<div class="text-center mb-16">';
                    echo '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-6">À propos de nous</span>';
                    $title = (new Title("Présentation du Laboratoire", "text-4xl font-bold text-[var(--gray-dark)] mb-6", 'h1'))->render();
                    echo $title;
                    echo '<p class="text-[var(--gray)] text-xl max-w-3xl mx-auto">Un centre d\'excellence dédié à l\'innovation scientifique et à la recherche de pointe</p>';
                echo '</div>';
                $this->print_labo_pres($teams);
                $this->print_organigramme($orga);
                $this->print_stat($stat['membres'], $stat['projets'], $stat['pubs'], $stat['parts']);
                $this->list_teams($teams);
            echo '</div>';
        echo '</section>';
    }


   
}
?>