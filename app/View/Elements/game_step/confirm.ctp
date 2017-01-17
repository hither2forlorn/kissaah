<?php
$vision_date = $this->Session->read('ActiveGame.vision_date');
if(!is_null($vision_date) || $vision_date != '') {
	$options['readonly'] = 'readonly';
}

$options['data-save'] 	= $this->Html->url(array('controller' => 'challenges', 'action' => 'set_challenge'));
$options['label'] 		= false;

echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-finished margin-bottom-5', $selfdata['Configuration']['title']);

$optionsch['data-conf'] = $options['data-conf'] = $selfdata['Configuration']['id'];

if(isset($selfdata['Dependent'])) {
	
	foreach($selfdata['Dependent'] as $dependent) {
		
		$goal = $this->requestAction(array('controller' => 'challenges', 'action' => 'goal', $dependent['id']));
		
		$optionsch 				= array();
		$optionsch['type'] 		= 'hidden';
		$optionsch['data-depn'] = $dependent['id'];
		
		$optionsch['value'] 	= $this->Session->read('Auth.User.id');
		$user_id 				= $this->Form->input('Challenge.user_id', $optionsch);

		$optionsch['value'] 	= 'myself';
		$created_by 			= $this->Form->input('Challenge.created_by', $optionsch);

		$optionsch['value'] 	= (empty($goal['Challenge']['name']))? $dependent['answer']: $goal['Challenge']['name'];
		$challenge_name 		= $this->Form->input('Challenge.name', $optionsch);

		$optionsch['value'] 	= $dependent['id'];
		$goal_id 				= $this->Form->input('Challenge.goal_id', $optionsch);

		$optionsch['value'] 	= (empty($goal['Challenge']['challenge_from_id']))? $this->Session->read('Auth.User.id'): $goal['Challenge']['challenge_from_id'];
		$optionsch['data'] 		= 'from-' . $dependent['id'];
		$challenge_from_id 		= $this->Form->input('Challenge.challenge_from_id', $optionsch);

		$optionsch['value'] 	= (empty($goal['Challenge']['id']))? '': $goal['Challenge']['id'];
		$optionsch['data'] 		= 'challenge-' . $dependent['id'];
		$challenge_id 			= $this->Form->input('Challenge.id', $optionsch);

		$challenge 				= $this->Html->para('', (empty($goal['Challenge']['name']))? $dependent['answer']: $goal['Challenge']['name']);

		$options['data-depn'] 	= $dependent['id'];
		$options['class'] 		= 'form-control date-picker-future';
		$options['div'] 		= 'col-md-3 no-padding';
		$options['type'] 		= 'text';
		$options['placeholder'] = 'Complete by';
		$options['value'] 		= (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by']));
		
		$cal_class = ($options['value'] == '')? ' hidden' : '';
		
		$complete_by  = $this->Html->div('btn-in-progress col-md-4', 'Complete by');
		$complete_by .= $this->Form->input('Challenge.complete_by', $options);
		
		$calendar  = $this->Html->tag('span', (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by'])), array('class' => '_start'));
		$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by'])), array('class' => '_end'));
		$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['name']))? $dependent['answer']: $goal['Challenge']['name'], array('class' => '_summary'));
		$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['description']))? '': $goal['Challenge']['description'], array('class' => '_description'));
		$calendar .= $this->Html->tag('span', 'true', array('class' => '_all_day_event'));

		$calendar = $this->Html->link('Add to Calendar' . $calendar, '#', array('class' => 'addthisevent' . $cal_class, 
																				'title' => 'Add to Calendar',
																				'data' 	=> 'addto-' . $dependent['id'],
																				'escape'=> false));

		if($summary) {
		} else {
			$left_block = $this->Html->div('col-md-10 col-sm-10 col-xs-9 padding-right-0', $challenge . $complete_by . $calendar . 
																	    $challenge_id . $challenge_name . $challenge_from_id . 
																	    $user_id . $created_by . $goal_id);
			$save_challenge = ' save-challenge';
		}
		
		$img = (empty($goal['ChallengeFrom']['slug']) || $goal['ChallengeFrom']['id'] == $this->Session->read('Auth.User.id'))? 
						'profile.png': '../files/img/medium/' . $goal['ChallengeFrom']['slug'];
		$img = $this->Html->div('col-md-12 no-padding margin-bottom-5', 
									$this->Html->image($img, array('data' => 'medium-' . $dependent['id'], 'class' => 'img-responsive')));
		
		$rght_block = $this->Html->div('col-md-2 col-sm-2 col-xs-3 no-padding', $img);
		
		if(($summary && !empty($goal)) || !$summary) {
			echo $this->Html->div('row no-margin margin-bottom-10' . $save_challenge, $rght_block . $left_block);
		}
	}
}
?>
<?php if(!$summary) { ?>
<script type="text/javascript">
	$(document).ready(function() {
		addthisevent.refresh();
	});
</script>
<?php }?>