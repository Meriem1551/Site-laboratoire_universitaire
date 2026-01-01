<?php
require_once "components/title.php";
require_once "components/badge.php";
require_once "components/card.php";
require_once "components/pagination.php";
require_once "components/table.php";
require_once "components/form.php";

class EventView{
    function show_events($eventsData){
    $events = $eventsData['events'];
    $total = $eventsData['total'];
    $currentPage = $eventsData['currentPage'];

    echo '<section id="events" class="p-6">';
    echo '<div class="container mx-auto px-4 max-w-7xl">';
    echo '<div class="text-center mb-12">';
    echo '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">Événements</span>';
    $title = (new Title("Événements à Venir", "text-4xl font-bold text-gray-900 mb-4", 'h2'))->render();
    echo $title;
    echo '<p class="text-gray-600 max-w-2xl mx-auto">Participez à nos conférences, ateliers et séminaires pour découvrir les dernières avancées de la recherche.</p>';
    echo '</div>';
    
    if(!empty($events)) {
        echo '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">';
        
        foreach($events as $event) {
            $isOpen = (bool)$event['registerOpen'];
            $eventDate = date('d M Y', strtotime($event['event_date']));
            
            $typeBadge = (new Badge(
                $event['type'],
                'var(--primary-light)',
                'white',
                'rounded-full px-3 py-1 text-xs font-medium absolute top-4 right-4'
            ))->render();
            
            $dateInfo = "<div class='flex items-center gap-3 mb-4'>
                <div class='w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0'>
                    <svg class='w-5 h-5 text-[var(--primary)]' fill='currentColor' viewBox='0 0 20 20'>
                        <path fill-rule='evenodd' d='M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z' clip-rule='evenodd'/>
                    </svg>
                </div>
                <div>
                    <div class='font-medium text-gray-900'>{$eventDate}</div>
                </div>
            </div>";
            
            $cardTitle = (new Title(
                $event['title'],
                'text-xl font-bold text-gray-900 mb-3 leading-tight',
                'h3'
            ))->render();
            
            if($isOpen) {
                $buttonHTML = "<a href='{$event['register_link']}' class='inline-flex items-center gap-2 bg-[var(--primary)] text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-[var(--primary-light)] transition-colors duration-300 text-sm'>
                    <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'>
                        <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z' clip-rule='evenodd'/>
                    </svg>
                    S'inscrire
                </a>";
            } else {
                $buttonHTML = "<span class='inline-flex items-center gap-2 bg-gray-100 text-gray-500 font-medium px-5 py-2.5 rounded-lg text-sm cursor-not-allowed'>
                    <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'>
                        <path fill-rule='evenodd' d='M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z' clip-rule='evenodd'/>
                    </svg>
                    Inscriptions closes
                </span>";
            }
            
            $header = [
                "<div class='relative h-48 overflow-hidden'>
                    <img src='{$event['image_path']}' class='w-full h-full object-cover transition-transform duration-700 hover:scale-110' alt='{$event['title']}'/>
                    {$typeBadge}
                </div>"
            ];

            $body = [
                "<div class='p-6'>
                    {$dateInfo}
                    {$cardTitle}
                    <p class='text-gray-600 leading-relaxed mb-4 line-clamp-3'>{$event['description']}</p>
                </div>"
            ];
            
            $footer = [
                "<div class='px-6 pb-6 pt-0'>
                        {$buttonHTML}
                </div>"
            ];

            $card = new Card(
                $header,
                $body,
                $footer,
                'bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2'
            );

            $card->render();
        }
        
        echo '</div>';
        
            echo '<div class="flex justify-center mt-8">';
            $pagination = new Pagination($currentPage, $total, 'index.php?page=evenments');
            $pagination->render();
            echo '</div>';
    } else {
        echo '<div class="text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-300">';
        echo '<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
        echo '<h3 class="text-xl font-bold text-gray-600 mb-2">Aucun événement à venir</h3>';
        echo '<p class="text-gray-500 max-w-md mx-auto">Les prochains événements seront annoncés prochainement. Restez à l\'écoute !</p>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</section>';
    }
    public function show_events_admin($events, $allowed){
        echo '<section class="min-h-screen py-24 w-full px-12">';
            echo '<div class="mb-10">';
                echo '<h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Gestion des evenements</h1>';
                echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
        
                    echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
                        echo '<h2 class="text-xl font-bold text-gray-900">Liste des evenements</h2>';
                        
                        echo "<div class='flex gap-6 ml-auto'>";
                            if ($allowed['create']) {
                                echo '<a href="index.php?page=create_event" class="px-4 py-2 bg-[var(--primary)] text-white font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">';
                                echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
                                echo '</svg>';
                                echo 'Nouvelle evenement';
                                echo '</a>';
                            }
                        echo "</div>";
                    echo '</div>';
                echo '</div>';
                $data = [];
                foreach($events as $event){
                     $registrations = [
                    '1' => ['bg' => '#bbf7d0', 'text' => '#166534', 'label' => 'ouvert'],
                    '0' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'ferme'],
                    ];
                    
                    $status = $event['registerOpen'] ?? '0';
                    $colorConfig = $registrations[$status] ?? $statusColors['0'];
                    
                    $badge = (new Badge(
                        $colorConfig['label'],
                        $colorConfig['text'],
                        $colorConfig['bg'],
                        "rounded-full px-3 py-1 text-xs font-medium"
                    ))->render();
                    $data[] = [
                        "Image" => "<img src='{$event['image_path']}' class='w-10 h-10 rounded-lg'>",
                        "Titre" => $event['title'],
                        "Description" => $event['description'],
                        "Type" => $event['type'],
                        "Date" => $event['event_date'],
                        "Cree par" => $event['created_by'],
                        "Les inscriptions" => $badge,
                        "L'evenement est externe" => (int)$event['isExtern'] ? 'Externe' : 'Interne',
                        "Le lien des inscriptions" => $event['register_link'],
                         'Actions' => '<div class="flex items-center gap-2 justify-center">
                ' . ($allowed['update'] ? '
                <a href="index.php?page=update_event&id=' . $event['id'] . '" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
                ' : '') . '
                    
                ' . ($allowed['delete'] ? '
                <a href="index.php?page=delete_event&id=' . $event['id'] . '" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"" title="Supprimer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </a>' : '') . '
                
            </div>'
                    ];
                }
                $columns = ["Image", "Titre", "Description","Type","Date","Cree par","Les inscriptions", "L'evenement est externe","Le lien des inscription","Actions"];
                $table = new Table($columns, $data, "w-full");
                $table->render();

         echo '</div>';
        echo '</section>';
    }

