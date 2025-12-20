<?php
class LineChart {
    public function render($data,$labels, $color, $bgColor) {

        echo '<div class="max-w-4xl mx-auto">';
        echo '<canvas id="reservationChart"></canvas>';
        echo '</div>';

        $data_json = json_encode($data);
        $labels_json = json_encode($labels);

        $color_js = json_encode($color);
        $bgColor_js = json_encode($bgColor);

        echo <<<HTML
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('reservationChart').getContext('2d');
    const reservationChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: $labels_json,
            datasets: [{
                label: 'Nombre de réservations',
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
                        text: 'Nombre de réservations'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mois'
                    }
                }
            }
        }
    });
</script>
HTML;
    }
}
?>
