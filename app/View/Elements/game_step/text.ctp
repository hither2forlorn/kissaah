<?php
$answer 				= '';
$id						= $selfdata['Configuration']['id'];

$options['class'] 		= 'form-control';
$options['label'] 		= false;
$options['type'] 		= 'text';
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
	$input = $this->Form->label('Game.answer', $answer, array('class' => 'control-label margin-bottom-10'));

} else {
	$options['value'] = $answer;
	$input 	= $this->Form->input($input, $options);

}

$display = $this->Html->div('form-group margin-bottom-15 margin-top-10 save-answer', $input); 

echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', $display);
?>