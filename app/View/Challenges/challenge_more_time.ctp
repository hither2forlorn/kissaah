<?php 
echo $this->Html->css(array('challenges'));
echo $this->Html->script(array('../plugins/jquery-inputmask/jquery.inputmask.bundle.min')); ?>

<?php echo $this->Form->create('Challenge', array('inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'), 
												  'action' => 'set_challenge')); ?>
<div class="row no-margin">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
		echo $this->Html->div('challenge-title pull-left margin-top-10', 'Ask for <br />more time');
		echo $this->Html->div('col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right margin-top-10 no-padding', 
							  $this->Html->image('ch/add-more-time.png', array('class'=> 'img-responsive')));
							  
	?></div>
</div>
<hr />
<div class="row no-margin">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><?php

		echo $this->Form->input('id', 			 array('value' => $challenge['Challenge']['id']));
		echo $this->Form->input('action_status', array('type' => 'hidden', 'value' => 'Extension Requested'));
		echo $this->Form->input('notification',  array('type' => 'hidden', 'value' => '2'));
		
		echo $this->Html->para('blue-normal', 'Your Ally has set the complete-by date <br />
											   for this Challenge as:');
		
		echo $this->Html->div('action-button margin-bottom-10', date('D jS M, Y', strtotime($challenge['Challenge']['complete_by'])));
		
		if($challenge['Challenge']['action_status'] == 'Extension Requested') {
			echo $this->Html->para('light-blue-normal', 'New Date Requested');
			echo $this->Html->div('action-button margin-bottom-10', date('D jS M, Y', strtotime($challenge['Challenge']['new_complete_by'])));
			
			echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center', 
						$this->Html->para('light-blue-normal', $challenge['Challenge']['action_reason']));
			
			echo $this->Html->div('row margin-bottom-25 reject-status', 
					$this->Html->div('col-lg-6 col-md-6 col-sm-12 col-xs-12',
							$this->Html->div('action-button pull-right', 'Extension Approved')) .
					$this->Html->div('col-lg-6 col-md-6 col-sm-12 col-xs-12', 
							$this->Html->div('action-button', 'Extension Rejected')));
							
			echo $this->Form->input('new_complete_by', array('type' => 'hidden', 'value' => $challenge['Challenge']['new_complete_by']));
		
		} else {
			echo $this->Html->para('light-blue-normal', 'Giving you');
	
			$datetime1 = date_create(date('Y-m-d'));
			$datetime2 = date_create(date('Y-m-d', strtotime($challenge['Challenge']['complete_by'])));
			$interval = date_diff($datetime1, $datetime2);
			
			echo $this->Html->div('action-button margin-bottom-25', 
					$this->Html->tag('span', $interval->format('%d&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;00<br />DAYs&nbsp;&nbsp;&nbsp;&nbsp;HRs')));
	
			echo $this->Html->div('col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center', 
						$this->Html->para('light-blue-normal', 
								'Create a new complete-by date for your Ally to approve. 
								 Once accepted by your Ally, the complete-by date will be 
								 updated in My Pending Challenges.'));
			
			echo $this->Html->div('col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12 text-center margin-bottom-20',
						$this->Form->input('new_complete_by', array(
									'type' => 'text', 'class' => 'form-control date-picker')));
	
			echo $this->Form->input('action_reason'); 
			
		}

		echo $this->Html->div('col-lg-4 col-md-4 col-sm-8 col-xs-8 pull-right no-padding margin-top-10', 
				$this->Form->submit('Save', array('class' => 'action-button pull-right')));		
	?></div>
</div>
<?php echo $this->Form->end(); ?>

<script>
	/*$('.date-mask').inputmask('dd/mm/yyyy', {
		'placeholder' : 'dd/mm/yyyy'
	});*/
	Challenges.RejectChallenge();
	Challenges.SaveChallenge();
</script>