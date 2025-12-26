<?php
class PieChart {
    public function render($data, $labels, $colors, $label) {
        echo '<div class="max-w-4xl mx-auto">';
        echo '<canvas id="PieChart"></canvas>';
        echo '</div>';

        $data_json = json_encode($data);
        $labels_json = json_encode($labels);
        $colors_json = json_encode($colors);
        $label_js = json_encode($label);

        echo <<<HTML
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('PieChart').getContext('2d');
    const pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: $labels_json,
            datasets: [{
                label: $label_js,
                data: $data_json,
                backgroundColor: $colors_json,
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
});
</script>
HTML;
    }
    public function display($pieChart, $title, $icon){
        $header = [
            '<div class="flex items-center gap-3 mb-3">',
                '<div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">',
                    $icon,
                '</div>',
                '<h3 class="text-xl font-bold text-gray-900">'.$title.'</h3>',
            '</div>',
    ];
    $body = [
        $pieChart,
    ];
    $card = new Card($header, $body, [], "bg-white rounded-xl p-4 shadow-sm border border-gray-200 ");
    $card->render();
    }
}
?>
