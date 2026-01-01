<?php
require_once __DIR__ . '/../../utils/helpers/report_generator.php';
require_once 'app/view/reportView.php';
require_once 'app/model/reservationModel.php';

class ReportController {

    public function show_report_form(){
        $view = new ReportView();
        $view->show_form();
    }
    public function show_report_form_equip(){
        $view = new ReportView();
        $view->show_form_equip();
    }
    public function show_report_form_pub(){
        $view = new ReportView();
        $view->show_form_pub();
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

    public function generate_report_equip(){
        $report_type = $_POST['type'];
        $start = strtotime($_POST['start_date']);
        $end   = strtotime($_POST['end_date']);
         $model =  new ReservationModel();
        $reservations = $model->getAllreservations();
        $filtered = array_filter($reservations, function($res) use ($start, $end) {
            $resStart = strtotime($res['start_datetime']);
            $resEnd   = strtotime($res['end_datetime']);
            return ($resStart <= $end && $resEnd >= $start);
        });
        switch ($report_type) {
            case 'taux':
                $this->generate_by_taux($filtered, $start, $end);
                break;
            case 'demande':
                $this->generate_by_demande($filtered);
                break;
            default:
                echo "Type de rapport inconnu.";
                break;
        }
    }
    public function generate_report_pub(){
    $report_type = $_POST['type'];
        $start = strtotime($_POST['start_date']);
        $end   = strtotime($_POST['end_date']);
        $publications = $_SESSION['pubs_for_report'];
        $filteredPubs = [];
        foreach ($publications as $pub) {
            if (empty($pub['publication_date'])) continue;
            $pubDate = strtotime($pub['publication_date']);

            if ($pubDate >= $start && $pubDate <= $end) {
                $filteredPubs[] = $pub;
            }
        }
        switch ($report_type) {
            case 'year':
                $this->generate_by_year_pub($filteredPubs);
                break;
            case 'author':
                $this->generate_by_author($filteredPubs);
                break;
            default:
                echo "Type de rapport inconnu.";
                break;
        }
}

private function generate_by_taux($reservations, $start, $end){
    $usage = [];
    foreach ($reservations as $res) {
        $equip = $res['name'];
        $resStart = strtotime($res['start_datetime']);
        $resEnd   = strtotime($res['end_datetime']);
        $duration = $resEnd - $resStart;

        if (!isset($usage[$equip])) {
            $usage[$equip] = 0;
        }
        $usage[$equip] += $duration;
    }

    $periodSeconds = $end - $start;
    $data = [];
    foreach ($usage as $equip => $reservedSeconds) {
        $taux = ($reservedSeconds / $periodSeconds) * 100;
        $data[] = [
            'equipment' => $equip,
            'value' => round($taux, 2)
        ];
    }
        generateEquipReportPDF($data, 'Taux d\'utilisation des equipemens', 'rapport_taux.pdf');
}

private function generate_by_demande($reservations){
    $counts = [];
    foreach ($reservations as $res) {
        $equipName = $res['name'];
        if (!isset($counts[$equipName])) $counts[$equipName] = 0;
        $counts[$equipName]++;
    }

    $data = [];
    foreach ($counts as $equip => $count) {
        $data[] = [
            'equipment' => $equip,
            'value' => $count
        ];
    }
    generateEquipReportPDF($data, 'Nombre de demande des equipemens', 'rapport_demande.pdf');
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
        generateProjectReportPDF($groupedProjects, 'Rapport des projets par superviseur', 'rapport_projets_par_superviseur.pdf', 'Superviseur');
    } else {
        echo "Aucune donnée de projet reçue pour générer le rapport.";
    }
}



private function generate_by_year_pub($pubs) {
    if (!empty($pubs)) {

        $groupedPubs = [];
        foreach ($pubs as $pub) {
             $year = !empty($pub['publication_date']) ? date('Y', strtotime($pub['publication_date'])) : 'N/A';
            $groupedPubs[$year][] = $pub;
        }
        generatePubReportPDF($groupedPubs, 'Rapport des publication par annee', 'rapport_pub_par_annee.pdf', 'Annee');
    } else {
        echo "Aucune donnée de publication reçue pour générer le rapport.";
    }
}

private function generate_by_author($pubs) {
    if (!empty($pubs)) {
        $groupedPubs = [];
        foreach ($pubs as $pub) {
            $authors = $pub['authors'] ?? ['N/A'];
            foreach ($authors as $author) {
                $groupedPubs[$author][] = $pub;
            }
        }
        generatePubReportPDF($groupedPubs, 'Rapport des publications par auteur', 'rapport_pub_par_auteur.pdf', 'Auteur');
    } else {
        echo "Aucune donnée de publication reçue pour générer le rapport.";
    }
}


}
?>
