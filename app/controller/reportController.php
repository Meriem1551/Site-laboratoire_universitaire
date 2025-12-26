<?php
require_once __DIR__ . '/../../utils/helpers/report_generator.php';

class ReportController {

    public function generate_report() {
        $report_type = $_GET['action'];
        $projects = $_SESSION['projects_for_report'];
        switch ($report_type) {
            case 'by_year':
                $this->generate_by_year($projects);
                break;
            case 'by_theme':
                $this->generate_by_theme($projects);
                break;
            case 'by_supervisor':
                $this->generate_by_supervisor($projects);
                break;
            default:
                echo "Type de rapport inconnu.";
                break;
        }
    }

private function generate_by_year($projects) {
    if (!empty($_SESSION['projects_for_report'])) {
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
    if (!empty($_SESSION['projects_for_report'])) {

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
    if (!empty($_SESSION['projects_for_report'])) {
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
