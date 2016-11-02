<div class='no-margin row roadmaps'>
<?php 
if(isset($roadmaps)){
	if(count($roadmaps) == 1 && $roadmaps[0]['UserGameStatus']['roadmap'] == '') {
?>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<?php
	 	echo $this->Html->tag('h3', 'Name your RoadMap', array('class' => 'activitytitle')); 

		echo $this->Html->para( 'margin-top-10', 
								'The name of your RoadMap should reflect a desired outcome or goal.');
		echo $this->Html->para( 'margin-top-10 margin-bottom-20', 
								'Here are a few examples: "Triathlon", "Perform at Carnegie", "Educate our youth", or "Autobiography".');
		echo $this->Html->para( 'margin-top-10 margin-bottom-20', 
								'You can also create more RoadMaps to account various facets of your life.');

	    echo $this->Html->tag('h5', 'Go ahead, name your RoadMap here:', 
	    					  array('class' => 'activitytitle margin-bottom-20')); 
							  
	    echo $this->Html->tag('h4', 'This is my', 
	    					  array('class' => 'activitytitle margin-top-10')); 
							  
		echo $this->Form->input('roadmap', array(
									'id'			=> $roadmaps[0]['UserGameStatus']['id'],
									'label' 		=> false,
									'div'   		=> false,
								    'class'			=> 'form-control roadmap-input',
									'type'			=> 'text',
									'placeholder'	=> 'You only have 20 characters!'));
		
		echo $this->Html->tag('h5', '', array('class' => 'activitytitle error-message'));

	    echo $this->Html->tag('h4', 'RoadMap', array('class' => 'activitytitle margin-top-10'));
		
		echo $this->Html->link('Save RoadMap', 
				array('controller' => 'games', 'action' => 'index'),
				array('class' => 'btn btn-primary collapsed roadmap-save', 'escape' => false));
				
		echo $this->Html->para('margin-top-10', 
				$this->Html->tag('span', '(Don\'t worry, you can re-name it later if you change your mind)', 
								 array('class' => 'btn-collage-small')));
		?>
	</div>
<?php
	} else {
?>
	<?php
		echo $this->Html->tag('h3', 'RoadMaps', array('class' => 'activitytitle'));
		echo $this->Html->tag('h5', 'Click icon to switch RoadMaps', array('class' => 'activitytitle'));
		$key = -1;
		foreach($roadmaps as $key => $roadmap) {
			if($roadmap['UserGameStatus']['active']) {
				$active = 'my-roadmap-active.png';
				$show_delete = '';
			} else {
				$active = 'my-roadmap.png';
				$show_delete = $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-times')), 
					  		array('controller' => 'users', 'action' => 'roadmap_delete', $roadmap['UserGameStatus']['id']),
							array('escape' => false));
			}
			echo $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 roadmap-block', 
				  //$show_delete .
				$this->Html->link(
				  		$this->Html->image($active, array('class' => 'img-responsive margin-bottom-10')), 
				  		array('controller' => 'users', 'action' => 'roadmap_edit_active', $roadmap['UserGameStatus']['id']),
						array('escape' => false)) . 
				$this->Form->label('Your') . 
				$this->Form->input('roadmap', array(
						'data-id' => $roadmap['UserGameStatus']['id'],
						'label'   => false,
						'div'     => false,
				    	'class'	  => 'form-control roadmap-input margin-bottom-5',
						'type'	  => 'text',
						'value'	  => $roadmap['UserGameStatus']['roadmap'])) .
				$this->Form->input('configuration_id', array(
						'conf-id' => $roadmap['UserGameStatus']['id'],
						'label'   => false,
						'div'     => false,
				    	'class'	  => 'form-control roadmap-input',
						'empty'	  => '--SELECT--',
						'value'	  => $roadmap['UserGameStatus']['configuration_id'])) .
				$this->Form->label('RoadMap'));
		}
		for($key++; $key < 3; $key++) {
			echo $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 roadmap-block', 
				$this->Html->link(
						  $this->Html->image('my-roadmap-add.png', array('class' => 'img-responsive margin-bottom-10')), 
						  '#', array('escape' => false)) .
						  $this->Form->label('Add') . 
				$this->Form->input('roadmap', array(
				  		'data-id' => 0,
						'label'   => false,
						'div'     => false,
				    	'class'	  => 'form-control roadmap-input margin-bottom-5',
						'type'	  => 'text')) .
				$this->Form->input('configuration_id', array(
						'conf-id' => 0,
						'label'   => false,
						'div'     => false,
				    	'class'	  => 'form-control roadmap-input',
						'empty'	  => '--SELECT--')) .
				$this->Form->label('New RoadMap'));
		}
	?>
<?php
	}
}
?>
</div>
<script>
	$(document).ready(function(){
		Game.RoadMap();
	});
</script>
