<?php echo $this->Html->css(array('challenges')); ?>

<div class="row no-margin margin-bottom-15 padding-10 challenges-header"><?php
if($this->request->params['pass'][0] == 'new') {
		
	if($this->request->params['pass'][1] > 0) {
		$notification = 'You have ' . $this->request->params['pass'][1] . ' new Challenges!';
	}
		
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 notification-strip', $notification);
	echo $this->Html->div('sorting-list', $this->Html->link('View earliest first', '#') . '<br />' .
										  $this->Html->link('View latest first', '#') . '<br />' .
										  $this->Html->link('View urgent first', '#'));
} else {
	if($this->request->params['pass'][0] == 'myself') {
		$text = 'My Pending Challenges';
		
	} else {
		$text = 'Ally Challenges' . $this->Html->para('light-blue-normal', 
						'Keep in touch your Allies and see how they\'re doing with the Challenges you\'ve set for them');
	}

	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12',
			$this->Html->div('challenge-title pull-left margin-top-10 padding-top-10', $text) .
			$this->Html->div('sorting-list pull-right', $this->Html->link('View urgent first', '#')));
}
?></div>
<?php
if($this->request->params['pass'][0] != 'new') {
	echo $this->Html->tag('hr', null);
}
?>
<div class="row no-margin padding-10">
<?php
foreach($challenges as $id => $challenge) {

	$assigned = 0;
	if($this->Session->read('Auth.User.id') == $challenge['Challenge']['user_id']) {
		$assigned = 1;
	}
	
	$buttons = array();

	$view = $this->Html->link($this->Html->image('ch/ch-view.png', array('class' => 'img-responsive challenge-icon')), 
									array('action' => 'view', $challenge['Challenge']['id']), 
									array('escape' => false, 'class' => 'challenge-link'));
	
	$out_of_time = $this->Html->link($this->Html->image('ch/out-of-time.png', array('class' => 'img-responsive challenge-icon')),
									array('action' => 'view', $challenge['Challenge']['id'], 'challenge_more_time'),
									array('escape' => false, 'class' => 'challenge-link-xsmall'));
	
	$time = $this->Html->link($this->Html->image('ch/add-more-time.png', array('class' => 'img-responsive challenge-icon')), 
									array('action' => 'view', $challenge['Challenge']['id'], 'challenge_more_time'), 
									array('escape' => false, 'class' => 'challenge-link-xsmall'));
	
	$question = $this->Html->link($this->Html->image('ch/question-mark.png', array('class' => 'img-responsive challenge-icon')), 
									array('action' => 'view', $challenge['Challenge']['id'], 'challenge_question'),
									array('escape' => false, 'class' => 'challenge-link-small'));
	
	$star = $this->Html->link($this->Html->image('ch/star-light.png', array('class' => 'img-responsive challenge-icon')),
									'#', array('escape' => false));
	
	$rejected = $this->Html->link($this->Html->image('ch/ch-rejected.png', array('class' => 'img-responsive challenge-icon')),
									'#', array('escape' => false)); 
	
	if($assigned) {
		$image = $challenge['ChallengeFrom']['slug'];
		$name = $challenge['ChallengeFrom']['name'];
		$text = 'created<br />';
	} else {
		$image = $challenge['User']['slug'];
		$name = $challenge['User']['name'];
		$text = 'you created<br />';
	}
	
	if (!empty($image)) :
		$image = '../files/img/medium/' . $image;
	else :
		$image = 'profile.png';
	endif;
	
?>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 margin-bottom-15">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 padding-left-0"><?php
			echo $this->Html->link($this->Html->image($image), array('action' => 'view', $challenge['Challenge']['id']), 
							  	   array('escape' => false, 'class' => 'challenge-link thumbnail'));
		?></div>
		
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 no-padding"><?php 
			echo $this->Html->para('light-blue-normal', $name); 
			echo $this->Html->tag('span', $text, array('class' => 'light-blue-normal'));
			echo $this->Html->para('blue-normal', $challenge['Challenge']['name']);
			
			$buttons[] = $view;
			
			$datetime1 = date_create(date('Y-m-d'));
			$datetime2 = date_create(date('Y-m-d', strtotime($challenge['Challenge']['complete_by'])));
			$interval = date_diff($datetime1, $datetime2);
			
			if($interval->format('%y') > 0) {
				$text = $interval->format('%y year %m month %d days');
			} elseif($interval->format('%m') > 0) {
				$text = $interval->format('%m month %d days');
			} else {
				$text = $interval->format('%d days');
			}

			$color = 'light-blue-normal';
			$text  = $text . ' left';
			
			if($challenge['Challenge']['status'] == 'New') {
				$buttons['Time'] = $time;
				if($challenge['Challenge']['complete_by'] < date('Y-m-d')) {
					$color = 'red-normal';
					$text  = 'Sorry! Out of time!';
					
					if($assigned) {
						$buttons['Time'] = $out_of_time;
					}
					
				}
				
				if(in_array($challenge['Challenge']['action_status'], array('Extension Approved', 'Extension Rejected'))) {
					unset($buttons['Time']);
				}
				
				if(!$assigned && is_null($challenge['Challenge']['action_status'])) {
					unset($buttons['Time']);
				}
				
				$lstMessage = count($challenge['Message']);
				if($lstMessage) {
					if($challenge['Message'][$lstMessage - 1]['user_id'] != $this->Session->read('Auth.User.id')) {
						$buttons['Question'] = $question;
					}
				}
				
			} elseif($challenge['Challenge']['status'] == 'Active') {
				if($challenge['Challenge']['complete_by'] < date('Y-m-d')) {
					$color = 'red-normal';
					$text  = 'Sorry! Out of time!';
					
				}

			} elseif($challenge['Challenge']['status'] == 'Rejected') {
				$color = 'red-normal';
				$text  = 'Rejected on ' . date('d.m.y', strtotime($challenge['Challenge']['accepted_on']));
				$buttons['Rejected'] = $rejected;

			} elseif($challenge['Challenge']['status'] == 'Completed') {
				$color = 'blue-normal';
				if($challenge['Challenge']['action_status'] == 'Approved') {
					$color = 'green-normal';
					
				} elseif($challenge['Challenge']['action_status'] == 'Rejected') {
					$color = 'red-normal';
					
				}
				$text = 'Completed on ' . date('d.m.y', strtotime($challenge['Challenge']['accepted_on']));
				$buttons['Completed'] = $star;
				
			}

			echo $this->Html->para($color, $text);
			
			foreach($buttons as $button) {
				echo $this->Html->div('col-lg-3 col-md-3 col-sm-6 col-xs-6 padding-left-0', $button);
			}
			
		?>
		</div>
	</div>
<?php
	if($id%2 == 1) {
		echo $this->Html->tag('hr', null, array('class' => 'clear'));
	}
}
if(isset($id) && ($id%2 == 0)) {
	echo $this->Html->tag('hr', null, array('class' => 'clear'));
}
?>
</div>