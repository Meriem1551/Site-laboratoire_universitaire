<?php
class LineChart {
    public function render($data,$labels, $color, $bgColor, $label='Nombre de réservations', $xtext='Mois', $ytext='Nombre de réservations') {

        echo '<div class="max-w-4xl mx-auto">';
        echo '<canvas id="lineChart"></canvas>';
        echo '</div>';

        $data_json = json_encode($data);
        $labels_json = json_encode($labels);

        $color_js = json_encode($color);
        $bgColor_js = json_encode($bgColor);

        $label_js = json_encode($label);
        $xtext_js = json_encode($xtext);
        $ytext_js = json_encode($ytext);

        echo <<<HTML
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('lineChart').getContext('2d');
    const reservationChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: $labels_json,
            datasets: [{
                label: $label_js,
                data: $data_json,
                backgroundColor: $bgColor_js,
                borderColor: $color_js,
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: $color_js,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: $ytext_js
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: $xtext_js
                    }
                }
            }
        }
    });
</script>
HTML;
    }
    public function display($lineChart, $title, $icon){
        $header = [
            '<div class="flex items-center gap-3 mb-3">',
                '<div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">',
                    $icon,
                '</div>',
                '<h3 class="text-xl font-bold text-gray-900">'.$title.'</h3>',
            '</div>',
    ];
    $body = [
        $lineChart,
    ];
    $card = new Card($header, $body, [], "bg-white rounded-xl p-4 shadow-sm border border-gray-200 ");
    $card->render();
    }
}
?>
