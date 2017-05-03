<?php
if(isset($selfdata['Dependent'])) {
	
	foreach($selfdata['Dependent'] as $dependent) {
		$goals[$dependent['id']] = $dependent['answer'];
	}

	echo $this->Form->create('Challenge', array('url' => array('controller' => 'challenges', 'action' => 'set_challenge')));
	
	$user_id = $this->Session->read('Auth.User.id');
	$hidden  = $this->Form->input('Challenge.user_id', array('type' => 'hidden', 'value' => $user_id));
	$hidden .= $this->Form->input('Challenge.challenge_from_id', array('type' => 'hidden', 'value' => $user_id));
	$hidden .= $this->Form->input('Challenge.created_by', array('type' => 'hidden', 'value' => 'capture'));

	$challenge_name = $this->Html->div('row no-margin margin-bottom-5', 
			$this->Html->div('btn btn-in-progress col-md-4', 'Learning') . 
			$this->Form->input('Challenge.name', array(
					'div' => 'col-md-8 padding-right-0', 'class' => 'form-control', 'label' => false,
					'placeholder' => 'Jot down what you learned today')));
	
	$complete_by = $this->Html->div('row no-margin margin-bottom-5',
			$this->Html->div('btn btn-in-progress col-md-4', 'Add date') . 
			$this->Form->input('Challenge.complete_by', array(
					'div' => 'col-md-4 padding-right-0', 'class' => 'form-control date-picker-future', 'label' => false,
					'type' => 'text', 'placeholder' => 'Add date')));
				
	$challenge_desc = $this->Html->div('row no-margin margin-bottom-5',
			$this->Html->div('btn btn-in-progress col-md-4', 'Add Context') .
			$this->Form->input('Challenge.description', array(
					'div' => 'col-md-8 padding-right-0', 'class' => 'form-control', 'label' => false, 'placeholder' => '')));
			
	$goal_id = $this->Html->div('row no-margin margin-bottom-5',
			$this->Html->div('col-md-4', '') .
			$this->Form->input('Challenge.goal_id', array(
					'div' => 'col-md-8 padding-right-0', 'class' => 'form-control', 'label' => false, 'options' => $goals)));

	$left_block = $this->Html->div('col-md-12 col-sm-12 col-xs-12 padding-right-0', 
			$hidden . $challenge_name . $complete_by . $challenge_desc . $goal_id);
	
	echo $this->Html->div('row no-margin margin-bottom-10', $left_block);
	echo $this->Form->submit('Add', array('class' => 'btn blue', 'div' => 'row no-margin text-center margin-bottom-20'));
	echo $this->Form->end();
}
?>