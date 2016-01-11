<?php
if($summary) {
	$options['readonly'] = 'readonly';
}
$options['class'] 		= 'form-control margin-bottom-5';
$options['label'] 		= false;
$options['type'] 		= 'text';
$options['div'] 		= false;
$options['tabindex'] 	= $selfdata['Configuration']['id'];
$options['data'] 		= $selfdata['Configuration']['dependent_id'];
$options['placeholder'] = $selfdata['Configuration']['title'];
$options['data-save'] 	= $this->Html->url(array('controller' => 'games', 'action' => 'save'));

if($selfdata['Configuration']['dependent_id'] > 0) {
	$games = $this->requestAction(array('controller' => 'games', 'action' => 'summary', 'summary', $selfdata['Configuration']['dependent_id']));
	$r = '';
	
	foreach($games[$selfdata['Configuration']['dependent_id']]['children'] as $value) {
		
		if(empty($value['Game'][0]['Game']['answer'])) {
			$value['Game'][0]['Game']['id'] = 0;
			$answer = $this->Html->tag('li', '', array('class' => 'draggable-drop-here'));
			
		} else {
			$answer	= $this->Html->tag('li', $value['Game'][0]['Game']['answer'], array('class' => 'draggable-fixed'));
		}
		
		$r .= $this->Html->div('col-md-4 col-sm-4 droppable-answer text-010', $answer, array(
										'data-conf' => $value['Configuration']['id'], 
										'data-id' 	=> $value['Game'][0]['Game']['id'], 
										'data'		=> 'drop-' . $value['Configuration']['id'],
										'name' 		=> 'data[Game][' . $value['Configuration']['id'] . '][' . $value['Game'][0]['Game']['id'] . ']'));
	}

	$imageRow = $this->Html->div('row no-margin margin-bottom-5 values-embrace', $r);
	$final = $this->Html->div('col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 no-padding', $imageRow);
	$vheading = $this->Html->div('col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 no-padding text-007', 
							$this->Html->div('btn-label light-blue sorting-list-header', $selfdata['Configuration']['title']));
	
	echo $this->Html->div('row no-margin margin-bottom-10', $vheading);
	echo $this->Html->div('row no-margin sorting-small', $final);
}
$display = '';
foreach($selfdata['children'] as $key => $value) {
	$input = $addmore = '';

	$options['tabindex'] 	= $value['Configuration']['id'];
	$options['data'] 		= $value['Configuration']['dependent_id'];
	$options['placeholder'] = $value['Configuration']['title'];
	
	$header  = $this->Html->div('col-md-4 col-sm-4 no-padding text-008', 
					$this->Html->div('btn-label light-blue sorting-list-header no-margin', $value['Configuration']['title']));
	
	foreach($value['Game'] as $game) {
		$options['value'] = $game['Game']['answer'];
		$input .= $this->Form->input('Game.' . $value['Configuration']['id'] . '.' . $game['Game']['id'], $options);
	}
	
	$options['value'] = '';
	$textfieldclass = 'col-md-8 col-sm-8 no-padding text-012';
	if(!$summary) {
		$input  .= $this->Form->input('Game.' . $value['Configuration']['id'] . '.0', $options);
		$addmore = $this->Html->div('col-md-1 col-sm-1 padding-right-0 text-011', 
						$this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-lg fa-plus-circle')), '#', 
										array('class' => 'add-more', 'escape' => false, 
											  'data'  => 'data[Game][' . $value['Configuration']['id'] . '][0]',
											  'data-add' => $value['Configuration']['id'])));
		$textfieldclass = 'col-md-7 col-sm-7 no-padding text-013';
	}
	 
	$input = $this->Html->div('form-group text-center save-answer', $input, array('data-add' => $value['Configuration']['id']));
	$display .= $this->Html->div('col-md-12 col-sm-12 no-padding', $header . $this->Html->div($textfieldclass, $input) . $addmore);
}

$final = $this->Html->div('col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 no-padding text-009', $display);
echo $this->Html->div('row no-margin sorting-small', $final);
?>
