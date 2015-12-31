<?php echo $this->Html->css(array('challenges')); ?>
<?php echo $this->Form->create('Challenge', array('inputDefaults' => array(
												        'label' => false,
												        'div' 	=> false,
														'class' => 'form-control'), 'action' => 'set_challenge')); ?>

<div class="row no-margin">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php
		echo $this->Html->div('challenge-title pull-left margin-top-10', 'Switch RoadMaps for the<br />' . $challenge['Challenge']['name']);
		echo $this->Html->div('col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right margin-top-10 no-padding', 
							  $this->Html->image('ch/road-map.png', array('class'=> 'img-responsive')));
							  
	?></div>
</div>
<hr />

<div class="row no-margin"><?php
	$image = $challenge['User']['slug'];
	if (!empty($image)) :
		$image = '../files/img/medium/' . $image;
	else :
		$image = 'profilecover.jpg';
	endif;	        	
	$image = $this->Html->link($this->Html->image($image), 
							   array('action' => 'view', $challenge['Challenge']['id']), 
							   array('escape' => false, 'class' => 'thumbnail challenge-link'));
	
	echo $this->Html->div('col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center', $image .
							$this->Html->para('greyed-small', 'Can view 2/3 RoadMaps').
							$this->Html->para('greyed-xsmall', 'Switching RoadMaps will<br />send a notification to your Ally.'));
	
	echo $this->Form->input('id', 			array('value' => $challenge['Challenge']['id']));
	echo $this->Form->input('notification', array('type' => 'hidden', 'value' => '2'));
	
	?>
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 padding-left-0 road-map-list"><?php
		echo $this->Html->para('light-blue-normal', $challenge['ChallengeFrom']['name'] . ' chose these<br />RoadMap(s) for your Challenge.');
		echo $this->Html->para('blue-normal margin-bottom-20', 'Click to switch or change RoadMaps for this Challenge.');
		
		foreach($challenge['UserGameStatus'] as $id => $road_map){
			echo $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding road-map',
				$this->Html->image('ch/road-map-selected.png', array('class' => 'margin-bottom-10')) .
				$this->Form->input('UserGameStatus.' . $road_map['id'], array(
										'type' => 'checkbox', 'checked' => true,
										'label' => $this->Html->tag('span', $road_map['roadmap'], array('class' => 'light-blue-small')))));
										
			unset($road_maps[$road_map['id']]);
		}

		foreach($road_maps as $id => $road_map){
			echo $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding road-map',
				$this->Html->image('ch/road-map-grey.png', array('class' => 'margin-bottom-10')) .
				$this->Form->input('UserGameStatus.' . $id, array(
										'type' => 'checkbox', 
										'label' => $this->Html->tag('span', $road_map, array('class' => 'light-blue-small')))));
										
		}
		
		echo $this->Html->div('col-lg-4 col-md-4 col-sm-8 col-xs-8 pull-right no-padding margin-top-20', 
				$this->Form->submit('Change', array('class' => 'action-button-large', 'div' => false)));		
		
	?></div>
</div>
<?php echo $this->Form->end(); ?>

<script>
	Challenges.SelectRoadMap();
	Challenges.SaveChallenge();
</script>