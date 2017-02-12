<?php
$options['label'] = false;

if(isset($selfdata['Dependent'])) {
	
	foreach($selfdata['Dependent'] as $dependent) {
		
		echo $this->Form->create('Challenge', array('url' => array('controller' => 'challenges', 'action' => 'set_challenge')));
		$optionsch 				= array();
		$optionsch['type'] 		= 'hidden';
		
		$optionsch['value'] 	= $this->Session->read('Auth.User.id');
		$user_id 				= $this->Form->input('Challenge.user_id', $optionsch);
		$challenge_from_id 		= $this->Form->input('Challenge.challenge_from_id', $optionsch);
		
		$optionsch['value'] 	= 'capture';
		$created_by 			= $this->Form->input('Challenge.created_by', $optionsch);

		$optionsch['value'] 	= $dependent['id'];
		$goal_id 				= $this->Form->input('Challenge.goal_id', $optionsch);

		$challenge 				= $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-finished margin-bottom-5', $dependent['answer']);

		$options['div'] 		= 'col-md-4 padding-right-0';
		$options['class'] 		= 'form-control date-picker-future';
		$options['type'] 		= 'text';
		$options['placeholder'] = 'Add date';
		
		$complete_by  			= $this->Html->div('row no-margin margin-bottom-5',
				$this->Html->div('btn-in-progress col-md-4', 'Add date') . $this->Form->input('Challenge.complete_by', $options));
		
		$options['div'] 		= 'col-md-8 padding-right-0';
		$options['class'] 		= 'form-control';
		$options['placeholder'] = 'Jot down what you learned today';
		$challenge_name 		= $this->Html->div('row no-margin margin-bottom-5',
				$this->Html->div('btn-in-progress col-md-4', 'Learning') . $this->Form->input('Challenge.name', $options));
		
		$options['placeholder'] = 'Jot down what you learned today';
		$challenge_desc 		= $this->Html->div('row no-margin margin-bottom-5',
				$this->Html->div('btn-in-progress col-md-4', 'Add Context') . $this->Form->input('Challenge.description', $options));
		
		$left_block = $this->Html->div('col-md-12 col-sm-12 col-xs-12 padding-right-0', 
				$challenge . $challenge_name . $complete_by . $challenge_desc .
				$challenge_from_id . $user_id . $created_by . $goal_id);
		
		echo $this->Html->div('row no-margin margin-bottom-10', $left_block);
		echo $this->Form->submit('Add', array('class' => 'btn blue', 'div' => 'row no-margin text-center margin-bottom-20'));
		echo $this->Form->end();
	}
}
?>