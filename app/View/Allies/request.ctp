<?php
	$ally_name = (empty($ally['User']['name']))? '': $ally['User']['name'];
	if($ally_name == '') {
		$ally_name = $ally['User']['email'];
	} 
?>
<div class='no-margin row allies'>
	<?php echo $this->Html->tag('h3', 'How do you think ' . $ally_name . ' can help you?', array('class' => 'activitytitle')); ?>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<?php
		$image = (empty($ally['User']['slug']))? 'profile.png': '/files/img/small/' . $ally['User']['slug'];
		echo $this->Html->image($image);
		
		echo $this->Html->para( 'margin-bottom-20 margin-top-10', 
								'Your ally has an opportunity to review, rate and comment on your vision map and path design');

		echo $this->Form->create('Ally', array('id' => 'AllyRequestForm', 'class' => 'text-left', 'inputDefaults' => array(
														'div' => false, 'class' => 'form-control margin-bottom-20')));
														
		echo $this->Form->input('ally', array('type' => 'hidden', 'value' => $ally['User']['id']));
		echo $this->Form->input('ally_email', array('type' => 'hidden', 'value' => $ally['User']['email']));
		echo $this->Form->input('ally_name', array('type' => 'hidden', 'value' => $ally_name));
		echo $this->Form->input('roadmap', array('type' => 'hidden'));
		
		if(isset($user_game_status_id)){
			echo $this->Form->input('user_game_status_id', array('options' => $user_game_status_id, 'label' => 'Select roadmap'));
		}

		echo $this->Form->input('need_ally_to', array('placeholder'	=> 'i need the ally to...'));
		echo $this->Form->input('help_with', array('placeholder' => 'this will help with...'));
		echo $this->Form->input('from_there', array('placeholder' => 'from there I can......'));
		
		if(empty($ally['User']['id'])) {
			echo $this->Html->para( 'margin-bottom-10 margin-top-10', 
									'As this person is not a ' . $this->Session->read('Company.name') . ' user right now, 
									 can you tell us their gender so we can address
									 them appropriately on your behalf?');
			echo $this->Form->radio('gender', array('M' => 'Male', 'F' => 'Female'), array(
																'div' 			=> 'radio-list',
																'label'			=> false,
																'legend'		=> false,
																'separator'		=> '&nbsp;&nbsp;&nbsp;'
			));
		}
		echo $this->Html->div('input-group margin-bottom-5 text-right',
				  					$this->Html->link('Send Request', 
				  									  array('controller' => 'allies', 'action' => 'request', $ally['User']['id']), 
				  									  array('class' => 'btn btn-ally-invite', 'escape' => false)), 
				  					array('class' => 'input-group-btn'));
		echo $this->Form->end();
		?>
	</div>
</div>
<script>
$(document).ready(function(){
	Allies.AllyFunctions();
});
</script>