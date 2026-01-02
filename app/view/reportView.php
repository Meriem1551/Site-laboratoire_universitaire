<?php
require_once "components/form.php";
class ReportView{
    public function show_form(){
        echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-[var(--white)] shadow-lg rounded-lg p-6 max-w-4xl">';

        $form = new Form('index.php?page=report_project', 'POST', 'Generate', 'Generation de rapport','Generer vos rapport par annee, thematique ou superviseur', false);
        $form->addInput('start_date', 'Date debut', '', 'date debut', 'date');
        $form->addInput('end_date', 'Date Fin', '', 'date fin', 'date');
        $form->addSelect('type', 'L\'attribut de generation', ['theme' => 'Thematique', 'year' => 'Annee', 'supervisor'=>'Superviseur'],'');
        $form->render();
    echo "</div>";
    echo "</section>";
    }
    public function show_form_equip(){
         echo '<section class="min-h-screen lg:w-full py-24 px-12">';
            echo '<div class="container mx-auto bg-[var(--white)] shadow-lg rounded-lg p-6 max-w-4xl">';
                $form = new Form('index.php?page=reportEquip', 'POST', 'Generate', 'Generation de rapport','Generer vos rapport de taux d\'utilisation, ou demande d\'equipment', false);
                $form->addInput('start_date', 'Date debut', '', 'date debut', 'date');
                $form->addInput('end_date', 'Date Fin', '', 'date fin', 'date');
                $form->addSelect('type', 'L\'attribut de generation', ['taux' => 'Taux d\'utilisation', 'demande' => 'Demande d\'equipment'],'');
                $form->render();
            echo "</div>";
        echo "</section>";
    }
    public function show_form_pub(){
         echo '<section class="min-h-screen lg:w-full py-24 px-12">';
            echo '<div class="container mx-auto bg-[var(--white)] shadow-lg rounded-lg p-6 max-w-4xl">';
                $form = new Form('index.php?page=reportPub', 'POST', 'Generate', 'Generation de rapport','Generer vos rapport par auteur ou type', false);
                $form->addInput('start_date', 'Date debut', '', 'date debut', 'date');
                $form->addInput('end_date', 'Date Fin', '', 'date fin', 'date');
                $form->addSelect('type', 'L\'attribut de generation', ['author' => 'Auteur', 'year' => 'Annee'],'');
                $form->render();
            echo "</div>";
        echo "</section>";
    }

}
?>
