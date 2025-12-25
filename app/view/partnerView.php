<?php
require_once "components/form.php";
require_once "components/card.php";
require_once "components/badge.php";
require_once "components/table.php";
class PartnerView{
    public function show_partners($partners, $projects_partners){
        $id_project = $_GET['id'];
        echo '<section class="min-h-screen py-24 px-12 md:px-8 lg:px-12">';
        echo '<div class="max-w-6xl mx-auto">';
        echo '<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">';
        
    
        echo '<div class="lg:col-span-2">';
        echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">';
        
        echo '<div class="px-6 py-4 border-b border-gray-200">';
        echo '<h2 class="text-xl font-bold text-gray-900">Partenaires de projet</h2>';
        echo '<p class="text-gray-600 text-sm mt-1">' . count($projects_partners) . ' partenaires disponibles</p>';
        echo '</div>';
        
        $data = [];
        foreach($projects_partners as $partner) {  
            $data[] = [
                'Nom du partenaire' => '<div class="font-medium text-gray-900">' .'<img src="' . htmlspecialchars($partner['logo_path']) . '" alt="Logo du partenaire" class="ml-2 w-8 h-8 inline-block">'. htmlspecialchars($partner['name']) . '</div>',
                'Actions' => '<div class="flex items-center gap-2 justify-end">
                <a href="index.php?page=delete_partner_project&id_project=' . $id_project . '&id_partner=' . $partner['id'] . '" 
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
                'Nom du partenaire' => '<div class="text-center py-8 text-gray-500">Aucun partenaire disponible</div>',
                'Actions' => ''
            ];
        }
        
        $columns = ["Nom du partenaire", "Actions"];
        $table = new Table($columns, $data, 'w-full');
        $table->render();

        echo '</div>'; 

        echo "<a href='index.php?page=gestion_projet'
                class='inline-flex items-center text-[var(--primary)] hover:text-blue-800 mt-4 font-medium hover:underline'>
                <svg class='w-4 h-4 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 19l-7-7m0 0l7-7m-7 7h18'/>
                </svg>
                Revenir à la page projets
              </a>";

        echo '</div>'; 

        echo '<div class="col-span-2">';
        echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">';
        echo '<h2 class="text-xl font-bold text-gray-900 mb-6">Ajouter un partenaire</h2>';
        
        $form = new Form(
            'index.php?page=add_partner&id_project=' . $id_project, 
            'POST', 
            'Ajouter le partenaire',
            '', 
            'Remplissez le formulaire ci-dessous pour ajouter un partenaire'
        );

        $partners = array_reduce($partners, function($acc, $partner) {
                $acc[$partner['id']] = $partner['name'];
                return $acc;
        }, []);

        $form->addSelect(
            'partner_id',
            'Sélectionner un partenaire',
            $partners,
            '',
        );
        $form->render();
        echo '</div>';
        echo '</div>'; 
        
        echo '</div>'; 
        echo '</div>';
        echo '</section>';
    }
    public function show_all_partners($partners, $allowed){
        echo '<section class="min-h-screen py-24 px-12 w-full md:px-8 lg:px-12">';
        echo '<div class="mb-10">';
        echo '<h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Gestion des partenaires</h1>';
        echo '<p class="text-gray-600 text-lg">Consultez et gérez tous les partenaires du système</p>';
        echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
            
            echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
            echo '<h2 class="text-xl font-bold text-gray-900">Liste des partenaires</h2>';
    echo "<div class='flex gap-6 ml-auto'>";
        if ($allowed['create']) {
            echo '<a href="index.php?page=create_partner" class="px-4 py-2 bg-[var(--primary)] text-white font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">';
            echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
            echo '</svg>';
            echo 'Nouvel partenaire';
            echo '</a>';
        }
    echo "</div>";
    echo '</div>';
    echo '</div>';
        $data = [];
        foreach($partners as $partner) { 
            $partInto = 
        "<div class='flex items-center gap-3'>
                <img src='{$partner['logo_path']}' class='w-10 h-10 rounded-full'>  
            <div>
                <div class='font-semibold text-gray-900'>{$partner['name']}</div>
            </div>
        </div>"; 
            $data[] = [
                'Partenaire' => $partInto,
                'Description' => '<div class="font-medium text-gray-900">' . htmlspecialchars($partner['description']) . '</div>',                
                'Type' => '<div class="font-medium text-gray-900">' . htmlspecialchars($partner['type']) . '</div>',                
                'Actions' => '<div class="flex items-center gap-2 justify-center">
                ' . ($allowed['update'] ? '
                <a href="index.php?page=update_partner&id=' . $partner['id'] . '" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>' : '') . '
                ' . ($allowed['delete'] ? '
                <a href="index.php?page=delete_partner&id=' . $partner['id'] . '" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"" title="Supprimer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </a>' : '') . '
            </div>'
            ];
        }
        
        $columns = ["Nom du partenaire", "description", "Type", "Actions"];
        $table = new Table($columns, $data, 'w-full');
        $table->render();

        echo '</div>'; 
        echo '</div>';
        echo '</section>';
    }


    public function create_update_form($partner) {

    $link = $partner === null ? "index.php?page=createPartner" : "index.php?page=updatePartner";
    $action = $partner === null ? "Ajouter" : "Modifier";

    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 max-w-4xl">';
    if ($partner) {
        echo "<div class='mb-6 flex flex-col items-center'>
            <img id='profilePreview' src='{$partner['logo_path']}' 
                 class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
        </div>";
    }

    $form = new Form($link, 'POST', $action, '', '', true);

    $form->addInput('name', 'Nom', $partner['name'] ?? '', 'Nom');
    $form->addInput('type', "Type du partenaire", $partner['type'] ?? '');

    $form->addTextarea('description', 'Description', $partner['description'] ?? '');

    $form->addFile('logo_path', 'Logo du partenaire');

    if ($partner) {
        $form->addHidden('current_logo', $partner['logo_path']??'');
        $form->addHidden('partner_id', $partner['id'] ?? '');
    }

    $form->render();

    echo '</div>';
    echo '</section>';
}
}
?>