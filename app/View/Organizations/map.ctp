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
<div class="row no-margin"><?php
		echo $this->Html->tag('h5', 'So, what do you think? Would you like to revise the picture your future or path', array('class' => 'activitytitle'));
		
		echo $this->Html->div('row no-margin margin-bottom-15', $this->Html->link('Go to EXECUTE', 
													array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => 190)), 
													array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3 btn btn-primary open-game text-018')));
?></div>