    public function create_update_form($event) {
    $link = $event === null ? "index.php?page=createEvent" : "index.php?page=updateEvent";
    $action = $event === null ? "Ajouter" : "Modifier";

    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 max-w-4xl">';

    if ($event) {
        echo "<div class='mb-6 flex flex-col items-center'>
            <img id='profilePreview' src='{$event['image_path']}' 
                 class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
            <label class='text-gray-600 text-sm'>Changer la photo</label>
        </div>";
    }


    $form = new Form($link, 'POST', $action, '', '', true);
    $form->addInput('title', 'Titre', $event['title'] ?? '', '');
    $form->addTextarea('description', 'Description', $event['description'] ?? '');
    $form->addSelect('type', 'Type de l\'evenement', ['atelier' => 'Atelier', 'séminaire' => 'Séminaire', 'conférence' => 'Conférence'], $event['type']??'');
    $form->addInput('event_date', 'Date de l\'evenement', $event['event_date'] ?? '','', 'date');
    $form->addFile('image', 'Image');
    $form->addCheckbox(
        'registerOpen',
        "Les inscription sont actives",
        (int)($event['registerOpen'] ?? 1),
        isset($event['registerOpen']) && (int)$event['registerOpen'] === 1
    );
    $form->addCheckbox(
    'isExtern',
    "Externe",
    1,
    isset($event['isExtern']) && (int)$event['isExtern'] === 1
    );
    if ($event) {
        $form->addHidden('current_image', $event['image_path']);
        $form->addHidden('event_id', $event['id']);
    }
    $form->render();

    echo '</div>';
    echo '</section>';
}
}
?>