<?php
require_once "components/diaporama.php";
require_once "components/card.php";
require_once "components/orga.php";
require_once "components/title.php";
require_once "components/button.php";
require_once "components/orga.php";
    class HomeView {
        private function diaporama($diaporamas) {
            echo '<section class="diaporama">';
            echo '<div class="diaporama-track">';
            foreach($diaporamas as $slide){
                echo '<div class="diaporama-slide">';
                $diapCard = new DiaporamaCard($slide['title'], $slide['description'], $slide['image']);
                $diapCard->render();
                echo '</div>';
            }  
            echo '</div>';   
            echo '</section>';
    }
      private function actualites($actualites) {
    echo '<section class="grid gap-2 justify-center p-8">';
    
        echo '<div class="flex justify-between items-end mb-12 max-w-7xl mx-auto w-full">';
            echo '<div>';
            $title = (new Title("Actualités", "text-4xl font-bold text-[var(--gray-dark)]", 'h2'))->render();
            echo $title;
            echo '<p class="text-[var(--gray)] max-w-2xl">Restez informé des dernières nouvelles, avancements et découvertes de notre laboratoire.</p>';
            echo '</div>';
            echo '<a href="index.php?page=actualites" class="inline-flex items-center text-[var(--primary)] hover:text-[var(--primary-light)] font-semibold transition-colors duration-300">';
            echo '<span>Voir toutes les actualités</span>';
            echo '<svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>';
            echo '</a>';
        echo '</div>';
    
    echo '<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 max-w-7xl mx-auto w-full">';
    
    foreach($actualites as $index => $act) {
        if($index < 3){
            $date = date('d M Y', strtotime($act['created_at'] ?? 'now'));
        
        $dateBadge = "<div class='absolute top-4 left-4 z-10'>
            <span class='inline-flex items-center px-3 py-1 rounded-full text-xs font-medium backdrop-blur-sm text-gray-700'>
                <svg class='w-4 h-4 mr-1.5' fill='currentColor' viewBox='0 0 20 20'>
                    <path fill-rule='evenodd' d='M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z' clip-rule='evenodd'/>
                </svg>
                {$date}
            </span>
        </div>";
        
        $cardTitle = (new Title(
            $act['title'], 
            'text-xl font-bold text-[var(--gray-dark)] mb-3 leading-tight',
            'h3'
        ))->render();

        $header = [
            "<div class='relative h-56 overflow-hidden'>
                <img src='{$act['image']}' class='w-full h-full object-cover transition-transform duration-700 hover:scale-110'/>
                {$dateBadge}
            </div>"
        ];

        $body = [
            "<div class='p-6'>
                {$cardTitle}
                <p class='text-[var(--gray)] leading-relaxed mb-4 line-clamp-3'>{$act['description']}</p>
            </div>"
        ];
        
        $footer = [];
        
        $card = new Card(
            $header,
            $body,
            $footer,
            'bg-[var(--white)] rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2'
        );

        $card->render();
        }
        
    }

    echo '</div>';
    echo '</section>';
}
        private function a_propos($orgData) {
        echo '<section class="px-6">';
            echo '<div class="container mx-auto px-4 max-w-7xl">';
            
                echo '<div class="grid lg:grid-cols-2 gap-12 items-center">';
                
                    echo '<div>';
                    echo '<div class="mb-8">';
                    echo '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-[var(--primary)] mb-4">À propos de nous</span>';
                    echo '<h2 class="text-4xl font-bold text-[var(--gray-dark)] mb-6">Notre Laboratoire de Recherche</h2>';
                    echo '</div>';
                
                    echo '<div class="space-y-6 text-[var(--gray)] leading-relaxed">';
                    echo '<p>Le Laboratoire de Recherche en Sciences et Technologies est un centre d\'excellence dédié à l\'innovation scientifique et à l\'avancement technologique. Nous rassemblons des chercheurs, enseignants-chercheurs et étudiants autour de projets multidisciplinaires visant à développer des solutions novatrices.</p>';
                    echo '<p>Notre mission est de favoriser la production de connaissances, la formation pratique des étudiants et la collaboration avec le milieu industriel et académique. Le laboratoire dispose d\'équipements modernes et d\'un environnement propice à la recherche appliquée et fondamentale.</p>';
                    echo '</div>';
                
               
                
                echo '</div>';
                
                echo '<div class=" p-8 rounded-2xl border border-gray-200">';
                echo '<div class="mb-6">';
                echo '<h3 class="text-2xl font-bold text-[var(--gray-dark)] mb-2">Organigramme</h3>';
                echo '<p class="text-[var(--gray)]">Structure organisationnelle de notre laboratoire</p>';
                echo '</div>';
                
                $orga = new Organigramme();
                echo '<div class="overflow-x-auto">';
                echo '<div class="min-w-max">';
                echo '<a href="index.php?page=membres">';
                $orga->render($orgData);
                echo '</a>';
                echo '</div>';
                echo '</div>';
                
                echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</section>';
    }

   private function event($eventsData) {
    $events = $eventsData['events'];
    echo '<section id="events" class="p-6">';
    echo '<div class="container mx-auto px-4 max-w-7xl">';
    
    echo '<div class="text-center mb-12">';
    echo '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-[var(--primary)] mb-4">Événements</span>';
    $title = (new Title("Événements à Venir", "text-4xl font-bold text-[var(--gray-dark)] mb-4", 'h2'))->render();
    echo $title;
    echo '<p class="text-[var(--gray)] max-w-2xl mx-auto">Participez à nos conférences, ateliers et séminaires pour découvrir les dernières avancées de la recherche.</p>';
    echo '</div>';
    
    if(!empty($events)) {
        echo '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">';
        
        foreach($events as $index => $event) {
            if($index < 3){
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
                    <div class='font-medium text-[var(--gray-dark)]'>{$eventDate}</div>
                </div>
            </div>";
            
            $cardTitle = (new Title(
                $event['title'],
                'text-xl font-bold text-[var(--gray-dark)] mb-3 leading-tight',
                'h3'
            ))->render();
            
            if($isOpen) {
                $buttonHTML = "<a href='#' class='inline-flex items-center gap-2 bg-[var(--primary)] text-[var(--white)] font-semibold px-5 py-2.5 rounded-lg hover:bg-[var(--primary-light)] transition-colors duration-300 text-sm'>
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
                    <p class='text-[var(--gray)] leading-relaxed mb-4 line-clamp-3'>{$event['description']}</p>
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
                'bg-[var(--white)] rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2'
            );

            $card->render();
            }
        }
        
        echo '</div>';
        
    } else {
        echo '<div class="text-center py-12 bg-[var(--white)] rounded-xl border-2 border-dashed border-gray-300">';
        echo '<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
        echo '<h3 class="text-xl font-bold text-gray-600 mb-2">Aucun événement à venir</h3>';
        echo '<p class="text-gray-500 max-w-md mx-auto">Les prochains événements seront annoncés prochainement. Restez à l\'écoute !</p>';
        echo '</div>';
    }
    echo '<a href="index.php?page=evenments" class="inline-flex items-center text-[var(--primary)] justify-end hover:text-[var(--primary-light)] font-semibold transition-colors duration-300">';
            echo '<span>Voir toutes les evenments</span>';
            echo '<svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>';
            echo '</a>';
    echo '</div>';
    echo '</section>';
}

        private function partners($partners) {
    echo '<section class="py-20 bg-[var(--white)]">';
    echo '<div class="container mx-auto px-4 max-w-7xl">';
    
    echo '<div class="text-center mb-12">';
    echo '<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-[var(--primary)] mb-4">Collaborations</span>';
    $title = (new Title("Nos Partenaires", "text-4xl font-bold text-[var(--gray-dark)]   mb-4", 'h2'))->render();
    echo $title;
    echo '<p class="text-[var(--gray)] max-w-2xl mx-auto">Nous collaborons avec des institutions académiques et industrielles de premier plan pour mener des recherches innovantes.</p>';
    echo '</div>';
    
    if(!empty($partners)) {
        echo '<div class="relative overflow-hidden py-4">';
        echo '<div class="partners-track flex gap-12 animate-scroll">';
        
        $duplicatedPartners = array_merge($partners, $partners);
        
        foreach($duplicatedPartners as $index => $partner) {
            $partnerName = (new Title(
                $partner['name'],
                'font-medium text-[var(--gray-dark)] text-sm mb-1',
                'h4'
            ))->render();
            
            $partnerType = $partner['type'] ?? 'Partenaire';
            
            $header = [
                "<div class='w-20 h-20 p-3 bg-[var(--white)] rounded-full shadow-sm flex items-center justify-center mx-auto mb-4'>
                    <img src='{$partner['logo_path']}' class='max-w-full max-h-full object-contain' alt='{$partner['name']}'>
                </div>"
            ];

            $body = [
                "<div class='text-center'>
                    {$partnerName}
                    <p class='text-xs text-[var(--gray)]'>{$partnerType}</p>
                </div>"
            ];
            
            $footer = [];
            
            $card = new Card(
                $header,
                $body,
                $footer,
                'bg-[var(--gray-light)] p-6 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-lg transition-all duration-300 w-48 flex-shrink-0'
            );

            echo '<div class="partner-item">';
            $card->render();
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
        
        echo '<style>
        .partners-track {
            display: flex;
            width: max-content;
        }
        .partner-item {
            flex: 0 0 auto;
        }
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-19rem * ' . count($partners) . ')); }
        }
        .animate-scroll {
            animation: scroll 40s linear infinite;
        }
        .partners-track:hover .animate-scroll {
            animation-play-state: paused;
        }
        </style>';
    } else {
        echo '<div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">';
        echo '<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
        echo '<h3 class="text-xl font-bold text-gray-600 mb-2">Nos partenariats</h3>';
        echo '<p class="text-gray-500 max-w-md mx-auto">Les informations sur nos partenaires seront bientôt disponibles.</p>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</section>';
}
        public function show_home($diaporamas, $actualites, $orgData, $eventsData, $partners){
            echo "<div class='grid gap-10 justify-center'>";
            $this->diaporama($diaporamas);
            $this->actualites($actualites);
            $this->a_propos($orgData);
            $this->event($eventsData);
            $this->partners($partners);
            echo "</div>";
        }
    }
?>