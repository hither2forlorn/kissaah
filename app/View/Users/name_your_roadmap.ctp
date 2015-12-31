<div class='no-margin row roadmaps'>
	<?php echo $this->Html->tag('h3', 'Name your RoadMap ', array('class' => 'activitytitle')); ?>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<?php
		echo $this->Html->para('margin-bottom-10 margin-top-10','The name of your RoadMap should reflect your end goal and desire.
					For Example, your RoadMap could be called
					"Buying a House","Writing a Book" or "Moving Jobs".');
		
		echo $this->Html->para('margin-bottom-20','You can also create more RoadMaps to account for the 
							multiple goals you may have.');
							
		echo $this->Html->tag('h5','Go ahead, name your RoadMap here :', array('class' => 'activitytitle margin-bottom-20'));
		?>
	</div>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<span>This is my</span><br/>
		<span>Buying a House</span><br/>
		<span>RoadMap</span>
	</div>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<?php
			echo $this->Html->para('margin-bottom-20',"(Don't worry, you can re-name it later if you can change your mind)");
		?>
	</div>
</div>
