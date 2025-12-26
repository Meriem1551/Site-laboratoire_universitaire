<?php
class BarChart {
    public function render($labels, $data, $color, $bgColor, $label = 'Nombre de réservations par equipment', $xtitle = 'Équipements', $ytitle = 'Nombre de réservations') {
        $labels_json = json_encode($labels);
        $data_json = json_encode($data);

        $color_json =  json_encode($color);
        $bgColor_json = json_encode($bgColor);

        $label_json = json_encode($label);
        $xtitle_json = json_encode($xtitle);
        $ytitle_json = json_encode($ytitle);

        echo '<div class="max-w-4xl mx-auto">';
        echo "<canvas id='barChart'></canvas>";
        echo '</div>';

        echo <<<HTML
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('barChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: $labels_json,
            datasets: [{
                label: $label_json,
                data: $data_json,
                backgroundColor: $bgColor_json,
                borderColor: $color_json,
                borderWidth: 1
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
                    stepSize: 1,
                    title: {
                        display: true,
                        text: $ytitle_json
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: $xtitle_json
                    }
                }
            }
        }
    });
});
</script>
HTML;
    }
    public function display($barChart, $title, $icon){
       $header = [
            '<div class="flex items-center gap-3 mb-3">',
                '<div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">',
                    $icon,
                '</div>',
                '<h3 class="text-xl font-bold text-gray-900">'.$title.'</h3>',
            '</div>',
    ];
    $body = [
        $barChart,
    ];
    $card = new Card($header, $body, [], "bg-white rounded-xl p-4 shadow-sm border border-gray-200 ");
    $card->render();
    }
}
?>
