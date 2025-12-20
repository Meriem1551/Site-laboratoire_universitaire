<?php
require_once "components/form.php";
require_once "components/title.php";

class ContactView{
    public function show_form(){

        echo '<section class="py-24 px-4 md:px-8">';
        
        echo '<div class="text-center mb-16">';
        $title = (new Title("Contactez-nous", "text-4xl font-bold text-gray-900 mb-6", "h1"))->render();
        echo $title;
        echo '    <p class="text-gray-600 text-lg max-w-2xl mx-auto">Nous sommes ravis de vous entendre. Remplissez le formulaire et nous vous répondrons rapidement.</p>';
        echo '</div>';
        
        
        $formText = '<p class="text-gray-600 mb-8 text-center">Merci de remplir tous les champs obligatoires pour nous permettre de mieux vous répondre.</p>';
        
        $form = new Form(
            'index.php?page=contact&action=send_message',
            'POST', 
            'Envoyer votre message', 
            'Formulaire de contact',
            $formText,
            true
        );
        
        $form->addField('nom', 'Nom', 'text', '', 'Votre nom');
        $form->addField('prenom', 'Prénom', 'text', '', 'Votre prénom');
        $form->addField('email', 'Adresse email', 'email', '', 'exemple@email.com');
        $form->addField('sujet', 'Sujet', 'text', '', 'Objet de votre message');
        $form->addField('message', 'Message', 'textarea', '', 'Votre message détaillé...');
    
        
        $form->render();
        
        echo '<div class="mt-10 pt-8 text-center">';
        echo '    <p class="text-gray-600 mb-4">Vous pouvez aussi nous contacter directement :</p>';
        echo '    <div class="flex justify-center gap-6">';
        echo '        <a href="#" class="inline-flex items-center text-[var(--primary)] hover:text-[var(--primary-light)] font-medium">';
        echo '            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">';
        echo '                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>';
        echo '                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>';
        echo '            </svg>';
        echo '            contact@laboratoire.com';
        echo '        </a>';
        echo '    </div>';
        echo '</div>';
        
        echo '</section>';
    }
}
?>