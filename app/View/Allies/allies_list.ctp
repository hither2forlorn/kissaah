<?php
if($message != ''){
	echo $this->Html->tag('h4', $message);
} else {
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12', $this->Html->tag('h4', count($answers) . ' Users Found'));
	
	if(count($answers) == 0) {
			
		$message = $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12',
						$this->Html->para(null, 'Enter your friends email to invite them to join ' . $this->Session->read('Company.name') . ' as your ally.'));
		
		echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12', $message);

		echo $this->Html->div('input-group',
					  $this->Form->input('Email', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text')) .
					  $this->Html->tag('span', 
					  					$this->Html->link('<i class="fa fa-plus-square"></i>', 
					  									  array('controller' => 'allies', 'action' => 'invite'), 
					  									  array('class' => 'btn btn-ally-email', 'escape' => false)), 
					  					array('class' => 'input-group-btn')));
	} else {
		$my_allies = '';
		foreach($answers as $ally) {
			$icon = ' fa-plus-circle';
			$link = array('controller' => 'allies', 'action' => 'request', $ally['User']['id']);
			$class = '';

			$ally_name = ((empty($ally['User']['name']))? $ally['User']['email']: $ally['User']['name']);
			
			$image = (empty($ally['User']['slug']))? 'profile.png': '../files/img/medium/' . $ally['User']['slug'];
			$image = $this->Html->image($image, array('class' => 'img-responsive margin-top-10 margin-bottom-10'));
			
			$btndr = $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus-square')), 
	  								   array('controller' => 'allies', 'action' => 'request', $ally['User']['id']), 
	  								   array('class' => 'fbox-ally btn-ally', 'escape' => false, 'data' => $ally['User']['id'], 'data-width' => '500'));
			
			$span  = $this->Html->tag('span', $ally_name . '<br />' . $btndr, array('id' => $ally['User']['id']));
			
			$my_allies .= $this->Html->div('col-md-4 col-sm-4 col-xs-6 text-015 margin-bottom-10 ally-box color-grey', 
											$image . $span, array('data' => $ally['User']['id']));
		}

		echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20', $my_allies);
		
	}
}
?>