<?php
require_once "components/title.php";
require_once "components/card.php";
require_once "components/badge.php";
require_once "components/userCard.php";
require_once "components/table.php";
require_once "components/form.php";

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
                    ' . $pub['type'] .  '
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
    if(!empty($members)) {
            echo "<div class='grid lg:grid-cols-3 gap-6'>";
            foreach($members as $member) {
                echo "<div class='transform transition-all duration-300 hover:-translate-y-1 hover:shadow-md'>";
                $userCard = new UserCard(
                    $member['first_name'], 
                    $member['last_name'], 
                    $member['role'], 
                    $member['status_user'], 
                    $member['profile_picture'], 
                    $member['email'], 
                    $member['speciality'],
                    $member['post'], 
                    $member['grade'],
                    $member['bio']
                );
                $userCard->render();
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200'>";
            echo "<svg class='w-16 h-16 text-gray-300 mx-auto mb-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>";
            echo "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'/>";
            echo "</svg>";
            echo "<p class='text-gray-600 font-medium'>Aucun membre supplémentaire</p>";
            echo "<p class='text-gray-500 text-sm mt-1'>Le responsable est actuellement le seul membre de ce projet</p>";
            echo "</div>";
        }
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

        if (!empty($team['research_themes'])) {
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
                <p class='text-gray-700 text-lg leading-relaxed pl-14'>" . $team['research_themes'] . "</p>
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
                        $previous = $_SERVER['HTTP_REFERER'];
                        echo '<div class="pt-8">';
                            echo "<a href='$previous' class='inline-flex items-center px-6 py-3 text-gray-700 font-medium rounded-lg hover:bg-gray-50'>
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
    public function show_teams($teams, $allowed){
        $nb_teams = count($teams);
        echo '<section class="min-h-screen py-24 w-full px-12">';
            echo '<div class="mb-10">';
                echo '<h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Gestion des equipes</h1>';
                echo '<p class="text-gray-600 text-lg">Consultez et gérez tous les equipes du système</p>';
                echo '<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">';
                     $header = [
                                "<div class='text-sm text-gray-500 mb-1'>Nombre d'equipe</div>"
                            ];
                            $body = [
                                "<div class='text-2xl font-bold text-gray-900'>{$nb_teams}</div>"
                            ];
                    $card = new Card($header, $body, [], "border-t-4 bg-white border-purple-600 rounded-xl p-4 shadow-sm");        $card->render();
                echo '</div>';
                echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
        
                    echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
                        echo '<h2 class="text-xl font-bold text-gray-900">Liste des equipes</h2>';
                        
                        echo "<div class='flex gap-6 ml-auto'>";
                            if ($allowed['create']) {
                                echo '<a href="index.php?page=create_team" class="px-4 py-2 bg-[var(--primary)] text-white font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">';
                                echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
                                echo '</svg>';
                                echo 'Nouvelle equipe';
                                echo '</a>';
                            }
                        echo "</div>";
                    echo '</div>';
                echo '</div>';
                $data = [];
                foreach($teams as $team){
                    $chef_equipe = "
                        <div class='flex items-center justify-center gap-4'>
                            <img src='{$team['profile_picture']}' class='rounded-full w-10 h-10'>
                            <p>{$team['first_name']} {$team['last_name']}</p>
                        </div>
                    ";
                    $data[] = [
                        "Nom de l'equipe" => $team['name'],
                        "Le chef d'equipe" => "{$chef_equipe}",
                        "Theme de recherche" => $team['research_themes'],
                         'Actions' => '<div class="relative inline-block text-left">
                                            <button type="button" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors action-menu-btn" data-project-id="' . $team['team_id'] . '">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                                </svg>
                                            </button>
                                    ' . ($allowed['update'] ? '
                                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-10 hidden action-menu" data-project-id="' . $team['team_id'] . '">'.'
                                    
                                        <div class="py-1">
                                            
                                            <a href="index.php?page=update_team&id=' . $team['team_id'] . '" 
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                <span>Modifier l\'equipe</span>
                                                <a href="index.php?page=team_member&id=' . $team['team_id'] . '" 
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-2.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                                                </svg>
                                                <span>Gérer les membres</span>
                                            </a>

                                    </a>' : '') . "
                                <div class='border-t border-gray-200 my-1'></div>
                                    <a href='index.php?page=team&id={$team['team_id']}' class='flex items-center gap-3 px-4 py-2.5 text-sm text-blue-600 hover:bg-blue-50 transition-colors'>
                                    <svg class='w-4 h-4 ml-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M14 5l7 7m0 0l-7 7m7-7H3'/>
                                    </svg>
                                    Voir plus
                                    </a>
                                </div>".'
                                ' . ($allowed['delete'] ? '
                                <div class="border-t border-gray-200 my-1"></div>
                                <a href="index.php?page=delete_team&id=' . $team['team_id'] . '"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>Supprimer l\'equipe</span>
                                </a>' : '') . '
                                </div>
                            </div>
                        </div>',
                    ];
                }
                $columns = ["Nom de l'equipe", "Le chef d'equipe", "Theme de recherche"];
                $table = new Table($columns, $data, "w-full");
                $table->render();

echo '
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("click", function(event) {
        const actionMenus = document.querySelectorAll(".action-menu");
        const actionBtns = document.querySelectorAll(".action-menu-btn");
        
        if (event.target.closest(".action-menu-btn")) {
            const btn = event.target.closest(".action-menu-btn");
            const menu = document.querySelector(\'.action-menu[data-project-id="\' + btn.dataset.projectId + \'"]\');
            
            actionMenus.forEach(function(otherMenu) {
                if (otherMenu !== menu) {
                    otherMenu.classList.add("hidden");
                }
            });
            
            if (menu) {
                menu.classList.toggle("hidden");
            }
            
            event.stopPropagation();
        } 
        else if (!event.target.closest(".action-menu")) {
            actionMenus.forEach(function(menu) {
                menu.classList.add("hidden");
            });
        }
    });
    
    const menuLinks = document.querySelectorAll(".action-menu a");
    menuLinks.forEach(function(link) {
        link.addEventListener("click", function() {
            const menu = this.closest(".action-menu");
            if (menu) {
                menu.classList.add("hidden");
            }
        });
    });
    
});
</script>
';
            echo '</div>';
        echo '</section>';
    }

public function create_update_form($team, $users) {
    $link = $team === null ? "index.php?page=createTeam" : "index.php?page=updateTeam";
    $action = $team === null ? "Ajouter" : "Modifier";

    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 max-w-4xl">';

    $users = array_reduce($users, function($acc, $user) {
        $acc[$user['id']] = $user['first_name'] . ' ' . $user['last_name'];
        return $acc;
    }, []);

    $form = new Form($link, 'POST', $action, '', '', true);

    $form->addInput('name', 'Nom de l\'equipe', $team['name'] ?? '', 'Nom de l\'equipe');
    $form->addTextarea('description', 'Description', $team['description'] ?? '', 'Description');
    $form->addInput('research_themes', 'Thème de recherche', $team['research_themes'] ?? '', 'Thème du recherche');
    $form->addSelect('team_leader_id', 'Chef d\'equipe', $users, $team['team_leader_id'] ?? '');
    if ($team) {
        $form->addHidden('team_id', $team['team_id'] ?? '');
    }    
    $form->render();
    echo '</div>';
    echo '</section>';
}
}


?>