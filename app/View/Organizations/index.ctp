<?php
foreach($organizations as $org) {
	$display = array();
	$row = $this->Html->div('col-md-2 padding-left-0', $org['Organization']['title']);
	foreach($levels[$org['Organization']['id']] as $level) {
		if($level['Organization']['parent_id'] == $org['Organization']['id']) {
			$display[$level['Organization']['id']] = 
				$this->Html->tag('h4', $level['Organization']['title'], array('class' => 'alert-heading'));
		} else {
			$display[$level['Organization']['parent_id']] .= '<br />' . $level['Organization']['title'];
		}
	}
	
	foreach($display as $dis) {
		$row .= $this->Html->div('col-md-3 padding-left-0', $this->Html->div('alert alert-warning', $dis));
	}
	$row .= $this->Html->div('col-md-1 padding-0', $this->Html->link('Create map', 
			array('action' => 'map', $org['Organization']['id']), 
			array('class' => 'btn btn-save orange')));
	
	echo $this->Html->div('row margin-bottom-15', $row);
}
?>