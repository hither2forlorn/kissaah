<?php echo $this->Html->css(array('challenges')); ?>

<?php echo $this->Form->create('Challenge', array('inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'), 
												  'action' => 'set_challenge')); ?>

<div class="row no-margin">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
		if(empty($challenge['Message'])) {
			$title = 'Ask a Question about the<br/>';
		} else {
			$title = 'Question response about the<br />';
		}

		echo $this->Html->div('challenge-title pull-left margin-top-10', $title . $challenge['Challenge']['name']);

		echo $this->Html->div('col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right margin-top-10 no-padding', 
							  $this->Html->image('ch/question-mark.png', array('class'=> 'img-responsive')));
	?></div>
</div>
<hr />

<div class="row no-margin margin-bottom-25"><?php
if(empty($challenge['Message'])) {
	$image = $challenge['ChallengeFrom']['slug'];
	if (!empty($image)) :
		$image = '../files/img/medium/' . $image;
	else :
		$image = 'profilecover.jpg';
	endif;	        	
	$image = $this->Html->link($this->Html->image($image), 
							   array('action' => 'view', $challenge['Challenge']['id']), 
							   array('escape' => false, 'class' => 'thumbnail challenge-link'));
	
	$text  = $this->Html->para('light-blue-normal', 'Your message from: ' . $challenge['ChallengeFrom']['name']);
	$text .= $this->Html->para('blue-normal', $challenge['Challenge']['description']);
	
	echo $this->Html->div('col-lg-3 col-md-3 col-sm-12 col-xs-12', $image);
	echo $this->Html->div('col-lg-9 col-md-9 col-sm-12 col-xs-12 padding-left-0', $text);
			
} else {
	
	$count = count($challenge['Message']);
	if($challenge['Message'][$count - 1]['user_id'] == $challenge['Challenge']['challenge_from_id']) {
		$image 	= $challenge['ChallengeFrom']['slug'];
		$from 	= $challenge['ChallengeFrom']['name'];
	} else {
		$image 	= $challenge['User']['slug'];
		$from 	= 'you'; //$challenge['User']['name'];
	}
	
	if (!empty($image)) :
		$image = '../files/img/medium/' . $image;
	else :
		$image = 'profilecover.jpg';
	endif;	        	

	$image = $this->Html->link($this->Html->image($image), 
							   array('action' => 'view', $challenge['Challenge']['id']), 
							   array('escape' => false, 'class' => 'thumbnail challenge-link'));
	
	echo $this->Html->div('col-lg-3 col-md-3 col-sm-12 col-xs-12', $image);
	echo $this->Html->div('col-lg-9 col-md-9 col-sm-12 col-xs-12 padding-left-0', 
				$this->Html->para('light-blue-small', 'On ' . date('d.m.Y', strtotime($challenge['Message'][$count - 1]['created'])) . ' ' . $from . ' wrote:') . 
				$this->Html->para('light-blue-normal', $challenge['Message'][$count - 1]['message']));

} 
?>
</div>

<div class="row no-margin">
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><?php
		$image = $this->Session->read('Auth.User.slug');
		if (!empty($image)) :
			$image = '../files/img/medium/' . $image;
		else :
			$image = 'profilecover.jpg';
		endif;
			        	
		echo $this->Html->link($this->Html->image($image), 
							   array('action' => 'view', $challenge['Challenge']['id']), 
							   array('escape' => false, 'class' => 'challenge-link thumbnail'));
	?></div>
	
	<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 padding-left-0"><?php
		echo $this->Form->input('id', 			array('value' => $challenge['Challenge']['id']));
		echo $this->Form->input('notification', array('type' => 'hidden', 'value' => '2'));
		
		echo $this->Form->input('Message.0.message', array('placeholder' => 'What\'s your question about this Challenge? 
																			 Type your question here then send. 
																			 (You will be notified of a reply in your Profile)'));
		
		echo $this->Form->input('Message.0.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
		echo $this->Form->input('Message.0.created', array('type' => 'hidden', 'value' => date('Y-m-d')));
		echo $this->Form->input('Message.0.modified', array('type' => 'hidden', 'value' => date('Y-m-d')));
		
		echo $this->Html->div('col-lg-4 col-md-4 col-sm-8 col-xs-8 pull-right no-padding margin-top-10', 
				$this->Form->submit('Send', array('class' => 'action-button-large', 'div' => false)));		
	?></div>
</div>
<?php echo $this->Form->end(); ?>

<script>
	Challenges.SaveChallenge();
</script>