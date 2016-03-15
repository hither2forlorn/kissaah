<?php
$id						= $selfdata['Configuration']['id'];
$optionan['class'] 		= 'form-control live-search-ally';
$optionan['label'] 		= false;
$optionan['div'] 		= false;
$optionan['type'] 		= 'text';
$optionan['placeholder']= $selfdata['Configuration']['title'];
$optionan['data-conf'] 	= $id;
$optionan['value']		= '';

$optionai['class'] 		= false;
$optionai['type']		= 'hidden';
$optionai['data']		= 'input-' . $id;
$optionai['data-save'] 	= $this->Html->url(array('controller' => 'games', 'action' => 'save'));

$title = $selfdata['Configuration']['title'] . '<br />' . $selfdata['Configuration']['sub_txt'];

if(!empty($selfdata['Game'])) {
	$ally = $this->requestAction(array('controller' => 'allies', 'action' => 'ally_detail', $selfdata['Game'][0]['Game']['answer']));
	$optionan['value']		= $ally['User']['name'];
	
	$optionai['value']		= $selfdata['Game'][0]['Game']['answer'];
	
	$inputid 				= 'Game.' . $id . '.' . $selfdata['Game'][0]['Game']['id'];
	$image					= '../files/img/medium/' . $ally['User']['slug'];
	
} else {
	$inputid  				= 'Game.' . $id . '.0';
	$image 					= 'profile.png';
}

if(!$summary) {
	$inputid = $this->Form->input($inputid, $optionai);
	$input 	 = $this->Form->input('Ally.name', $optionan);
	$input 	 = $this->Html->div('input-group save-ally',  $input . $inputid . 
						$this->Html->tag('span', $this->Html->tag('i', '', array('class' => 'fa fa-search')), array('class' => 'input-group-addon')));
	
} else {
	$input	 = $this->Form->label('Ally.answer', $optionan['value'], array('class' => 'control-label'));

}

$image 	 = $this->Html->div('col-md-2 col-sm-2 col-xs-4 padding-left-0', 
						   $this->Html->image($image, array('class' => 'img-responsive', 'data' => 'medium-' . $id)));
$input 	 = $this->Html->div('col-md-10 col-sm-10 col-xs-8 no-padding', $title . $input);
echo $this->Html->div('row no-margin margin-bottom-10', $image . $input);
?>
