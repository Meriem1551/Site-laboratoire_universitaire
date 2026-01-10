<?php
require_once "components/form.php";
require_once "components/table.php";
require_once "components/title.php";
require_once "components/card.php";
require_once "components/filterManager.php";
require_once "components/userCard.php";

class UserView {

    public function userForm($user = null, $actionUrl = '', $submitText = '') {
    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-[var(--white)] shadow-lg rounded-lg p-6 max-w-4xl">';

    echo "<div class='mb-6 flex flex-col items-center'>
        <img id='profilePreview' src='" . ($user['profile_picture'] ?? 'public/assets/placeholder.jpg') . "' 
             class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
        <label class='text-[var(--gray)] text-sm'>Changer la photo de profil</label>
    </div>";

    $form = new Form(
        'index.php?page=edit_profile',
        'POST',
        'Enregistrer',
        '',
        '',
        true
    );

    $form->addFile('profile_picture', 'Photo de profil');
    $form->addFile('cv', 'CV');

    $form->addInput('first_name', 'Prénom', $user['first_name'] ?? '', 'Prénom');
    $form->addInput('last_name', 'Nom', $user['last_name'] ?? '', 'Nom de famille');
    $form->addInput('email', 'Adresse email', $user['email'] ?? '', 'exemple@domaine.com', 'email');
    $form->addInput('speciality', 'Spécialité', $user['speciality'] ?? '', 'Domaine de spécialisation');
    $form->addInput('post', 'Poste', $user['post'] ?? '', 'Poste actuel');
    $form->addInput('grade', 'Grade', $user['grade'] ?? '', 'Grade académique');
    $form->addTextarea('bio', 'Biographie', $user['bio'] ?? '', 'Biographie');

    $form->addHidden('current_profile_picture', $user['profile_picture'] ?? '');
    $form->addHidden('current_cv', $user['cv'] ?? '');
    $form->addHidden('user_id', $user['id'] ?? '');

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
            echo '<h1 class="text-3xl lg:text-4xl font-bold text-[var(--gray-dark)] mb-2">Gestion des utilisateurs</h1>';
            echo '<p class="text-[var(--gray)] text-lg">Consultez et gérez tous les utilisateurs du système</p>';
    
         echo '<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4 mb-5">';
            foreach($stats as $stat){
                $header = [
                    "<div class='text-sm text-[var(--gray)] mb-1'>{$stat['title']}</div>"
                ];
                $body = [
                    "<div class='text-2xl font-bold text-[var(--gray-dark)]'>{$stat['value']}</div>"
                ];
                $card = new Card($header, $body, [], "bg-[var(--white)] rounded-xl p-4 shadow-sm border border-gray-200 ");
                $card->render();
            }
        echo '</div>';
        $allStatuses = [];
        $allRoles = [];
        $allSpecialities = [];
        $allPubRanges = [
             '0' => '0',
            '1-5' => '1–5',
            '6-10' => '6–10',
            '10+' => '10+'
        ];
        $filterManager = FilterManager::getInstance();

foreach ($users as $user) {
    if (!in_array($user['status_user'], $allStatuses)) {
        $allStatuses[] = $user['status_user'];
    }

    if (!in_array($user['role'], $allRoles)) {
        $allRoles[] = $user['role'];
    }

    if (!empty($user['speciality']) && !in_array($user['speciality'], $allSpecialities)) {
        $allSpecialities[] = $user['speciality'];
    }
}

 $filterManager->reset();

$filterManager->addFilter(
    'status',
    'Statut',
    array_combine($allStatuses, $allStatuses),
    'Tous les statuts',
    '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>'
);

$filterManager->addFilter(
    'role',
    'Rôle',
    array_combine($allRoles, $allRoles),
    'Tous les rôles',
    '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
    </svg>'
);

$filterManager->addFilter(
    'speciality',
    'Spécialité',
    array_combine($allSpecialities, $allSpecialities),
    'Toutes les spécialités',
    '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
            </svg>'
);

$filterManager->addFilter(
    'publications',
    'Publications',
    $allPubRanges,
    'Toutes',
    '<svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
            </svg>'
);

$filterManager->renderFilterSection(
    "Filtrer les utilisateurs",
    "Sélectionnez vos critères de filtrage"
);
   
    echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8 ">';
    
    echo '<div class="px-6 py-4 border-b border-gray-200 flex flex-col rounded-lg sm:flex-row sm:items-center sm:justify-between gap-4">';
    echo '<h2 class="text-xl font-bold text-[var(--gray-dark)]">Liste des utilisateurs</h2>';
    
    
    echo "<div class='flex gap-6 ml-auto'>";
        if ($allowed['create']) {
            echo '<a href="index.php?page=create_user" class="px-4 py-2 bg-[var(--primary)] text-[var(--white)] font-medium rounded-lg hover:bg-[var(--primary-light)] transition-colors flex items-center gap-2">';
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
        $pubColor = $pubCount > 10 ? 'text-[var(--gray)]' : ($pubCount > 0 ? 'text-blue-600' : 'text-[var(--gray)]');
        $pubDisplay = '<div class="flex items-center justify-center gap-2"><span class="' . $pubColor . ' font-semibold">' . $pubCount . '</span><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>';
        
        $userInfo = 
        "<div class='flex items-center gap-3'>
                <img src='{$user['profile_picture']}' class='w-10 h-10 rounded-full'>  
            <div>
                <div class='font-semibold text-[var(--gray-dark)]'>{$user['first_name']} {$user['last_name']}</div>
                <div class='text-[var(--gray)] text-sm'>" . ($user['email'] ?? '') . "</div>
            </div>
        </div>";

        $pubCount = (int)$user['nb_pubs'];

if ($pubCount === 0) $pubRange = '0';
elseif ($pubCount <= 5) $pubRange = '1-5';
elseif ($pubCount <= 10) $pubRange = '6-10';
else $pubRange = '10+';
        
        $data[] = [
            'Utilisateur' => $userInfo,
            'Rôle' => $user['role'],
            'Spécialité' => '<div class="text-[var(--gray-dark)] font-medium">' . $user['speciality'] . '</div>',
            'Statut' => $statusBadge,
            'Publications' => $pubDisplay,
            'Actions' => '<div class="flex items-center gap-2 justify-center">
                ' . ($allowed['update'] ? '
                <a href="index.php?page=update_user&id=' . $user['id'] . '" class="p-2 text-[var(--gray-dark)] hover:bg-green-50 rounded-lg transition-colors" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
                <a href="index.php?page=gestion_perm&id=' . $user['id'] . '" 
                    class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Gérer les permissions">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </a>
                ' : '') . '
                    
                ' . ($allowed['delete'] ? '
                <a href="index.php?page=delete_user&id=' . $user['id'] . '" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"" title="Supprimer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </a>' : '') . '
                
            </div>',
           'rowClass' => 'filterable-item',
            'rowData' => htmlspecialchars(json_encode([
                'status' => $user['status_user'],
                'role' => $user['role'],
                'speciality' => $user['speciality'],
                'publications' => $pubRange
            ]), ENT_QUOTES, 'UTF-8')
        ];
    }
    
    $columns = ["Utilisateur", "Rôle", "Spécialité", "Statut", "Publications", "Actions"];
    $table = new Table($columns, $data, 'w-full');
    $table->render();
    echo $filterManager->getFilterJS('usersContainer','.filterable-item','noResults');
    
    echo '</div>';
    echo '</section>';
     echo '
    <style>
    .filter-group {
        min-width: 200px;
    }
    
    .filter-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3e%3cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M6 8l4 4 4-4\'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .filter-select:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
    }
    
