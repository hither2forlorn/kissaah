<?php
echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-finished margin-bottom-5', $selfdata['Configuration']['title']);


$answer 				= '';
$id						= $selfdata['Configuration']['id'];

$options['class'] 		= 'form-control';
$options['type'] 		= 'text';
$options['label'] 		= false;
$options['div'] 		= false;
$options['tabindex'] 	= $id;
$options['data'] 		= $selfdata['Configuration']['dependent_id'];
$options['placeholder'] = $selfdata['Configuration']['title'];
$options['data-save'] 	= $this->Html->url(array('controller' => 'games', 'action' => 'save'));

$input  = 'Game.' . $id . '.0';
if(empty($selfdata['Configuration']['dependent_id'])) {
	if(!empty($selfdata['Game'])) {
		$answer	= $selfdata['Game'][0]['Game']['answer'];
		$input  = 'Game.' . $id . '.' . $selfdata['Game'][0]['Game']['id'];
	}
	
} else {
	if(!empty($selfdata['Dependent'][0]['answer'])) {
		$answer = $selfdata['Dependent'][0]['answer'];
	}
	$id = $selfdata['Configuration']['dependent_id'];
	$input  = 'Game.' . $id . '.' . $selfdata['Configuration']['id'];
}

if($summary) {
	$input = $this->Form->label('Game.answer', $answer, array('class' => 'control-label margin-bottom-10'));

} else {
	$options['value'] = $answer;
	$input 	= $this->Form->input($input, $options);

}

if(1 == 1) {
	echo $input;
	
} else {
	$display = $this->Html->div('form-group margin-bottom-15 margin-top-10 save-answer', $input);
	
	if($selfdata['Configuration']['sub_txt'] != '') {
		echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', $selfdata['Configuration']['sub_txt']);
	}
	echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', $display);
	
}

debug($selfdata);
$options['data-save'] 	= $this->Html->url(array('controller' => 'challenges', 'action' => 'set_challenge'));
$options['label'] 		= false;


	if(isset($selfdata['Dependent'])) {
		
		foreach($selfdata['Dependent'] as $dependent) {
			
			$calendar  = $this->Html->tag('span', '', array('class' => '_start'));
			$calendar .= $this->Html->tag('span', '', array('class' => '_end'));
			$calendar .= $this->Html->tag('span', $dependent['answer'], array('class' => '_summary'));
			$calendar .= $this->Html->tag('span', '', array('class' => '_description'));
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
					
					$modalbody = $this->Html->div('modal-body', $rating . $feedback . $status);
					
					$modalcontent = $this->Html->div('modal-content', $modalheader . $modalbody . $modalfooter);
					
					$modaldialog = $this->Html->div('modal-dialog', $modalcontent);
					
					$modal = $this->Html->div('modal fade', $modaldialog, array('id' => 'Challenge-' . $goal['Challenge']['id'],
																				'tabindex' => '-1', 'role' => 'dialog',
																				'aria-hidden' => 'true'));
				}

				$left_block = $this->Html->div('col-md-10 col-sm-10 col-xs-9 padding-right-0', $challenge_id . $challenge . $complete_by . 
																			$modalbtn . $description . $modal);
				
			} else {
				$left_block = $this->Html->div('col-md-10 col-sm-10 col-xs-9 padding-right-0', $calendar);
			}
			
			$ally = (empty($goal['Challenge']['goal']))? '&nbsp;': $goal['Challenge']['goal'];
			$ally = $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-in-progress margin-bottom-5', $ally, array('data' => 'label-' . $dependent['id']));
			
			if(($summary && !empty($goal)) || !$summary) {
				echo $this->Html->div('row no-margin margin-bottom-10', $left_block);
			}
		}
	}
?>
<script type="text/javascript">
	$(document).ready(function() {
		addthisevent.refresh();
	});
</script>
