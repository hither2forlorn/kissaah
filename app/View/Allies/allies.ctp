<div class='no-margin row allies'>
<?php
	echo $this->Html->div('highlighted margin-bottom-15', $this->Session->flash(), array('id' => 'message'));
	
	echo $this->Html->tag('h3', 'Who can give you feedback before moving forward?', array('class' => 'activitytitle'));
	
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12', 
				$this->Html->para('margin-bottom-20 margin-top-10', 'You will be sharing your Vision Map and Design section with them.') . 
				$this->Html->para('margin-bottom-20', 
								'Please select someone who will give you honest feedback and constructive criticism as well as encouragement. 
								Effectively they become part of your vital circle as you pave your new life path'));
								
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20', 
				$this->Html->div('input-group',
							  $this->Form->input('SearchText',
												 array('label' 			=> false, 'div' => false, 
													   'class'			=> 'form-control',
													   'type' 			=> 'text', 
													   'placeholder'	=> 'Search for an ally')) .
							  $this->Html->tag( 'span', 
							  					$this->Html->link('Search', 
							  									  array('controller' => 'allies', 'action' => 'allies_list', 'allies'), 
							  									  array('class' => 'btn btn-primary', 'id' => 'search-allies')), 
							  					array('class' => 'input-group-btn'))));
?>
	<div class='no-margin row allies-list'>
		<?php
		echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12', 
				$this->Html->para('margin-bottom-20', 
								  'Once you\'ve typed in their name, you\'ll be able to see if your Ally is already a Kissaah user.') . 
				$this->Html->para('margin-bottom-20', 'If so you can add them as an ally easily at the touch of a button.'));
		
		if(count($current_allies) > 0) {
			$my_allies = $this->Html->tag('h3', 'To see feedback from allies - click on ' . 
												$this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')), array('class' => 'activitytitle'));
			
			foreach($current_allies as $ally) {
				$status = isset($ally['Ally']['status'])? $ally['Ally']['status']: 0;
				if($status == 0) {
					$ally_field_class = 'color-grey';
					$btndr = '';
					
				} else {
					$ally_field_class = 'color-finished';
					
					$btndr = $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right fa-2x')), 
			  								   array('controller' => 'feedbacks', 'action' => 'index', 'myself', $ally['Ally']['id']),
			  								   array('class' => 'fbox-ally btn-ally', 'escape' => false, 'data-width' => '650')); 
				}
				$ally_name = ((empty($ally['MyAlly']['name']))? $ally['Ally']['ally_email']: $ally['MyAlly']['name']);
				
				$image = (empty($ally['MyAlly']['slug']))? 'profile.png': '../files/img/medium/' . $ally['MyAlly']['slug'];
				$image = $this->Html->image($image, array('class' => 'img-responsive margin-top-10 margin-bottom-10'));
				
				$btndr .= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash-o fa-2x')), 
		  								   array('controller' => 'allies', 'action' => 'request_action', 'delete', $ally['Ally']['id']), 
		  								   array('class' => 'btn-ally-status', 'escape' => false));
				
				$span  = $this->Html->div('margin-bottom-5', $ally_name . '<br />' . $ally['UserGameStatus']['roadmap'] . '<br />' . 
															 $btndr, array('id' => $ally['Ally']['id']));
				
				$my_allies .= $this->Html->div('col-md-4 col-sm-4 col-xs-6 text-013 margin-bottom-10 ally-box ' . $ally_field_class, $image . $span, array('data' => $ally['Ally']['id']));
									
			}
			
			echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20', $my_allies);
		}
		
		if(count($allies_of) > 0) {
			$my_allies = $this->Html->tag('h3', 'To give feedback to allies - click on ' .
												$this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')), array('class' => 'activitytitle'));
			
			foreach($allies_of as $ally) {
				$status = isset($ally['Ally']['status'])? $ally['Ally']['status']: 0;
				if($status == 0) {
					$ally_field_class = 'color-grey';
					$hidden = ' hidden';
					
					$btndr = $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-check-square fa-2x')), 
			  								   array('controller' => 'allies', 'action' => 'request_action', 'accept', $ally['Ally']['id']), 
			  								   array('class' => 'btn-ally-status', 'escape' => false));
											   
				} else {
					$ally_field_class = 'color-finished';
					$btndr = $hidden = '';
					
				}

				$btndr .= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right fa-2x')), 
		  								   array('controller' => 'feedbacks', 'action' => 'index', 'ally', $ally['Ally']['id']), 
		  								   array('class' => 'fbox-ally btn-ally' . $hidden, 'escape' => false, 'data-width' => '650'));
										   
				$btndr .= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash-o fa-2x')), 
		  								   array('controller' => 'allies', 'action' => 'request_action', 'delete', $ally['Ally']['id']), 
		  								   array('class' => 'btn-ally-status' . $hidden, 'escape' => false));
										   
				$btndr .= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-ban fa-2x')), 
		  								   array('controller' => 'allies', 'action' => 'request_action', 'block', $ally['Ally']['id']), 
		  								   array('class' => 'btn-ally-status' . $hidden, 'escape' => false));
										   
				$ally_name = ((empty($ally['User']['name']))? $ally['Ally']['ally_email']: $ally['User']['name']);
				
				$image = (empty($ally['User']['slug']))? 'profile.png': '../files/img/medium/' . $ally['User']['slug'];
				$image = $this->Html->image($image, array('class' => 'img-responsive margin-top-10 margin-bottom-10'));
				
				$span  = $this->Html->div('margin-bottom-5', $ally_name . '<br />' . $ally['UserGameStatus']['roadmap'] . 
															 '<br />' . $btndr, array('id' => $ally['Ally']['id']));
				
				$my_allies .= $this->Html->div('col-md-4 col-sm-4 col-xs-6 text-014 margin-bottom-10 ally-box ' . $ally_field_class, 
												$image . $span, array('data' => $ally['Ally']['id']));
			}
			
			echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12', $my_allies);
		}
		?>
	</div>
</div>
<script>
$(document).ready(function(){
	Allies.OpenPopup();
	Allies.Search();
	Allies.AllyFunctions();
});
</script>