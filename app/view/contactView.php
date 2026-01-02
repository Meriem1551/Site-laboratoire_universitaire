<?php
require_once "components/form.php";
require_once "components/title.php";

class ContactView {
    public function show_form() {

        echo '<section class="py-24 px-4 md:px-8">';

        echo '<div class="text-center mb-16">';
        $title = (new Title("Contactez-nous", "text-4xl font-bold text-[var(--gray-dark)] mb-6", "h1"))->render();
        echo $title;
        echo '<p class="text-[var(--gray)] text-lg max-w-2xl mx-auto">Nous sommes ravis de vous entendre. Remplissez le formulaire et nous vous répondrons rapidement.</p>';
        echo '</div>';

        $formText = '<p class="text-[var(--gray)] mb-8 text-center">Merci de remplir tous les champs obligatoires pour nous permettre de mieux vous répondre.</p>';

        $form = new Form(
            'index.php?page=contact&action=send_message',
            'POST',
            'Envoyer votre message',
            'Formulaire de contact',
            $formText,
            true
        );

        $form->addInput('nom', 'Nom', '', 'Votre nom', 'text');
        $form->addInput('prenom', 'Prénom', '', 'Votre prénom', 'text');
        $form->addInput('email', 'Adresse email', '', 'exemple@email.com', 'email');
        $form->addInput('sujet', 'Sujet', '', 'Objet de votre message', 'text');
        $form->addTextarea('message', 'Message', '', 'Votre message détaillé...');

        $form->render();

        echo '</section>';
    }
}
?>
