<?php
echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-finished margin-bottom-5', $selfdata['Configuration']['title']);
if(!empty($selfdata['Dependent'][0]['answer'])) {
	$input 	= $this->Html->para('', $selfdata['Dependent'][0]['answer']);
	
	$calendar  = $this->Html->tag('span', date('m/d/Y'), array('class' => '_start'));
	$calendar .= $this->Html->tag('span', date('m/d/Y'), array('class' => '_end'));
	$calendar .= $this->Html->tag('span', $selfdata['Dependent'][0]['answer'], array('class' => '_summary'));
	$calendar .= $this->Html->tag('span', '', array('class' => '_description'));
	$calendar .= $this->Html->tag('span', 'true', array('class' => '_all_day_event'));
	$calendar  = $this->Html->link('Add to Calendar' . $calendar, '#', array('class' => 'addthisevent event', 
																			'title' => 'Add to Calendar',
																			'data' 	=> 'addto-' . $selfdata['Dependent'][0]['id'],
																			'escape'=> false));
	
	$notify = $this->Html->link('Notify Ally', 
			array('controller' => 'allies', 'action' => 'notify_ally'), 
			array('escape' => false, 'class' => 'btn-save btn-notify-ally'));
	
	echo $this->Html->div('col-md-9 col-sm-6 col-xs-12 no-padding margin-bottom-5', 
			$input . $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', $calendar));
	echo $this->Html->div('col-md-3 col-sm-6 col-xs-12 no-padding margin-bottom-5', $notify);
}
?>