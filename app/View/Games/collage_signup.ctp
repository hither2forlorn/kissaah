<div class='no-margin row'>
	<div class='col-xs-7 col-sm-7 col-md-7 col-lg-7'>
		<?php echo $this->Html->tag('h3', 'Make a collage of your RoadMap', array('class' => 'activitytitle')); ?>
		<?php
		echo $this->Html->para('margin-top-10', 'In your ' . $this->Session->read('Company.name') . ' game,you will be using an interactive vision board which you 
								 				 will populate with your own images and other content.');
	    echo $this->Html->tag('strong', 'This is called your RoadMap');
		echo $this->Html->para('margin-top-10 margin-bottom-20', 'Once you\'ve completed your RoadMap, ' . $this->Session->read('Company.name') . ' can 
								automatically create a Collage of it, complete with your images to document your journey.
								You can save this as a keepsake and/or share it with other people in your network and 
								outside of the ' . $this->Session->read('Company.name') . ' Community.');
		echo $this->Html->para('margin-top-10 margin-bottom-20', 'You can also consent to let ' . $this->Session->read('Company.name') . ' use your RoadMap 
								Collage in order to inspire other people also using ' . $this->Session->read('Company.name') . '.');
		 echo $this->Html->para('margin-top-10 margin-bottom-20', 'Completed RoadMaps show where you were, and what 
		 						you\'ve gained and achieved through the game, and this is great for the 
		 						' . $this->Session->read('Company.name') . ' Community to see!');
		?>
	</div>
	<div class='col-xs-5 col-sm-5 col-md-5 col-lg-5 '>
		<?php 
		echo $this->Html->image('CollageSignUp.png',array('class' => 'img-responsive margin-bottom-10'));
		
		echo $this->Html->link('Make my RoadMap Collage for my own personal use ' . 
				$this->Html->tag('span', '(which I can share as I wish)', array('class' => 'btn-collage-small')), 
				array('controller' => 'users' , 'action' => 'edit'), 
				array('class' => 'btn btn-primary collapsed btn-collage margin-bottom-5', 'escape' => false , 'data' => 0));
				
		echo $this->Html->link('Let ' . $this->Session->read('Company.name') . ' use my RoadMap Collage publicly to inspire others ' .
				$this->Html->tag('span', '(RoadMap collages may appear on the 
					' . $this->Session->read('Company.name') . ' website and/or social media pages)', array('class' => 'btn-collage-small')), 
				array('controller' => 'users' , 'action' => 'edit'), 
				array('class' => 'btn btn-primary collapsed btn-collage margin-bottom-5', 'escape' => false , 'data' => 1));
		
		echo $this->Html->link('Let me decide later ' .
				$this->Html->tag('span', '(you can change your preferences in Settings 
					and when you complete your RoadMap)', array('class' => 'btn-collage-small')), 
				array('controller' => 'users' , 'action' => 'edit'), 
				array('class' => 'btn btn-primary collapsed btn-collage margin-bottom-5', 'escape' => false , 'data' => 0));
		?>
	</div>
</div>
<script>
	$(document).ready(function(){
		Game.CollageSignUp();
	});
</script>