<?php
require_once "components/title.php";
require_once "components/card.php";
require_once "components/button.php";
require_once "components/badge.php";
require_once "components/userCard.php";
require_once "components/table.php";
require_once "components/form.php";

class PublicationView {
    public function show_publications($publications) {
        echo '<section class="py-24 bg-gray-50 min-h-screen">';
        echo '<div class="container mx-auto px-4 max-w-7xl">';
        $title = (new Title("Publications Scientifiques", "text-4xl font-bold text-gray-900 mb-4", "h1"))->render();
        echo '<div class="mb-12">';
        echo $title;
        echo '<p class="text-gray-600 max-w-3xl">Explorez notre catalogue de publications académiques et de recherches scientifiques.</p>';
        echo '</div>';
        if(!empty($publications)) {
            $groupedPubs = [];
            foreach ($publications as $pub) {
                $pubId = $pub['id'];

                if (!isset($groupedPubs[$pubId])) {
                    $groupedPubs[$pubId] = $pub;
                    $groupedPubs[$pubId]['authors'] = [];
                }

                if (!empty($pub['user_id'])) {
                    $groupedPubs[$pubId]['authors'][] = "{$pub['first_name']} {$pub['last_name']}";
                }
            }

            $data = [];
            foreach($groupedPubs as $publication) {
                $typeColors = [
                    'Article' => 'bg-blue-100 text-blue-800',
                    'Conférence' => 'bg-purple-100 text-purple-800',
                    'Thèse' => 'bg-green-100 text-green-800',
                    'Rapport' => 'bg-orange-100 text-orange-800',
                ];
                
                $typeClass = $typeColors[$publication['type']] ?? 'bg-gray-100 text-gray-800';
                $typeBadge = "<span class='inline-flex px-3 py-1 text-xs font-medium rounded-full {$typeClass}'>{$publication['type']}</span>";
                
                $authors = !empty($publication['authors']) ? 
                    implode(', ', $publication['authors']) : 
                    "<span class='text-gray-400 text-sm'>Auteurs non spécifiés</span>";

                $year = date('Y', strtotime($publication['publication_date']));
                
                $downloadButton = (new Button(
                    '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Télécharger',
                    $publication['file_path'],
                    'inline-flex items-center text-white bg-[var(--primary)] hover:bg-[var(--primary-light)] px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200',
                    true
                ))->render();

                $downloadButton = "<a download href='{$publication['file_path']}' target='_blank'>" . (new Button(
                    '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Télécharger',
                    $publication['file_path'],
                    'inline-flex items-center text-white bg-[var(--primary)] hover:bg-[var(--primary-light)] px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200',
                    true
                ))->render();
                
                $detailsButton = '<a href="index.php?page=publication&id=' . $publication['id'] . '" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5 border border-blue-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </a>';
                
                $data[] = [
                    'Titre' => "
                        {$publication['title']}
                        {$typeBadge}
                    ",
                    'Domaine' => "<div class='font-medium text-gray-700'>{$publication['domain']}</div>",
                    'Auteurs' => $authors,
                    'Date' => "<div class='text-center'>
                        <div class='font-medium text-gray-900'>{$year}</div>
                        <div class='text-xs text-gray-500'>" . date('d M', strtotime($publication['publication_date'])) . "</div>
                    </div>",
                    'DOI' => $publication['doi'] ? 
                        "<span class='font-mono text-sm text-[var(--primary)] bg-blue-50 px-2 py-1 rounded'>" . substr($publication['doi'], 0, 20) . "...</span>" : 
                        "<span class='text-gray-400 text-sm'>Non disponible</span>",
                    'Actions' => "<div class='flex gap-2'>
                        {$detailsButton}
                        {$downloadButton}
                    </div>"
                ];
            }

            $columns = ["Titre", "Domaine", "Auteurs", "Date", "DOI", "Actions"];
            $table = new Table($columns, $data, 'w-full bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden');
            $table->render();
            
            echo '<div class="mt-8 flex items-center justify-between">';
            echo '<div class="text-sm text-gray-600">';
            echo 'Affichage de <span class="font-semibold">1-' . count($groupedPubs) . '</span> sur <span class="font-semibold">' . count($groupedPubs) . '</span> publications';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="text-center py-16 bg-white rounded-xl border-2 border-dashed border-gray-300">';
            echo '<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>';
            echo '<h3 class="text-xl font-bold text-gray-600 mb-2">Aucune publication disponible</h3>';
            echo '<p class="text-gray-500 max-w-md mx-auto">Les publications seront ajoutées au fur et à mesure de leur acceptation.</p>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</section>';
    }

    public function show_publication($publication, $authors) {
        echo '<section class="py-24 bg-gray-50 min-h-screen">';
        echo '<div class="container mx-auto px-4 max-w-7xl">';        
        $typeColors = [
            'Article' => 'bg-blue-100 text-blue-800',
            'Conférence' => 'bg-purple-100 text-purple-800',
            'Thèse' => 'bg-green-100 text-green-800',
            'Rapport' => 'bg-orange-100 text-orange-800',
        ];
        
        $typeClass = $typeColors[$publication['type']] ?? 'bg-gray-100 text-gray-800';
        $typeBadge = "<span class='inline-flex px-4 py-2 text-sm font-medium rounded-full {$typeClass}'>{$publication['type']}</span>";
        
        $date = date('d M Y', strtotime($publication['publication_date']));
        
        $title = (new Title(
            $publication['title'],
            'text-3xl lg:text-4xl font-bold text-gray-900 leading-tight mb-6',
            'h1'
        ))->render();
        
        
        
        $authorsTitle = (new Title(
            "Auteurs",
            'text-2xl font-bold text-gray-900 mb-6',
            'h2'
        ))->render();
        
        ob_start();
        $this->render_authors($authors);
        $authorsHTML = ob_get_clean();
        
        $header = [
            "<div class='flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8'>",
                "<div class='space-y-4 flex-1'>",
                    "<div class='flex flex-wrap items-center gap-4'>",
                        $typeBadge,
                        "<span class='inline-flex items-center text-gray-600'>",
                            "<svg class='w-5 h-5 mr-2' fill='currentColor' viewBox='0 0 20 20'>",
                            "<path fill-rule='evenodd' d='M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z' clip-rule='evenodd'/>",
                            "</svg>",
                            "Publié le {$date}",
                        "</span>",
                    "</div>",
                    $title,
                "</div>",
            "</div>"
        ];
        
        $body = [
            "<div class='space-y-8'>",
                "<div class='grid gap-8'>",
                    "<div class='lg:col-span-2 space-y-8'>",
                        "<div class='bg-white p-8 rounded-xl border border-gray-200'>",
                            "<h3 class='text-xl font-bold text-gray-900 mb-4'>Résumé</h3>",
                            "<div class='prose prose-lg max-w-none text-gray-700 leading-relaxed'>",
                                "<p>{$publication['abstract']}</p>",
                            "</div>",
                        "</div>",
                        
                        "<div class='bg-white p-8 rounded-xl border border-gray-200'>",
                            "<h3 class='text-xl font-bold text-gray-900 mb-6'>Métadonnées</h3>",
                            "<div class='grid md:grid-cols-2 gap-6'>",
                                "<div class='space-y-4'>",
                                    "<div>",
                                        "<h4 class='text-sm font-medium text-gray-500 mb-1'>Domaine</h4>",
                                        "<p class='font-medium text-gray-900'>{$publication['domain']}</p>",
                                    "</div>",
                                    "<div>",
                                        "<h4 class='text-sm font-medium text-gray-500 mb-1'>Journal/Conférence</h4>",
                                        "<p class='font-medium text-gray-900'>" . ($publication['type'] ?? 'Non spécifié') . "</p>",
                                    "</div>",
                                "</div>",
                                "<div class='space-y-4'>",
                                    "<div>",
                                        "<h4 class='text-sm font-medium text-gray-500 mb-1'>DOI</h4>",
                                        "<p class='font-mono text-[var(--primary)] bg-blue-50 px-3 py-2 rounded'>",
                                        $publication['doi'] ? $publication['doi'] : '<span class="text-gray-400">Non disponible</span>',
                                        "</p>",
                                    "</div>",
                
                                "</div>",
                            "</div>",
                        "</div>",
                        "<div class='bg-white p-8 rounded-xl border border-gray-200'>",
                            "<div class='flex items-center justify-between mb-8'>",
                                $authorsTitle,
                                "<div class='text-sm text-gray-500'>" . count($authors) . " auteurs</div>",
                            "</div>",
                            "<div class='grid md:grid-cols-2 lg:grid-cols-2 gap-6'>",
                                $authorsHTML,
                            "</div>",
                        "</div>",
                    "</div>",
                    
                
                
            "</div>"
        ];
         $previous = $_SERVER['HTTP_REFERER'];
        $footer = [
                "<a href='$previous' class='inline-flex items-center mt-4 text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200'>",
                    "<svg class='w-5 h-5 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 19l-7-7m0 0l7-7m-7 7h18'/></svg>",
                    "Retour aux publications",
                "</a>",
        ];
        
        $card = new Card(
            $header,
            $body,
            $footer,
            'bg-white rounded-xl shadow-sm border border-gray-200 p-8 space-y-8'
        );
        
        $card->render();
        
        echo '</div>';
        echo '</section>';
    }

    private function render_authors($members) {
        if(!empty($members)) {
            foreach($members as $member) {
                echo '<div class="transform transition-all duration-300 hover:-translate-y-1 hover:shadow-md">';
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
                echo '</div>';
            }
        } else {
            echo '<div class="col-span-full text-center py-12 border-2 border-dashed border-gray-200 rounded-xl">';
            echo '<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
            echo '<p class="text-gray-600 font-medium">Aucun auteur associé</p>';
            echo '<p class="text-gray-500 text-sm mt-1">Les informations sur les auteurs seront ajoutées prochainement</p>';
            echo '</div>';
        }
    }
    public function show_pubs_admin($publications, $allowed){
    $pubs = [];
            foreach ($publications as $pub) {
                $pubId = $pub['id'];

                if (!isset($pubs[$pubId])) {
                    $pubs[$pubId] = $pub;
                    $pubs[$pubId]['authors'] = [];
                }

                if (!empty($pub['user_id'])) {
                    $pubs[$pubId]['authors'][] = "{$pub['first_name']} {$pub['last_name']}";
                }
            }

    $validePubs = array_filter($pubs, fn($pub) => $pub['status'] === 'valide');
    $rejectPubs = array_filter($pubs, fn($pub) => $pub['status'] === 'rejete');
    $nonvalider = count($pubs) - (count($validePubs)+ count($rejectPubs));
    $stats = [
        ['title' => 'Total publications', 'value' => count($pubs), 'color' => 'blue-400'],
        ['title' => 'Publications validees', 'value' => count($validePubs), 'color' => 'green-400'],
        ['title' => 'Publications rejetees', 'value' => count($rejectPubs), 'color' => 'red-400'],
        ['title' => 'Publications non validees', 'value' => $nonvalider, 'color' => 'purple-400'],
    ];
    
    echo '<section class="min-h-screen py-24 w-full px-12">';
    echo '<div class="mb-10">';
    echo '<h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Gestion des publications</h1>';
    echo '<p class="text-gray-600 text-lg">Consultez et gérez tous les publications du système</p>';

    echo '<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">';
    foreach($stats as $stat){
        $header = [
            "<div class='text-sm text-gray-500 mb-1'>{$stat['title']}</div>"
        ];
        $body = [
            "<div class='text-2xl font-bold text-gray-900'>{$stat['value']}</div>"
        ];
        $card = new Card($header, $body, [], "border-t-4 bg-white border-" . $stat['color'] . " rounded-xl p-4 shadow-sm");
        $card->render();
    }
    echo '</div>';

    echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
    
    echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
    echo '<h2 class="text-xl font-bold text-gray-900">Liste des projets</h2>';
    $role = $_SESSION['user'][0]['role'];
    $isAdmin = ($role === 'admin');
    $isAuthor = in_array($role, ['enseignant', 'doctorant']);
    $canUpdate = $allowed['update'] ?? false;
    echo "<div class='flex gap-6 ml-auto'>";
    if ($allowed['create'] && $isAuthor) {
        echo '<a href="index.php?page=create_pub" class="px-4 py-2 bg-[var(--primary)] text-white font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2 shadow-sm hover:shadow">';
        echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
        echo '</svg>';
        echo 'Nouvelle publication';
        echo '</a>';
    }
    echo "</div>";
    echo '</div>';
    echo '</div>';
     $_SESSION['pubs_for_report'] = $pubs;
    $data = [];
    foreach ($pubs as $pub) {
        $statusColor = $pub['status'] === 'valide' ? 'bg-green-100 text-green-800' : ($pub['status'] === 'rejete' ? 'bg-red-100 text-red-800':'bg-gray-100 text-gray-800');
        $statusIcon = $pub['status'] === 'valide' ? 
            '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>' :
            '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>';
        
        $statusBadge = '<div class="flex items-center justify-center"><span class="px-3 py-1 rounded-full text-xs font-medium ' . $statusColor . ' flex items-center gap-1">' . $statusIcon . ' ' . ucfirst($pub['status']) . '</span></div>';


        $pubInfo = 
        "<div class='grid justify-center items-center gap-3'> 
                <div class='font-semibold text-gray-900'>{$pub['title']}</div>
                <div class='text-gray-500 text-sm flex items-center gap-1'>
                    <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'>
                        <path fill-rule='evenodd' d='M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z' clip-rule='evenodd'/>
                    </svg>
                    " . ($pub['domain'] ?? 'Non spécifié') . "
                </div>
        </div>";
                $actions = '
                <a href="index.php?page=publication&id=' . $pub['id'] . '" class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </a>';
            if ($isAdmin) {
                if($pub['status'] ==='non-valide'){
                    $actions .= '
                <a href="index.php?page=validate_pub&id=' . $pub['id'] . '" class="px-3 py-1.5 bg-green-600 text-white hover:bg-green-700 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5 shadow-sm hover:shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </a>
                <a href="index.php?page=reject_pub&id=' . $pub['id'] . '" class="px-3 py-1.5 bg-red-600 text-white hover:bg-red-700 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5 shadow-sm hover:shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
                ';
                }
            }

            if ($isAuthor) {
                $actions .= '
                <a href="index.php?page=update_pub&id=' . $pub['id'] . '" class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
                <a href="index.php?page=manage_authors&id=' . $pub['id'] . '" class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1.907a3 3 0 01-4.243-4.243"/>
                    </svg>
                </a>';
            }
         $authors = !empty($pub['authors']) ? 
                    implode(', ', $pub['authors']) : 
                    "<span class='text-gray-400 text-sm'>Auteurs non spécifiés</span>";

        $data[] = [
            'Publication' => $pubInfo,
            'Date de publication' => '<div class="text-center text-sm text-gray-700 font-medium">' . $pub['publication_date'] . '</div>',
            'Auteurs' => $authors,
            'DOI' => $pub['doi'],
            'Lien de l\'article' => "<a href='{$pub['file_path']}' class='text-[var(--primary)] font-medium'>Voir l'article</a>",
            'Statut' => $statusBadge,
            'Actions' => '<div class="flex gap-2 items-center">'.$actions.'
                        </div>'
        ];
    }

    $columns = ["Publication", "Date de publication", "Auteurs", "DOI", "Lien de l'article", "Status", "Actions"];
    $table = new Table($columns, $data, 'w-full');
    $table->render();
    if($isAdmin){
        echo '<div class="mt-6 flex gap-4 justify-between md:justify-end">
        <a href="index.php?page=report_pubs" class="px-4 py-2 bg-[var(--primary)] text-white rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2 shadow-sm hover:shadow font-medium" target="_blank">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Générer un rapport
        </a>
    </div>'; 
    }
    echo '</div>';
    echo '</section>';
}



public function create_update_form($pub, $projects) {
    $link = $pub === null ? "index.php?page=createPub" : "index.php?page=updatePub";
    $action = $pub === null ? "Ajouter" : "Modifier";

    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 max-w-4xl">';

    $projects = array_reduce($projects, function($acc, $project) {
        $acc[$project['id']] = $project['title'];
        return $acc;
    }, []);

    $form = new Form($link, 'POST', $action, '', '', true);

    $form->addInput('title', 'Titre', $pub['title'] ?? '', 'Titre du publication');
    $form->addInput('doi', 'Identifiant du publication(DOI)', $pub['doi'] ?? '', '');
    $form->addTextarea('abstract', 'Resume', $pub['abstract'] ?? '', 'Resume');
    $form->addTextarea('file_path', 'Le lien de publication', $pub['file_path'] ?? '', '');
    $form->addInput('publication_date', 'Date de la publication', $pub['publication_date'] ?? '', '', 'date');
    $form->addInput('type', 'Type', $pub['type'] ?? '', 'Ex: article, journal...');
    $form->addInput('domain', 'Domaine', $pub['domain'] ?? '', 'Ex: AI, Quantum computing');
    $form->addSelect('project', 'Project', $projects, $pub['project_id'] ?? '');
    if ($pub) {
        $form->addHidden('pub_id', $pub['id'] ?? '');
    }    
    $form->render();
    echo '</div>';
    echo '</section>';
}



public function show_authors($pub_authors, $users){
        $pub_id = $_GET['id'];
        echo '<section class="min-h-screen py-24 px-12 md:px-8 lg:px-12">';
        echo '<div class="max-w-6xl mx-auto">';
        echo '<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">';
        
    
        echo '<div class="lg:col-span-2">';
        echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">';
        
        echo '<div class="px-6 py-4 border-b border-gray-200">';
        echo '<h2 class="text-xl font-bold text-gray-900">Les auteurs de la publication</h2>';
        echo '<p class="text-gray-600 text-sm mt-1">' . count($pub_authors) . ' auteurs disponibles</p>';
        echo '</div>';
        $data = [];
        foreach($pub_authors as $author) { 
            $data[] = [
                'Nom de l\'auteur' => '<div class="font-medium text-gray-900 flex justify-center gap-2">' .'<img src="' . htmlspecialchars($author['profile_picture']) . '" alt="Logo du partenaire" class="ml-2 rounded-lg w-8 h-8 inline-block">'. htmlspecialchars($author['first_name']) ." " . htmlspecialchars($author['last_name']) . '</div>',
                'Actions' => '<div class="flex items-center gap-2 justify-end">
                <a href="index.php?page=delete_author&id_pub=' . $pub_id . '&id_author=' . $author['id'] . '" 
                             class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16"/>
                             </svg>
                           </a>'
                . '</div>'
            ];
        }
        
        if(empty($data)) {
            $data[] = [
                'Auteur' => '<div class="text-center py-8 text-gray-500">Aucun membre disponible</div>',
                'Actions' => ''
            ];
        }
        
        $columns = ["Membre", "Actions"];
        $table = new Table($columns, $data, 'w-full');
        $table->render();

        echo '</div>'; 
        $previous = $_SERVER['HTTP_REFERER'];
        echo "<a href='$previous'
                class='inline-flex items-center text-[var(--primary)] hover:text-blue-800 mt-4 font-medium hover:underline'>
                <svg class='w-4 h-4 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 19l-7-7m0 0l7-7m-7 7h18'/>
                </svg>
                Revenir à la page
              </a>";

        echo '</div>'; 

        echo '<div class="col-span-2">';
        echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">';
        echo '<h2 class="text-xl font-bold text-gray-900 mb-6">Ajouter un membre</h2>';
        
        $form = new Form(
            'index.php?page=manage_authors&id=' . $pub_id, 
            'POST', 
            'Ajouter l\'auteur',
            '', 
            'Remplissez le formulaire ci-dessous pour ajouter un auteur'
        );

        $authors = array_reduce($users, function($acc, $user) {
                $acc[$user['id']] = $user['first_name'].' '.$user['last_name'];
                return $acc;
        }, []);

        $form->addSelect(
            'user_id',
            'Sélectionner un auteur',
            $authors,
            '',
        );
        $form->render();
        echo '</div>';
        echo '</div>'; 
        
        echo '</div>'; 
        echo '</div>';
        echo '</section>';
    }
}
?>