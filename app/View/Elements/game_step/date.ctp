<?php
$options['class'] 		= 'form-control date-picker-mm-yyyy';
$options['label'] 		= false;
$options['type'] 		= 'text';
$options['div'] 		= 'col-md-4 col-sm-5 col-md-offset-4';
$options['tabindex'] 	= $selfdata['Configuration']['id'];
$options['data'] 		= $selfdata['Configuration']['dependent_id'];
$options['data-save'] 	= $this->Html->url(array('controller' => 'games', 'action' => 'save'));

$answer	= '';
$input  = 'Game.' . $selfdata['Configuration']['id'] . '.0';
if(!empty($selfdata['Game'])) {
	$answer	= $selfdata['Game'][0]['Game']['answer'];
	$input  = 'Game.' . $selfdata['Configuration']['id'] . '.' . $selfdata['Game'][0]['Game']['id'];
}

$label	= $this->Form->label('Game.text', $selfdata['Configuration']['title'], array('class' => 'display-block'));

if($summary) {
	$input = $this->Html->div('Game.answer', $answer, array('class' => ''));

} else {
	$options['value'] = $answer;
	$input 	= $this->Form->input($input, $options);
	
}

$display = $this->Html->div('form-group margin-bottom-5 text-center', $label . $input); 

echo $this->Html->div('col-md-12 col-sm-12 no-padding save-answer', $display);
?>
