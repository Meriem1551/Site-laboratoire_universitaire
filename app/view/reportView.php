<?php
require_once "components/form.php";
class ReportView{
    public function show_form(){
        echo '<section class="min-h-screen lg:w-full py-24 px-12">';
    echo '<div class="container mx-auto bg-white shadow-lg rounded-lg p-6 max-w-4xl">';

        $form = new Form('index.php?page=report_project', 'POST', 'Generate', 'Generation de rapport','Generer vos rapport par annee, thematique ou superviseur', false);
        $form->addInput('start_date', 'Date debut', '', 'date debut', 'date');
        $form->addInput('end_date', 'Date Fin', '', 'date fin', 'date');
        $form->addSelect('type', 'L\'attribut de generation', ['theme' => 'Thematique', 'year' => 'Annee', 'supervisor'=>'Superviseur'],'');
        $form->render();
    echo "</div>";
    echo "</section>";
    }
}
?>
