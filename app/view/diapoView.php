<?php
require_once "components/table.php";
require_once "components/form.php";

class diapoView{
   public function show_diapo($diapo,$allowed){
        echo '<section class="min-h-screen py-24 w-full px-12">';
            echo '<div class="mb-10">';
                echo '<h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Gestion des actualites</h1>';
                echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
        
                    echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
                        echo '<h2 class="text-xl font-bold text-gray-900">Liste des actualites</h2>';
                        
                        echo "<div class='flex gap-6 ml-auto'>";
                            if ($allowed['create']) {
                                echo '<a href="index.php?page=create_diapo" class="px-4 py-2 bg-[var(--primary)] text-white font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">';
                                echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
                                echo '</svg>';
                                echo 'Nouvel slide';
                                echo '</a>';
                            }
                        echo "</div>";
                    echo '</div>';
                echo '</div>';
                $data = [];
                foreach($diapo as $slide){
                    $data[] = [
                        "Image" => "<img src='{$slide['image']}' class='w-16 h-16 rounded-lg'>",
                        "Titre" => $slide['title'],
                        "Description" => $slide['description'],
                         'Actions' => '<div class="flex items-center gap-2 justify-center">
                ' . ($allowed['update'] ? '
                <a href="index.php?page=update_diapo&id=' . $slide['id'] . '" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
                ' : '') . '
                    
                ' . ($allowed['delete'] ? '
                <a href="index.php?page=delete_diapo&id=' . $slide['id'] . '" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"" title="Supprimer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </a>' : '') . '
                
            </div>'
                    ];
                }
                $columns = ["Image", "Titre","Description", "Actions"];
                $table = new Table($columns, $data, "w-full");
                $table->render();

         echo '</div>';
        echo '</section>';
    }
    public function create_update_form($slide) {
    $link = $slide === null ? "index.php?page=createDiapo" : "index.php?page=updateDiapo";
    $action = $slide === null ? "Ajouter" : "Modifier";

    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 max-w-4xl">';

    if ($slide) {
        echo "<div class='mb-6 flex flex-col items-center'>
            <img id='profilePreview' src='{$slide['image']}' 
                 class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
            <label class='text-gray-600 text-sm'>Changer la photo</label>
        </div>";
    }


    $form = new Form($link, 'POST', $action, '', '', true);
    $form->addInput('title', 'Titre', $slide['title'] ?? '', '');
    $form->addTextarea('description', 'Description', $slide['description'] ?? '');
   
    $form->addFile('image', 'Image');

    if ($slide) {
        $form->addHidden('current_image', $slide['image']);
        $form->addHidden('slide_id', $slide['id']);
    }
    $form->render();

    echo '</div>';
    echo '</section>';
}
}
?>