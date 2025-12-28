<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Mpdf\Mpdf;

function generateProjectReportPDF($groupedProjects, $title = 'Rapport des projets', $filename = 'rapport.pdf', $groupLabel) {
    $mpdf = new \Mpdf\Mpdf();

    $html = "<h1 style='text-align:center;'>$title</h1>";
    $html .= "<table border='1' cellpadding='5' cellspacing='0' style='width:100%; border-collapse: collapse;'>";
    $html .= "<thead>
                <tr>";
                    if ($groupLabel) {
                        $html .= "<th>$groupLabe</th>";
                    }
                    if($groupLabel==='Année'){
                        $html.= "<th>Titre</th>
                            <th>Thème</th>
                            <th>Superviseur</th>
                            <th>Membres</th>
                            <th>Partenaires</th>
                            <th>Publications</th>
                        </tr>";
                    }else if($groupLabel==='Thèmatique'){
                        $html.= "<th>Titre</th>
                            <th>Année</th>
                            <th>Superviseur</th>
                            <th>Membres</th>
                            <th>Partenaires</th>
                            <th>Publications</th>
                        </tr>";
                    }else if($groupLabel==='Superviseur'){
                        $html.= "<th>Titre</th>
                            <th>Thème</th>
                            <th>Année</th>
                            <th>Membres</th>
                            <th>Partenaires</th>
                            <th>Publications</th>
                        </tr>";
                    }
    $html .= "</thead>";
                    
                
    $html .= "<tbody>";

    foreach ($groupedProjects as $groupName => $projects) {
        $groupRowCount = 0;
        foreach ($projects as $project) {
            $members = $project['members'] ?? [];
            $partners = $project['partners'] ?? [];
            $publications = $project['publications'] ?? [];
            $groupRowCount += max(count($members), count($partners), count($publications), 1);
        }

        $groupPrinted = false;

        foreach ($projects as $project) {
            $members = $project['members'] ?? [];
            $partners = $project['partners'] ?? [];
            $publications = $project['publications'] ?? [];

            $rowCount = max(count($members), count($partners), count($publications), 1);

            for ($i = 0; $i < $rowCount; $i++) {
                $html .= "<tr>";

                if (!$groupPrinted) {
                    $html .= "<td rowspan='$groupRowCount'>$groupName</td>";
                    $groupPrinted = true;
                }

                if ($i === 0) {

                    $html .= "<td rowspan='$rowCount'>{$project['title']}</td>";
                    if($groupLabel==='Année'){
                        $html .= "<td rowspan='$rowCount'>{$project['theme']}</td>";
                        $html .= "<td rowspan='$rowCount'>{$project['supervisor']['first_name']}</td>";
                    }else if($groupLabel==='Thèmatique'){
                        $html .= "<td rowspan='$rowCount'>" . (!empty($project['start_date']) ? date('Y', strtotime($project['start_date'])) : '') . "</td>";
                        $html .= "<td rowspan='$rowCount'>{$project['supervisor']['first_name']}</td>";
                    }else if($groupLabel==='Superviseur'){
                    $html .= "<td rowspan='$rowCount'>{$project['theme']}</td>";
                    $html .= "<td rowspan='$rowCount'>" . (!empty($project['start_date']) ? date('Y', strtotime($project['start_date'])) : '') . "</td>";
                    }
                }
                $html .= "<td>" . ($members[$i]['first_name'] ?? ($members[$i]['last_name'] ?? '')) . "</td>";
                $html .= "<td>" . ($partners[$i]['name'] ?? '') . "</td>";
                $html .= "<td>" . ($publications[$i]['title'] ?? '') . "</td>";

                $html .= "</tr>";
            }
        }
    }

    $html .= "</tbody></table>";

    if (ob_get_length()) ob_end_clean();
    $mpdf->WriteHTML($html);
    $mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
}

function generateEquipReportPDF($data, $title, $file){
        $mpdf = new \Mpdf\Mpdf();

    $html = "<h1 style='text-align:center;'>$title</h1>";
    $html .= "<table border='1' cellpadding='5' cellspacing='0' style='width:100%; border-collapse: collapse;'>";
    $html .= "<thead>
                <tr>";
                    $html.= "<th>Nom d'equipment</th>
                    <th>{$title}</th>
                </tr>";
    $html .= "</thead>"; 
    $html .= "<tbody>";

    foreach ($data as $row) {
               $html .= "<tr>";
                $html .= "<td>" . ($row['equipment'] ?? '') . "</td>";
                $html .= "<td>" . ($row['value'] ?? '') . "</td>";
                $html .= "</tr>";
        } 

    $html .= "</tbody></table>";

    if (ob_get_length()) ob_end_clean();
    $mpdf->WriteHTML($html);
    $mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
}

?>
