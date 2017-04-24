<div class="no-margin row data-width-600"><?php
$options = array('1' => 'Strongly disagree', '2' => '2', '3' => '3', '4' => '4', '5' => 'Strongly disagree');
echo $this->Form->hidden('Feedback.user_game_status_id', array('value' => $feedback_for_user['UserGameStatus']['id']));

echo $this->Html->tag('h3', 'Feedback', array('class' => 'activitytitle'));
if($this->request->pass[0] == 'myself') {
	echo $this->Html->tag('h5', 'Your ally\'s feedback for you', array('class' => 'activitytitle'));
	
} else {
	echo $this->Html->tag('h5', 'Your ally has requested your feedback', array('class' => 'activitytitle'));
	
}

$title = $subtt = $image = $text = $blockid = '';
$feedbackblock = array();

foreach($feedback_list as $key => $value) {
	$answer = '&nbsp;';
	$id = $feedbacks[$key]['Configuration']['id'];
	
	if($feedbacks[$key]['Configuration']['type'] == 0) {
		$blockid = $id;
		$feedbackblock[$blockid]['title'] = $feedbacks[$key]['Configuration']['title'] . ' Feedback';
		
	} elseif($feedbacks[$key]['Configuration']['type'] == 1) {
		$answer = 'http://placehold.it/300x300&text=X';
		if(!empty($feedbacks[$key]['Game'][0]['answer'])) {
			$answer = '/files/img/medium/' . $feedbacks[$key]['Game'][0]['answer'];
		}
		
		$feedbackblock[$blockid]['image'][] = $this->Html->image($answer, array('class' => 'img-responsive', 'data' => 'medium-' . $id));
		
	} elseif(in_array($feedbacks[$key]['Configuration']['type'], array(2, 5))) {
		if(!empty($feedbacks[$key]['Game'][0]['answer'])) {
			$answer = $feedbacks[$key]['Game'][0]['answer'];
		}
		
		$feedbackblock[$blockid]['text'][] = $this->Html->div('col-md-12 col-sm-12 col-xs-12', 
											 $this->Html->div('border-input margin-bottom-5', $answer), array('data' => 'medium-' . $id));
		
	} elseif($feedbacks[$key]['Configuration']['type'] == 8) {
		if(!empty($feedbacks[$key]['Game'][0]['answer'])) {
			$feedbackblock[$blockid]['value'][] = $this->Html->div('btn-in-progress btn-featured', 
																	$feedbacks[$key]['Game'][0]['answer'], 
																	array('data' => 'medium-' . $id));
																	
		} else {
			$feedbackblock[$blockid]['value'][] = $this->Html->div('btn-start btn-featured', '', array('data' => 'medium-' . $id));
		}
		
	} elseif($feedbacks[$key]['Configuration']['type'] == 7) {
		if(!empty($feedbacks[$key]['Game'][0]['answer'])) {
			$answer = $feedbacks[$key]['Game'][0]['answer'];
		}
		
		$feedbackblock[$blockid]['people'][] = $this->Html->div('col-md-12 col-sm-12 col-xs-12', 
											 $this->Html->div('border-input margin-bottom-5', $answer), array('data' => 'medium-' . $id));
		
	} else {
		//debug($feedbacks[$key]);
		
	}
}

$label = $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding', $this->Html->div('btn-label dark-blue', 'Strongly disagree')) .
		 $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding', $this->Html->div('btn-label dark-blue', 'Neither agree nor disagree')) .
		 $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding', $this->Html->div('btn-label dark-blue', 'Strongly agree'));

