<?php
require_once "components/title.php";
require_once "components/card.php";
require_once "components/badge.php";
class TeamView{

    private function render_publications($publications){
        $pubBody = [];
if (!empty($publications)) {
    $pubContent = '<div class="grid md:grid-cols-2 gap-6">';
    $borderColors = [
        'border-t-8 border-blue-500',
        'border-t-8 border-purple-500',
        'border-t-8 border-emerald-500',
        'border-t-8 border-amber-500'
    ];
    
    foreach ($publications as $index => $pub) {

        $borderColor = $borderColors[$index % count($borderColors)];
        $pubContent .= '
        <div class="bg-white '. $borderColor .' rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-[var(--primary)]">
                    ' . $pub['type'] . '
                </span>
                <span class="text-sm text-gray-500">
                    ' . $pub['publication_date'] . '
                </span>
            </div>
            
            <h4 class="font-bold text-gray-900 mb-2">
                ' . $pub['title'] . '
            </h4>
            
            <p class="text-gray-600 text-sm mb-4">
                ' . substr(strip_tags($pub['abstract']), 0, 100) . '...
            </p>
            
            <div class="flex items-center gap-2">
                <p class="font-medium text-gray-700">Domain: </p>
                <span class="text-sm text-gray-500">
                    ' . $pub['domain'] . '
                </span>
                
            </div>
            <div class="flex items-center gap-2">
                <p class="font-medium text-gray-700">DOI: </p>
                <span class="text-sm text-gray-500">
                    ' . $pub['doi'] . '
                </span>
                
            </div>
            <div class="flex justify-end gap-2">
            <a class="text-[var(--primary)]" href="index.php?page=publication&id=' . $pub['id'] . '">Voir détails</a>
            </div>
        </div>';
    }
    
    $pubContent .= '</div>';
    
    $pubCard = new Card(
        ["<div class='flex items-center justify-between mb-8 pb-6 border-b border-gray-200'>
                    <div>
                        <h2 class='text-2xl font-bold text-gray-900'>Publications</h2>
                        <p class='text-gray-600 text-sm mt-2'>Voir ce que nos membres ont publie</p>
                    </div>
                    <span class='px-4 py-2 bg-blue-100 text-[var(--primary-light)] text-sm font-medium rounded-full'>
                        " . count($publications) . " publications
                    </span>
                </div>"],
        [$pubContent],
        [],
        'bg-white rounded-xl shadow-lg border border-gray-200 p-6'
    );
    
    echo $pubCard->render();
} else {
    echo '<div class="text-center p-8 text-gray-500">
        <p>Aucune publication disponible</p>
    </div>';
}              
    }
    private function render_members($members){
        $membersCard = null;
        if (!empty($members)) {
            $membersHeader = [
                "<div class='flex items-center justify-between mb-8 pb-6 border-b border-gray-200'>
                    <div>
                        <h2 class='text-2xl font-bold text-gray-900'>Membres de l'équipe</h2>
                        <p class='text-gray-600 text-sm mt-2'>Collaborateurs et chercheurs</p>
                    </div>
                    <span class='px-4 py-2 bg-blue-100 text-[var(--primary-light)] text-sm font-medium rounded-full'>
                        " . count($members) . " membres
                    </span>
                </div>"
            ];
            
            $membersBody = [];
            foreach($members as $index => $member) {
                $emailSection = '';
                if (!empty($member['email'])) {
                    $emailSection = "
                    <div class='mt-3 pt-3 border-t border-gray-100'>
                        <a href='mailto:" . $member['email'] . "' class='inline-flex items-center text-sm text-[var(--primary)] hover:text-[var(--primary-light)] transition-colors'>
                            <svg class='w-4 h-4 mr-2' fill='currentColor' viewBox='0 0 20 20'>
                                <path d='M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z'/>
                                <path d='M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z'/>
                            </svg>
                            " . $member['email'] . "
                        </a>
                    </div>";
                }
                
               
                
                $membersBody[] = "
                <div class='group bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-all duration-300 animate-fade-in'>
                    <div class='flex items-start gap-5'>
                        <div class='relative'>
                            <img src='{$member['profile_picture']}' class='rounded-full w-12 h-12'>
                        </div>
                        <div class='grid gap-2'>
                            <div class='flex items-start justify-between mb-2'>
                                <div>
                                    <h3 class='font-bold text-gray-900 text-lg transition-colors'>
                                        " . $member['first_name'] . " " . $member['last_name'] . "
                                    </h3>
                                </div>
                            </div>
                            <div class='space-y-2'>
                                <div class='flex items-centers gap-2'>
                                    <div class='w-6 h-6 rounded-md bg-blue-50 flex items-center justify-center'>
                                        <svg class='w-4 h-4 text-blue-600' fill='currentColor' viewBox='0 0 20 20'>
                                            <path fill-rule='evenodd' d='M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z' clip-rule='evenodd'/>
                                        </svg>
                                    </div>
                                    <span class='text-sm text-gray-700'>Poste: <span class='font-medium'>" . $member['post'] . "</span></span>
                                </div>
                    
                                <div class='flex items-center gap-2'>
                                    <span class='text-sm text-gray-700'>Grade: <span class='font-medium'>" . $member['grade'] . "</span></span>
                                </div>
                        </div>
                        <span class='text-sm text-gray-700'>Specialite: <span class='font-medium'>" . $member['speciality'] . "</span></span>
                            $emailSection
                    </div>
                </div>
                </div>";
            }
            
            $membersCard = new Card(
                $membersHeader,
                ["<div class='grid md:grid-cols-2 lg:grid-cols-3 gap-6'>" . implode('', $membersBody) . "</div>"],
                [],
                'bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition-shadow duration-300'
            );
        }

        echo $membersCard->render();
    }
    private function render_team($team){
        $teamInfoBody = [];

        if (!empty($team['team_leader_id'])) {
            $teamInfoBody[] = "
            <div class='rounded-xl p-5 border border-blue-200 mb-6'>
                <div class='flex items-center gap-4'>
                    <img src='{$team['profile_picture']}' class='rounded-full w-12 h-12'>
                    <div>
                        <div class='text-sm font-medium text-[var(--primary)] mb-1'>Responsable de l'équipe</div>
                        <div class='text-xl font-bold text-gray-900'>" . $team['first_name'] . " " . $team['last_name'] . "</div>
                    </div>
                </div>
                <div>
                    <div class='text-sm font-medium text-[var(--primary)] mb-1'>". $team['speciality'] ."</div>
                    <div class='text-xl font-bold text-gray-900'>" . $team['post'] . "</div>
                    <div class='text-xl font-bold text-gray-900'>" . $team['grade'] . "</div>
                </div>
            </div>";
        }

        if (!empty($team['research_theme'])) {
            $teamInfoBody[] = "
            <div class='mb-8'>
                <div class='flex items-center gap-3 mb-4'>
                    <div class='w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center'>
                        <svg class='w-5 h-5 text-purple-600' fill='currentColor' viewBox='0 0 20 20'>
                            <path fill-rule='evenodd' d='M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z' clip-rule='evenodd'/>
                        </svg>
                    </div>
                    <h3 class='text-xl font-bold text-gray-900'>Thème de recherche</h3>
                </div>
                <p class='text-gray-700 text-lg leading-relaxed pl-14'>" . $team['research_theme'] . "</p>
            </div>";
        }

        if (!empty($team['description'])) {
            $teamInfoBody[] = "
            <div class='mb-8'>
                <div class='flex items-center gap-3 mb-4'>
                    <div class='w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center'>
                        <svg class='w-5 h-5 text-green-600' fill='currentColor' viewBox='0 0 20 20'>
                            <path fill-rule='evenodd' d='M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z' clip-rule='evenodd'/>
                        </svg>
                    </div>
                    <h3 class='text-xl font-bold text-gray-900'>Description</h3>
                </div>
                <div class='prose prose-lg max-w-none pl-14'>
                    <p class='text-gray-700 leading-relaxed'>" . $team['description'] . "</p>
                </div>
            </div>";
        }

        $teamInfoCardHeader = [(new Title(
            "À propos de l'équipe",
            'text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-200',
            'h2'
        ))->render()];

        $teamInfoCard = new Card(
            $teamInfoCardHeader,
            ["<div class='space-y-8'>" . implode('', $teamInfoBody) . "</div>"],
            [],
            'bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition-shadow duration-300'
        );
        echo $teamInfoCard->render();

    }


private function render_equips($equips) {
    $equipHeader = [
        "<div class='flex items-center justify-between mb-8 pb-6 border-b border-gray-200'>
                    <div>
                        <h2 class='text-2xl font-bold text-gray-900'>Équipements</h2>
                        <p class='text-gray-600 text-sm mt-2'>Tous les équipements réservés par nos membres</p>
                    </div>
                    <span class='px-4 py-2 bg-blue-100 text-[var(--primary-light)] text-sm font-medium rounded-full'>
                        " . count($equips) . " equipments
                    </span>
                </div>"
    ];
    
   $equipmentsHTML = '';
    foreach($equips as $equip) {
        $equipmentsHTML .= "
        <div class='bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow'>
            <span class='inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full mb-3'>
                " . ($equip['category'] ?? 'Catégorie') . "
            </span>
            <h3 class='text-lg font-bold text-gray-900 mb-2'>
                " . ($equip['name'] ?? 'Nom') . "
            </h3>
            <p class='text-gray-600 text-sm'>
                " . (isset($equip['description']) ? substr(strip_tags($equip['description']), 0, 120) . '...' : 'Pas de description') . "
            </p>
        </div>
        ";
    }
    
    $card = new Card(
        $equipHeader,
        ["<div class='grid md:grid-cols-2 lg:grid-cols-3 gap-6'>" . $equipmentsHTML . "</div>"],
        [],
        'bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition-shadow duration-300'
    );
    
    echo $card->render();
}


     public function show_team($team, $members, $publications, $equips){
       echo '<section class="py-24 px-24 bg-gray-50 min-h-screen">';
            echo '<div class="container mx-auto px-4 max-w-7xl">';

                    echo '<div class="mb-10">';
                        $title = (new Title(
                            $team['name'],
                            'text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-3',
                            'h1'
                        ))->render();
                        echo $title;
                        echo "<div class='text-gray-600 text-lg'>Équipe de recherche</div>";
                    echo '</div>';

                    echo '<div class="space-y-10">';
                        $this->render_team($team);
                        $this->render_members($members);
                        $this->render_publications($publications);
                        $this->render_equips($equips);
                        echo '<div class="pt-8">';
                            echo "<a href='index.php?page=membres' class='inline-flex items-center px-6 py-3 text-gray-700 font-medium rounded-lg hover:bg-gray-50'>
                                <svg class='w-5 h-5 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 19l-7-7m0 0l7-7m-7 7h18'/>
                                </svg>
                                Retour aux équipes
                            </a>";
                        echo '</div>';
                    echo '</div>';

            echo '</div>';
        echo '</section>';
    }
}


?>