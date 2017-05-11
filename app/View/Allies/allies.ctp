<?php 
if($this->request->is('ajax')) {
	$offset = 'allies row no-margin data-width-600';
} else {
	$offset = 'allies col-md-6 col-md-offset-3';
}
?>
<div class="<?php echo $offset; ?>">
<?php
	echo $this->Html->div('highlighted margin-bottom-15', $this->Session->flash(), array('id' => 'message'));
	
	if(strpos(Router::url('/', true), 'kissaah') !== false) {
		echo $this->Html->tag('h3', 'Who can give you feedback before moving forward?', array('class' => 'activitytitle'));
	} else {
		echo $this->Html->tag('h3', 'Who can keep you accountable on your 90 day Human Catalyst sprint?', array('class' => 'activitytitle'));
	}
	
	if(strpos(Router::url('/', true), 'kissaah') !== false) {
		echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12',
				$this->Html->para('margin-bottom-20 margin-top-10', 'You will be sharing your Vision Map and Design section with them.') .
				$this->Html->para('margin-bottom-20',
						'Please select someone who will give you honest feedback and constructive criticism as well as encouragement.
								Effectively they become part of your vital circle as you pave your new life path'));
	} else {
		echo $this->Html->para('', 'Your ally can:');
		$list = array('View your Catalyst Plan', 'Nudge you', 'Add comment', 'Arrange a catch up', 'Share stories');
		echo $this->Html->nestedList($list, array(), array(), 'ul');
	}
	
	$link = array('controller' => 'allies', 'action' => 'allies_list', 'allies', '?' => $this->request->query);
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20', 
				$this->Html->div('input-group',
							  $this->Form->input('SearchText',
												 array('label' 			=> false, 'div' => false, 
													   'class'			=> 'form-control',
													   'type' 			=> 'text', 
													   'placeholder'	=> 'Search for an ally')) .
							  $this->Html->tag('span', 
							  		$this->Html->link('Search', $link, array('class' => 'btn btn-primary', 'id' => 'search-allies')), 
							  		array('class' => 'input-group-btn'))));
