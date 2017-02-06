<?php
$vision_date = $this->Session->read('ActiveGame.vision_date');
if(!is_null($vision_date) || $vision_date != '') {
	$options['readonly'] = 'readonly';
}
//debug($selfdata);
$options['label'] 		= false;

$optionsch['data-conf'] = $options['data-conf'] = $selfdata['Configuration']['id'];

if(isset($selfdata['Dependent'])) {
	
	foreach($selfdata['Dependent'] as $dependent) {
		
		$optionsch 				= array();
		$optionsch['type'] 		= 'hidden';
		
		$optionsch['value'] 	= $this->Session->read('Auth.User.id');
		$user_id 				= $this->Form->input('Challenge.user_id', $optionsch);
		$challenge_from_id 		= $this->Form->input('Challenge.challenge_from_id', $optionsch);
		
		$optionsch['value'] 	= 'myself';
		$created_by 			= $this->Form->input('Challenge.created_by', $optionsch);

		$optionsch['value'] 	= $dependent['id'];
		$goal_id 				= $this->Form->input('Challenge.goal_id', $optionsch);

		$challenge 				= $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-finished margin-bottom-5', $dependent['answer']);

		$options['div'] 		= 'col-md-3 no-padding';
		$options['class'] 		= 'form-control date-picker-future';
		$options['type'] 		= 'text';
		$options['placeholder'] = 'Add date';
		
		$complete_by  			= $this->Html->div('btn-in-progress col-md-4', 'Add date') . $this->Form->input('Challenge.complete_by', $options);
		
		$options['div'] 		= 'col-md-8 padding-right-0';
		$options['class'] 		= 'form-control';
		$options['placeholder'] = 'Jot down what you learned today';
		$challenge_name 		= $this->Html->div('btn-in-progress col-md-4', 'Learning') . $this->Form->input('Challenge.name', $options);
		
		$options['placeholder'] = 'Jot down what you learned today';
		$challenge_desc 		= $this->Html->div('btn-in-progress col-md-4', 'Add Context') . $this->Form->input('Challenge.description', $options);
		
		$left_block = $this->Html->div('col-md-12 col-sm-12 col-xs-12 padding-right-0', 
				$challenge . $challenge_name . $complete_by . $challenge_desc .
				$challenge_from_id . $user_id . $created_by . $goal_id);
		
		$save_challenge = ' save-challenge';

		echo $this->Html->div('row no-margin margin-bottom-10' . $save_challenge, $left_block);
	}
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		Game.handleDatePicker();
	});
</script>