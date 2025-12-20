<?php
require_once "components/title.php";
require_once "components/card.php";
require_once "components/button.php";
require_once "components/badge.php";
require_once "components/userCard.php";
require_once "components/table.php";

class PublicationView {
    public function show_publications($publications) {
        echo '<section class="py-24 bg-gray-50 min-h-screen">';
        echo '<div class="container mx-auto px-4 max-w-7xl">';
        $title = (new Title("Publications Scientifiques", "text-4xl font-bold text-gray-900 mb-4", "h1"))->render();
        echo '<div class="mb-12">';
        echo $title;
        echo '<p class="text-gray-600 max-w-3xl">Explorez notre catalogue de publications académiques et de recherches scientifiques.</p>';
        echo '</div>';
        
        // echo '<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">';
        // echo '<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">';
        // echo '<div class="flex-1">';
        // echo '<div class="relative">';
        // echo '<input type="text" placeholder="Rechercher des publications..." class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">';
        // echo '<svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>';
        // echo '</div>';
        // echo '</div>';
        // echo '<div class="flex gap-3">';
        // echo '<select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">';
        // echo '<option>Tous les domaines</option>';
        // echo '<option>Informatique</option>';
        // echo '<option>Biologie</option>';
        // echo '<option>Ingénierie</option>';
        // echo '</select>';
        // echo '<select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">';
        // echo '<option>Toutes les années</option>';
        // echo '<option>2024</option>';
        // echo '<option>2023</option>';
        // echo '<option>2022</option>';
        // echo '</select>';
        // echo '</div>';
        // echo '</div>';
        // echo '</div>';
        
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
                
                $detailsButton = "<a href='index.php?page=publication&id={$publication['id']}' class='inline-flex items-center text-[var(--primary)] hover:text-blue-800 font-medium text-sm'>
                    <span>Détails</span>
                    <svg class='w-4 h-4 ml-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M14 5l7 7m0 0l-7 7m7-7H3'/></svg>
                </a>";
                
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
            // echo '<div class="flex gap-2">';
            // echo '<button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">Précédent</button>';
            // echo '<button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">Suivant</button>';
            // echo '</div>';
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
        
        $downloadButton = (new Button(
            '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Télécharger le PDF',
            $publication['file_path'],
            'inline-flex items-center bg-[var(--primary)] hover:bg-[var(--primary-light)] text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200',
            true
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
                "<div class='flex flex-col gap-3'>",
                    "<a download href='{$publication['file_path']}' class='inline-flex items-center justify-center gap-2'>",
                    $downloadButton,
                    "</a>",
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
        
        $footer = [
                "<a href='index.php?page=publications' class='inline-flex items-center mt-4 text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200'>",
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
}
?>