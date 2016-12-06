<?php
$title = str_replace('%roadmap%', $this->Session->read('ActiveGame.roadmap'), $selfdata['Configuration']['title']);

$options['class'] 		= 'form-control';
$options['label'] 		= false;
$options['type'] 		= 'textarea';
$options['div'] 		= false;
$options['tabindex'] 	= $selfdata['Configuration']['id'];
$options['data'] 		= $selfdata['Configuration']['dependent_id'];
$options['placeholder'] = $title;
$options['data-save'] 	= $this->Html->url(array('controller' => 'games', 'action' => 'save'));
$options['rows'] 		= 2;

$answer	= '';
$input  = 'Game.' . $selfdata['Configuration']['id'] . '.0';
if(!empty($selfdata['Game'])) {
	$answer	= $selfdata['Game'][0]['Game']['answer'];
	$input  = 'Game.' . $selfdata['Configuration']['id'] . '.' . $selfdata['Game'][0]['Game']['id'];
}

if($summary) {
	$label = '';
	
} else {
	$label = $this->Form->label('Game.dependent_id', '', array('data' => $selfdata['Configuration']['dependent_id'], 'class' => 'control-label margin-top-10'));
	
}

if(isset($selfdata['Dependent'][0])) {
	
	if($selfdata['Dependent'][0]['type'] == 7) {
		$label = $this->Form->label('Game.dependent_id', 
									$selfdata['Dependent'][0]['answer'], 
									array('data' => $selfdata['Configuration']['dependent_id'], 'class' => 'control-label margin-top-10'));
	
	} elseif($selfdata['Dependent'][0]['type'] == 1) {
		if(empty($selfdata['Dependent'][0]['answer'])){
			$image = 'http://placehold.it/198x198&text=No Image';
			
		} else {
			$image = '/files/img/small/' . $selfdata['Dependent'][0]['answer'];
			
		}
		$image 			= $this->Html->image($image, array('class' => 'img-responsive thumbnail', 'data'  => 'small-' . $selfdata['Dependent'][0]['id']));
		$label 			= $this->Html->div('col-md-2 col-sm-2 no-padding', $image);
		$options['div'] = 'col-md-10 col-sm-10 padding-right-0';
	}
}

if($summary) {
	$input = $this->Form->label('Game.answer', $answer, array('class' => 'control-label margin-top-10'));

} else {
	$options['value'] = $answer;
	$input 	= $this->Form->input($input, $options);
							 					
}								

if($selfdata['Configuration']['sub_txt'] != '')
	echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 padding-left-0', nl2br($selfdata['Configuration']['sub_txt']));
	
$display = $this->Html->div('form-group margin-bottom-5', $label . $input); 

echo $this->Html->div('col-md-12 col-sm-12 col-xs-12 no-padding', $display);
?>