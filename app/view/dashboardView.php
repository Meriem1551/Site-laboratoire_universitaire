<?php
require_once "components/card.php";
require_once "components/title.php";

class DashboardView {
    public function show_page($cards) {
        echo '<div class="min-h-screen py-24 px-12">';
        echo '<div class="mx-auto">';
        
        echo '<div class="mb-8 md:mb-12">';
        echo (new Title('Tableau de bord', 'text-3xl lg:text-4xl font-bold text-gray-900 mb-2', 'h1'))->render();
        echo '<p class="text-gray-600 text-lg">Gérez l\'ensemble de votre système</p>';
        echo '</div>';
        
        echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">';
        
        foreach ($cards as $cardKey => $cardData) {
            
            $header = [
                "<div class='p-6 grid justify-center'>
                    <div class='rounded-lg flex items-center justify-center mb-4'>
                        <div class='text-" . $cardData['color'] . "-600'>
                            " . $cardData['icon'] . "
                        </div>
                    </div>
                    
                    <h3 class='text-lg font-bold text-gray-900 mb-2'>" . $cardData['title'] . "</h3>
                    
                    <div class='absolute top-0 left-0 right-0 h-1 bg-" . $cardData['color'] . "-500 rounded-t-lg'></div>
                </div>"
            ];
            
            $body = [
                "<div class='px-6 pb-6'>
                    <div class='flex items-center justify-center'>
                        <a href='" . $cardData['url'] . "' 
                           class='px-6 py-3 text-sm font-medium text-white bg-" . $cardData['color'] . "-500 hover:bg-" . $cardData['color'] . "-600 rounded-lg transition-colors hover:shadow-md w-full text-center'>
                            Accéder au module
                        </a>
                    </div>
                </div>"
            ];
            
            $footer = [];
            
            $card = new Card(
                $header, 
                $body, 
                $footer, 
                "bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-200 overflow-hidden relative"
            );
            
            echo $card->render();
        }
        
        echo '</div>'; 
        echo '</div>'; // Close max-w-7xl
        echo '</div>'; // Close min-h-screen
    }
}
?>