<?php
foreach($organizations as $org) {
	$display = array();
	$row = $this->Html->div('col-md-2', $org['Organization']['title']);
	foreach($levels[$org['Organization']['id']] as $level) {
		if($level['Organization']['parent_id'] == $org['Organization']['id']) {
			$display[$level['Organization']['id']] = 
				$this->Html->tag('span', $level['Organization']['title'], array('class' => 'btn btn-primary activitytitle'));
		} else {
			$display[$level['Organization']['parent_id']] .= '<br />' . $level['Organization']['title'];
		}
	}
	
	foreach($display as $dis) {
		$row .= $this->Html->div('col-md-3', $dis);
	}
	$row .= $this->Html->div('col-md-1', $this->Html->link('Create map', '#', array('class' => 'btn btn-save orange')));
	
	echo $this->Html->div('row margin-bottom-15', $row);
}
?>