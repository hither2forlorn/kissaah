<?php echo $this->Html->css(array('challenges')); ?>
<div class="row challenges-header">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
		echo $this->Html->div('new-challenges-logo pull-left', $this->Html->image('new-challenge.png'));
		echo $this->Html->div('challenge-title pull-left margin-top-10', 'Digital Exhibition Challenge');
		echo $this->Html->div('challenge-date pull-right', 'Created on <br /> Mon 18th Jan, 2015');
		echo $this->Html->div('challenge-date pull-right', '003 14<br />DAYs HRs');
	?></div>
</div>
<hr />
<div class="row challenges-row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 thumbnail"><?php
			echo $this->Html->link($this->Html->image('sample.jpg'), array('action' => 'view'), array('escape' => false, 'class' => 'challenge-link'));;
			?></div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 desc">
				From:<br />Alici May <br /><br />
				Complete by:<br />
				on Mon 18th Jan
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<p>Hi Betty,</p>
			<p>The Digital Revolution exhibition is fantastic, and is taking place at the
				Barbican. I think this will be useful for your PhD RoadMap AND inspire you
				in your ambition to become a CTO! The exhibition is finishing on the
				21st Jan. I know you will love it!</p>
			<p>Have fun!</p>
			<p>Alicia xoxo</p>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 action-block"><?php
			echo $this->Html->div('action margin-bottom-10', 
					$this->Html->link('Challenge Accepted!', array('action' => 'accept'), array('class' => 'challenge-link-small')));
			echo $this->Html->tag('p', 'You can now view this Challenge in My Pending Challenges. <br />Good luck!');
			echo $this->Html->div('action-button pull-left', $this->Html->image('ch/email-icon.png'));
			echo $this->Html->div('action-button pull-left', $this->Html->image('ch/question-mark.png'));
			echo $this->Html->div('action-button pull-left', $this->Html->image('ch/reject.png'));
		?></div>
	</div>
</div>