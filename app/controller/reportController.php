<?php
require_once __DIR__ . '/../../utils/helpers/report_generator.php';
require_once 'app/view/reportView.php';
class ReportController {

    public function show_report_form(){
        $view = new ReportView();
        $view->show_form();
    }
    public function generate_report() {
        $report_type = $_POST['type'];
        $start = strtotime($_POST['start_date']);
        $end   = strtotime($_POST['end_date']);
        $projects = $_SESSION['projects_for_report'];

        $filteredProjects = [];
        foreach ($projects as $project) {
            if (empty($project['start_date'])) continue;

            $projectDate = strtotime($project['start_date']);

            if ($projectDate >= $start && $projectDate <= $end) {
                $filteredProjects[] = $project;
            }
        }
        switch ($report_type) {
            case 'year':
                $this->generate_by_year($filteredProjects);
                break;
            case 'theme':
                $this->generate_by_theme($filteredProjects);
                break;
            case 'supervisor':
                $this->generate_by_supervisor($filteredProjects);
                break;
            default:
                echo "Type de rapport inconnu.";
                break;
        }
    }

private function generate_by_year($projects) {
    if (!empty($projects)) {
        $groupedProjects = [];
        foreach ($projects as $project) {
            $year = !empty($project['start_date']) ? date('Y', strtotime($project['start_date'])) : 'N/A';
            $groupedProjects[$year][] = $project;
        }
        
        generateProjectReportPDF($groupedProjects, 'Rapport des projets par année', 'rapport_projets_par_annee.pdf', 'Année');
    } else {
        echo "Aucune donnée de projet reçue pour générer le rapport.";
    }
}

private function generate_by_theme($projects) {
    if (!empty($projects)) {

        $groupedProjects = [];
        foreach ($projects as $project) {
            $theme = $project['theme'] ?? 'N/A';
            $groupedProjects[$theme][] = $project;
        }
        generateProjectReportPDF($groupedProjects, 'Rapport des projets par thèmatique', 'rapport_projets_par_theme.pdf', 'Thèmatique');
    } else {
        echo "Aucune donnée de projet reçue pour générer le rapport.";
    }
}

private function generate_by_supervisor($projects) {
    if (!empty($projects)) {
        $groupedProjects = [];
        foreach ($projects as $project) {
            $supervisor = $project['supervisor']['first_name'] ?? 'N/A';
            $groupedProjects[$supervisor][] = $project;
        }
        print_r($groupedProjects);
        generateProjectReportPDF($groupedProjects, 'Rapport des projets par superviseur', 'rapport_projets_par_superviseur.pdf', 'Superviseur');
    } else {
        echo "Aucune donnée de projet reçue pour générer le rapport.";
    }
}

}
?>
