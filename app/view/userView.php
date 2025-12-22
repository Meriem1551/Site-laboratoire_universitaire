<?php
require_once "components/form.php";
require_once "components/table.php";
require_once "components/title.php";
require_once "components/card.php";

class UserView {

    public function userForm($user = null, $actionUrl = '', $submitText = '') {
        echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 max-w-4xl">';

    echo "<div class='mb-6 flex flex-col items-center'>
        <img id='profilePreview' src='" . ($user['profile_picture'] ?? 'public/assets/placeholder.jpg') . "' 
             alt='Photo de profil' 
             class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
        <label class='text-gray-600 text-sm'>Changer la photo de profil</label>
      </div>";
    
    $form = new Form(
        'index.php?page=edit_profile', 
        'POST', 
        'Enregistrer', 
        '',
        '', 
        true
    );

    
    $form->addField('profile_picture', 'Photo de profile', 'file', "", 'Choisir un fichier');   
    $form->addField('cv','CV', 'file', 'CV', 'Choisir un fichier');//for the cv

    $form->addField('first_name', 'Prénom', 'text', $user['first_name'] ?? '', 'Prénom');
    $form->addField('last_name', 'Nom', 'text', $user['last_name'] ?? '', 'Nom de famille');
    $form->addField('email', 'Adresse email', 'email', $user['email'] ?? '', 'exemple@domaine.com');
    $form->addField('speciality', 'Spécialité', 'text', $user['speciality'] ?? '', 'Domaine de spécialisation');
    $form->addField('post', 'Poste', 'text', $user['post'] ?? '', 'Poste actuel');
    $form->addField('grade', 'Grade', 'text', $user['grade'] ?? '', 'Grade académique');
    $form->addField('bio', 'Biographie', 'textarea', $user['bio'] ?? '', 'Biographie');
    $form->addField('current_profile_picture', '', 'hidden', $user['profile_picture'] ?? '', '');
    $form->addField('user_id', '', 'hidden', $user['id'], '');
    $form->addField('current_cv', '', 'hidden', $user['cv'] ?? '', '');
    $form->render();
    
    echo '</div>';
    echo '</section>';
    }

