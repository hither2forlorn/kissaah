<?php 
echo $this->Html->css(array('../plugins/OrgChart/dist/css/jquery.orgchart'));
echo $this->Html->script(array('../plugins/OrgChart/dist/js/jquery.orgchart')); 
?>
<div class="col-md-6 col-md-offset-3">
<?php 
$row = '';
foreach($level as $l1) {
	
	echo $this->Html->tag('h3', $l1['Organization']['title']);
	
	foreach($l1['children'] as $l2) {
		echo $this->Html->tag('h3', $l2['Organization']['title']);
		
		$row = '';
		foreach($l2['children'] as $l3) {
			$row .= $l3['Organization']['title'] . '<br />';
		}
		
		echo $this->Html->div('alert alert-success', $row);
	}
}

$maps = array();
foreach($org_map as $k1 => $m1) {
	
	echo $this->Html->tag('h3', $m1['Organization']['title']);
	
	$maps[$k1]['name'] = $m1['Organization']['title'];
	$maps[$k1]['title'] = $m1['Organization']['title'];
	
	foreach($m1['children'] as $k2 => $m2) {
		$maps[$k1]['children'][$k2]['name'] = $m2['Organization']['title'];
		$maps[$k1]['children'][$k2]['title'] = $m2['Organization']['description'];
		
		foreach($m2['children'] as $k3 => $m3) {
			$maps[$k1]['children'][$k2]['children'][$k3]['name'] = $m3['Organization']['title'];
			$maps[$k1]['children'][$k2]['children'][$k3]['title'] = $m3['Organization']['description'];
		}
	}
}

$maps = substr(json_encode($maps), 1, -1);
?>
	<div id="chart-container"></div>
</div>

<script type="text/javascript">
var data_map = <?php echo $maps; ?>;
jQuery(document).ready(function() {
	OrganizationMap.init(data_map);
});
</script>