    .filter-clear-btn {
        height: fit-content;
        transition: all 0.2s;
    }
    
    .filter-clear-btn:hover {
        background-color: #e5e7eb;
    }
    
    .filterable-item {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .pagination-item {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    </style>';
}



public function create_update_form($user, $roles, $errors) {

    $link = $user === null ? "index.php?page=createUser" : "index.php?page=updateUser";
    $action = $user === null ? "Ajouter" : "Modifier";

    $text = "";
    if(!empty($errors)){
        foreach($errors as $error){
            $text .= "<p class='text-[var(--error)] text-md text-center pb-2'>{$error}</p>";
        }
    }
   

    echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-[var(--white)] shadow-lg rounded-lg p-6 max-w-4xl">';

    if ($user) {
        echo "<div class='mb-6 flex flex-col items-center'>
            <img id='profilePreview' src='{$user['profile_picture']}' 
                 class='w-24 h-24 rounded-full mb-4 border border-gray-300'>
            <label class='text-[var(--gray)] text-sm'>Changer la photo de profil</label>
        </div>";
    }

    $rolesOptions = [];
    foreach ($roles as $role) {
        $rolesOptions[$role['name']] = ucfirst($role['name']);
    }

    $form = new Form($link, 'POST', $action, '', $text, true);

    $form->addInput('first_name', 'Nom', $user['first_name'] ?? '', 'Nom');
    $form->addInput('last_name', 'Prénom', $user['last_name'] ?? '', 'Prénom');
    $form->addInput('email', 'Adresse email', $user['email'] ?? '', 'exemple@domaine.com', 'email');
    $form->addInput('username', "Nom d'utilisateur", $user['username'] ?? '');

    $form->addSelect('role', 'Rôle', $rolesOptions, $user['role'] ?? '');

    $form->addCheckbox(
        'status',
        "Utilisateur actif",
        $user['status_user']??'',
        isset($user['status_user']) && $user['status_user'] === 'active'
    );

    $form->addInput('pw', 'Mot de passe', '', '', 'password');
    $form->addInput('confirme', 'Confirmer le mot de passe', '', '', 'password');

    $form->addInput('speciality', 'Spécialité', $user['speciality'] ?? '');
    $form->addInput('post', 'Poste', $user['post'] ?? '');
    $form->addTextarea('bio', 'Biographie', $user['bio'] ?? '');
    $form->addInput('grade', 'Grade', $user['grade'] ?? '');

    $form->addFile('profile_picture', 'Photo de profil');
    $form->addFile('cv', 'CV');

    if ($user) {
        $form->addHidden('current_profile_picture', $user['profile_picture']);
        $form->addHidden('current_cv', $user['cv'] ?? '');
        $form->addHidden('user_id', $user['id'] ?? '');
    }

    $form->render();

    echo '</div>';
    echo '</section>';
}

public function show_members($users, $project_members){
        $id_project = $_GET['id'];
        echo '<section class="min-h-screen py-24 px-12 md:px-8 lg:px-12">';
        echo '<div class="max-w-6xl mx-auto">';
        echo '<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">';
        
    
        echo '<div class="lg:col-span-2">';
        echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 overflow-hidden">';
        
        echo '<div class="px-6 py-4 border-b border-gray-200">';
        echo '<h2 class="text-xl font-bold text-[var(--gray-dark)]">Membres de projet</h2>';
        echo '<p class="text-[var(--gray)] text-sm mt-1">' . count($project_members) . ' membres disponibles</p>';
        echo '</div>';
        $data = [];
        foreach($project_members as $member) { 
            $data[] = [
                'Nom du membre' => '<div class="font-medium text-[var(--gray-dark)] flex justify-center gap-2">' .'<img src="' . htmlspecialchars($member['profile_picture']) . '" alt="Logo du partenaire" class="ml-2 rounded-lg w-8 h-8 inline-block">'. htmlspecialchars($member['first_name']) ." " . htmlspecialchars($member['last_name']) . '</div>',
                'Actions' => '<div class="flex items-center gap-2 justify-end">
                <a href="index.php?page=delete_member&id_project=' . $id_project . '&id_member=' . $member['id'] . '" 
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
                'Membre' => '<div class="text-center py-8 text-[var(--gray)]">Aucun membre disponible</div>',
                'Actions' => ''
            ];
        }
        
        $columns = ["Membre", "Actions"];
        $table = new Table($columns, $data, 'w-full');
        $table->render();

        echo '</div>'; 
        $previous = $_SERVER['HTTP_REFERER'];
        echo "<a href='$previous'
                class='inline-flex items-center text-[var(--primary)] hover:text-blue-800 mt-4 font-medium hover:underline'>
                <svg class='w-4 h-4 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 19l-7-7m0 0l7-7m-7 7h18'/>
                </svg>
                Revenir à la page
              </a>";

        echo '</div>'; 

        echo '<div class="col-span-2">';
        echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 p-6">';
        echo '<h2 class="text-xl font-bold text-[var(--gray-dark)] mb-6">Ajouter un membre</h2>';
        
        $form = new Form(
            'index.php?page=add_member&id_project=' . $id_project, 
            'POST', 
            'Ajouter le membre',
            '', 
            'Remplissez le formulaire ci-dessous pour ajouter un membre'
        );

        $members = array_reduce($users, function($acc, $user) {
                $acc[$user['id']] = $user['first_name'].' '.$user['last_name'];
                return $acc;
        }, []);

        $form->addSelect(
            'member_id',
            'Sélectionner un membre',
            $members,
            '',
        );
        $form->render();
        echo '</div>';
        echo '</div>'; 
        
        echo '</div>'; 
        echo '</div>';
        echo '</section>';
    }



    public function show_team_members($users, $team_members){
        $id_team = $_GET['id'];
        echo '<section class="min-h-screen py-24 px-12 md:px-8 lg:px-12">';
        echo '<div class="max-w-6xl mx-auto">';
        echo '<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">';
        
    
        echo '<div class="lg:col-span-2">';
        echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 overflow-hidden">';
        
        echo '<div class="px-6 py-4 border-b border-gray-200">';
        echo '<h2 class="text-xl font-bold text-[var(--gray-dark)]">Membres de projet</h2>';
        echo '<p class="text-[var(--gray)] text-sm mt-1">' . count($team_members) . ' membres disponibles</p>';
        echo '</div>';
        $data = [];
        foreach($team_members as $member) { 
            $data[] = [
                'Nom du membre' => '<div class="font-medium text-[var(--gray-dark)] flex justify-center gap-2">' .'<img src="' . htmlspecialchars($member['profile_picture']) . '" alt="Logo du partenaire" class="ml-2 rounded-lg w-8 h-8 inline-block">'. htmlspecialchars($member['first_name']) ." " . htmlspecialchars($member['last_name']) . '</div>',
                'Actions' => '<div class="flex items-center gap-2 justify-end">
                <a href="index.php?page=delete_team_member&id_team=' . $id_team . '&id_member=' . $member['id'] . '" 
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
                'Membre' => '<div class="text-center py-8 text-[var(--gray)]">Aucun membre disponible</div>',
                'Actions' => ''
            ];
        }
        
        $columns = ["Membre", "Actions"];
        $table = new Table($columns, $data, 'w-full');
        $table->render();

        echo '</div>'; 
        echo "<a href='index.php?page=gestion_equipes'
                class='inline-flex items-center text-[var(--primary)] hover:text-blue-800 mt-4 font-medium hover:underline'>
                <svg class='w-4 h-4 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 19l-7-7m0 0l7-7m-7 7h18'/>
                </svg>
                Revenir à la page
              </a>";

        echo '</div>'; 

        echo '<div class="col-span-2">';
        echo '<div class="bg-[var(--white)] rounded-2xl shadow-lg border border-gray-200 p-6">';
        echo '<h2 class="text-xl font-bold text-[var(--gray-dark)] mb-6">Ajouter un membre</h2>';
        
        $form = new Form(
            'index.php?page=add_team_member&id_team=' . $id_team, 
            'POST', 
            'Ajouter le membre',
            '', 
            'Remplissez le formulaire ci-dessous pour ajouter un membre'
        );

        $members = array_reduce($users, function($acc, $user) {
                $acc[$user['id']] = $user['first_name'].' '.$user['last_name'];
                return $acc;
        }, []);

        $form->addSelect(
            'member_id',
            'Sélectionner un membre',
            $members,
            '',
        );
        $form->render();
        echo '</div>';
        echo '</div>'; 
        
        echo '</div>'; 
        echo '</div>';
        echo '</section>';
    }

    private function render_publications($publications){
           $pubBody = [];
if (!empty($publications)) {
    $pubContent = '<div class="grid md:grid-cols-2 gap-6">';
    $borderColors = [
        'border-t-8 border-blue-500',
        'border-t-8 border-purple-500',
        'border-t-8 border-emerald-500',
        'border-t-8 border-amber-500'
    ];
    
    foreach ($publications as $index => $pub) {

        $borderColor = $borderColors[$index % count($borderColors)];
        $pubContent .= '
        <div class="bg-[var(--white)] '. $borderColor .' rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-[var(--primary)]">
                    ' . $pub['type'] .  '
                </span>
                <span class="text-sm text-[var(--gray)]">
                    ' . $pub['publication_date'] . '
                </span>
            </div>
            
            <h4 class="font-bold text-[var(--gray-dark)] mb-2">
                ' . $pub['title'] . '
            </h4>
            
            <p class="text-[var(--gray)] text-sm mb-4">
                ' . substr(strip_tags($pub['abstract']), 0, 100) . '...
            </p>
            
            <div class="flex items-center gap-2">
                <p class="font-medium text-[var(--gray-dark)]">Domain: </p>
                <span class="text-sm text-[var(--gray)]">
                    ' . $pub['domain'] . '
                </span>
                
            </div>
            <div class="flex items-center gap-2">
                <p class="font-medium text-[var(--gray-dark)]">DOI: </p>
                <span class="text-sm text-[var(--gray)]">
                    ' . $pub['doi'] . '
                </span>
                
            </div>
            <div class="flex justify-end gap-2">
            <a class="text-[var(--primary)]" href="index.php?page=publication&id=' . $pub['id'] . '">Voir détails</a>
            </div>
        </div>';
    }
    
    $pubContent .= '</div>';
    
    $pubCard = new Card(
        ["<div class='flex items-center justify-between mb-8 pb-6 border-b border-gray-200'>
                    <span class='px-4 py-2 bg-blue-100 text-[var(--primary-light)] text-sm font-medium rounded-full'>
                        " . count($publications) . " publications
                    </span>
                </div>"],
        [$pubContent],
        [],
        'bg-[var(--white)] rounded-xl shadow-lg border border-gray-200 p-6'
    );
    
    echo $pubCard->render();
} else {
    echo '<div class="text-center p-8 text-[var(--gray)]">
        <p>Aucune publication disponible</p>
    </div>';
    }
}
    public function show_member($member){
             echo '<section class="py-24 px-24 min-h-screen">';
            echo '<div class="container mx-auto px-4 max-w-7xl">';

                     $userCard = new UserCard(
                        $member['first_name'], 
                        $member['last_name'], 
                        $member['role'], 
                        $member['status_user'], 
                        $member['profile_picture'], 
                        $member['email'], 
                        $member['speciality'],
                        $member['post'], 
                        $member['grade'],
                        $member['bio']
                    );
                    $userCard->render();

                    echo '<div class="space-y-10">';
                        $this->render_publications($member['publications']);
                        $previous = $_SERVER['HTTP_REFERER'];
                        echo '<div class="pt-8">';
                            echo "<a href='$previous' class='inline-flex items-center px-6 py-3 text-[var(--gray-dark)] font-medium rounded-lg hover:bg-gray-50'>
                                <svg class='w-5 h-5 mr-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 19l-7-7m0 0l7-7m-7 7h18'/>
                                </svg>
                                Retour a la page
                            </a>";
                        echo '</div>';
                    echo '</div>';

            echo '</div>';
        echo '</section>';
    }
}
?>
