<?php echo $this->Html->css(array('challenges')); ?>
<?php
	$status = $challenge['Challenge']['status'];
	
	$buttons['Print'] = $this->Html->link($this->Html->image('ch/printer.png', array('class' => 'img-responsive')), '#',
									array('escape' => false, 'class' => 'challenge-link-small'));
	
	$buttons['Email'] = $this->Html->link($this->Html->image('ch/email-icon.png', array('class' => 'img-responsive')), '#',
									array('escape' => false, 'class' => 'challenge-link-small'));
	
	$buttons['Question'] = $this->Html->link($this->Html->image('ch/question-mark.png', array('class' => 'img-responsive')), 
									array('action' => 'view', $challenge['Challenge']['id'], 'challenge_question'),
									array('escape' => false, 'class' => 'challenge-link-small'));
	
	$buttons['Time'] = $this->Html->link($this->Html->image('ch/add-more-time.png', array('class' => 'img-responsive')), 
									array('action' => 'view', $challenge['Challenge']['id'], 'challenge_more_time'), 
									array('escape' => false, 'class' => 'challenge-link-xsmall'));
	
	if(in_array($challenge['Challenge']['action_status'], array('Extension Requested', 'Extension Approved', 'Extension Unapproved'))) {
		$buttons['Time'] = $this->Html->image('ch/add-more-time-grey.png', array('class' => 'img-responsive'));
		
	}
									
	$buttons['Roadmap'] = $this->Html->link($this->Html->image('ch/road-map.png', array('class' => 'img-responsive')), 
									array('action' => 'view', $challenge['Challenge']['id'], 'challenge_road_map'),
									array('escape' => false, 'class' => 'challenge-link-small'));
									
	$buttons['Reject'] = $this->Html->link($this->Html->image('ch/reject.png', array('class' => 'img-responsive')), 
									array('action' => 'view', $challenge['Challenge']['id'], 'challenge_reject'), 
									array('escape' => false, 'class' => 'challenge-link-small'));

	
	if($status == 'Created') {
		echo $this->element('challenges/' . strtolower($status));
	} else {
		echo $this->element('challenges/view', array('buttons' => $buttons));
	}
	
