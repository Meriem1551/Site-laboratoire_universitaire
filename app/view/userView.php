<?php
require_once "components/form.php";

class UserView {

    public function userForm($user = null, $actionUrl = 'index.php?page=edit_profile', $submitText = 'Enregistrer') {
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
        'Enregistrer les modifications', 
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
}
?>
