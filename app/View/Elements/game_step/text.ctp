<?php
$vision_date = $this->Session->read('ActiveGame.vision_date');
if(!is_null($vision_date) || $vision_date != '') {
	$options['readonly'] = 'readonly';
}

$answer 				= '';
$id						= $selfdata['Configuration']['id'];

$options['class'] 		= 'form-control';
$options['type'] 		= 'text';
$options['label'] 		= false;
$options['div'] 		= false;
$options['tabindex'] 	= $id;
$options['data'] 		= $selfdata['Configuration']['dependent_id'];
$options['placeholder'] = $selfdata['Configuration']['title'];
$options['data-save'] 	= $this->Html->url(array('controller' => 'games', 'action' => 'save'));

$input  = 'Game.' . $id . '.0';
if(empty($selfdata['Configuration']['dependent_id'])) {
	if(!empty($selfdata['Game'])) {
		$answer	= $selfdata['Game'][0]['Game']['answer'];
		$input  = 'Game.' . $id . '.' . $selfdata['Game'][0]['Game']['id'];
	}
	
} else {
	if(!empty($selfdata['Dependent'][0]['answer'])) {
		$answer = $selfdata['Dependent'][0]['answer'];
	}
	$id = $selfdata['Configuration']['dependent_id'];
	$input  = 'Game.' . $id . '.' . $selfdata['Configuration']['id'];
}

if($summary) {
	$input = $this->Html->para('summary-text', $answer);

} else {
	$options['value'] = $answer;
	$input 	= $this->Form->input($input, $options);
}

if($raw) {
	echo $input;
	
} else {
	$display = $this->Html->div('form-group margin-bottom-15 margin-top-10', $input);
	
	if($summary && $selfdata['Configuration']['help_bubble'] != '') {
		echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', nl2br($selfdata['Configuration']['help_bubble']));
	} elseif($selfdata['Configuration']['sub_txt'] != '') {
		echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', nl2br($selfdata['Configuration']['sub_txt']));
	}
	echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', $display);
}
?>