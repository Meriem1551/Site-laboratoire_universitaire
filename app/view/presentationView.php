<?php
require_once "components/orga.php";
require_once "components/title.php";
require_once "components/card.php";
require_once "components/badge.php";

class PresentationView {
    private function print_labo_pres($teams) { 
        $header = [
            '<h3 class="text-2xl font-bold text-gray-900 mb-6">Le Laboratoire de Recherche Avancée</h3>'
        ];

        $body = [
            '<p class="text-gray-700 leading-relaxed mb-6">Le Laboratoire de Recherche en Sciences et Technologies est un centre d\'excellence dédié à l\'innovation scientifique et technologique. Nous rassemblons des chercheurs, enseignants-chercheurs et étudiants autour de projets multidisciplinaires visant à développer des solutions novatrices dans les domaines de l\'informatique avancée, la biotechnologie, l\'ingénierie des matériaux et l\'intelligence artificielle.</p>',
            '<p class="text-gray-700 leading-relaxed">Le laboratoire est organisé en équipes de recherche, chacune dirigée par un responsable scientifique et structurée autour de thèmes de recherche spécifiques.</p>',
        ];

        foreach ($teams as $team) {
    $body[] = "
        <div class='mt-6'>
            <h4 class='text-lg font-semibold text-gray-900'>
                {$team['name']}
            </h4>
            <p>{$team['description']}<p>
            <p class='text-sm text-gray-600 mt-1'>
                Responsable : <span class='font-medium'>{$team['first_name']} {$team['last_name']}</span>
            </p>
            <p class='text-sm text-gray-700 mt-2'>
                Thèmes de recherche :
                <span class='italic'>{$team['research_themes']}</span>
            </p>
        </div>
    ";
}
        $card = new Card($header, $body, [], "bg-white p-8 rounded-2xl border border-gray-200");
        $card->render();
    
    }

    private function list_teams($teams) {
        echo '<section class="px-8">';
        echo '<div class=" mx-auto px-4">';
        
        echo '<div class="text-center mb-12">';
        echo '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">Équipes de Recherche</span>';
        $title = (new Title("Nos Équipes Scientifiques", "text-3xl font-bold text-gray-900 mb-4", 'h2'))->render();
        echo $title;
        echo '<p class="text-gray-600 max-w-3xl mx-auto">Découvrez nos équipes de recherche spécialisées, chacune dédiée à un domaine d\'expertise spécifique</p>';
        echo '</div>';
        
        if(!empty($teams)) {
            echo '<section class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">';
            
            foreach($teams as $team) {
                $teamLead = $team['first_name']." ".$team['last_name'];
                $researchDomain = $team['research_themes'];
                $description = $team['description'];
                
                if(strlen($description) > 120) {
                    $description = substr($description, 0, 120) . '...';
                }
                
                $header = [
                    "<div class='p-6 border-b border-gray-200'>
                            <div class='w-12 h-12 rounded-xl bg-gradient-to-r from-blue-100 to-blue-50 flex items-center justify-center'>
                                <svg class='w-6 h-6 text-[var(--primary)]' fill='currentColor' viewBox='0 0 20 20'>
                                    <path d='M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z'/>
                                </svg>
                            </div>
                        <h3 class='text-xl font-bold text-gray-900 mb-2'>{$team['name']}</h3>
                        <span class='inline-flex items-center text-sm text-gray-600 gap-2'>
                            <img src='{$team['profile_picture']}'  class='w-8 h-8 rounded-full'>
                            {$teamLead}
                        </span>
                    </div>"
                ];
                
                $body = [
                    "<div class='p-6'>
                        <div class='mb-4'>
                            <h4 class='text-sm font-medium text-gray-500 mb-1'>Domaine de recherche</h4>
                            <span class='inline-flex px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full'>
                                {$researchDomain}
                            </span>
                        </div>
                        <p class='text-gray-600 text-sm leading-relaxed'>{$description}</p>
                        <div class='grid'>
                        <h4 class='text-sm font-medium text-gray-500 mb-2'>Membres</h4>
                        <div class='grid gap-2'>
                    "
                ];

                foreach ($team['members'] as $member) {
                    if($member['id'] !== $team['team_leader_id']){
                        $body[] ="
                        <p class='text-gray-600 text-sm leading-relaxed flex gap-2 items-center'><img src='{$member['profile_picture']}' class='rounded-full w-10 h-10'> {$member['first_name']} {$member['last_name']}</p>
                    ";
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
                    'bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300'
                );
                
                echo '<div class="transform transition-all duration-300 hover:-translate-y-2">';
                $card->render();
                echo '</div>';
            }
            
            echo '</?div>';
        }
        
        echo '</div>';
        echo '</section>';
    }

    private function print_organigramme($orgaData){
         echo '<div class="mb-16">';
            $subtitle = (new Title("Structure Organisationnelle", "text-3xl font-bold text-gray-900 mb-6", 'h3'))->render();
            echo $subtitle;
            echo '<p class="text-gray-600 mb-8 max-w-3xl">Notre laboratoire est structuré de manière à optimiser la collaboration entre les différentes équipes de recherche et à favoriser l\'innovation transversale.</p>';
            echo '<div class="bg-white p-8 rounded-2xl border border-gray-200">';
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
            
            echo '<div class="bg-white p-6 rounded-xl border border-gray-200 text-center">';
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
            echo '<div class="text-3xl font-bold text-gray-900 mb-2">' . $stat['value'] . '</div>';
            echo '<div class="text-gray-600">' . $stat['label'] . '</div>';
            echo '</div>';
        }
        
        echo '</div>';

    }

    public function show_page($orga, $teams,$stat) {
        echo '<section class="py-24 px-12">';
            echo '<div class="container mx-auto px-4 max-w-7xl flex flex-col gap-8">';
            
                echo '<div class="text-center mb-16">';
                    echo '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-6">À propos de nous</span>';
                    $title = (new Title("Présentation du Laboratoire", "text-4xl font-bold text-gray-900 mb-6", 'h1'))->render();
                    echo $title;
                    echo '<p class="text-gray-600 text-xl max-w-3xl mx-auto">Un centre d\'excellence dédié à l\'innovation scientifique et à la recherche de pointe</p>';
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