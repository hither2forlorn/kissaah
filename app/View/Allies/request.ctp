<?php
$ally_name = (empty($ally['User']['name']))? '': $ally['User']['name'];
if($ally_name == '') {
	$ally_name = $ally['User']['email'];
} 

if($this->request->is('ajax')) {
	echo '<div class="row no-margin allies">';
} else {
	echo '<div class="col-md-6 col-md-offset-3 allies">';
}

	echo $this->Html->tag('h3', 'How do you think ' . $ally_name . ' can help you?', array('class' => 'activitytitle'));
	echo $this->Html->para('margin-bottom-20', 'Your ally has an opportunity to review, rate and comment on your vision map and path design');

	$image = (empty($ally['User']['slug']))? 'profile.png': '/files/img/medium/' . $ally['User']['slug'];
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-4 col-lg-4 padding-left-0', 
			$this->Html->image($image, array('class' => 'img-responsive')));
	
	echo '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 no-padding">';
		echo $this->Form->create('Ally', array('id' => 'AllyRequestForm', 'class' => 'text-left', 'inputDefaults' => array(
														'div' => false, 'class' => 'form-control')));
														
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
		if($this->request->is('ajax')) {
			echo $this->Html->div('input-group margin-top-10',
					$this->Html->link('Send Request',
							array('controller' => 'allies', 'action' => 'request', $ally['User']['id']),
							array('class' => 'btn btn-in-progress ally-invite', 'escape' => false, 'data-type' => 'ajax')),
					array('class' => 'input-group-btn'));
			
		} else {
			echo $this->Form->submit('Send Request', array('class' => 'btn btn-in-progress', 'div' => 'input-group margin-top-10'));
			
		}
		echo $this->Form->end();
	echo '</div>';
	?>
	</div>
</div>
<script>
$(document).ready(function(){
	Allies.AllyFunctions();
});
</script>