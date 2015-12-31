<div class="row no-margin">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
	
		echo $this->Html->div('challenge-title pull-left margin-top-10', $challenge['Challenge']['name'] . '<br />Challenge');
		
		$datetime1 = date_create(date('Y-m-d'));
		$datetime2 = date_create(date('Y-m-d', strtotime($challenge['Challenge']['complete_by'])));
		$interval = date_diff($datetime1, $datetime2);

		echo $this->Html->div('challenge-date pull-right', 
				$this->Html->tag('span', 'Created on<br />' . date('D jS M, Y', strtotime($challenge['Challenge']['created_on']))) .
				$this->Html->tag('span', $interval->format('%d&nbsp;&nbsp;&nbsp;&nbsp;00<br />DAYs&nbsp;&nbsp;HRs')));
	?></div>
</div>
<hr />
<div class="row no-margin">
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10 padding-left-0">
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padding"><?php
				$image = $challenge['User']['slug'];
		    	$image = (!empty($image))? '../files/img/medium/' . $image : 'profilecover.jpg';
	
				echo $this->Html->link( $this->Html->image($image), 
										array('action' => 'view', $challenge['Challenge']['id']), 
										array('escape' => false, 'class' => 'challenge-link thumbnail'));
			?></div>
			
			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 padding-right-0"><?php
				if($challenge['Challenge']['created_by'] == 'myself') {
					echo $this->Html->para('light-blue-normal', 'From:<br />Myself');
				} else {
					echo $this->Html->para('light-blue-normal', 'For:<br />' . $challenge['User']['name']);
				}
			
				$time = date('D jS M, Y', strtotime($challenge['Challenge']['complete_by']));
				echo $this->Html->para('light-blue-normal', 'Complete by:<br />' . $time);
			
				foreach($challenge['UserGameStatus'] as $user_game_status) {
					echo $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding road-map text-center',
							$this->Html->image('ch/road-map-selected.png', array('class' => 'margin-bottom-10')) . '<br />' .
							$this->Html->tag('span', $user_game_status['roadmap'], array('class' => 'light-blue-small')));
				}
			?></div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-left-0"><?php 
			
			echo $this->Html->para('blue-normal', $challenge['Challenge']['description']);
			
		if($challenge['Challenge']['created_by'] == 'myself') {
			
			echo $this->Html->para('greyed-xsmall', '(psst...you can view this in <u>My Data</u> right now)');
		}
		?></div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom-20 text-center"><?php 
		if($challenge['Challenge']['created_by'] == 'myself') {

			if($challenge['Challenge']['challenge_from_id'] != $challenge['Challenge']['user_id']) {
				
				$image = $challenge['ChallengeFrom']['slug'];
			    $image = (!empty($image))? '../files/img/medium/' . $image : 'profilecover.jpg';
				
				echo $this->Html->image($image, array('class' => 'ally-image'));
				echo $this->Html->para('blue-normal', 'Ally:<br />' . $challenge['ChallengeFrom']['name']);
				echo $this->Html->para('greyed-normal margin-bottom-25', 'Thank you!<br />You Ally will receive a notification to help you with this Challenge.');
			}

			echo $this->Html->div('action-button margin-bottom-20', 'Saved & Sent!');
		} else {
			
			echo $this->Html->para('blue-xsmall', '(psst...you can view this in <u>My Data</u> right now)');
		}
		?></div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding thumbnail text-center"><?php
			echo $this->Html->para('light-blue-normal', 'Share your achievement!');
			echo $this->Html->div('col-lg-4 col-md-4 col-sm-4 no-padding', $this->Html->image('icons/ch-twitter.png'));
			echo $this->Html->div('col-lg-4 col-md-4 col-sm-4 no-padding', $this->Html->image('icons/ch-facebook.png'));
			echo $this->Html->div('col-lg-4 col-md-4 col-sm-4 no-padding', $this->Html->image('icons/ch-instagram.png'));
		?></div>
	</div>
	<?php if($challenge['Challenge']['created_by'] == 'ally') { ?>
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-2 text-center margin-top-10"><?php
			echo $this->Html->div('action-button margin-bottom-5', 'Saved & Sent!');
			echo $this->Html->para('greyed-normal', 'Thank you!<br />Your Ally will recieve this Challenge soon!');
		?></div>
	<?php } ?>
</div>
