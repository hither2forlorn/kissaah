<?php echo $this->Form->create('Challenge', array('inputDefaults' => array(
												        'label' => false,
												        'div' 	=> false,
														'class' => 'form-control'))); ?>
<div class="row no-margin">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
 		echo $this->Html->div('col-md-8 col-lg-8 pull-left margin-top-10 padding-left-0 form-field', 
 									$this->Form->input('name', array('placeholder' => 'Your Challenge Title here in 100 characters or less')));

		echo $this->Html->div('challenge-title pull-left margin-top-10 preview-field hidden', '');

		echo $this->Html->div('challenge-date pull-right', 
				$this->Html->tag('span', 'Created on<br />' . date('D jS M, Y')) .
				$this->Html->tag('span', '000&nbsp;&nbsp;&nbsp;&nbsp;00<br />DAYs&nbsp;&nbsp;HRs', array('class' => 'date-diff')));
	?></div>
</div>
<hr />

<div class="row no-margin">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 no-padding">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 no-padding thumbnail"><?php
			$image = 'profile.png';
			if($this->request->pass[0] == 'myself') {
				$image = $this->Session->read('Auth.User.slug');
	        	if (!empty($image)) :
					$image = '../files/img/medium/' . $image;
	        	else :
					$image = 'profile.png';
	        	endif;	        	
			}
			echo $this->Html->image($image, array('class' => 'profile-image'));
			if($this->request->pass[0] != 'myself') {
				echo $this->Form->input('assigned', array('class' => 'form-field form-control',
														  'placeholder' => 'Type Ally name'));
			}
			?></div>
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 padding-right-0"><?php
			if($this->request->pass[0] == 'myself') {
				echo $this->Html->para('light-blue-normal', 'From:<br />Myself');
			} else {
				echo $this->Html->para('light-blue-normal ally-name', 'For:<br />');
			}
			echo $this->Html->para('light-blue-normal', 'Complete by:<br />');
			echo $this->Form->input('complete_by', array(	'type'			=> 'text',
															'class' 		=> 'form-control date-picker margin-bottom-10 form-field'));
			echo $this->Html->para('light-blue-normal challenge-complete-by preview-field hidden', '');
			?></div>
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 desc padding-right-0 road-map-list"><?php
			if($this->request->pass[0] == 'myself') {
				foreach($road_maps as $id => $road_map) {
					echo $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding road-map',
						$this->Html->image('ch/road-map-grey.png', array('class' => 'margin-bottom-10')) .
						$this->Form->input('UserGameStatus.' . $id, array('type' => 'checkbox', 
																		  'label' => $this->Html->tag('span', $road_map, array('class' => 'light-blue-small')))));
				}
				echo $this->Html->div('clear', '');
				echo $this->Html->para('greyed-xsmall form-field', '(Pick the relevant RoadMap(s))');
			}
			?></div>
		</div>
		<?php
		if($this->request->pass[0] == 'myself') {
			echo $this->Html->div('col-lg-4 col-md-4 col-sm-12 col-xs-12 padding-right-0 select-ally text-center', 
						$this->Html->image('profile.png', array('class' => 'ally-image')) .
						$this->Form->input('assigned', array('class' => 'form-field form-control',
															 'placeholder' => 'Add Ally to help you')) .
						$this->Html->para('preview-field challenge-ally blue-normal', '')
			);
		}

		/* Setting default fields */
		if($this->request->pass[0] == 'myself') {
			echo $this->Form->input('accepted_on', array('type' => 'hidden', 'value' => date('Y-m-d')));
		}
		echo $this->Form->input('created_by', array('type' => 'hidden', 'value' => $this->request->pass[0]));
		echo $this->Form->input('challenge_from_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
		echo $this->Form->input('notification', array('type' => 'hidden', 'value' => 0));
		echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
		?>
	</div>
	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 no-padding"><?php 
			echo $this->Form->input('description', array('class' => 'form-field form-control',
														 'placeholder' => 'Leave details about the Challenge here:'));
			echo $this->Html->para('blue-normal challenge-description preview-field hidden', ''); 
		?></div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 padding-right-0 form-field"><?php
			echo $this->Html->div('action-button', 'Preview');
		?></div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 padding-right-0 preview-field hidden text-center"><?php
			echo $this->Html->div('action-button margin-bottom-5', 'Edit');
			echo $this->Form->submit('Save & Send', array('class' => 'action-button', 'div' => false));
		?></div>
	</div>
</div>
<?php echo $this->Form->end(); ?>
<script>
	/* $('.date-mask').inputmask('dd/mm/yyyy', {
		'placeholder' : 'dd/mm/yyyy'
	}); */
	
	Challenges.SelectRoadMap();
	Challenges.SelectAlly();
	Challenges.SaveChallenge();
	Challenges.PreviewChallenge();
</script>