<div class='no-margin row collage-box'>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<?php
		echo $this->Html->tag('h3', 'Logging in using Facebook?', array('class' => 'activitytitle')); 

		echo $this->Html->para('margin-top-10', 'Great! Please don\'t forget to logout of your Facebook account 
								once you\'ve finished your session with Kissaah today. This will prevent other 
								users from accidentally your Kissaah account if they want to use Kissaah from this PC/laptop as well.');

		echo $this->Html->para('got-it', $this->Html->link('Got it !', array('controller' => 'users' , 'action' => 'edit'), 
           					   array('class' => 'btn btn-primary margin-bottom-10 btn-facebook', 'escape' => false)));

		echo $this->Html->para('margin-top-10', 'Understood, I don\'t need to see this message again ' . 
												$this->Form->checkbox('User.facebook_warning', array('hiddenField' => false)));
		
		echo $this->Html->tag('h5', 'If you logout of Facebook during your Kissaah session, then please refresh 
									 your Kissaah browser in order to log out of Kissaah.', array('class' => 'activitytitle')); 
		?>
	</div>
</div>
<script>
	$(document).ready(function(){
		Game.FacebookSession();
	});
</script>