?>
	<div class='no-margin row allies-list'>
	<?php
	if($this->request->is('ajax')) {
		echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12', 
				$this->Html->para('margin-bottom-20', 
								  'Once you\'ve typed in their name, you\'ll be able to see if your 
								   Ally is already a ' . $this->Session->read('Company.name') . ' user.') . 
				$this->Html->para('margin-bottom-20', 'If so you can add them as an ally easily at the touch of a button.'));
	}
	
	if(count($current_allies) > 0) {
		if($this->request->is('ajax')) {
			$my_allies = $this->Html->tag('h3', 'To see feedback from allies - click on ' . 
											$this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')), array('class' => 'activitytitle'));
		} else {
			$my_allies = $this->Html->tag('h3', 'To select allies please click on ' .
					$this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')), array('class' => 'activitytitle'));
		}
		$my_allies .= '<div class="row">';

		foreach($current_allies as $ky => $ally) {
			if($ky%3 == 0) $my_allies .= '</div><div class="row">';
			$status = isset($ally['Ally']['status'])? $ally['Ally']['status']: 0;
			
			$btndr = '';
			if($status == 0 && $this->request->is('ajax')) {
				$ally_field_class = 'color-grey';
			} else {
				$ally_field_class = 'color-finished';
				
				if($this->request->is('ajax') || (!isset($this->request->query['st']) && !isset($this->request->query['challenge']))) {
					/*
					$btndr = $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right fa-2x')),
							array('controller' => 'feedbacks', 'action' => 'index', 'myself', $ally['Ally']['id']),
							array('class' => 'btn-ally', 'escape' => false, 'data-type' => 'ajax'));
					*/
				} else {
					$btndr = $this->Html->link('Select Ally ' . $this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right fa-2x')),
							array('controller' => 'challenges', 'action' => 'set_challenge_user', 'add', 
									$this->request->query['challenge'], $ally['Ally']['id'], $ally['Ally']['ally'], 
									'?' => array('st' => $this->request->query['st'])),
							array('class' => 'btn btn-finished margin-top-5', 'escape' => false, 'data-type' => 'ajax'));
					
				}
			}
			$ally_name = ((empty($ally['MyAlly']['name']))? '': $ally['MyAlly']['name'] . '<br />');
			$ally_emai = ((empty($ally['MyAlly']['email']))? $ally['Ally']['ally_email']: $ally['MyAlly']['email']) . '<br />';
			
			$image = (empty($ally['MyAlly']['slug']))? 'profile.png': '../files/img/medium/' . $ally['MyAlly']['slug'];
			$image = $this->Html->image($image, array('class' => 'img-responsive margin-top-10 margin-bottom-10'));
			
			if($this->request->is('ajax')) {
				$btndr .= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash-o fa-2x')), 
		  								   array('controller' => 'allies', 'action' => 'request_action', 'delete', $ally['Ally']['id']), 
		  								   array('class' => 'btn-ally-status', 'escape' => false));
			}
			
			$span  = $this->Html->div('margin-bottom-5', $ally_name . $ally_emai . $ally['UserGameStatus']['roadmap'] . '<br />' . 
														 $btndr, array('id' => $ally['Ally']['id']));
			
			$my_allies .= $this->Html->div('col-md-4 col-sm-4 col-xs-12 text-013 margin-bottom-10 ally-box ' . 
								$ally_field_class, $image . $span, array('data' => $ally['Ally']['id']));
								
		}
		$my_allies .= '</div>';
		echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20', $my_allies);
	}
	
	if(count($allies_of) > 0 && $this->request->is('ajax')) {
		$my_allies = $this->Html->tag('h3', 'To give feedback to allies - click on ' .
											$this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')), array('class' => 'activitytitle'));
		$my_allies .= '<div class="row">';

		foreach($allies_of as $ky => $ally) {
			if($ky%3 == 0) $my_allies .= '</div><div class="row">';
			$status = isset($ally['Ally']['status'])? $ally['Ally']['status']: 0;
			
			if($status == 0) {
				$ally_field_class = 'color-grey';
				$hidden = ' hidden';
				
				$btndr = $this->Html->link('Accept ' . $this->Html->tag('i', '', array('class' => 'fa fa-check-square')), 
		  								   array('controller' => 'allies', 'action' => 'request_action', 'accept', $ally['Ally']['id']), 
		  								   array('class' => 'btn btn-default btn-ally-status', 'escape' => false));
			} else {
				$ally_field_class = 'color-finished';
				$btndr = $hidden = '';
			}

			$btndr .= $this->Html->link('Feedback ' . $this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')), 
	  				array('controller' => 'feedbacks', 'action' => 'index', 'ally', $ally['Ally']['id']), 
					array('class' => 'btn btn-sm green btn-ally' . $hidden, 'escape' => false, 'data-type' => 'ajax')) . '&nbsp;';
									   
			$btndr .= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')), 
	  				array('controller' => 'allies', 'action' => 'request_action', 'delete', $ally['Ally']['id']), 
					array('class' => 'btn btn-sm yellow btn-ally-status' . $hidden, 'escape' => false)) . '&nbsp;';
									   
			$btndr .= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-ban')), 
	  				array('controller' => 'allies', 'action' => 'request_action', 'block', $ally['Ally']['id']), 
	  				array('class' => 'btn btn-sm purple btn-ally-status' . $hidden, 'escape' => false));
									   
			$ally_name = ((empty($ally['User']['name']))? '': $ally['User']['name'] . '<br />');
			$ally_emai = ((empty($ally['User']['email']))? $ally['Ally']['ally_email']: $ally['User']['email']) . '<br />';
			
			$image = (empty($ally['User']['slug']))? 'profile.png': '../files/img/medium/' . $ally['User']['slug'];
			$image = $this->Html->image($image, array('class' => 'img-responsive margin-top-10 margin-bottom-10'));
			
			$span  = $this->Html->div('margin-bottom-5', $btndr, array('id' => $ally['Ally']['id']));
			
			$my_allies .= $this->Html->div('col-md-4 col-sm-4 col-xs-12 text-014 margin-bottom-10 ally-box ' . $ally_field_class, 
											$image . $span, array('data' => $ally['Ally']['id']));

			$my_allies .= $this->Html->div('col-md-8 col-sm-8 col-xs-12 text-015 margin-bottom-10', 
					'Name: ' . $ally_name . 'Email: ' . $ally_emai. '<br />' .
					'Catalyst Plan: ' . $ally['UserGameStatus']['roadmap'] . '<br />' .
					'Development: ' . $ally['Challenge']['Challenge']['name'] . '<br />' .
					'By: ' . $ally['Challenge']['Challenge']['complete_by']);
		}
		$my_allies .= '</div>';
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