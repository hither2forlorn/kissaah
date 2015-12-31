<?php echo $this->Html->css(array('challenges')); ?>
<?php echo $this->Form->create('Challenge', array('inputDefaults' => array(
												        'label' => false,
												        'div' 	=> false,
														'class' => 'form-control'), 'action' => 'set_challenge')); ?>

<div class="row no-margin">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
		echo $this->Html->div('challenge-title pull-left margin-top-10', 'You completed<br />this Challenge! Yay!');
		echo $this->Html->div('col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right margin-top-10 no-padding', 
							  $this->Html->image('ch/star.png', array('class'=> 'img-responsive')));
							  
	?></div>
</div>
<hr />

<div class="row no-margin">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><?php

		echo $this->Form->input('id', 			 array('value' => $challenge['Challenge']['id']));
		echo $this->Form->input('status', 		 array('type' => 'hidden', 'value' => 'Completed'));
		echo $this->Form->input('notification',  array('type' => 'hidden', 'value' => '2'));
		
		echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center', 
					$this->Html->para('light-blue-normal', 
							'Tell your Ally how you completed the Challenge they set you.'));
		
		echo $this->Form->input('action_reason', array('class' => 'text-center form-control'));
		
		echo $this->Html->div('col-lg-4 col-md-4 col-sm-8 col-xs-8 pull-right no-padding margin-top-10', 
				$this->Form->submit('Save', array('class' => 'action-button pull-right')));		
	?></div>
</div>
<?php echo $this->Form->end(); ?>

<script>
	Challenges.SaveChallenge();
</script>