?>
<?php /*
<div class="row challenges-header">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
	
	if($status == 'Created') {
		echo $this->Html->div('challenge-title pull-left margin-top-10', $challenge['Challenge']['name'] . '<br />Challenge');
		echo $this->Html->div('challenge-date pull-right', 'Created on <br />' . date('D jS M, Y', strtotime($challenge['Challenge']['created_on'])));
		
		$datetime1 = date_create(date('Y-m-d'));
		$datetime2 = date_create(date('Y-m-d', strtotime($challenge['Challenge']['complete_by'])));
		$interval = date_diff($datetime1, $datetime2);
		echo $this->Html->div('challenge-date pull-right', $interval->format('%y Year %m Month %d Day(s)'));

	} elseif($status == 'New') {
		echo $this->Html->div('new-challenges-logo pull-left', $this->Html->image('ch/ch-new.png'));
		echo $this->Html->div('challenge-title pull-left margin-top-10', $challenge['Challenge']['name'] . '<br />Challenge');
		echo $this->Html->div('challenge-date pull-right', 'Created on <br />' . date('D jS M, Y', strtotime($challenge['Challenge']['created_on'])));
		
		if($challenge['Challenge']['action_status'] == 'Extension Approved') {
			echo $this->Html->para('light-green-normal pull-right', 'Extension approved');
		} elseif($challenge['Challenge']['action_status'] == 'Extension Rejected') {
			echo $this->Html->para('red-normal pull-right', 'Extension unapproved');
		}
		
	} elseif($status == 'Accepted') {
		echo $this->Html->div('new-challenges-logo pull-left', $this->Html->image('ch/ch-pending.png'));
		echo $this->Html->div('challenge-title pull-left margin-top-10', $challenge['Challenge']['name'] . '<br />Challenge');
		echo $this->Html->div('challenge-date pull-right', 'Created on <br />' . date('D jS M, Y', strtotime($challenge['Challenge']['created_on'])));

		$datetime1 = date_create(date('Y-m-d'));
		$datetime2 = date_create(date('Y-m-d', strtotime($challenge['Challenge']['complete_by'])));
		$interval = date_diff($datetime1, $datetime2);
		echo $this->Html->div('challenge-date pull-right', 'Finish in <br />' . $interval->format('%y Year %m Month %d Day(s)'));

	} elseif($status == 'Active') {
		echo $this->Html->div('new-challenges-logo pull-left', $this->Html->image('ch/ch-pending.png'));
		echo $this->Html->div('challenge-title pull-left margin-top-10', $challenge['Challenge']['name'] . '<br />Challenge');
		echo $this->Html->div('challenge-date pull-right', 'Created on <br />' . date('D jS M, Y', strtotime($challenge['Challenge']['created_on'])));

		$datetime1 = date_create(date('Y-m-d'));
		$datetime2 = date_create(date('Y-m-d', strtotime($challenge['Challenge']['complete_by'])));
		$interval = date_diff($datetime1, $datetime2);
		echo $this->Html->div('challenge-date pull-right', 'Finish in <br />' . $interval->format('%y Year %m Month %d Day(s)'));

	} elseif($status == 'Rejected') {
		echo $this->Html->div('new-challenges-logo pull-left', $this->Html->image('new-challenge.png'));
		echo $this->Html->div('challenge-title pull-left margin-top-10', $challenge['Challenge']['name'] . '<br />Challenge');
		echo $this->Html->div('action-button pull-right margin-top-10', $this->Html->image('ch/reject.png'));

	} elseif($status == 'Completed') {
		echo $this->Html->div('new-challenges-logo pull-left', $this->Html->image('new-challenge.png'));
		echo $this->Html->div('challenge-title pull-left margin-top-10', $challenge['Challenge']['name'] . '<br />Challenge');
		echo $this->Html->div('action-button pull-right margin-top-10', $this->Html->image('ch/reject.png'));

	}
	?></div>
</div>
<hr />
<div class="row challenges-row">
	<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10 padding-left-0">
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padding"><?php
			$image = $challenge['ChallengeFrom']['slug'];
			if($status == 'Created') {
				if($this->Session->read('Auth.user.id') != $challenge['ChallengeFrom']['id']) {
					$image = $challenge['User']['slug'];
				}
			}
			
	    	if (!empty($image)) :
				$image = '../files/img/medium/' . $image;
	    	else :
				$image = 'profilecover.jpg';
	    	endif;	        	
			echo $this->Html->link( $this->Html->image($image), 
									array('action' => 'view', $challenge['Challenge']['id']), 
									array('escape' => false, 'class' => 'challenge-link thumbnail'));
			?></div>
			
			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 desc padding-right-0"><?php
			if($status == 'Created') {
				if($this->Session->read('Auth.user.id') == $challenge['ChallengeFrom']['id']) {
					echo $this->Html->para('light-blue-normal', 'From:<br />Myself');
				} else {
					echo $this->Html->para('light-blue-normal', 'For:<br />' . $challenge['User']['name']);
				}
				
			} else {
				if($this->Session->read('Auth.user.id') == $challenge['ChallengeFrom']['id']) {
					echo $this->Html->para('light-blue-normal', 'From:<br />Myself');
				} else {
					echo $this->Html->para('light-blue-normal', 'From:<br />' . $challenge['ChallengeFrom']['name']);
				}
				
			}
			
			$time = date('D jS M, Y', strtotime($challenge['Challenge']['complete_by']));
			if($challenge['Challenge']['action_status'] == 'Extension Approved') {
				$time = $this->Html->tag('span', date('D jS M, Y', strtotime($challenge['Challenge']['complete_by'])), array('class' => 'light-green-normal'));
			}
			echo $this->Html->para('light-blue-normal', 'Complete by:<br />' . $time);
			
			foreach($challenge['UserGameStatus'] as $user_game_status) {
				echo $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding road-map',
						$this->Html->image('ch/road-map-selected.png', array('class' => 'margin-bottom-10')) . '<br />' .
						$user_game_status['roadmap'] . '<br />RoadMap');
			}
	
			if($status == 'Created') {
			} elseif($status == 'New') {
			} elseif($status == 'Accepted') {
			} elseif($status == 'Active') {
			} elseif($status == 'Rejected') {
			} elseif($status == 'Completed') {
			}
			?></div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-left-0"><?php 
			if($status == 'Rejected' || $challenge['Challenge']['action_status'] == 'Extension Rejected') {
				echo $this->Html->para('blue-normal', $challenge['Challenge']['action_reason']);
			} else {
				echo $this->Html->para('blue-normal', $challenge['Challenge']['description']);
			}
			
			if($status == 'Created') {
				echo $this->Html->para('greyed-xsmall', '(psst...you can view this in <u>My Data</u> right now)');
			} 
		?></div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 action-block no-padding"><?php
		$print = $this->Html->link($this->Html->image('ch/printer.png'), '#',
										array('escape' => false, 'class' => 'challenge-link-small'));
		
		$email = $this->Html->link($this->Html->image('ch/email-icon.png'), '#',
										array('escape' => false, 'class' => 'challenge-link-small'));
		
		$question = $this->Html->link($this->Html->image('ch/question-mark.png'), 
										array('action' => 'view', $challenge['Challenge']['id'], 'challenge_question'),
										array('escape' => false, 'class' => 'challenge-link-small'));
		
		$time = $this->Html->link($this->Html->image('ch/add-more-time.png'), 
										array('action' => 'view', $challenge['Challenge']['id'], 'challenge_more_time'), 
										array('escape' => false, 'class' => 'challenge-link-xsmall'));
		if($challenge['Challenge']['action_status'] == 'Extension Rejected') {
			$time = $this->Html->image('ch/add-more-time-grey.png');
		}
										
		$roadmap = $this->Html->link($this->Html->image('ch/road-map.png'), 
										array('action' => 'view', $challenge['Challenge']['id'], 'challenge_road_map'),
										array('escape' => false, 'class' => 'challenge-link-small'));
										
		$reject = $this->Html->link($this->Html->image('ch/reject.png'), 
										array('action' => 'view', $challenge['Challenge']['id'], 'challenge_reject'), 
										array('escape' => false, 'class' => 'challenge-link-small'));
		  
		//debug($status);debug($challenge['Challenge']['user_id']);debug($this->Session->read('Auth.User.id'));
		
 		/* If the challenege is assigned to me */
 		/*
		if($challenge['Challenge']['user_id'] == $this->Session->read('Auth.User.id')) {
			
			if($status == 'Created') {
		
			} elseif($status == 'New') {
				echo $this->Html->div('action margin-bottom-10', $this->Html->link('Accept Challenge', 
																					array('action' => 'accept', $challenge['Challenge']['id']), 
																					array('class' => 'challenge-link')));
				
				echo $this->Html->div('action-button pull-left', $print);
				echo $this->Html->div('action-button pull-left', $time);
				echo $this->Html->div('action-button pull-left', $question);
												
				echo $this->Html->div('action-button pull-left', $email);
				echo $this->Html->div('action-button pull-left', $roadmap);
				echo $this->Html->div('action-button pull-left', $reject);
	
			} elseif($status == 'Accepted') {
				echo $this->Html->div('action margin-bottom-10 pull-left', 
						$this->Html->tag('span', 'Challenge Accepted!', array('class' => 'pull-left')) . 
						$this->Html->image('ch/star-dark.png', array('class' => 'pull-left')));
				
				echo $this->Html->para(null, 'You can now view this Challenge in My Pending Challenges. <br />Good luck!');
				
				echo $this->Html->div('action-button pull-left', $print);
				echo $this->Html->div('action-button pull-left', $email);
				echo $this->Html->div('action-button pull-left', $question);
				
			} elseif($status == 'Active') {
				echo $this->Html->div('action margin-bottom-10 pull-left', 
						$this->Html->tag('span', 'Challenge Accepted<br />on ' . date('d.m.y', strtotime($challenge['Challenge']['accepted_on'])), array('class' => 'pull-left')) . 
						$this->Html->image('ch/star-dark.png', array('class' => 'pull-left')));
				
				echo $this->Html->div('action-button pull-left', $print);
				echo $this->Html->div('action-button pull-left', $email);
				echo $this->Html->div('action-button pull-left', $question);
				
			} elseif($status == 'Rejected') {
				echo $this->Html->para('light-blue-small', 'Challenge rejected as');
				echo $this->Html->div('action margin-bottom-40', $this->Html->link($challenge['Challenge']['action_status'], '#',  
																					array('class' => 'challenge-link')));
				echo $this->Html->div('action margin-bottom-10', $this->Html->link('Ask Ally to help you!', '#',  
																					array('class' => 'challenge-link')));
				echo $this->Html->div('action margin-bottom-10', $this->Html->link('Create new Challenge for Ally!',
													array('action' => 'set_challenge', 'ally'),
													array('class' => 'challenge-link')));
	
				echo $this->Html->div('action-button pull-left', $this->Html->image('ch/email-icon.png'));
				echo $this->Html->div('action-button pull-left', $this->Html->image('ch/printer.png'));
				echo $this->Html->div('action-button pull-left', $question);
				
			}
			
		/* If the challenege is assigned to an ally */
		/*
		} elseif($challenge['Challenge']['user_id'] != $this->Session->read('Auth.User.id')) {
			
		}
		?></div>
	</div>
</div>
*/ ?>