<?php
class Organigramme{
    public function render($data){
echo '<div style="overflow:auto; width:100%; max-height:80vh; border:1px solid #ccc;">'; 
    echo '<div style="min-width:max-content; min-height:max-content;">';
        echo '<div id="orgChart" style="background-color:transparent;"></div>';
    echo '</div>';
echo '</div>';


echo <<<HTML
<script src="https://cdn.balkan.app/orgchart.js"></script>
<script>
const orgData = $data; 

OrgChart.templates.smallNode = Object.assign({}, OrgChart.templates.ana);

OrgChart.templates.smallNode.size = [120, 60]; // width 120px, height 60px

OrgChart.templates.smallNode.node = '<rect x="0" y="0" width="{w}" height="{h}" fill="white" stroke="var(--primary-light)" rx="5" ry="5" stroke-width="1"></rect>';

OrgChart.templates.smallNode.field_0 = '<text class="field_0" x="75" y="20" text-anchor="middle" fill="var(--primary-dark)" font-size="10px" font-family="Arial">{val}</text>';

OrgChart.templates.smallNode.field_1 = '<text class="field_1" x="80" y="40" text-anchor="middle" fill="var(--gray-dark)" font-size="8px" font-family="Arial">{val}</text>';

OrgChart.templates.smallNode.img_0 = '<image preserveAspectRatio="xMidYMid slice" clip-path="url(#{randId})"width="30" height="30" xlink:href="{val}"></image>';

new OrgChart(document.getElementById("orgChart"), {
    template: 'smallNode',
    nodeBinding: {
        field_0: "name",
        field_1: "post",
        img_0: "img"
    },
    nodes: orgData,
    collapse: { toggle: true }
});
</script>
HTML;

    }
}
?>

