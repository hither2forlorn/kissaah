<div class="row no-margin">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
	$image = '';
	if($challenge['Challenge']['status'] == 'New') {
		$image = $this->Html->image('ch/ch-new.png');
		
	} elseif($challenge['Challenge']['status'] == 'Active') {
		$image = $this->Html->image('ch/ch-pending.png');

	} elseif($challenge['Challenge']['status'] == 'Rejected') {
		$image = $this->Html->image('ch/ch-pending.png');

	} elseif($challenge['Challenge']['status'] == 'Completed') {
		$image = $this->Html->image('ch/ch-pending.png');

	} elseif($challenge['Challenge']['complete_by'] < date('Y-m-d') && $challenge['Challenge']['status'] != 'Complete') {
		$image = $this->Html->image('ch/ch-out-of-time.png');
		
	}
	
	if($image != '') {
		echo $this->Html->div('margin-right-10 pull-left', $image);
	}
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
			
		?></div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	<?php
		$showbutton  = $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6', $buttons['Print']);
		$showbutton .= $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6', $buttons['Email']);
		$showbutton .= $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6', $buttons['Question']);
				
		$add_to_calendar = false;
		if($challenge['Challenge']['user_id'] == $this->Session->read('Auth.User.id')) {
			
			if($challenge['Challenge']['action_status'] == 'Extension Approved') {
				echo $this->Html->para('green-normal text-center', 'Extension Approved');
				
			} elseif($challenge['Challenge']['action_status'] == 'Extension Unapproved') {
				echo $this->Html->para('red-normal text-center', 'Extension Unapproved');
				
			}
			
			if($challenge['Challenge']['complete_by'] < date('Y-m-d') && $challenge['Challenge']['status'] != 'Complete') {
				
				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10', 
							$this->Html->div('action-button-large', $this->Html->link('Ask to replay this Challenge', 
															  array('action' => 'accept', $challenge['Challenge']['id']), 
															  array('class' => 'challenge-link'))));
	
				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10', 
							$this->Html->div('action-button-large', $this->Html->link('Ask for a new Challenge', 
															  array('action' => 'accept', $challenge['Challenge']['id']), 
															  array('class' => 'challenge-link'))));
	
				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10', 
							$this->Html->div('action-button-large', $this->Html->link('Help your Ally achieve their goals!', 
															  array('action' => 'accept', $challenge['Challenge']['id']), 
															  array('class' => 'challenge-link'))));
				
			} elseif($challenge['Challenge']['status'] == 'New') {
				
				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-20', 
							$this->Html->div('action-button-large', $this->Html->link('Accept Challenge', 
															  array('action' => 'accept', $challenge['Challenge']['id']), 
															  array('class' => 'challenge-link'))));
	
				$showbutton  = $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6', $buttons['Print']);
				$showbutton .= $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6', $buttons['Time']);
				$showbutton .= $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6', $buttons['Question']);
	
				$showbutton .= $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6 margin-top-10', $buttons['Email']);
				$showbutton .= $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6 margin-top-10', $buttons['Roadmap']);
				$showbutton .= $this->Html->div('col-lg-4 col-md-4 col-sm-6 col-xs-6 margin-top-10', $buttons['Reject']);
				
				$add_to_calendar = true;
	
			} elseif($challenge['Challenge']['status'] == 'Accepted') {
				
				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-20',
							$this->Html->div('action-button-large pull-left', 
									$this->Html->div('col-lg-9 col-md-9 col-sm-12 col-xs-12', 'Challenge Accepted') . 
									$this->Html->div('col-lg-3 col-md-3 col-sm-12 col-xs-12 padding-left-0', 
													 $this->Html->image('ch/star-dark.png', array('class' => 'img-responsive')))));
				
				echo $this->Html->para('light-blue-normal text-center margin-bottom-20', 
									   'You can now view this Challenge in My Pending Challenges.<br />Good luck!');
									   
				$add_to_calendar = true;
				
			} elseif($challenge['Challenge']['status'] == 'Active') {
				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-20', 
							$this->Html->div('action-button-large', $this->Html->link('Challenge Completed', 
															  array('action' => 'view', $challenge['Challenge']['id'], 'challenge_completed'), 
															  array('class' => 'challenge-link-xsmall'))));

				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-20',
							$this->Html->div('action-button-large pull-left', 
									$this->Html->div('col-lg-8 col-md-8 col-sm-12 col-xs-12', 
													 'Challenge Accepted<br />on ' . date('d.m.y', strtotime($challenge['Challenge']['accepted_on']))) . 
									$this->Html->div('col-lg-4 col-md-4 col-sm-12 col-xs-12 padding-left-0', 
													 $this->Html->image('ch/star-dark.png', array('class' => 'img-responsive')))));
				
			}
			
		} else {

			if($challenge['Challenge']['status'] == 'New') {
				
				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-20', 
							$this->Html->div('action-button-large', 'Waiting for Acceptance'));
	
			} elseif($challenge['Challenge']['status'] == 'Active') {
				
				echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-20',
							$this->Html->div('action-button pull-left', 
									$this->Html->div('col-lg-8 col-md-8 col-sm-12 col-xs-12', 
													 'Challenge Accepted<br />on ' . date('d.m.y', strtotime($challenge['Challenge']['accepted_on']))) . 
									$this->Html->div('col-lg-4 col-md-4 col-sm-12 col-xs-12 padding-left-0', 
													 $this->Html->image('ch/star-dark.png', array('class' => 'img-responsive')))));
				
			}
		}
		echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12', $showbutton); 

		if($add_to_calendar) {
			$calendar  = $this->Html->tag('span', $challenge['Challenge']['complete_by'], array('class' => '_start'));
			$calendar .= $this->Html->tag('span', $challenge['Challenge']['complete_by'], array('class' => '_end'));
			$calendar .= $this->Html->tag('span', $challenge['Challenge']['name'], array('class' => '_summary'));
			$calendar .= $this->Html->tag('span', $challenge['Challenge']['description'], array('class' => '_description'));
			$calendar .= $this->Html->tag('span', 'true', array('class' => '_all_day_event'));

			echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-20 margin-top-10 text-center', 
						$this->Html->link('Add to Calendar' . $calendar, '#', array('class' => 'addthisevent event', 
																					'title' => 'Add to Calendar', 'escape' => false)));
			
		}
		?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	Game.initAddToCalendar();
	addthisevent.refresh();
});
</script>