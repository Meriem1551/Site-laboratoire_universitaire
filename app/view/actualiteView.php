<?php
require_once "components/card.php";
class ActualiteView{
    public function displayActualites($actualites){
        $title= (new Title("Nos dernières actualités", "text-3xl font-bold text-gray-800 mb-", "h1"))->render();
        echo '<section class="py-24 px-4 md:px-8">';
        echo '<div class="mb-10">';
        echo $title;
        echo '<p class="text-gray-700">Découvrez les dernières publications, projets et evenements de nos équipes de recherche et leurs partenaires.</p>';
        echo '</div>';
        
        echo '<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-6">';
        
        foreach($actualites as $index => $act) {
            $date = date('d M Y', strtotime($act['created_at'] ?? 'now'));
            
            $dateBadge = "
            <div class='absolute top-4 left-4'>
                <span class='inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-white text-gray-800 shadow-sm backdrop-blur-sm'>
                    {$date}
                </span>
            </div>";
            
            $cardTitle = (new Title(
                $act['title'], 'text-xl font-bold text-gray-900 mb-3 leading-tight', 'h3'
            ))->render();
            
            $header = [
                "<div class='relative overflow-hidden'>
                    <div class='absolute'></div>
                    <img src='{$act['image']}' alt='{$act['title']}' 
                         class='w-full h-full object-cover transition-transform duration-500 hover:scale-110'/>
                    {$dateBadge}
                </div>"
            ];

            $body = [
                "<div class='p-6'>
                    {$cardTitle}
                    <p class='text-gray-600 leading-relaxed mb-4'>{$act['description']}</p>
                </div>"
            ];
            
            $card = new Card(
                $header,
                $body,
                [],
                "bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300"
            );

            $card->render();
        }

        echo '</div>';
        
        
        echo '</div>';
        echo '</section>';
    }
}
?>