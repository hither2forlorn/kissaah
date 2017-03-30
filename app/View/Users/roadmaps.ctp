<div class='no-margin row roadmaps'>
<?php 
if(isset($roadmaps)) {
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
							  
		$row  = $this->Form->input('id', array('value' => $roadmaps[0]['UserGameStatus']['id'], 'type' => 'hidden'));
	    $row .= $this->Form->input('roadmap', array(
									'data-save' 	=> $this->Html->url(array('controller' => 'users', 'action' => 'roadmap_save')),
									'label' 		=> false, 'div' => false, 'type' => 'text',
								    'class'			=> 'form-control roadmap-input',
									'placeholder'	=> 'You only have 20 characters!'));
	    echo $this->Html->div('row no-margin roadmap-block', $row);
	     
		echo $this->Html->tag('h5', '', array('class' => 'activitytitle error-message'));

	    echo $this->Html->tag('h4', 'RoadMap', array('class' => 'activitytitle margin-top-10'));
		
		echo $this->Html->link('Save RoadMap', 
				array('controller' => 'users', 'action' => 'roadmap_edit_active'),
				array('class' => 'btn btn-primary collapsed roadmap-save', 'escape' => false));
				
		echo $this->Html->para('margin-top-10', 
				$this->Html->tag('span', '(Don\'t worry, you can re-name it later if you change your mind)', 
								 array('class' => 'btn-collage-small')));
		?>
	</div>
<?php
	} else {

		echo $this->Html->tag('h3', 'RoadMaps', array('class' => 'activitytitle'));
		echo $this->Html->tag('h5', 'Click icon to switch RoadMaps', array('class' => 'activitytitle'));

		foreach($roadmaps as $key => $roadmap) {
			/*
			$show_delete = $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-2x')), 
				  		array('controller' => 'users', 'action' => 'roadmap_delete', $roadmap['UserGameStatus']['id']),
						array('escape' => false));
			*/
			$vision_date  = date_create(date('Y-m-d H:i:s', strtotime($roadmap['UserGameStatus']['vision_date'])));
			$create_date  = date_create(date('Y-m-d H:i:s', strtotime($roadmap['UserGameStatus']['created'])));
			$current_date = date_create(date('Y-m-d H:i:s'));
			
			$vision_interval = date_diff($vision_date, $current_date);
			$create_interval = date_diff($create_date, $current_date);
				
			$active_text = 'In Progress';
			if($roadmap['UserGameStatus']['active']) {
				$active_text = 'Active';
			} elseif($create_interval->days > 365) {
				$active_text = 'Archived';
			} elseif($vision_interval->days > 90) {
				$active_text = 'Completed';
			}

			$row = $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4', 
				$this->Html->link(
				  		$active_text, array('controller' => 'users', 'action' => 'roadmap_edit_active', $roadmap['UserGameStatus']['id']),
						array('escape' => false, 'class' => 'btn red col-sm-12')));
			$row .= $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding',
				$this->Form->input('id', array('type' => 'hidden', 'value' => $roadmap['UserGameStatus']['id'])) .
				$this->Form->input('roadmap', array(
						'label' => false, 'div' => false, 'class' => 'form-control', 'type'	=> 'text',
						'data-save' => $this->Html->url(array('controller' => 'users', 'action' => 'roadmap_save')),
						'value'	  => $roadmap['UserGameStatus']['roadmap'])));
			$row .= $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4',
				$this->Form->input('configuration_id', array(
						'label' => false, 'div' => false, 'class' => 'form-control', 'empty' => '--SELECT--',
						'data-save' => $this->Html->url(array('controller' => 'users', 'action' => 'roadmap_save')),
						'value'	  => $roadmap['UserGameStatus']['configuration_id'])));
			/* $row .= $this->Html->div('col-xs-2 col-sm-2 col-md-2 col-lg-2', $show_delete); */
			
			echo $this->Html->div('row no-margin margin-bottom-5 roadmap-block', $row);
		}
		
		$row = $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 active-roadmap', 
				$this->Html->link('Add New', '#', array('escape' => false, 'class' => 'btn blue col-sm-12')));
		$row .= $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding', 
			$this->Form->input('id', array('type' => 'hidden', 'class' => 'roadmap-id')) .
			$this->Form->input('roadmap', array(
					'label'   => false, 'div' => false, 'class'	=> 'form-control', 'type' => 'text',
					'data-save' => $this->Html->url(array('controller' => 'users', 'action' => 'roadmap_save')))));
		$row .= $this->Html->div('col-xs-4 col-sm-4 col-md-4 col-lg-4', 
			$this->Form->input('configuration_id', array(
					'label'   => false, 'div' => false, 'class'	=> 'form-control', 'empty' => '--SELECT--',
					'data-save' => $this->Html->url(array('controller' => 'users', 'action' => 'roadmap_save')))));
		/* $row .= $this->Html->div('col-xs-2 col-sm-2 col-md-2 col-lg-2 delete-roadmap', ''); */
			
		echo $this->Html->div('row no-margin margin-bottom-5 roadmap-block', $row);
		echo $this->Html->div('row no-margin margin-bottom-5 roadmap-block hidden', $row);
	}
}
?>
</div>
<script>
$(document).ready(function(){
	Game.RoadMap();
});
</script>
