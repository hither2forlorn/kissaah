<?php
$vision_date = $this->Session->read('ActiveGame.vision_date');
if(!is_null($vision_date) || $vision_date != '' || $summary == true) {
	$options['readonly'] = 'readonly';
}

$options['data-save'] = $this->Html->url(array('controller' => 'challenges', 'action' => 'set_challenge'));
$options['label'] 	  = false;

$optionsch['data-conf'] = $options['data-conf'] = $selfdata['Configuration']['id'];

$group_users = $this->requestAction(array('controller' => 'allies', 'action' => 'allies'));
$allies = array();
foreach($group_users as $value) {
	$allies[$value['MyAlly']['id']]['slug']  = $value['MyAlly']['slug'];
	$allies[$value['MyAlly']['id']]['name']  = $value['MyAlly']['name'];
	$allies[$value['MyAlly']['id']]['email'] = $value['MyAlly']['email'];
}

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

		$challenge 				 = $this->Html->div('col-md-3 col-sm-3 col-xs-3 btn-finished text-left', $selfdata['Configuration']['title']);
		$challenge 				.= $this->Html->div('col-md-8 col-sm-8 col-xs-8', 
										(empty($goal['Challenge']['name']))? $dependent['answer']: $goal['Challenge']['name']);
		$challenge				= $this->Html->div('row no-margin margin-bottom-5', $challenge);

		$options['data-depn'] 	= $dependent['id'];
		$options['class'] 		= 'form-control date-picker-future';
		$options['div'] 		= 'col-md-3 no-padding';
		$options['type'] 		= 'text';
		$options['placeholder'] = 'Complete by';
		$options['value'] 		= (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by']));
		
		$hidden = ($options['value'] == '')? ' hidden' : '';
		
		$complete_by  = $this->Html->div('btn-in-progress col-md-3 text-left', 'Complete by');
		$complete_by .= $this->Form->input('Challenge.complete_by', $options);
		
		$calendar = $add_ally = '';
		if(!$summary) {
			$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by'])), array('class' => '_start'));
			$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by'])), array('class' => '_end'));
			$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['name']))? $dependent['answer']: $goal['Challenge']['name'], array('class' => '_summary'));
			$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['description']))? '': $goal['Challenge']['description'], array('class' => '_description'));
			$calendar .= $this->Html->tag('span', 'true', array('class' => '_all_day_event'));
			
			$calendar = $this->Html->link('Calendar' . $calendar, '#', array('class' => 'addthisevent pull-left' . $hidden,
					'title' => 'Add to Calendar', 'data' => 'addto-' . $dependent['id'], 'escape'=> false));
			
			$add_ally = $this->Html->link('Add Ally', 
					array('controller' => 'allies', 'action' => 'allies', '?' => array(
							'st' => $this->request->query['st'], 'challenge' => $optionsch['value'])), 
					array('class' => 'btn-in-progress col-md-3' . $hidden, 'data' => 'ally-' . $dependent['id'], 'escape'=> false));
		}

		$allies_selected = $allies_list = '';
		if(!empty($goal['ChallengesUser'])) {
			foreach($goal['ChallengesUser'] as $chall_user) {

				$key = $chall_user['user_id'];
				$value = $allies[$key];
		
				if(empty($value['slug']) || $value['slug'] == '' || is_null($value['slug'])) {
					$img = 'profile.png';
				} else {
					$img = '../files/img/medium/' . $value['slug'];
				}
					
				$allies_selected = $this->Html->link($this->Html->image($img, array('class' => 'img-responsive')),
						array('controller' => 'challenges', 'action' => 'set_challenge_user', 'delete', $optionsch['value'], $key),
						array('class' => 'col-md-2 col-sm-4 col-xs-6 padding-left-0 ally-selection', 'escape' => false));
				
				$allies_selected .= $this->Html->div('col-md-10 col-sm-8 col-xs-6 padding-left-0', $value['name'] . '<br />' . $value['email']);
				$allies_list .= $this->Html->div('row no-margin margin-bottom-5', $allies_selected);
		
				unset($allies[$key]);
			}
		}
		$users = $this->Html->div('col-md-12 col-sm-12 no-padding margin-top-5 ally-selected' . $hidden, $allies_list);
		$users = $this->Html->div('row no-margin', $users);
		
		$left_block = $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', $challenge . $complete_by . $calendar .
									$add_ally . $challenge_id . $challenge_name . 
									$challenge_from_id . $user_id . $created_by . $goal_id . $users);
		
		if(($summary && !empty($goal)) || !$summary) {
			echo $this->Html->div('row no-margin margin-bottom-20 padding-bottom-20 save-challenge', $left_block);
		}
	}
}
?>