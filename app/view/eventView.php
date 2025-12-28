<?php
require_once "components/title.php";
require_once "components/badge.php";
require_once "components/card.php";
require_once "components/pagination.php";


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
}
?>