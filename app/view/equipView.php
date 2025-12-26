<?php
require_once "components/table.php";
require_once "components/title.php";
require_once "components/badge.php";
require_once "components/button.php";
require_once "components/card.php";
require_once "components/form.php";
require_once "components/lineChart.php";
require_once "components/barChart.php";

class EquipmentView {
    private function list_equipments($equipments) {
        echo '<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">';
        echo '<div class="p-6 border-b border-gray-200">';
        echo '<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">';
        echo '<div>';
        echo '<h3 class="text-xl font-bold text-gray-900">Équipements Disponibles</h3>';
        echo '<p class="text-gray-600 text-sm mt-1">Liste de tous les équipements disponibles pour réservation</p>';
        echo '</div>';
        
        echo '<div class="flex flex-wrap gap-3">';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
        if(!empty($equipments)) {
            $data = [];
            foreach($equipments as $equipment) {
                $statusColors = [
                    'libre' => ['bg' => '#bbf7d0', 'text' => '#166534', 'label' => 'Disponible'],
                    'reserve' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'Réservé'],
                    'en-maintenance' => ['bg' => '#fef3c7', 'text' => '#92400e', 'label' => 'Maintenance']
                ];
                
                $status = $equipment['status'] ?? 'libre';
                $colorConfig = $statusColors[$status] ?? $statusColors['libre'];
                
                $badge = (new Badge(
                    $colorConfig['label'],
                    $colorConfig['text'],
                    $colorConfig['bg'],
                    "rounded-full px-3 py-1 text-xs font-medium"
                ))->render();
                
                $description = strlen($equipment['description']) > 80 ? 
                    substr($equipment['description'], 0, 80) . '...' : 
                    $equipment['description'];
                    $button = null;
                if(isset($_SESSION['user'])){
                     if($status === 'libre') {
                    $button = (new Button(
                        "<a href='index.php?page=equipment&id={$equipment['id']}' class='flex'><svg class='w-4 h-4 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'/></svg>Réserver</a>",
                        "",
                        'bg-[var(--primary)] hover:bg-[var(--primary-light)] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200'
                    ))->render();
                    } else {
                        $button = '<span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/></svg>
                            Indisponible
                        </span>';
                    }
                }
                
                $data[] = [
                    'Nom' => "<div class='font-medium text-gray-900'>{$equipment['name']}</div>",
                    'Catégorie' => "<div class='text-gray-700'>{$equipment['category']}</div>",
                    'Description' => "<div class='text-gray-600 text-sm'>{$description}</div>",
                    'État' => "<div class='flex justify-center'>{$badge}</div>",
                    'Action' => "<div class='flex justify-center'>{$button}</div>"
                ];
            }

            $columns = ["Nom", "Catégorie", "Description", "État"];
            $table = new Table($columns, $data, 'w-full');
            $table->render();
        } else {
            echo '<div class="text-center py-12">';
            echo '<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>';
            echo '<h4 class="text-lg font-medium text-gray-600 mb-2">Aucun équipement disponible</h4>';
            echo '<p class="text-gray-500 text-sm">Tous les équipements sont actuellement indisponibles</p>';
            echo '</div>';
        }
        
