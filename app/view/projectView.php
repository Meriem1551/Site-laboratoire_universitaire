<?php
require_once "components/card.php";
require_once "components/badge.php";
require_once "components/title.php";
require_once "components/table.php";
require_once "components/form.php";
require_once "components/lineChart.php";
require_once "components/barChart.php";
require_once "components/pieChart.php";
require_once "components/userCard.php";
require_once "components/filterManager.php";

class ProjectView {
   public function show_projects($projects) {
    echo '<section class="py-16 my-10">';
    echo '<div class="container mx-auto px-4 max-w-7xl">';
    
    echo '<div class="mb-12">';
    echo '<h1 class="text-3xl font-bold text-[var(--gray-dark)] mb-4">Projets de Recherche</h1>';
    echo '<p class="text-[var(--gray)] max-w-3xl">Explorez nos initiatives de recherche innovantes menées par nos équipes scientifiques et leurs partenaires.</p>';
    echo '</div>';
    
    $allStatuses = [];
    $allThemes = [];
    
    foreach($projects as $project) {
        if (!empty($project['status']) && !in_array($project['status'], $allStatuses)) {
            $allStatuses[] = $project['status'];
        }
        
        if (!empty($project['theme']) && !in_array($project['theme'], $allThemes)) {
            $allThemes[] = $project['theme'];
        }
    }

    
    $filterManager = FilterManager::getInstance();
    $filterManager->reset();
    
    $filterManager->addFilter(
        'status',
        'Statut',
        array_combine($allStatuses, $allStatuses),
        'Tous les statuts',
        '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>'
    );
    
    $filterManager->addFilter(
        'theme',
        'Thème',
        array_combine($allThemes, $allThemes),
        'Tous les thèmes',
        '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
        </svg>'
    );
    
    $filterManager->renderFilterSection("Filtrer les projets", "Sélectionnez vos critères de filtrage");
    
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
    $themeFilter = isset($_GET['theme']) ? $_GET['theme'] : '';
    
    $filteredProjects = array_filter($projects, function($project) use ($statusFilter, $themeFilter) {
        $matches = true;
        
        if ($statusFilter && $project['status'] !== $statusFilter) {
            $matches = false;
        }
        
        if ($themeFilter && $project['theme'] !== $themeFilter) {
            $matches = false;
        }
        
        return $matches;
    });
    
    if(!empty($filteredProjects)) {
        echo '<div id="projectsContainer">';
        echo '<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8" id="projectsGrid">';
        
        foreach($filteredProjects as $index => $project) {            
            $filterData = [
                'status' => $project['status'],
                'theme' => $project['theme']
            ];
            
            $statusBadge = (new Badge(
                $project['status'],
                $this->getStatusColor($project['status']),
                "white",
                "rounded-full px-3 py-1 text-xs font-medium"
            ))->render();

            $title = (new Title(
                $project['title'], 
                'font-semibold text-xl text-[var(--gray-dark)] leading-tight mb-2', 
                'h3'
            ))->render();

            $header = [
                "<div class='relative h-56 overflow-hidden rounded-t-lg'>",
                "<div class='absolute inset-0 bg-gradient-to-br from-blue-900/20 to-gray-900/10 z-10'></div>",
                "<img src='{$project['image']}' class='w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110'>",
                "<div class='absolute top-4 right-4 z-20'>",
                $statusBadge,
                "</div>",
                "</div>"
            ];

            $body = [
                "<div class='p-6'>",
                "<div class='mb-3'>",
                $title,
                "</div>",
                "<div class='mb-4'>",
                "<span class='inline-flex items-center text-sm text-[var(--primary)] font-medium bg-blue-50 px-3 py-1 rounded-full'>",
                "<svg class='w-4 h-4 mr-1.5' fill='currentColor' viewBox='0 0 20 20'>",
                "<path fill-rule='evenodd' d='M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z' clip-rule='evenodd'/>",
                "</svg>",
                "{$project['theme']}",
                "</span>",
                "</div>",
                "<p class='text-[var(--gray)] text-sm leading-relaxed line-clamp-3 mb-4'>{$project['description']}</p>",
                "</div>"
            ];
            
            
            $footer = [
                "<div class='px-6 py-4 border-t border-gray-100 rounded-b-lg'>",
                "<div class='flex justify-between items-center text-sm'>",
                "<span class='text-[var(--gray)]'>Durée</span>",
                "<span class='font-medium text-[var(--gray-dark)]'>",
                "{$project['start_date']} – {$project['end_date']}",
                "</span>",
                "</div>",
                "</div>"
            ];

            echo '<div class="filterable-item pagination-item transform transition-all duration-300 hover:-translate-y-2" data-page="all" data-filter-info=\'' . htmlspecialchars(json_encode($filterData), ENT_QUOTES, 'UTF-8') . '\'>';
            echo "<a href='index.php?page=projet&id={$project['id']}' class='group block'>";
            $card = new Card(
                $header,
                $body,
                $footer,
                'bg-[var(--white)] rounded-lg shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300'
            );
            $card->render();
            echo "</a>";
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        
        $totalProjects = count($filteredProjects);
        $itemsPerPage = 6;
        $totalPages = ceil($totalProjects / $itemsPerPage);
        
        if ($totalPages > 1) {
            echo '<div class="mt-12 flex justify-center items-center gap-4">';
            echo '<div id="paginationInfo" class="text-sm text-gray-600">';
            echo 'Page <span id="currentPage" class="font-semibold">1</span> sur <span id="totalPages" class="font-semibold">' . $totalPages . '</span>';
            echo ' (<span id="visibleItems" class="font-semibold">' . min($itemsPerPage, $totalProjects) . '</span> sur <span id="totalItems" class="font-semibold">' . $totalProjects . '</span> projets)';
            echo '</div>';
            
            echo '<div class="flex items-center gap-2">';
            echo '<button id="prevPage" class="px-4 py-2 bg-[var(--white)] border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center gap-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>';
            echo '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>';
            echo '</svg>';
            echo '<span>Précédent</span>';
            echo '</button>';
            
            echo '<div id="pageNumbers" class="flex gap-1">';
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == 1) {
                    echo '<button class="page-btn px-3 py-2 bg-[var(--primary)] text-[var(--white)] font-medium rounded-lg hover:bg-blue-700 transition-colors" data-page="' . $i . '">' . $i . '</button>';
                } else {
                    echo '<button class="page-btn px-3 py-2 bg-[var(--white)] border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors" data-page="' . $i . '">' . $i . '</button>';
                }
            }
            echo '</div>';
            
            echo '<button id="nextPage" class="px-4 py-2 bg-[var(--white)] border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center gap-2 transition-colors' . ($totalPages > 1 ? '' : ' disabled:opacity-50 disabled:cursor-not-allowed') . '">';
            echo '<span>Suivant</span>';
            echo '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
            echo '</svg>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '<div id="noResults" class="hidden text-center py-12">';
        echo '<h3 class="text-xl font-semibold text-gray-600 mb-2">Aucun projet trouvé</h3>';
        echo '<p class="text-gray-500">Aucun projet ne correspond à vos critères de filtrage</p>';
        echo '</div>';
        
    } else {
        echo '<div class="text-center py-12">';
        echo '<p class="text-gray-500">Aucun projet disponible pour le moment.</p>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</section>';
    
    echo $filterManager->getFilterJS('projectsContainer', '.filterable-item', 'noResults');
    
    echo '
    <style>
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
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .pagination-item {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    </style>';
}

    private function getStatusColor($status) {
        $colors = [
            'soumis' => '#10b981',
            'termine' => '#6b7280', 
            'en-cours' => '#3b82f6',
        ];
        return $colors[$status] ?? '#6b7280';
    }

    public function show_project($project, $members = "", $partners = "", $publications = "") {
        $title = (new Title(
            $project['title'],
            'font-bold text-3xl lg:text-4xl text-[var(--gray-dark)] leading-tight',
            'h1'
        ))->render();

        $statusBadge = (new Badge(
            $project['status'],
            $this->getStatusColor($project['status']),
            "white",
            "rounded-full px-4 py-1.5 font-medium"
        ))->render();

        $typeFinaBadge = (new Badge(
            $project['funding_type'],
            "#1e40af",
            "white",
            "rounded-full px-4 py-1.5 font-medium"
        ))->render();

        $hasSupervisor = !empty($project['first_name']) && !empty($project['last_name']);
        
        ob_start();
        if ($hasSupervisor) {
            $this->render_supervisor(
                $project['profile_picture'],
                $project['first_name'],
                $project['last_name'],
                $project['post'],
                $project['grade'],
                $project['speciality'],
                $project['email'],
                $project['role'],
                $project['status_user'],
                $project['bio']
            );
        } else {
            echo '<div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">';
            echo '<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>';
            echo '</svg>';
            echo '<p class="text-[var(--gray)] font-medium">Aucun responsable assigné</p>';
            echo '<p class="text-[var(--gray)] text-sm mt-1">Le projet est en attente d\'un responsable</p>';
            echo '</div>';
        }
        $supervisorHTML = ob_get_clean();

        ob_start(); 
        $this->render_members($members);       
        $membersHTML = ob_get_clean();
        
        ob_start(); 
        $this->render_partners($partners);     
        $partnersHTML = ob_get_clean();
        
        ob_start(); 
        $this->render_publications($publications); 
        $publicationsHTML = ob_get_clean();

        $respoTitle  = $this->createSectionTitle('Responsable du projet', 'user');
        $memberTitle = $this->createSectionTitle('Équipe de Recherche', 'users');
        $partTitle   = $this->createSectionTitle('Partenaires Institutionnels', 'building');
        $pubTitle    = $this->createSectionTitle('Publications Scientifiques', 'document-text');

        $header = [
            "<div class='space-y-6'>",
                "<div class='flex flex-col lg:flex-row justify-between items-start gap-6'>",
                    "<div class='space-y-4 flex-1'>",
                        $title,
                        "<div class='flex flex-wrap items-center gap-4'>",
                            "<div class='inline-flex items-center text-[var(--primary)] font-medium bg-blue-50 px-4 py-2 rounded-lg'>",
                                "<svg class='w-5 h-5 mr-2' fill='currentColor' viewBox='0 0 20 20'>",
                                "<path fill-rule='evenodd' d='M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z' clip-rule='evenodd'/>",
                                "</svg>",
                                "{$project['theme']}",
                            "</div>",
                        "</div>",
                    "</div>",
                    "<div class='flex flex-wrap gap-3'>",
                        $statusBadge,
                        $typeFinaBadge,
                    "</div>",
                "</div>",
            "</div>"
        ];

        $body = [
            "<div class='space-y-12'>",

                "<div class='relative rounded-xl overflow-hidden shadow-lg'>",
                    "<div class='absolute inset-0 bg-gradient-to-r from-blue-900/20 to-gray-900/10 z-10'></div>",
                    "<img src='{$project['image']}'",
                    "class='w-full h-96 object-cover'>",
                "</div>",

                "<div class='grid lg:grid-cols-3 gap-8'>",
                    "<div class='lg:col-span-2 space-y-8'>",
                        "<div class='bg-[var(--white)] p-8 rounded-xl border border-gray-200'>",
                            "<h2 class='text-2xl font-bold text-[var(--gray-dark)] mb-6'>Description du Projet</h2>",
                            "<div class='prose prose-lg max-w-none text-[var(--gray-dark)] leading-relaxed'>",
                                "<p>{$project['description']}</p>",
                            "</div>",
                        "</div>",

                        "<div class='bg-gradient-to-r from-blue-50 to-gray-50 p-8 rounded-xl border border-blue-100'>",
                            $pubTitle,
                            "<div class='mt-6 space-y-6'>",
                                $publicationsHTML,
                            "</div>",
                        "</div>",
                        "<div class='bg-[var(--white)] p-8 col-span-2 rounded-xl border border-gray-200'>",
                    $memberTitle,
                    "<div>",
                        $membersHTML,
                    "</div>",
                "</div>",
                    "</div>",

                    "<div class='space-y-8'>",
                        "<div class='bg-[var(--white)] p-8 rounded-xl border border-gray-200'>",
                            "<div class='flex items-center justify-between mb-6'>",
                                "<div class='w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center'>",
                                    "<svg class='w-6 h-6 text-[var(--primary)]' fill='currentColor' viewBox='0 0 20 20'>",
                                    "<path fill-rule='evenodd' d='M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z' clip-rule='evenodd'/>",
                                    "</svg>",
                                "</div>",
                                "<h3 class='text-xl font-bold text-[var(--gray-dark)]'>Chronologie</h3>",
                            "</div>",
                            "<div class='space-y-4'>",
                                "<div class='flex items-center justify-between py-3 border-b border-gray-100'>",
                                    "<span class='text-[var(--gray)]'>Date de début</span>",
                                    "<span class='font-medium text-[var(--gray-dark)]'>{$project['start_date']}</span>",
                                "</div>",
                                "<div class='flex items-center justify-between py-3 border-b border-gray-100'>",
                                    "<span class='text-[var(--gray)]'>Date de fin</span>",
                                    "<span class='font-medium text-[var(--gray-dark)]'>{$project['end_date']}</span>",
                                "</div>",
                                "<div class='flex items-center justify-between py-3'>",
                                    "<span class='text-[var(--gray)]'>Financement</span>",
                                    "<span class='font-medium text-[var(--primary)]'>{$project['funding_type']}</span>",
                                "</div>",
                            "</div>",
                        "</div>",

                        "<div class='bg-[var(--white)] p-8 rounded-xl border border-gray-200'>",
                            $respoTitle,
                            "<div class='mt-6'>",
                                $supervisorHTML,
                            "</div>",
                        "</div>",
                    "</div>",
                "</div>",


                "<div class='bg-gradient-to-r from-gray-50 to-blue-50 p-8 rounded-xl border border-gray-200'>",
                    $partTitle,
                    "<div class='mt-6'>",
                        $partnersHTML,
                    "</div>",
                "</div>",

            "</div>"
        ];

        $footer = [
            "<div class='flex items-center justify-between pt-8 border-t border-gray-200'>",
                "<a href='index.php?page=projets'",
                "class='inline-flex items-center text-[var(--gray)] hover:text-[var(--gray-dark)] font-medium transition-colors duration-200'>",
                    "<svg class='w-5 h-5 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>",
                    "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 19l-7-7m0 0l7-7m-7 7h18'/>",
                    "</svg>",
                    "Retour aux projets",
                "</a>",
            "</div>"
        ];

        $card = new Card(
            $header,
            $body,
            $footer,
            'p-8 lg:p-12 bg-[var(--white)] rounded-xl shadow-sm max-w-7xl  my-24 mx-12 space-y-8'
        );

        $card->render();
    }

    private function createSectionTitle($text, $icon) {
        $icons = [
            'user' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>',
            'users' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>',
            'building' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/></svg>',
            'document-text' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>',
        ];

        return "
        <div class='flex items-center gap-3 mb-6'>
            <div class='w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center'>
                {$icons[$icon]}
            </div>
            <div>
                <h2 class='text-2xl font-bold text-[var(--gray-dark)]'>{$text}</h2>
                <p class='text-[var(--gray)] mt-1'>Détails et informations complémentaires</p>
            </div>
        </div>";
    }

    private function render_supervisor($picture, $first_name, $last_name, $post, $grade, $speciality, $email, $role, $status, $bio) {
        $userCard = new UserCard(
            $first_name, 
            $last_name, 
            $role, 
            $status, 
            $picture, 
            $email, 
            $speciality,
            $post, 
            $grade, $bio
        );
        echo "<div class='transform transition-all duration-300 hover:shadow-md'>";
        $userCard->render();
        echo "</div>";
    }

    private function render_members($members) {
        if(!empty($members)) {
            echo "<div class='grid lg:grid-cols-2 gap-6'>";
            foreach($members as $member) {
                $header = [
                    "<div class='p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg'>",
                    "<div class='flex items-center gap-3'>",
                    "<div class='w-12 h-12 rounded-full overflow-hidden border-2 border-white shadow-sm'>",
                    "<img src='{$member['profile_picture']}' class='w-full h-full object-cover' alt='{$member['first_name']} {$member['last_name']}'>",
                    "</div>",
                    "<div>",
                    "<h4 class='font-semibold text-[var(--gray-dark)]'>{$member['first_name']} {$member['last_name']}</h4>",
                    "<p class='text-sm text-[var(--gray)]'>{$member['role']}</p>",
                    "</div>",
                    "</div>",
                    "</div>"
                ];

                $body = [
                    "<div class='p-4'>",
                    "<div class='space-y-3'>",
                    "<div class='flex items-center text-sm'>",
                    "<svg class='w-4 h-4 mr-2 text-gray-400' fill='currentColor' viewBox='0 0 20 20'>",
                    "<path d='M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z'/>",
                    "<path d='M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z'/>",
                    "</svg>",
                    "<span class='text-[var(--gray-dark)]'>{$member['email']}</span>",
                    "</div>",
                    "<div class='flex items-center text-sm'>",
                    "<svg class='w-4 h-4 mr-2 text-gray-400' fill='currentColor' viewBox='0 0 20 20'>",
                    "<path fill-rule='evenodd' d='M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z' clip-rule='evenodd'/>",
                    "</svg>",
                    "<span class='text-[var(--gray-dark)]'>Spécialité: {$member['speciality']}</span>",
                    "</div>",
                    "</div>",
                    "</div>"
                ];

                $footer = [
                    "<div class='p-4 border-t border-gray-100 bg-gray-50 rounded-b-lg'>",
                    "<div class='flex justify-between items-center'>",
                    "<span class='text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-800'>{$member['grade']}</span>",
                    "<span class='text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800'>{$member['post']}</span>",
                    "</div>",
                    "</div>"
                ];

                $card = new Card(
                    $header,
                    $body,
                    $footer,
                    'bg-[var(--white)] rounded-lg shadow-sm hover:shadow-md border border-gray-100 transition-all duration-300'
                );
                $card->render();
            }
            echo "</div>";
        } else {
            $header = [
                "<div class='p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg'>",
                "<div class='flex items-center gap-3'>",
                "<div class='w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center'>",
                "<svg class='w-6 h-6 text-gray-400' fill='none' stroke='currentColor' viewBox='0 0 24 24'>",
                "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'/>",
                "</svg>",
                "</div>",
                "<div>",
                "<h4 class='font-semibold text-[var(--gray-dark)]'>Aucun membre supplémentaire</h4>",
                "<p class='text-sm text-[var(--gray)]'>L'équipe est actuellement réduite</p>",
                "</div>",
                "</div>",
                "</div>"
            ];

            $body = [
                "<div class='p-6 text-center'>",
                "<svg class='w-16 h-16 text-gray-300 mx-auto mb-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>",
                "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'/>",
                "</svg>",
                "<p class='text-[var(--gray)] font-medium mb-2'>Équipe en constitution</p>",
                "<p class='text-[var(--gray)] text-sm'>Les membres seront ajoutés au fur et à mesure de leur recrutement</p>",
                "</div>"
            ];

            $footer = [
                "<div class='p-4 border-t border-gray-100 bg-gray-50 rounded-b-lg text-center'>",
                "<p class='text-xs text-[var(--gray)]'>Contactez l'administration pour rejoindre ce projet</p>",
                "</div>"
            ];

            $card = new Card(
                $header,
                $body,
                $footer,
                'bg-[var(--white)] rounded-lg shadow-sm border-2 border-dashed border-gray-200'
            );
            $card->render();
        }
    }

    private function render_partners($partners) {
        if(!empty($partners)) {
            echo "<div class='grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8'>";
            foreach($partners as $partner) {
                echo "<div class='bg-[var(--white)] p-6 rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all duration-300'>";
                echo "<div class='flex flex-col items-center text-center space-y-4'>";
                echo "<div class='w-20 h-20 p-4 bg-gray-50 rounded-full flex items-center justify-center'>";
                echo "<img src='{$partner['logo_path']}' class='max-w-full max-h-full object-contain' alt='{$partner['name']}'>";
                echo "</div>";
                echo "<div>";
                echo "<h4 class='font-medium text-[var(--gray-dark)] mb-1'>{$partner['name']}</h4>";
                if(isset($partner['type'])) {
                    echo "<p class='text-sm text-[var(--gray)]'>{$partner['type']}</p>";
                }
                if(isset($partner['country'])) {
                    echo "<p class='text-xs text-[var(--gray)] mt-2'>{$partner['country']}</p>";
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200'>";
            echo "<svg class='w-16 h-16 text-gray-300 mx-auto mb-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>";
            echo "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'/>";
            echo "</svg>";
            echo "<p class='text-[var(--gray)] font-medium'>Aucun partenaire institutionnel</p>";
            echo "<p class='text-[var(--gray)] text-sm mt-1'>Les partenariats seront annoncés ultérieurement</p>";
            echo "</div>";
        }
    }

    private function render_publications($publications) {
        if(!empty($publications)) {
            echo "<div class='space-y-6'>";
            foreach($publications as $publication) {
                $typeColors = [
                    'Article' => 'bg-blue-100 text-[var(--primary)]',
                    'Conférence' => 'bg-purple-100 text-purple-800',
                    'Thèse' => 'bg-green-100 text-green-800',
                    'Rapport' => 'bg-orange-100 text-orange-800',
                ];
                
                $typeClass = $typeColors[$publication['type']] ?? 'bg-gray-100 text-gray-800';
                
                echo "<div class='bg-[var(--white)] p-6 rounded-lg border border-gray-200 hover:border-blue-200 hover:shadow-sm transition-all duration-300'>";
                echo "<div class='flex flex-col lg:flex-row lg:items-start gap-6'>";
                echo "<div class='lg:w-3/4'>";
                echo "<div class='flex items-start gap-3'>";
                echo "<div class='w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0'>";
                echo "<svg class='w-5 h-5 text-[var(--primary-light)]' fill='currentColor' viewBox='0 0 20 20'>";
                echo "<path fill-rule='evenodd' d='M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z' clip-rule='evenodd'/>";
                echo "</svg>";
                echo "</div>";
                echo "<div>";
                echo "<h4 class='font-bold text-[var(--gray-dark)] text-lg mb-2'>{$publication['title']}</h4>";
                echo "<div class='flex flex-wrap items-center gap-3 mb-3'>";
                echo "<span class='text-sm px-3 py-1 rounded-full {$typeClass}'>{$publication['type']}</span>";
                if(isset($publication['journal'])) {
                    echo "<span class='text-sm text-[var(--gray)]'>{$publication['journal']}</span>";
                }
                echo "</div>";
                if(isset($publication['abstract'])) {
                    echo "<p class='text-[var(--gray)] text-sm leading-relaxed line-clamp-2 mb-4'>{$publication['abstract']}</p>";
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "<div class='lg:w-1/4 lg:border-l lg:pl-6 lg:border-gray-100'>";
                echo "<div class='space-y-3'>";
                echo "<div class='flex items-center text-sm text-[var(--gray)]'>";
                echo "<svg class='w-4 h-4 mr-2' fill='currentColor' viewBox='0 0 20 20'>";
                echo "<path fill-rule='evenodd' d='M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z' clip-rule='evenodd'/>";
                echo "</svg>";
                echo "{$publication['publication_date']}";
                echo "</div>";
                if(isset($publication['doi'])) {
                    echo "<div class='text-sm'>";
                    echo "<span class='text-[var(--gray)]'>DOI: </span>";
                    echo "<span class='font-mono text-[var(--primary)]'>{$publication['doi']}</span>";
                    echo "</div>";
                }
                echo "<div class='pt-4'>";
                echo "<a href='index.php?page=publication&id={$publication['id']}' class='inline-flex items-center text-[var(--primary)] hover:text-[var(--primary-light)] font-medium text-sm'>";
                echo "Accéder à la publication";
                echo "<svg class='w-4 h-4 ml-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'>";
                echo "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M14 5l7 7m0 0l-7 7m7-7H3'/>";
                echo "</svg>";
                echo "</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200'>";
            echo "<svg class='w-16 h-16 text-gray-300 mx-auto mb-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>";
            echo "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'/>";
            echo "</svg>";
            echo "<p class='text-[var(--gray)] font-medium'>Aucune publication disponible</p>";
            echo "<p class='text-[var(--gray)] text-sm mt-1'>Les publications seront ajoutées au fur et à mesure de leur acceptation</p>";
            echo "</div>";
        }
    }

    
  public function show_projects_admin($projects, $allowed, $analytics=null) {
    $activeprojects = array_filter($projects, fn($project) => $project['status'] === 'soumis');
    $nb_pubs = array_map(fn($project) => count($project['publications']), $projects);
    $nb_partners = array_map(fn($project) => count($project['partners']), $projects);
    $stats = [
        ['title' => 'Total projets', 'value' => count($projects), 'color' => 'blue-400'],
        ['title' => 'Projets soumis', 'value' => count($activeprojects), 'color' => 'green-400'],
        ['title' => 'Nombre de publications pour tous les projets', 'value' => array_sum($nb_pubs), 'color' => 'purple-400'],
        ['title' => 'Partenaires des projets', 'value' => array_sum($nb_partners), 'color' => 'yellow-400'],
    ];
    
    echo '<section class="min-h-screen py-24 w-full px-12">';
    echo '<div class="mb-10">';
    echo '<h1 class="text-3xl lg:text-4xl font-bold text-[var(--gray-dark)] mb-2">Gestion des projets</h1>';
    echo '<p class="text-[var(--gray)] text-lg">Consultez et gérez tous les projets du système</p>';

    echo '<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">';
    foreach($stats as $stat){
        $header = [
            "<div class='text-sm text-[var(--gray)] mb-1'>{$stat['title']}</div>"
        ];
        $body = [
            "<div class='text-2xl font-bold text-[var(--gray-dark)]'>{$stat['value']}</div>"
        ];
$card = new Card($header, $body, [], "border-t-4 bg-[var(--white)] border-" . $stat['color'] . " rounded-xl p-4 shadow-sm");        $card->render();
    }
    echo '</div>';

    echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
    
    echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
    echo '<h2 class="text-xl font-bold text-[var(--gray-dark)]">Liste des projets</h2>';
    
    echo "<div class='flex gap-6 ml-auto'>";
    if ($allowed['create']) {
        echo '<a href="index.php?page=create_project" class="px-4 py-2 bg-[var(--primary)] text-[var(--white)] font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">';
        echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
        echo '</svg>';
        echo 'Nouvel projet';
        echo '</a>';
    }
    echo "</div>";
    echo '</div>';
    echo '</div>';
    
    $data = [];
    $projects = array_map(function($p) {
        if (!isset($p['partners'])) $p['partners'] = [];
        if (!isset($p['publications'])) $p['publications'] = [];
        if (!isset($p['members'])) $p['members'] = [];
        return $p;
    }, $projects);
    
    foreach ($projects as $project) {
        $statusColor = $project['status'] === 'soumis' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
        $statusIcon = $project['status'] === 'soumis' ? 
            '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>' :
            '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>';
        
        $statusBadge = '<div class="flex items-center justify-center"><span class="px-3 py-1 rounded-full text-xs font-medium ' . $statusColor . ' flex items-center gap-1">' . $statusIcon . ' ' . ucfirst($project['status']) . '</span></div>';

        $membersList = '';
        if (!empty($project['members'])) {
            $memberCount = count($project['members']);
            $displayedMembers = array_slice($project['members'], 0, 2);
            
            $membersList .= "<div class='space-y-2'>";
            
            foreach($displayedMembers as $member) {
                $membersList .= "
                <div class='flex items-center gap-2 p-2 bg-gray-50 rounded-lg border border-gray-100'>
                    <div class='w-6 h-6 rounded-full overflow-hidden flex-shrink-0'>
                        <img src='{$member['profile_picture']}' class='w-full h-full object-cover' alt='{$member['first_name']}'>
                    </div>
                    <div class='min-w-0'>
                        <p class='text-xs text-[var(--gray)] font-medium truncate' title='{$member['first_name']} {$member['last_name']}'>{$member['first_name']} {$member['last_name']}</p>
                        <p class='text-xs text-[var(--gray)] truncate'>{$member['role']}</p>
                    </div>
                </div>";
            }
            
            if ($memberCount > 2) {
                $remaining = $memberCount - 2;
                $membersList .= "
                <div class='text-center'>
                    <span class='inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-[var(--gray)]'>
                        +{$remaining} autre" . ($remaining > 1 ? 's' : '') . "
                    </span>
                </div>";
            }
            $membersList .= "</div>";
        } else {
            $membersList = "
            <div class='text-center py-3'>
                <p class='text-xs text-[var(--gray)]'>Aucun membre</p>
            </div>";
        }

        $partnersList = '';
        if (!empty($project['partners'])) {
            $partnerCount = count($project['partners']);
            $displayedPartners = array_slice($project['partners'], 0, 2);
           
            $partnersList .= "<div class='space-y-2'>";
            
            foreach($displayedPartners as $partner) {
                $partnersList .= "
                <div class='flex items-center gap-2 p-2 bg-gray-50 rounded-lg border border-gray-100'>
                    <div class='w-6 h-6 rounded bg-gradient-to-r from-blue-100 to-blue-50 flex items-center justify-center flex-shrink-0'>
                        <svg class='w-3 h-3 text-blue-600' fill='currentColor' viewBox='0 0 20 20'>
                            <path fill-rule='evenodd' d='M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z' clip-rule='evenodd'/>
                        </svg>
                    </div>
                    <span class='text-xs text-[var(--gray-dark)] truncate' title='{$partner['name']}'>{$partner['name']}</span>
                </div>";
            }
            
            if ($partnerCount > 2) {
                $remaining = $partnerCount - 2;
                $partnersList .= "
                <div class='text-center'>
                    <span class='inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-[var(--gray)]'>
                        +{$remaining} autre" . ($remaining > 1 ? 's' : '') . "
                    </span>
                </div>";
            }
            $partnersList .= "</div>";
        } else {
            $partnersList = "
            <div class='text-center py-3'>
                <p class='text-xs text-[var(--gray)]'>Aucun partenaire</p>
            </div>";
        }

        $publicationsList = '';
        if (!empty($project['publications'])) {
            $pubCount = count($project['publications']);
            $displayedPublications = array_slice($project['publications'], 0, 2);
            
            $publicationsList .= "<div class='space-y-2'>";

            foreach($displayedPublications as $pub) {
                $pubTitle = strlen($pub['title']) > 40 ? substr($pub['title'], 0, 40) . '...' : $pub['title'];
                $publicationsList .= "
                <div class='p-2 bg-gray-50 rounded-lg border border-gray-100'>
                    <div class='flex items-start gap-2'>
                        <div class='w-6 h-6 rounded bg-gradient-to-r from-purple-100 to-purple-50 flex items-center justify-center flex-shrink-0 mt-0.5'>
                            <svg class='w-3 h-3 text-purple-600' fill='currentColor' viewBox='0 0 20 20'>
                                <path fill-rule='evenodd' d='M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z' clip-rule='evenodd'/>
                            </svg>
                        </div>
                        <div>
                            <p class='text-xs text-[var(--gray)] font-medium leading-tight' title='{$pub['title']}'>{$pubTitle}</p>
                            " . (isset($pub['type']) ? "<span class='text-xs text-[var(--gray)]'>{$pub['type']}</span>" : "") . "
                        </div>
                    </div>
                </div>";
            }
            
            
            $publicationsList .= "</div>";
        } else {
            $publicationsList = "
            <div class='text-center py-3'>
                <p class='text-xs text-[var(--gray)]'>Aucune publication</p>
            </div>";
        }

        $projectInfo = 
        "<div class='flex items-center gap-3'>
            <div class='w-10 h-10 rounded-lg overflow-hidden bg-gradient-to-br from-blue-50 to-gray-50 flex items-center justify-center'>
                <img src='{$project['image']}' class='w-full h-full object-cover'>
            </div>  
            <div>
                <div class='font-semibold text-[var(--gray-dark)]'>{$project['title']}</div>
                <div class='text-[var(--gray)] text-sm flex items-center gap-1'>
                    <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'>
                        <path fill-rule='evenodd' d='M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z' clip-rule='evenodd'/>
                    </svg>
                    " . ($project['theme'] ?? 'Non spécifié') . "
                </div>
            </div>
        </div>";
        
        $data[] = [
            'Projet' => $projectInfo,
            'supervisor' => '<div class="text-center text-sm text-[var(--gray-dark)] font-medium">' . ($project['supervisor']['first_name'] ??''). ' ' . ($project['supervisor']['last_name']??'') . '</div>',
            'Statut' => $statusBadge,
            'Date debut' => '<div class="text-center text-sm text-[var(--gray-dark)] font-medium">' . $project['start_date'] . '</div>',
            'Date_fin' => '<div class="text-center text-sm text-[var(--gray-dark)] font-medium">' . $project['end_date'] . '</div>',
            'Membres' => $membersList,
            'Partenaires' => $partnersList,
            'Publications' => $publicationsList,
            'Actions' => '<div class="relative inline-block text-left">
    <button type="button" class="p-2 text-gray-400 hover:text-[var(--gray)] hover:bg-gray-100 rounded-lg transition-colors action-menu-btn" data-project-id="' . $project['id'] . '">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
        </svg>
    </button>
    ' . ($allowed['update'] ? '
    <div class="absolute right-0 mt-2 w-56 bg-[var(--white)] rounded-lg shadow-lg border border-gray-200 z-10 hidden action-menu" data-project-id="' . $project['id'] . '">
        <div class="py-1">
            
            <a href="index.php?page=update_project&id=' . $project['id'] . '" 
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-[var(--gray-dark)] hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Modifier le projet</span>
                 <a href="index.php?page=add_member&id=' . $project['id'] . '" 
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-[var(--gray-dark)] hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-2.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                </svg>
                <span>Gérer les membres</span>
            </a>
            
            <a href="index.php?page=add_partner&id=' . $project['id'] . '" 
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-[var(--gray-dark)] hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>Gérer les partenaires</span>
            </a>
            </a>' : '') . '

            
            ' . ($allowed['delete'] ? '
            <div class="border-t border-gray-200 my-1"></div>
            <a href="index.php?page=delete_project&id=' . $project['id'] . '"
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span>Supprimer le projet</span>
            </a>' : '') . '
        </div>
    </div>
</div>'
        ];
    }

    $columns = ["Projet","Responsable", "Statut", "Date debut", "Date_fin", "Membres", "Partenaires", "Publications", "Actions"];
    $table = new Table($columns, $data, 'w-full');
    $table->render();
    echo '<div class="mt-6 flex gap-4 justify-between md:justify-end">
        <a href="index.php?page=report" class="px-4 py-2 bg-[var(--primary)] text-[var(--white)] rounded hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">
        Générer un rapport
    </div></a>
    ';
$_SESSION['projects_for_report'] = $projects;
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

    ob_start();
    $lineChart = new LineChart();
    $lineChart->render($analytics['by_year'] ,"", 'rgba(2, 43, 109, 1)', 'rgba(96, 154, 247, 0.2)', 'Nombre de projets par année', 'Annee', 'Nombre de projets');
    $lineChartHTML = ob_get_clean();

    ob_start();
    $barChart = new BarChart();
    $barChart->render("", $analytics['by_supervisor'], 'rgba(3, 204, 93, 1)', 'rgba(110, 250, 166, 0.21)', 'Nombre de projets par superviseur', 'Superviseur', 'Nombre de projets');
    $barChartHTML = ob_get_clean();

$data = array_values($analytics['by_theme']);
$labels = array_keys($analytics['by_theme']); 
$count = count($labels);
$colors = [];

for ($i = 1; $i <= $count; $i++) {
    $hue = intval(($i * 260) / $count+40);
    $colors[] = "hsl($hue, 65%, 65%)";
}


    ob_start();
    $pieChart = new PieChart();
    $pieChart->render($data, $labels, $colors, 'Répartition des projets par thématique');
    $pieChartHTML = ob_get_clean();

    echo '<section class="mt-32 grid grid-cols-1  gap-10">';
        echo '<h1 class="text-3xl lg:text-4xl font-bold text-[var(--gray-dark)] mb-2">Statistiques des projets</h1>';
            $lineChart->display($lineChartHTML, 'Nombre de projets par année', '<svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>');
        echo '<section class="grid grid-cols-1 md:grid-cols-3 items-center gap-10">';
            echo '<div class="md:col-span-2">';
            $barChart->display($barChartHTML, 'Nombre de projets par superviseur', '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>');
            echo "</div>";
            echo "<div class='md:col-span-1'>";
            $pieChart->display($pieChartHTML, 'Répartition des projets par thematique', '<svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                </svg>');
            echo "</div>";
        echo "</section>";
            
        echo '</section>';
    echo '</section>';
}



public function create_update_form($project, $users, $publications, $partners) {
    $link = $project === null ? "index.php?page=createProject" : "index.php?page=updateProject";
    $action = $project === null ? "Ajouter" : "Modifier";

    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-[var(--white)] shadow-lg rounded-lg p-6 max-w-4xl">';

    if ($project) {
        echo "<div class='mb-6 flex flex-col items-center'>
            <img id='profilePreview' src='{$project['image']}' alt='Image du projet'
                 class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
            <label class='text-[var(--gray)] text-sm'>Changer la photo</label>
        </div>";
    }

    $StatusOptions = [
        'soumis' => 'Soumis',
        'en-cours' => 'En cours',
        'termine' => 'Terminé'
    ];
    $users = array_reduce($users, function($acc, $user) {
        $acc[$user['id']] = $user['first_name'] . ' ' . $user['last_name'];
        return $acc;
    }, []);

    $form = new Form($link, 'POST', $action, '', '', true);

    $form->addInput('title', 'Titre', $project['title'] ?? '', 'Titre du projet');
    $form->addInput('description', 'Description', $project['description'] ?? '', 'Description');
    $form->addInput('theme', 'Thème', $project['theme'] ?? '', 'Thème du projet');
    $form->addInput('start_date', 'Date de début', $project['start_date'] ?? '', 'YYYY-MM-DD');
    $form->addInput('end_date', 'Date de fin', $project['end_date'] ?? '', 'YYYY-MM-DD');
    $form->addInput('funding_type', 'Type de financement', $project['funding_type'] ?? '', 'Type de financement');
    $form->addSelect('status', 'Statut', $StatusOptions, $project['status'] ?? '');
    $form->addFile('image', 'Photo de projet');
    $form->addSelect('supervisor', 'Superviseur', $users, $project['supervisor_id'] ?? '');
    if ($project) {
        $form->addHidden('current_image', $project['image']);
        $form->addHidden('project_id', $project['project_id'] ?? '');
    }
    
    $form->render();
    echo '</div>';
    echo '</section>';
}
}
?>