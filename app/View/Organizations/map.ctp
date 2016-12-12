<?php
$row = '';
foreach($level as $l) {
	if($l['Organization']['parent_id'] == $organization['Organization']['id'] && $row == '') {
		echo $this->Html->tag('h3', $l['Organization']['title']);
	} elseif($l['Organization']['parent_id'] == $organization['Organization']['id'] && $row != '') {
		echo $this->Html->div('row margin-bottom-15', $row);
		$row = '';
		echo $this->Html->tag('h3', $l['Organization']['title']);
		
	} else {
		$row .= '<br />' . $l['Organization']['title'];
	}
	
}

debug($organization);
debug($level);
?>
