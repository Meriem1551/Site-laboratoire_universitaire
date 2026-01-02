<?php
require_once "components/form.php";
class PermissionView{
    public function show_perm_form($permissions, $user_id){
        echo '<section class="min-h-screen py-24 px-12 md:px-8 lg:px-12">';
        echo '<div class="w-full mx-auto">';
        $activeCount = array_sum(array_map(fn($p) => $p['permission_id'] ? 1 : 0, $permissions));
        
        echo '<div class="mb-8 text-center">';
        echo '<h1 class="text-3xl lg:text-4xl font-bold text-[var(--gray-dark)] mb-2">Gestion des permissions utilisateur</h1>';
        echo '<p class="text-[var(--gray)] text-lg mb-4">Sélectionnez les permissions à attribuer</p>';
        
        echo '<div class="inline-flex items-center gap-6 bg-[var(--white)] rounded-xl p-4 shadow-sm border border-gray-200">';
        echo '<div class="text-center">';
        echo '<div class="text-2xl font-bold text-blue-600">' . count($permissions) . '</div>';
        echo '<div class="text-sm text-[var(--gray)]">Permissions disponibles</div>';
        echo '</div>';
        echo '<div class="h-8 w-px bg-gray-300"></div>';
        echo '<div class="text-center">';
        echo '<div class="text-2xl font-bold text-green-600">' . $activeCount . '</div>';
        echo '<div class="text-sm text-[var(--gray)]">Activées actuellement</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
        echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 p-6 md:p-8">';
        
        $form = new Form(
            'index.php?page=give_permission', 
            'POST', 
            'Enregistrer les permissions', 
            'Sélection des permissions', 
            'Cochez les cases pour accorder les permissions correspondantes', 
            true
        );

        foreach($permissions as $permission){
            $displayName = ucwords(str_replace(['_', '.'], ' ', $permission['name']));
            $checked = !empty($permission['permission_id']);
                $form->addCheckbox(
                'permissions[]',
                $displayName,
                $permission['id'],            
                $permission['permission_id'] ? true : false 
            );
        }
        $form->addHidden('user_id', $user_id);
        $form->render();
        
        echo '</div>'; 
        echo '</div>';
        echo '</section>';
    }
}
?>
