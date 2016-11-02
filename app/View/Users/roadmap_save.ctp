<?php
if($roadmap['UserGameStatus']['active']) {
	echo 'ActiveName' . $roadmap['UserGameStatus']['roadmap'];
} else {
	echo 
		$this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-times')), 
					  		array('controller' => 'users', 'action' => 'roadmap_delete', $roadmap['UserGameStatus']['id']),
							array('escape' => false)) .
		$this->Html->link(
		  		$this->Html->image('my-roadmap.png', array('class' => 'img-responsive margin-bottom-10')), 
		  		array('controller' => 'users', 'action' => 'roadmap_edit_active', $roadmap['UserGameStatus']['id']),
				array('escape' => false)) . 
			$this->Form->label('Your') . 
			$this->Form->input('roadmap', array(
					'data-id'=> $roadmap['UserGameStatus']['id'],
					'label'  => false,
					'div'    => false,
		    		'class'	 => 'form-control roadmap-input margin-bottom-5',
					'type'	 => 'text',
					'value'	 => $roadmap['UserGameStatus']['roadmap'])) .
			$this->Form->input('configuration_id', array(
					'conf-id' => $roadmap['UserGameStatus']['id'],
					'label'   => false,
					'div'     => false,
				    'class'	  => 'form-control roadmap-input',
					'value'	  => $roadmap['UserGameStatus']['configuration_id'])) .
			$this->Form->label('RoadMap');
}
?>