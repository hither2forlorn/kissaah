<?php echo $this->Html->css(array('challenges')); ?>

<div class="row no-margin margin-bottom-15 padding-10 challenges-header"><?php
if($this->request->params['pass'][0] == 'new') {
		
	if($this->request->params['pass'][1] > 0) {
		$notification = 'You have ' . $this->request->params['pass'][1] . ' new Challenges!';
	}
		
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 notification-strip', $notification);
	echo $this->Html->div('sorting-list', $this->Html->link('View earliest first', '#') . '<br />' .
										  $this->Html->link('View latest first', '#') . '<br />' .
										  $this->Html->link('View urgent first', '#'));
} else {
	if($this->request->params['pass'][0] == 'myself') {
		$text  = 'My Completed Challenges<br />';
		$text .= $this->Session->read('Auth.User.name');
		
	} else {
		$text = 'Ally Challenges' . $this->Html->para('light-blue-normal', 
						'Keep in touch your Allies and see how they\'re doing with the Challenges you\'ve set for them');
	}

	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center',
			$this->Html->div('challenge-title margin-top-10 padding-top-10', $text));
}
?></div>
<div class="row no-margin padding-10">
<?php
	$image = $this->Session->read('Auth.User.slug');
	
	if (!empty($image)) :
		$image = '../files/img/medium/' . $image;
	else :
		$image = 'profile.png';
	endif;
?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-15 text-center"><?php
		echo $this->Html->image($image, array('class' => ''));
	?></div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-15 text-center"><?php 
		echo $this->Html->para('light-blue-normal', 'Your stat is as follows'); 
		
		foreach($stats as $stat) {
			echo $this->Html->para('light-blue-normal', $stat['Challenge']['status'] . ' - ' . $stat[0]['stats']);
		}

		echo $this->Html->para('blue-normal', 'Challenges');
	?></div>
</div>