    public function show_users($allowed, $users, $allowedRoles) {
        $activeUsers = array_filter($users, fn($user) => $user['status_user'] === 'active');
        $adminUsers = array_filter($users, fn($user) => $user['role'] === 'admin');
        $totalPubs = array_sum(array_column($users, 'nb_pubs'));
        $stats = [
            ['title' => 'Total utilisateurs', 'value' => count($users)],
            ['title' => 'Utilisateurs actifs', 'value' => count($activeUsers)],
            ['title' => 'Administrateurs', 'value' => count($adminUsers)],
            ['title' => 'Publications totales', 'value' => $totalPubs]
        ];
    echo '<section class="min-h-screen py-24 w-full px-12">';
        echo '<div class="mb-10">';
            echo '<h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Gestion des utilisateurs</h1>';
            echo '<p class="text-gray-600 text-lg">Consultez et gérez tous les utilisateurs du système</p>';
    
         echo '<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">';
            foreach($stats as $stat){
                $header = [
                    "<div class='text-sm text-gray-500 mb-1'>{$stat['title']}</div>"
                ];
                $body = [
                    "<div class='text-2xl font-bold text-gray-900'>{$stat['value']}</div>"
                ];
                $card = new Card($header, $body, [], "bg-white rounded-xl p-4 shadow-sm border border-gray-200 ");
                $card->render();
            }
        echo '</div>';
    
    echo '<div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
    
    echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
    echo '<h2 class="text-xl font-bold text-gray-900">Liste des utilisateurs</h2>';
    
    
    echo "<div class='flex gap-6 ml-auto'>";
        if ($allowed['create']) {
            echo '<a href="index.php?page=create_user" class="px-4 py-2 bg-[var(--primary)] text-white font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">';
            echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
            echo '</svg>';
            echo 'Nouvel utilisateur';
            echo '</a>';
        }
        if($allowedRoles['read']){
        echo '<a href="index.php?page=roles" class="px-4 py-2 text-[var(--primary)] font-medium">';
            echo 'Gestion des roles';
        echo '</a>';
        }
    echo "</div>";
    echo '</div>';
    echo '</div>';
    
    $data = [];
    foreach ($users as $user) {
        $statusColor = $user['status_user'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
        $statusIcon = $user['status_user'] === 'active' ? 
            '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>' :
            '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>';
        
        $statusBadge = '<div class="flex items-center justify-center"><span class="px-3 py-1 rounded-full text-xs font-medium ' . $statusColor . ' flex items-center gap-1">' . $statusIcon . ' ' . ucfirst($user['status_user']) . '</span></div>';
        

        
        
        $pubCount = $user['nb_pubs'];
        $pubColor = $pubCount > 10 ? 'text-green-600' : ($pubCount > 0 ? 'text-blue-600' : 'text-gray-600');
        $pubDisplay = '<div class="flex items-center justify-center gap-2"><span class="' . $pubColor . ' font-semibold">' . $pubCount . '</span><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>';
        
        $userInfo = 
        "<div class='flex items-center gap-3'>
                <img src='{$user['profile_picture']}' class='w-10 h-10 rounded-full'>  
            <div>
                <div class='font-semibold text-gray-900'>{$user['first_name']} {$user['last_name']}</div>
                <div class='text-gray-500 text-sm'>" . ($user['email'] ?? '') . "</div>
            </div>
        </div>";

        
        $data[] = [
            'Utilisateur' => $userInfo,
            'Rôle' => $user['role'],
            'Spécialité' => '<div class="text-gray-700 font-medium">' . $user['speciality'] . '</div>',
            'Statut' => $statusBadge,
            'Publications' => $pubDisplay,
            'Actions' => '<div class="flex items-center gap-2 justify-center">
                ' . ($allowed['update'] ? '
                <a href="index.php?page=update_user&id=' . $user['id'] . '" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>' : '') . '
                ' . ($allowed['delete'] ? '
                <a href="index.php?page=delete_user&id=' . $user['id'] . '" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"" title="Supprimer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </a>' : '') . '
            </div>'
        ];
    }
    
    $columns = ["Utilisateur", "Rôle", "Spécialité", "Statut", "Publications", "Actions"];
    $table = new Table($columns, $data, 'w-full');
    $table->render();
    
    
    echo '</div>';
    echo '</section>';
}



public function create_update_form($user, $roles){
    $link = '';
    $action = '';
    if($user === null){
        //creating 
        $link = "index.php?page=createUser";
        $action = "Ajouter";
    }
    else {
        //updating
       $link = "index.php?page=updateUser";
       $action = 'Modifier';
    }
    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
        echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 max-w-4xl">';
        if($user != null){
            echo "<div class='mb-6 flex flex-col items-center'>
                <img id='profilePreview' src='" . ($user['profile_picture'] ?? '') . "' 
                    alt='Photo de profil' 
                    class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
                <label class='text-gray-600 text-sm'>Changer la photo de profil</label>
            </div>";
        }
        
        $rolesOptions = [];
        foreach ($roles as $role) {
            $rolesOptions[$role['name']] = ucfirst($role['name']);
        }
        $form = new Form($link, 'POST', $action, '', '', true);
        $form->addField('first_name', 'Nom', 'text', $user['first_name'] ?? '', 'Nom');
        $form->addField('last_name', 'Prenom', 'text', $user['last_name'] ?? '', 'Prenom');
        $form->addField('email', 'Adresse email', 'email', $user['email'] ?? '', 'exemple@domaine.com');
        $form->addField('username', 'Nom d\'utilisateur', 'text', $user['username'] ?? '', '');
        $form->addField('role', 'role', 'select', $user['role'] ?? '', '', $rolesOptions);

        $form->addField(
            'status', 
            "Etat de l'utilisateur (actif ou non-actif)", 
            'checkbox', 
            (isset($user['status_user']) && $user['status_user'] === 'active') ? 'checked' : '', 
            ''
        );
        $form->addField('pw', 'Mot de pass', 'password', $user['password'] ?? '', '');
        $form->addField('confirme', 'Confirme Le mot de pass', 'password', $user['password'] ?? '', '');
        $form->addField('speciality', 'Spécialité', 'text', $user['speciality'] ?? '', 'Domaine de spécialisation');
        $form->addField('post', 'Poste', 'text', $user['post'] ?? '', 'Poste actuel');
        $form->addField('bio', 'Biographie', 'textarea', $user['bio'] ?? '', 'Biographie');
        $form->addField('grade', 'Grade', 'text', $user['grade'] ?? '', 'Grade académique');
        $form->addField('profile_picture', 'Photo de profile', 'file', "", 'Choisir un fichier');   
        $form->addField('cv','CV', 'file', 'CV', 'Choisir un fichier');
        if($user !== null){
            $form->addField('current_profile_picture', '', 'hidden', $user['profile_picture'] ?? '', '');
            $form->addField('user_id', '', 'hidden', $user['id'], '');
            $form->addField('current_cv', '', 'hidden', $user['cv'] ?? '', '');
        }
        //add permissions
        $form->render();

        //form of permissions
        
        echo '</div>';
    echo '</section>';
}
}
?>
