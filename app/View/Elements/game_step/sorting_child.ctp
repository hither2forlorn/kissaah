<?php
if($summary) {
	$drophere = '';
} else {
	$drophere = 'Drop <br />Here';
}
$r = '';
foreach($selfdata['children'] as $key => $value) {
	
	if(empty($value['Game'][0]['Game']['answer'])) {
		$value['Game'][0]['Game']['id'] = 0;
		$answer = $this->Html->tag('li', $drophere, array('class' => 'draggable-drop-here'));
		
	} else {
		$answer	= $this->Html->tag('li', $value['Game'][0]['Game']['answer'], array('class' => 'draggable-list'));
	}
	
	$r .= $this->Html->div('col-md-4 col-sm-4 droppable-answer margin-bottom-5', $answer, array(
									'data-conf' => $value['Configuration']['id'], 
									'data-id' 	=> $value['Game'][0]['Game']['id'], 
									'data'		=> 'drop-' . $value['Configuration']['id'],
									'name' 		=> 'data[Game][' . $value['Configuration']['id'] . '][' . $value['Game'][0]['Game']['id'] . ']'));
}

$imageRow = $this->Html->div('row no-margin margin-bottom-5 values-embrace', $r);

if(!$summary) {
	$final = $this->Html->div('col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 no-padding', $imageRow);
} else {
	$final = $this->Html->div('col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 no-padding', $imageRow);
}

$vheading = $this->Html->div('col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 no-padding', 
						$this->Html->div('btn-label light-blue sorting-list-header', $selfdata['Configuration']['title']));
echo $this->Html->div('row no-margin margin-bottom-10', $vheading);
echo $this->Html->div('row no-margin sorting-small', $final);
?>