        echo '</div>';
    }

    private function list_reservations($reservations) {
        echo '<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">';
        echo '<div class="p-6 border-b border-gray-200">';
        echo '<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">';
        echo '<div>';
        $title = (new Title('Historique des Réservations', "text-xl font-bold text-gray-900", 'h3'))->render();
        echo $title;
        echo '<p class="text-gray-600 text-sm mt-1">Suivi des réservations passées et en cours</p>';
        echo '</div>';
        
        $stats = [
            'confirme' => 0,
            'termine' => 0,
            'en-attente' => 0
        ];
        
        foreach($reservations as $reservation) {
            $stats[$reservation['status_res']] = ($stats[$reservation['status_res']] ?? 0) + 1;
        }
        
        echo '<div class="flex gap-4">';
        echo '<div class="text-center">';
        echo '<div class="text-2xl font-bold text-green-600">' . ($stats['confirme'] ?? 0) . '</div>';
        echo '<div class="text-xs text-gray-500">Confirmées</div>';
        echo '</div>';
        echo '<div class="text-center">';
        echo '<div class="text-2xl font-bold text-blue-600">' . ($stats['en-attente'] ?? 0) . '</div>';
        echo '<div class="text-xs text-gray-500">En attente</div>';
        echo '</div>';
        echo '<div class="text-center">';
        echo '<div class="text-2xl font-bold text-gray-600">' . ($stats['termine'] ?? 0) . '</div>';
        echo '<div class="text-xs text-gray-500">Terminées</div>';
        echo '</div>';
        echo '</div>';
        
        echo '</div>';
        echo '</div>';
        
        if(!empty($reservations)) {
            $data = [];
            foreach($reservations as $reservation) {
                $statusConfigs = [
                    'confirme' => ['bg' => '#d1fae5', 'text' => '#065f46', 'label' => 'Confirmée'],
                    'termine' => ['bg' => '#e5e7eb', 'text' => '#374151', 'label' => 'Terminée'],
                    'en-attente' => ['bg' => '#fef3c7', 'text' => '#92400e', 'label' => 'En attente']
                ];
                
                $status = $reservation['status_res'] ?? 'attente';
                $config = $statusConfigs[$status] ?? $statusConfigs['en-attente'];
                
                $badge = (new Badge(
                    $config['label'],
                    $config['text'],
                    $config['bg'],
                    "rounded-full px-3 py-1 text-xs font-medium"
                ))->render();
                
                $startDate = date('d M', strtotime($reservation['start_datetime']));
                $endDate = date('d M', strtotime($reservation['end_datetime']));
                $timeRange = date('H:i', strtotime($reservation['start_datetime'])) . ' - ' . date('H:i', strtotime($reservation['end_datetime']));
                
                $userName = $reservation['first_name'] . ' ' . $reservation['last_name'];
                $purpose = strlen($reservation['purpose']) > 60 ? 
                    substr($reservation['purpose'], 0, 60) . '...' : 
                    $reservation['purpose'];
                
                $data[] = [
                    'Équipement' => "<div class='font-medium text-gray-900'>{$reservation['name']}</div>",
                    'Utilisateur' => "<div class='text-gray-700'>{$userName}</div>",
                    'Motif' => "<div class='text-gray-600 text-sm'>{$purpose}</div>",
                    'Période' => "<div class='text-center'>
                        <div class='font-medium text-gray-900'>{$startDate} - {$endDate}</div>
                        <div class='text-xs text-gray-500'>{$timeRange}</div>
                    </div>",
                    'Statut' => "<div class='flex justify-center'>{$badge}</div>"
                ];
            }

            $columns = ["Équipement", "Utilisateur", "Motif", "Période", "Statut"];
            $table = new Table($columns, $data, 'w-full');
            $table->render();
        } else {
            echo '<div class="text-center py-12">';
            echo '<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
            echo '<h4 class="text-lg font-medium text-gray-600 mb-2">Aucune réservation</h4>';
            echo '<p class="text-gray-500 text-sm">Aucune réservation n\'a été effectuée pour le moment</p>';
            echo '</div>';
        }
        
        echo '</div>';
    }

    
    private function show_statistiques($reserv_month, $equipReserv, $labels) {
    $labelsDate = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    ob_start();
    $lineChart = new LineChart();
    $lineChart->render($reserv_month, $labelsDate, 'rgba(2, 43, 109, 1)', 'rgba(96, 154, 247, 0.2)');
    $lineChartHTML = ob_get_clean();


    $title = (new Title('Statistiques', 'text-3xl font-bold text-gray-900 mb-2', 'h3'))->render();

    $subCardClass = "bg-gradient-to-br from-white to-gray-50 rounded-2xl border border-gray-200 p-6";
    


    ob_start();
    $barChart = new BarChart();
    $barChart->render($equipReserv, $labels, 'rgba(3, 204, 93, 1)', 'rgba(110, 250, 166, 0.21)');
    $barChartHTML = ob_get_clean();


    $header = [
        '<div class="mb-10">',
            $title,
            "<p class='text-gray-600'>Visualiser les statistiques des equipments</p>",
        '</div>'
    ];
ob_start();
 $lineChart->display($lineChartHTML, 'Nombre de reservation par mois', '<svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>');
$card1HTML = ob_get_clean();
ob_start();
        $barChart->display($barChartHTML, 'Nombre de reservation par equipment', '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>');
$card2HTML = ob_get_clean();
    
    $body = [
        '<div class="grid grid-cols-1 xl:grid-cols-2 gap-8">',
            $card1HTML,
            $card2HTML,
        '</div>'
    ];

    $card = new Card(
        $header, 
        $body, 
        [], 
        "bg-white p-8 rounded-3xl shadow-xl"
    );
    $card->render();
}

    public function show_equipments($equipments, $reservations, $reserv_month, $equipReserv, $labels) {
        echo '<section class="py-24 w-[90%] min-h-screen">';
        echo '<div class="container px-4">';
        
        echo '<div class="mb-8">';
        $title = (new Title('Gestion des Équipements', "text-3xl font-bold text-gray-900 mb-2", 'h1'))->render();
        echo $title;
        echo '<p class="text-gray-600">Gérez les équipements du laboratoire et suivez les réservations en temps réel</p>';
        echo '</div>';
        


        echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">';

        $available = array_filter($equipments, fn($e) => ($e['status'] ?? '') === 'libre');
        $reservation = array_filter($reservations, fn($e) => ($e['status_res'] ?? '') === 'confirme');

        $stats = [
            ['title'=>'Équipements Totaux', 'class' => 'bg-gradient-to-r from-blue-600 to-blue-700 ', 'value' => count($equipments), 'icon' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z"/></svg>'],
            ['title'=>'Disponibles', 'class' => 'bg-gradient-to-r from-green-600 to-green-700 ', 'value' => count($available), 'icon' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>'],
            ['title'=>'Réservations Actives', 'class' => 'bg-gradient-to-r from-purple-600 to-purple-700 ', 'value' => count($reservation), 'icon' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>']
        ];

            $header = [];
            foreach($stats as $stat){
                $body  = [
                    '<div class="flex items-end justify-between">',
                        '<div>',
                            "<h3 class='text-lg font-semibold mb-2'>{$stat['title']}</h3>",
                            '<div class="text-3xl font-bold">' . $stat['value'] . '</div>',
                        '</div>',
                        '<div class="w-12 h-12 rounded-lg bg-white/20 flex items-center justify-center">',
                            $stat['icon'],
                        '</div>',
                    '</div>',
                ];
                $footer = [];
                $card = new Card($header, $body, $footer, $stat['class'].'text-white p-4 rounded-xl');
                $card->render();
            }
            
        
           
        
        echo '</div>';
        
        $this->list_equipments($equipments);
        $this->list_reservations($reservations);
        $this->show_statistiques($reserv_month, $equipReserv, $labels);
        
        echo '</div>';
        echo '</section>';
    }

    private function getEquip($name){
        $equipmentBody = [
        "<div class='space-y-4 mb-2'>",
            "<div class='flex flex-col md:flex-row md:items-center justify-between gap-6'>",
                "<div class='space-y-3 flex-1'>",
                    "<h3 class='text-xl font-bold text-gray-900'>" . htmlspecialchars($name) . "</h3>",
                    "<div class='flex flex-wrap gap-4'>",
                        "<div class='flex items-center gap-2 text-green-600 font-medium'>",
                            "<svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'/></svg>",
                            "<span>Disponible</span>",
                        "</div>",
                    "</div>",
                "</div>",
            "</div>",
    ];
    
    ob_start();
        $equipmentCard = new Card([], $equipmentBody, [], "bg-gray-50 p-6 rounded-xl border border-gray-200 mb-8");
        $equipmentCard->render();
        $equipHTML = ob_get_clean();
        return $equipHTML;
    }




private function getUser($user){
        $userInfoHeader = [
        "<div class='flex items-center gap-3'>",
            "<svg class='w-6 h-6 text-blue-600' fill='currentColor' viewBox='0 0 20 20'>",
                "<path fill-rule='evenodd' d='M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z' clip-rule='evenodd'/>",
            "</svg>",
            "<h4 class='text-lg font-semibold text-gray-900'>Informations du demandeur</h4>",
        "</div>"
        ];
    
        $userInfoBody = [
            "<div class='grid md:grid-cols-2 gap-6'>",
                "<div class='space-y-1'>",
                    "<div class='text-sm text-gray-500'>Nom complet</div>",
                    "<div class='font-medium text-gray-900'>" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . "</div>",
                "</div>",
                "<div class='space-y-1'>",
                    "<div class='text-sm text-gray-500'>Email</div>",
                    "<div class='font-medium text-gray-900'>" . htmlspecialchars($user['email']) . "</div>",
                "</div>",
                "<div class='space-y-1'>",
                    "<div class='text-sm text-gray-500'>Rôle</div>",
                    "<div class='font-medium text-gray-900'>" . htmlspecialchars($user['role']) . "</div>",
                "</div>",
                "<div class='space-y-1'>",
                    "<div class='text-sm text-gray-500'>Specialite</div>",
                    "<div class='font-medium text-gray-900'>" . htmlspecialchars($user['speciality'] ?? 'Non spécifié') . "</div>",
                "</div>",
            "</div>"
        ];
    
        ob_start();
        $userInfoCard = new Card($userInfoHeader, $userInfoBody, [], "bg-blue-50 p-6 rounded-xl border border-blue-100 mb-8");
        $userInfoCard->render();
        $userHTML = ob_get_clean();
        return $userHTML;
    }
        


    private function getForm($user_id, $equip_id) {
    $formHeaderContent = [
        "<div class='text-center mb-6'>",
            "<h3 class='text-2xl font-bold text-gray-900 mb-2'>Détails de la réservation</h3>",
            "<p class='text-gray-600'>Remplissez les informations requises pour votre réservation</p>",
        "</div>"
    ];

    $formText = '<p class="text-gray-600 text-center mb-6">Veuillez remplir tous les champs obligatoires pour effectuer votre réservation.</p>';

    $form = new Form(
        'index.php?page=reservation',
        'POST', 
        'Confirmer la réservation', 
        'Formulaire de réservation',
        $formText
    );

    $form->addHidden('equip_id', $equip_id);
    $form->addHidden('user_id', $user_id);
    $form->addInput('start_datetime', 'Date et heure de début', '', 'JJ/MM/AAAA HH:MM', 'datetime-local');
    $form->addInput('end_datetime', 'Date et heure de fin', '', 'JJ/MM/AAAA HH:MM', 'datetime-local');
    $form->addTextarea('purpose', 'Motif de la réservation', '', 'Décrivez l\'utilisation prévue de l\'équipement');

    ob_start();
    $form->render();
    $formHTML = ob_get_clean();

    $formBody = ["<div>" . $formHTML . "</div>"];
    ob_start();
    $formCard = new Card($formHeaderContent, $formBody, [], "bg-white p-6 rounded-xl border border-gray-200 mb-8");
    $formCard->render();
    $formCardHTML = ob_get_clean();

    return $formCardHTML;
}



public function show_res_form($equip) {
    $user = $_SESSION['user'][0];
    
    echo '<section class="min-h-screen lg:w-5xl bg-gradient-to-br from-gray-50 to-blue-50 py-24 px-4">';
    echo '<div class="container mx-auto max-w-4xl">';
    
    $headerTitle = (new Title("Réservation d'équipement", "text-3xl font-bold text-gray-900", "h1"))->render();
    $headerContent = [
        "<div class='flex flex-col md:flex-row md:items-center justify-between gap-6'>",
            "<div class='space-y-3'>",
                $headerTitle,
                "<p class='text-gray-600'>Formulaire de demande de réservation</p>",
            "</div>",
            "<div class='flex items-center gap-4'>",
                "<div class='w-16 h-16 rounded-xl bg-blue-100 flex items-center justify-center'>",
                    "<svg class='w-8 h-8 text-blue-600' fill='currentColor' viewBox='0 0 20 20'><path d='M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z'/></svg>",
                "</div>",
            "</div>",
        "</div>"
    ];
    

$equipHTML = $this->getEquip($equip['name']);
$userHTML = $this->getUser($user);
$formCardHTML= $this->getForm($user['id'],$equip['id']);

    $mainBody = [
        "<div class='space-y-8'>",
            "<div>",
                $equipHTML,
            "</div>",
            "<div>",
                $userHTML,
            "</div>",
            "<div>",
                $formCardHTML,
            "</div>",
        "</div>"
    ];
    
    $mainFooter = [
        "<div class='text-center'>",
            "<p class='text-sm text-gray-500'>",
                "Votre demande sera traitée dans les plus brefs délais.",
            "</p>",
        "</div>"
    ];
    $mainCard = new Card(
        $headerContent,
        $mainBody,
        $mainFooter,
        'bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 p-8'
    );
    
    $mainCard->render();
    
    echo '</div>';
    echo '</section>';
    
   
}
}
?>