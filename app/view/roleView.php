<?php
require_once "components/table.php";
require_once "components/form.php";

class RoleView{
    
    public function show_roles($roles, $allowed){
        echo '<section class="min-h-screen py-24 px-12 md:px-8 lg:px-12">';
        echo '<div class="max-w-6xl mx-auto">';
        
        echo '<div class="mb-8">';
        echo '<h1 class="text-3xl lg:text-4xl font-bold text-[var(--gray-dark)] mb-2">Gestion des rôles</h1>';
        echo '<p class="text-[var(--gray)] text-lg">Consultez, ajoutez et gérez les rôles du système</p>';
        echo '</div>';
        
        echo '<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">';
        
    
        echo '<div class="lg:col-span-2">';
        echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 overflow-hidden">';
        
        echo '<div class="px-6 py-4 border-b border-gray-200">';
        echo '<h2 class="text-xl font-bold text-[var(--gray-dark)]">Rôles existants</h2>';
        echo '<p class="text-[var(--gray)] text-sm mt-1">' . count($roles) . ' rôles disponibles</p>';
        echo '</div>';
        
        $data = [];
        foreach($roles as $role) {
            $data[] = [
                'Nom du rôle' => '<div class="font-medium text-[var(--gray-dark)]">' . htmlspecialchars($role['name']) . '</div>',
                'Actions' => '<div class="flex items-center gap-2 justify-end">'
                    . ($allowed['delete']
                        ? '<a href="index.php?page=delete_role&id=' . $role['id'] . '" 
                             class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16"/>
                             </svg>
                           </a>'
                        : '')
                . '</div>'
            ];
        }
        
        if(empty($data)) {
            $data[] = [
                'Nom du rôle' => '<div class="text-center py-8 text-[var(--gray)]">Aucun rôle disponible</div>',
                'Actions' => ''
            ];
        }
        
        $columns = ["Nom du rôle", "Actions"];
        $table = new Table($columns, $data, 'w-full');
        $table->render();

        echo '</div>'; 

        echo "<a href='index.php?page=gestion_users' 
                class='inline-flex items-center text-[var(--primary)] hover:text-blue-800 mt-4 font-medium hover:underline'>
                <svg class='w-4 h-4 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                          d='M10 19l-7-7m0 0l7-7m-7 7h18'/>
                </svg>
                Revenir à la page users
              </a>";

        echo '</div>'; 

        echo '<div class="col-span-2">';
        echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 p-6">';
        echo '<h2 class="text-xl font-bold text-[var(--gray-dark)] mb-6">Ajouter un nouveau rôle</h2>';
        
        $form = new Form(
            'index.php?page=add_role', 
            'POST', 
            'Ajouter le rôle', 
            '', 
            'Remplissez le formulaire ci-dessous pour créer un nouveau rôle'
        );
        
        $form->addInput(
            'name',
            'Nom du rôle',
            '',
            'Ex : Administrateur, Éditeur, etc.',
            'text'
        );
        
        if($allowed['create']){
            $form->render();
        }
        
        echo '</div>';
        echo '</div>'; 
        
        echo '</div>'; 
        echo '</div>';
        echo '</section>';
    }
}
?>