foreach($feedbackblock as $key => $block) {

	$text = $images = $action = '';

	$answer  = (isset($feedbacks[$key]['Feedback']['answer']))? $feedbacks[$key]['Feedback']['answer']: '';
	$comment = (isset($feedbacks[$key]['Feedback']['comment']))? $feedbacks[$key]['Feedback']['comment']: '';
	
	$radio = $this->Form->input('Feedback.answer.' . $feedbacks[$key]['Configuration']['id'], 
								array(	'type' => 'radio', 'label' => false, 'legend' => false, 'div' => 'feedback-radio btn-label orange',
										'disabled' => $disabled, 'value' => $answer, 
										'options' => array('1' => '', '2' => '', '3' => '', '4' => '', '5' => '')));
										  
	$comment = $this->Form->textarea('Feedback.comment.' . $feedbacks[$key]['Configuration']['id'], 
								   		  array('label' => false, 'div' => false, 'disabled' => $disabled, 
								   		  		'value' => $comment, 'class' => 'form-control', 'placeholder' => 'Enter comment here ...'));

	if($key == 188) {
		$subtt = $feedback_for_user['User']['name'] . ' created a vision of the future';
		$btntext = 'To what extent will this vision bring ' . $feedback_for_user['User']['name'] . ' future better self?';

		foreach($block['text'] as $txt) {
			$text .= $txt;
		}
		foreach($block['image'] as $image) {
			$images .= $this->Html->div('col-md-4 col-sm-4 col-xs-4', $image);
		}
		$images = $this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-10', $images);
		
		$title = $this->Html->div('btn-label orange', $block['title']);
		$subtt = $this->Html->div('btn-label light-blue', $subtt);
		$btn = $this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $this->Html->div('btn-label light-blue', $btntext));
		
		echo $this->Html->div('row no-margin feedback-block margin-bottom-30', 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $title) . 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $subtt) . 
						$text . $images . $btn . 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $label) . 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $radio) . 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $comment) . 
						$this->Html->div('col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6 margin-top-20 border-bottom text-018', ''));
	
	} else {
		$subtt = 'Below are actions that help ' . $feedback_for_user['User']['name'] . ' realize their vision:';
		$btntext = 'Do you think this vision will bring ' . $feedback_for_user['User']['name'] . ' wellbeing?';

		foreach($block['image'] as $image) {
			$path = $this->Html->div('col-md-2 col-sm-2 col-xs-2 text-015', $image);
			$ally = $this->Html->image('/files/img/medium/' . $feedback_for_user['User']['slug'], 
										array('class' => 'img-responsive', 'data' => 'medium-' . $id));
			$ally = $this->Html->div('col-md-2 col-sm-2 col-xs-2 text-016', $ally);
		}
		foreach($block['value'] as $value) {
			$text .= $value;
		}
		foreach($block['people'] as $people) {
			$action .= $people;
		}
		
		$title = $this->Html->div('btn-label orange', $block['title']);
		$subtt = $this->Html->div('btn-label light-blue', $subtt);
		$btn = $this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $this->Html->div('btn-label light-blue', $btntext));
		
		echo $this->Html->div('row no-margin feedback-block margin-bottom-30 text-019', 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $title) . 
						$path . $this->Html->div('col-md-8 col-sm-8 col-xs-8 margin-bottom-5 no-padding', $text) . $ally .
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $subtt) . 
						$action . $btn . 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $label) . 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $this->Html->div('btn-label orange', $radio)) . 
						$this->Html->div('col-md-12 col-sm-12 col-xs-12 margin-bottom-5', $comment) . 
						$this->Html->div('col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6 margin-top-20 border-bottom text-017', ''));
	}
}
?>
<div class="row no-margin"><?php
	if($disabled) {
		echo $this->Html->tag('h5', 'So, what do you think? Would you like to revise the picture your future or path', array('class' => 'activitytitle'));
		
		echo $this->Html->div('row no-margin text-center margin-bottom-5', $this->Html->link('Edit ENVISION', 
													array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => 188)), 
													array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3 btn btn-primary open-game text-018')));

		echo $this->Html->div('row no-margin margin-bottom-5', $this->Html->link('Edit DESIGN', 
													array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => 189)), 
													array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3 btn btn-primary open-game text-018')));

		echo $this->Html->div('row no-margin margin-bottom-15', $this->Html->link('Go to EXECUTE', 
													array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => 190)), 
													array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3 btn btn-primary open-game text-018')));
	}

echo $this->Html->div('row no-margin text-center margin-bottom-20', 
						$this->Html->link('Save and Close', '#', array('class' => 'btn btn-save orange', 'id' => 'tour-step-05')));
?></div>
</div>
<script>
$(document).ready(function(){
	Allies.SaveFeedback();
	Game.SaveAndCloseGame();
});
</script>