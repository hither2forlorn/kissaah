<?php
$options['data-save'] 	= $this->Html->url(array('controller' => 'challenges', 'action' => 'set_challenge'));
$options['label'] 		= false;

echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-finished margin-bottom-5', $selfdata['Configuration']['title']);

if(!isset($selfdata['children']) && isset($selfdata['Dependent'])) {
	$selfdata['children'][] = $selfdata;
}

foreach($selfdata['children'] as $child) {
	$optionsch['data-conf'] = $options['data-conf'] = $child['Configuration']['id'];

	if(isset($child['Dependent'])) {
		
		foreach($child['Dependent'] as $dependent) {
			
			$goal = $this->requestAction(array('controller' => 'challenges', 'action' => 'goal', $dependent['id']));
			
			$optionsch 				= array();
			$optionsch['type'] 		= 'hidden';
			$optionsch['data-depn'] = $dependent['id'];
			
			$optionsch['value'] 	= $this->Session->read('Auth.User.id');
			$user_id = $this->Form->input('Challenge.user_id', $optionsch);
	
			$optionsch['value'] = 'myself';
			$created_by 			= $this->Form->input('Challenge.created_by', $optionsch);
	
			$optionsch['value'] = (empty($goal['Challenge']['name']))? $dependent['answer']: $goal['Challenge']['name'];
			$challenge_name 		= $this->Form->input('Challenge.name', $optionsch);
	
			$optionsch['value'] = $dependent['id'];
			$goal_id = $this->Form->input('Challenge.goal_id', $optionsch);
	
			$optionsch['value'] = (empty($goal['Challenge']['challenge_from_id']))? $this->Session->read('Auth.User.id'): $goal['Challenge']['challenge_from_id'];
			$optionsch['data'] = 'from-' . $dependent['id'];
			$challenge_from_id = $this->Form->input('Challenge.challenge_from_id', $optionsch);
	
			$optionsch['value'] 	= (empty($goal['Challenge']['id']))? '': $goal['Challenge']['id'];
			$optionsch['data'] 		= 'challenge-' . $dependent['id'];
			$challenge_id 			= $this->Form->input('Challenge.id', $optionsch);
	
			$challenge = $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-in-progress text-left', 
								(empty($goal['Challenge']['name']))? $dependent['answer']: $goal['Challenge']['name']);
			$complete_by = $this->Html->div('col-md-4 col-sm-4 col-xs-12 margin-top-5 btn-in-progress text-left', 'Created: ' . date('m/d/Y', strtotime($dependent['created'])));
	
			unset($options['rows']);
			$options['data-depn'] 	= $dependent['id'];
			$options['class'] 		= 'form-control date-picker-future';
			$options['div'] 		= 'col-md-4 col-sm-4 col-xs-4 no-padding margin-top-5 text-016';
			$options['type'] 		= 'text';
			$options['placeholder'] = 'Complete by';
			$options['value'] 		= (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by']));
			
			if($summary) {
				$options['readonly'] = 'readonly';
			}
			$complete_by .= $this->Form->input('Challenge.complete_by', $options);
			
			$options['class'] 		= 'form-control description';
			$options['div'] 		= 'col-md-12 col-sm-12 col-xs-12 no-padding margin-top-5';
			$options['type'] 		= 'textarea';
			$options['placeholder'] = $selfdata['Configuration']['naration_txt'];
			$options['value'] 		= (empty($goal['Challenge']['description']))? '': $goal['Challenge']['description'];

			$description = $this->Form->input('Challenge.description', $options);

			unset($options['rows']);
			$options['class'] 		= 'form-control live-search-goal';
			$options['label'] 		= false;
			$options['div'] 		= 'col-md-12 no-padding extra-width';
			$options['type'] 		= 'text';
			$options['placeholder'] = 'Search Ally';
			$options['value'] 		= (empty($goal['ChallengeFrom']['name']) || $goal['ChallengeFrom']['id'] == $this->Session->read('Auth.User.id'))? 
												'': $goal['ChallengeFrom']['name'];

			$name = $this->Form->input('Challenge.ally', $options);
			
			$calendar  = $this->Html->tag('span', (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by'])), array('class' => '_start'));
			$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['complete_by']))? '': date('m/d/Y', strtotime($goal['Challenge']['complete_by'])), array('class' => '_end'));
			$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['name']))? $dependent['answer']: $goal['Challenge']['name'], array('class' => '_summary'));
			$calendar .= $this->Html->tag('span', (empty($goal['Challenge']['description']))? '': $goal['Challenge']['description'], array('class' => '_description'));
			$calendar .= $this->Html->tag('span', 'true', array('class' => '_all_day_event'));

			$calendar = $this->Html->link('Add to Calendar' . $calendar, '#', array('class' => 'pull-right addthisevent event', 
																					'title' => 'Add to Calendar',
																					'data' 	=> 'addto-' . $dependent['id'],
																					'escape'=> false));
			$calendar = $this->Html->div('col-md-4 col-sm-4 col-xs-8 margin-top-5 no-padding', $calendar);

			if($summary) {
				$modalbtn = $modal = '';
				if(!empty($goal)) {
					if($goal['Challenge']['status'] != 'Completed') {
						$modalbtn = $this->Html->div('col-md-4 col-sm-4 col-xs-8 margin-top-5 no-padding',
										$this->Html->link('Review Challenge', '#Challenge-' . $goal['Challenge']['id'], 
													array('role' => 'button', 'class' => 'btn blue pull-right', 'data-toggle' => 'modal',
														  'data' => 'goal-' . $goal['Challenge']['id'])));
						
					} else {
						$modalbtn = $this->Html->div('col-md-4 no-padding',
										$this->Html->div('btn-finished pull-right', 'Challenge Completed'));
					}
					
					$modalheader = $this->Html->div('modal-header', 
						$this->Form->button('', array('type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')) .
						$this->Html->tag('h4', $goal['Challenge']['name'], array('class' => 'modal-title')));
					
					$modalfooter = $this->Html->div('modal-footer', 
						$this->Form->button('Cancel', array('type' => 'button', 'class' => 'btn default', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')) .
						$this->Form->button('Challenge Completed', array('type' => 'button', 'class' => 'btn yellow', 'data-dismiss' => 'modal',
														  'data-save' => $this->Html->url(array('controller' => 'challenges', 'action' => 'set_challenge')),
														  'data' => $goal['Challenge']['id'])));
					
					$optionsid['type'] 		= 'hidden';
					$optionsid['data-depn'] = $dependent['id'];
					$optionsid['value'] 	= $goal['Challenge']['id'];
					$optionsid['data'] 		= 'challenge-' . $dependent['id'];
					$optionsid['value'] 	= $goal['Challenge']['rating'];
					$optionsid['data'] 		= 'rating-' . $dependent['id'];
					$rating = $this->Form->input('Challenge.rating', $optionsid);
					$rating = $this->Html->div('rating', '', array('data-score' => $optionsid['value'], 'data-depn' => $dependent['id'])) . $rating;
					$rating = $this->Html->div('col-md-12 no-padding', $this->Html->div('btn-label dark-blue', $rating));
					
					$status = $this->Form->input('Challenge.status', array('type' => 'hidden', 'value' => 'Completed'));
					
					unset($options['readonly']);
					$options['class'] 		= 'form-control';
					$options['label'] 		= false;
					$options['div'] 		= 'col-md-12 no-padding margin-top-5 margin-bottom-10';
					$options['type'] 		= 'textarea';
					$options['rows']  		= '3';
					$options['placeholder'] = $selfdata['Configuration']['title'];
					$options['value'] 		= $goal['Challenge']['feedback'];
					$feedback = $this->Form->input('Challenge.feedback', $options);
					
					$modalbody = $this->Html->div('modal-body', $rating . $feedback . $status);
					
					$modalcontent = $this->Html->div('modal-content', $modalheader . $modalbody . $modalfooter);
					
					$modaldialog = $this->Html->div('modal-dialog', $modalcontent);
					
					$modal = $this->Html->div('modal fade', $modaldialog, array('id' => 'Challenge-' . $goal['Challenge']['id'],
																				'tabindex' => '-1', 'role' => 'dialog',
																				'aria-hidden' => 'true'));
				}

				$left_block = $this->Html->div('col-md-10 col-sm-10 col-xs-9 padding-right-0', $challenge_id . $challenge . $complete_by . 
																			$modalbtn . $description . $modal);
				$save_challenge = ' modal-challenge';
				
			} else {
				$left_block = $this->Html->div('col-md-10 col-sm-10 col-xs-9 padding-right-0', $challenge . $complete_by . $calendar . $description . 
																		    $challenge_id . $challenge_name . $challenge_from_id . 
																		    $user_id . $created_by . $goal_id);
				$save_challenge = ' save-challenge';
			}
			
			$ally = (empty($goal['Challenge']['goal']))? '&nbsp;': $goal['Challenge']['goal'];
			$ally = $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-in-progress margin-bottom-5', $ally, array('data' => 'label-' . $dependent['id']));
			
			$img = (empty($goal['ChallengeFrom']['slug']) || $goal['ChallengeFrom']['id'] == $this->Session->read('Auth.User.id'))? 
							'profile.png': '../files/img/medium/' . $goal['ChallengeFrom']['slug'];
			$img = $this->Html->div('col-md-12 no-padding margin-bottom-5', 
										$this->Html->image($img, array('data' => 'medium-' . $dependent['id'], 'class' => 'img-responsive')));
			
			$rght_block = $this->Html->div('col-md-2 col-sm-2 col-xs-3 no-padding', $ally . $img . $name);
			
			if(($summary && !empty($goal)) || !$summary) {
				echo $this->Html->div('row no-margin margin-bottom-10' . $save_challenge, $rght_block . $left_block);
			}
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