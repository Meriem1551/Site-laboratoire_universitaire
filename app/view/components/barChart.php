<?php
class BarChart {
    public function render($labels, $data, $color, $bgColor) {
        $labels_json = json_encode($labels);
        $data_json = json_encode($data);

        $color_json =  json_encode($color);
        $bgColor_json = json_encode($bgColor);

        echo '<div class="max-w-4xl mx-auto">';
        echo "<canvas id='equipChart'></canvas>";
        echo '</div>';

        echo <<<HTML
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('equipChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: $labels_json,
            datasets: [{
                label: 'Nombre de réservations par equipment',
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
                        text: 'Nombre de réservations'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Équipements'
                    }
                }
            }
        }
    });
});
</script>
HTML;
    }
}
?>
