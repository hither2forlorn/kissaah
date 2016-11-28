<?php
$options['class'] 		= 'form-control';
$options['type'] 		= 'text';
$options['label'] 		= false;
$options['div'] 		= false;
$options['value'] 		= '';

echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 btn-finished margin-bottom-5', $selfdata['Configuration']['title']);
if(!empty($selfdata['Dependent'][0]['answer'])) {
	$options['value'] = $selfdata['Dependent'][0]['answer'];
	$input  = 'Game.' . $selfdata['Dependent'][0]['id'] . '.' . $selfdata['Configuration']['dependent_id'];
	$input 	= $this->Form->input($input, $options);
	
	$calendar  = $this->Html->tag('span', '', array('class' => '_start'));
	$calendar .= $this->Html->tag('span', '', array('class' => '_end'));
	$calendar .= $this->Html->tag('span', $options['value'], array('class' => '_summary'));
	$calendar .= $this->Html->tag('span', '', array('class' => '_description'));
	$calendar .= $this->Html->tag('span', 'true', array('class' => '_all_day_event'));
	$calendar = $this->Html->link('Add to Calendar' . $calendar, '#', array('class' => 'pull-right addthisevent event', 
																			'title' => 'Add to Calendar',
																			'data' 	=> 'addto-' . $selfdata['Dependent'][0]['id'],
																			'escape'=> false));
	
	echo $this->Html->div('col-md-6 col-sm-6 col-xs-12 no-padding margin-bottom-5', $input);
	echo $this->Html->div('col-md-6 col-sm-6 col-xs-12 no-padding margin-bottom-5', $calendar);
}
?>
