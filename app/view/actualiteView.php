<?php
require_once "components/card.php";
require_once "components/table.php";
require_once "components/form.php";

class ActualiteView{
    public function displayActualites($actualites){
        $title= (new Title("Nos dernières actualités", "text-3xl font-bold text-[var(--gray-dark)] mb-", "h1"))->render();
        echo '<section class="py-24 px-4 md:px-8">';
        echo '<div class="mb-10">';
        echo $title;
        echo '<p class="text-[var(--gray)]">Découvrez les dernières publications, projets et evenements de nos équipes de recherche et leurs partenaires.</p>';
        echo '</div>';
        
        echo '<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-6">';
        
        foreach($actualites as $index => $act) {
            $date = date('d M Y', strtotime($act['created_at'] ?? 'now'));
            
            $dateBadge = "
            <div class='absolute top-4 left-4'>
                <span class='inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-[var(--white)] text-[var(--gray-dark)] shadow-sm backdrop-blur-sm'>
                    {$date}
                </span>
            </div>";
            
            $cardTitle = (new Title(
                $act['title'], 'text-xl font-bold text-[var(--gray-dark)] mb-3 leading-tight', 'h3'
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
                    <p class='text-[var(--gray)] leading-relaxed mb-4'>{$act['description']}</p>
                </div>"
            ];
            
            $card = new Card(
                $header,
                $body,
                [],
                "bg-[var(--white)] rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300"
            );

            $card->render();
        }

        echo '</div>';
        
        
        echo '</div>';
        echo '</section>';
    }
    public function show_news($news,$allowed){
        echo '<section class="min-h-screen py-24 w-full px-12">';
            echo '<div class="mb-10">';
                echo '<h1 class="text-3xl lg:text-4xl font-bold text-[var(--gray-dark)] mb-2">Gestion des actualites</h1>';
                echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
        
                    echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
                        echo '<h2 class="text-xl font-bold text-[var(--gray-dark)]">Liste des actualites</h2>';
                        
                        echo "<div class='flex gap-6 ml-auto'>";
                            if ($allowed['create']) {
                                echo '<a href="index.php?page=create_new" class="px-4 py-2 bg-[var(--primary)] text-[var(--white)] font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">';
                                echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
                                echo '</svg>';
                                echo 'Nouvelle actualite';
                                echo '</a>';
                            }
                        echo "</div>";
                    echo '</div>';
                echo '</div>';
                $data = [];
                foreach($news as $new){
                    $newInfo = "
                        <div class='flex items-center gap-2'>
                            <img src='{$new['image']}' class='w-16 h-16 rounded-lg'>
                            <p class='text-[var(--gray)]'>{$new['title']}</p>
                        </div>
                    ";
                    $data[] = [
                        "Titre" => $newInfo,
                        "Description" => $new['description'],
                         'Actions' => '<div class="flex items-center gap-2 justify-center">
                ' . ($allowed['update'] ? '
                <a href="index.php?page=update_new&id=' . $new['id'] . '" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
                ' : '') . '
                    
                ' . ($allowed['delete'] ? '
                <a href="index.php?page=delete_new&id=' . $new['id'] . '" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"" title="Supprimer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </a>' : '') . '
                
            </div>'
                    ];
                }
                $columns = ["Titre", "Description", "Actions"];
                $table = new Table($columns, $data, "w-full");
                $table->render();

         echo '</div>';
        echo '</section>';
    }

    public function create_update_form($new) {
    $link = $new === null ? "index.php?page=createNew" : "index.php?page=updateNew";
    $action = $new === null ? "Ajouter" : "Modifier";

    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-[var(--white)] shadow-lg rounded-lg p-6 max-w-4xl">';

    if ($new) {
        echo "<div class='mb-6 flex flex-col items-center'>
            <img id='profilePreview' src='{$new['image']}' 
                 class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
            <label class='text-[var(--gray-dark)] text-sm'>Changer la photo</label>
        </div>";
    }


    $form = new Form($link, 'POST', $action, '', '', true);
    $form->addInput('title', 'Titre', $new['title'] ?? '', 'Titre actualite');
    $form->addTextarea('description', 'Description', $new['description'] ?? '');
   
    $form->addFile('image', 'Image');

    if ($new) {
        $form->addHidden('current_image', $new['image']);
        $form->addHidden('new_id', $new['id']);
    }
    $form->render();

    echo '</div>';
    echo '</section>';
}
}
?>