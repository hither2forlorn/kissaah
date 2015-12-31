<?php echo $this->Html->css(array('challenges')); ?>
<?php echo $this->Form->create('Challenge', array('inputDefaults' => array(
												        'label' => false,
												        'div' 	=> false,
														'class' => 'form-control'), 'action' => 'set_challenge')); ?>

<div class="row no-margin">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
		echo $this->Html->div('challenge-title pull-left margin-top-10', 'Reject <br />Challenge');
		echo $this->Html->div('col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right margin-top-10 no-padding', 
							  $this->Html->image('ch/reject.png', array('class'=> 'img-responsive')));
							  
	?></div>
</div>
<hr />

<div class="row no-margin">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><?php

		echo $this->Form->input('id', 			 array('value' => $challenge['Challenge']['id']));
		echo $this->Form->input('status', 		 array('type' => 'hidden', 'value' => 'Rejected'));
		echo $this->Form->input('action_status', array('type' => 'hidden'));
		echo $this->Form->input('notification',  array('type' => 'hidden', 'value' => '2'));
		
		echo $this->Html->para('blue-normal', 'Please let your Ally know why you<br />are rejecting this Challenge:');
			
		echo $this->Html->div('row margin-bottom-25 reject-status', 
				$this->Html->div('col-lg-4 col-md-4 col-sm-12 col-xs-12',
						$this->Html->div('action-button pull-right', 'Unfeasible')) .
				$this->Html->div('col-lg-4 col-md-4 col-sm-12 col-xs-12', 
						$this->Html->div('action-button', 'Unclear')) .
				$this->Html->div('col-lg-4 col-md-4 col-sm-12 col-xs-12', 
						$this->Html->div('action-button pull-left', 'Irrelevant'))
		);
	
		echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center', 
					$this->Html->para('light-blue-normal', 
							'If you feel the Challenge is unfeasible, <br />you can always 
							 Ask for More Time, or Ask a Question <br />to your Ally before rejecting the Challenge.'));
		
		$placeholder  = 'Please leave an explanation for rejecting this Challenge. ';
		$placeholder .= 'This will help your Ally revise the Challenge to help you with your journey.';
		
		echo $this->Form->input('action_reason', array('placeholder' => $placeholder, 'class' => 'text-center form-control'));
		
		echo $this->Html->div('col-lg-4 col-md-4 col-sm-8 col-xs-8 pull-right no-padding margin-top-10', 
				$this->Form->submit('Save', array('class' => 'action-button pull-right')));		
	?></div>
</div>
<?php echo $this->Form->end(); ?>

<script>
	Challenges.RejectChallenge();
	Challenges.SaveChallenge();
</script>