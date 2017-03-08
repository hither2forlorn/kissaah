<?php 
echo $this->Html->css(array('../plugins/OrgChart/dist/css/jquery.orgchart'), null, array('inline' => false));
echo $this->Html->script(array('../plugins/OrgChart/dist/js/jquery.orgchart'), array('inline' => false)); 

$maps = array();
$org_map = $this->requestAction(array('controller' => 'organizations', 'action' => 'map', 1));
foreach($org_map as $k1 => $m1) {
	
	$maps[$k1]['id'] 	= $m1['Organization']['id'];
	$maps[$k1]['name'] 	= $m1['Organization']['title'];
	$maps[$k1]['title'] = $m1['Organization']['title'];
	
	foreach($m1['children'] as $k2 => $m2) {
		$maps[$k1]['children'][$k2]['id'] 	 = $m2['Organization']['id'];
		$maps[$k1]['children'][$k2]['name']  = $m2['Organization']['title'];
		$maps[$k1]['children'][$k2]['title'] = $m2['Organization']['description'];
		
		foreach($m2['children'] as $k3 => $m3) {
			$maps[$k1]['children'][$k2]['children'][$k3]['id'] 		= $m3['Organization']['id'];
			$maps[$k1]['children'][$k2]['children'][$k3]['name'] 	= $m3['Organization']['title'];
			$maps[$k1]['children'][$k2]['children'][$k3]['title'] 	= $m3['Organization']['description'];
		}
	}
}

$maps = substr(json_encode($maps), 1, -1);
?>
<div id="chart-container"></div>
<script type="text/javascript">
var data_map = <?php echo $maps; ?>;
jQuery(document).ready(function() {
	OrganizationMap.init(data_map);
});
</script>
