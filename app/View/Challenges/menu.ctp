<?php echo $this->Html->css(array('challenges')); ?>
<div class="row challenges-header margin-bottom-15">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 notification-strip"><?php
	if($new > 0) {
		echo $this->Html->link('You have ' . $new . ' new Challenges!', array('action' => 'challenges', 'new', $new), array('class' => 'challenge-link'));
	} else {
		echo 'You have no new Challenges!';
	}
	?></div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><?php
		echo $this->Html->image('logo-challenges.png', array('class' => 'logo'));
	?></div>
	<!-- <div class="faq">FAQs</div> -->
</div>
<div class="row no-margin padding-20">
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<?php if($myself > 0) echo $this->Html->div('challenges-notification', $myself); ?>
		<div class="my-challenges">
			<div class="visual"><?php 
			echo $this->Html->link('My pending Challenges', array('action' => 'challenges', 'myself'), array('class' => 'challenge-link')); 
			?></div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="my-challenges">
			<div class="visual"><?php 
			echo $this->Html->link('Set myself a Challenge', array('action' => 'set_challenge', 'myself'), array('class' => 'challenge-link')); 
			?></div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="my-challenges">
			<div class="visual"><?php 
			echo $this->Html->link('View My Stats', array('action' => 'view_stats', 'myself'), array('class' => 'challenge-link-small')); 
			?></div>
		</div>
	</div>
</div>
<hr />
<div class="row no-margin padding-20 margin-bottom-15">
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<?php if($ally > 0) echo $this->Html->div('challenges-notification', $ally); ?>
		<div class="ally-challenges">
			<div class="visual"><?php 
			echo $this->Html->link('Ally pending Challenges', array('action' => 'challenges', 'ally'), array('class' => 'challenge-link')); 
			?></div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="ally-challenges">
			<div class="visual"><?php 
			echo $this->Html->link('Set Ally a Challenge', array('action' => 'set_challenge', 'ally'), array('class' => 'challenge-link')); 
			?></div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="ally-challenges">
			<div class="visual"><?php 
			echo $this->Html->link('View Ally Stats', array('action' => 'view_stats', 'ally'), array('class' => 'challenge-link-small')); 
			?></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		Challenges.Challenge();
	});
</script>