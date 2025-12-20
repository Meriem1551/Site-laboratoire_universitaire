<?php
require_once "components/card.php";
require_once "components/badge.php";
require_once "components/title.php";
require_once "components/userCard.php";

class ProjectView {
    public function show_projects($projects) {
        echo '<section class="py-16 my-10 bg-gray-50">';
        echo '<div class="container mx-auto px-4 max-w-7xl">';
        
        echo '<div class="mb-12">';
        echo '<h1 class="text-3xl font-bold text-gray-900 mb-4">Projets de Recherche</h1>';
        echo '<p class="text-gray-600 max-w-3xl">Explorez nos initiatives de recherche innovantes menées par nos équipes scientifiques et leurs partenaires.</p>';
        echo '</div>';
        
        echo '<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8">';
        
        foreach($projects as $project) {
            $statusBadge = (new Badge(
                $project['status'],
                $this->getStatusColor($project['status']),
                "white",
                "rounded-full px-3 py-1 text-xs font-medium"
            ))->render();

            $title = (new Title(
                $project['title'], 
                'font-semibold text-xl text-gray-900 leading-tight mb-2', 
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
                "<p class='text-gray-600 text-sm leading-relaxed line-clamp-3 mb-4'>{$project['description']}</p>",
                "</div>"
            ];
            
            $footer = [
                "<div class='px-6 py-4 border-t border-gray-100 bg-gray-50 rounded-b-lg'>",
                "<div class='flex justify-between items-center text-sm'>",
                "<span class='text-gray-500'>Durée</span>",
                "<span class='font-medium text-gray-900'>",
                "{$project['start_date']} – {$project['end_date']}",
                "</span>",
                "</div>",
                "</div>"
            ];

            echo "<a href='index.php?page=projet&id={$project['id']}' class='group block transition-all duration-300 hover:-translate-y-2'>";
            $card = new Card(
                $header,
                $body,
                $footer,
                'bg-white rounded-lg shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300'
            );
            $card->render();
            echo "</a>";
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
    }

    private function getStatusColor($status) {
        $colors = [
            'Actif' => '#10b981',
            'termine' => '#6b7280', 
            'en-cours' => '#3b82f6',
            'Planifié' => '#8b5cf6',
            'Suspendu' => '#f59e0b',
        ];
        return $colors[$status] ?? '#6b7280';
    }

    public function show_project($project, $members = "", $partners = "", $publications = "") {
        $title = (new Title(
            $project['title'],
            'font-bold text-3xl lg:text-4xl text-gray-900 leading-tight',
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

        ob_start();
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
        $supervisorHTML = ob_get_clean();

        ob_start(); $this->render_members($members);       $membersHTML = ob_get_clean();
        ob_start(); $this->render_partners($partners);     $partnersHTML = ob_get_clean();
        ob_start(); $this->render_publications($publications); $publicationsHTML = ob_get_clean();

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
                        "<div class='bg-white p-8 rounded-xl border border-gray-200'>",
                            "<h2 class='text-2xl font-bold text-gray-900 mb-6'>Description du Projet</h2>",
                            "<div class='prose prose-lg max-w-none text-gray-700 leading-relaxed'>",
                                "<p>{$project['description']}</p>",
                            "</div>",
                        "</div>",

                        "<div class='bg-gradient-to-r from-blue-50 to-gray-50 p-8 rounded-xl border border-blue-100'>",
                            $pubTitle,
                            "<div class='mt-6 space-y-6'>",
                                $publicationsHTML,
                            "</div>",
                        "</div>",
                        "<div class='bg-white p-8 col-span-2 rounded-xl border border-gray-200'>",
                    $memberTitle,
                    "<div>",
                        $membersHTML,
                    "</div>",
                "</div>",
                    "</div>",

                    "<div class='space-y-8'>",
                        "<div class='bg-white p-8 rounded-xl border border-gray-200'>",
                            "<div class='flex items-center justify-between mb-6'>",
                                "<div class='w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center'>",
                                    "<svg class='w-6 h-6 text-[var(--primary)]' fill='currentColor' viewBox='0 0 20 20'>",
                                    "<path fill-rule='evenodd' d='M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z' clip-rule='evenodd'/>",
                                    "</svg>",
                                "</div>",
                                "<h3 class='text-xl font-bold text-gray-900'>Chronologie</h3>",
                            "</div>",
                            "<div class='space-y-4'>",
                                "<div class='flex items-center justify-between py-3 border-b border-gray-100'>",
                                    "<span class='text-gray-600'>Date de début</span>",
                                    "<span class='font-medium text-gray-900'>{$project['start_date']}</span>",
                                "</div>",
                                "<div class='flex items-center justify-between py-3 border-b border-gray-100'>",
                                    "<span class='text-gray-600'>Date de fin</span>",
                                    "<span class='font-medium text-gray-900'>{$project['end_date']}</span>",
                                "</div>",
                                "<div class='flex items-center justify-between py-3'>",
                                    "<span class='text-gray-600'>Financement</span>",
                                    "<span class='font-medium text-[var(--primary)]'>{$project['funding_type']}</span>",
                                "</div>",
                            "</div>",
                        "</div>",

                        "<div class='bg-white p-8 rounded-xl border border-gray-200'>",
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
                "class='inline-flex items-center text-gray-600 hover:text-gray-900 font-medium transition-colors duration-200'>",
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
            'p-8 lg:p-12 bg-white rounded-xl shadow-sm max-w-7xl  my-24 mx-12 space-y-8'
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
                <h2 class='text-2xl font-bold text-gray-900'>{$text}</h2>
                <p class='text-gray-600 mt-1'>Détails et informations complémentaires</p>
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
            echo "<div class='grid lg:grid-cols-2  gap-6'>";
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

    private function render_partners($partners) {
        if(!empty($partners)) {
            echo "<div class='grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8'>";
            foreach($partners as $partner) {
                echo "<div class='bg-white p-6 rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all duration-300'>";
                echo "<div class='flex flex-col items-center text-center space-y-4'>";
                echo "<div class='w-20 h-20 p-4 bg-gray-50 rounded-full flex items-center justify-center'>";
                echo "<img src='{$partner['logo_path']}' class='max-w-full max-h-full object-contain' alt='{$partner['name']}'>";
                echo "</div>";
                echo "<div>";
                echo "<h4 class='font-medium text-gray-900 mb-1'>{$partner['name']}</h4>";
                if(isset($partner['type'])) {
                    echo "<p class='text-sm text-gray-500'>{$partner['type']}</p>";
                }
                if(isset($partner['country'])) {
                    echo "<p class='text-xs text-gray-400 mt-2'>{$partner['country']}</p>";
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
            echo "<p class='text-gray-600 font-medium'>Aucun partenaire institutionnel</p>";
            echo "<p class='text-gray-500 text-sm mt-1'>Les partenariats seront annoncés ultérieurement</p>";
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
                
                echo "<div class='bg-white p-6 rounded-lg border border-gray-200 hover:border-blue-200 hover:shadow-sm transition-all duration-300'>";
                echo "<div class='flex flex-col lg:flex-row lg:items-start gap-6'>";
                echo "<div class='lg:w-3/4'>";
                echo "<div class='flex items-start gap-3'>";
                echo "<div class='w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0'>";
                echo "<svg class='w-5 h-5 text-[var(--primary-light)]' fill='currentColor' viewBox='0 0 20 20'>";
                echo "<path fill-rule='evenodd' d='M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z' clip-rule='evenodd'/>";
                echo "</svg>";
                echo "</div>";
                echo "<div>";
                echo "<h4 class='font-bold text-gray-900 text-lg mb-2'>{$publication['title']}</h4>";
                echo "<div class='flex flex-wrap items-center gap-3 mb-3'>";
                echo "<span class='text-sm px-3 py-1 rounded-full {$typeClass}'>{$publication['type']}</span>";
                if(isset($publication['journal'])) {
                    echo "<span class='text-sm text-gray-600'>{$publication['journal']}</span>";
                }
                echo "</div>";
                if(isset($publication['abstract'])) {
                    echo "<p class='text-gray-600 text-sm leading-relaxed line-clamp-2 mb-4'>{$publication['abstract']}</p>";
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "<div class='lg:w-1/4 lg:border-l lg:pl-6 lg:border-gray-100'>";
                echo "<div class='space-y-3'>";
                echo "<div class='flex items-center text-sm text-gray-600'>";
                echo "<svg class='w-4 h-4 mr-2' fill='currentColor' viewBox='0 0 20 20'>";
                echo "<path fill-rule='evenodd' d='M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z' clip-rule='evenodd'/>";
                echo "</svg>";
                echo "{$publication['publication_date']}";
                echo "</div>";
                if(isset($publication['doi'])) {
                    echo "<div class='text-sm'>";
                    echo "<span class='text-gray-500'>DOI: </span>";
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
            echo "<p class='text-gray-600 font-medium'>Aucune publication disponible</p>";
            echo "<p class='text-gray-500 text-sm mt-1'>Les publications seront ajoutées au fur et à mesure de leur acceptation</p>";
            echo "</div>";
        }
    }
}
?>