<?php 
echo $this->Html->css(array('../plugins/OrgChart/dist/css/jquery.orgchart'));
echo $this->Html->script(array('../plugins/OrgChart/dist/js/jquery.orgchart', '../plugins/OrgChart/examples/vertical-depth/scripts')); 
?>

<div class="col-md-6 col-md-offset-3">
<?php
$row = '';
foreach($level as $l) {
	if($l['Organization']['parent_id'] == $organization['Organization']['id'] && $row == '') {
		echo $this->Html->tag('h3', $l['Organization']['title']);
	} elseif($l['Organization']['parent_id'] == $organization['Organization']['id'] && $row != '') {
		echo $this->Html->div('alert alert-success', $row);
		$row = '';
		echo $this->Html->tag('h3', $l['Organization']['title']);
		
	} else {
		$row .= '<br />' . $l['Organization']['title'];
	}
}
echo $this->Html->div('alert alert-success', $row);
debug($organization);
debug($level);
?>
	<div id="chart-container"></div>
</div>
