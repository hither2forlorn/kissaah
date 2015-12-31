<?php
$imageRow = $li = $id = '';
if($selfdata['Configuration']['dependent_id'] > 0) {
	$games = $this->requestAction(array('controller' => 'games', 'action' => 'summary', 'summary', $selfdata['Configuration']['dependent_id']));
	foreach($games as $game) {
		$selfdata = $game;
	}
}

foreach($selfdata['children'] as $key => $value) {
	$id = $value['Configuration']['parent_id'];
	$r =  '';
	
	if(isset($value['children'])) {
		foreach($value['children'] as $k => $l) {
			
			$heading[$l['Configuration']['title']] = $this->Html->div('col-md-4 no-padding', $this->Html->div('btn-label light-blue sorting-list-header', 
																											  $l['Configuration']['title']));
			if(empty($l['Game'][0]['Game']['answer'])) {
				$l['Game'][0]['Game']['id'] = 0;
				$answer = $this->Html->tag('li', '', array('class' => 'draggable-drop-here'));
			} else {
				$answer	= $this->Html->tag('li', $l['Game'][0]['Game']['answer'], array('class' => 'draggable-list draggable-fixed'));
			}
			
			$r .= $this->Html->div('col-md-4 col-sm-4 droppable-fixed', $answer, array(
											'data-conf' => $l['Configuration']['id'], 
											'data-id' 	=> $l['Game'][0]['Game']['id'], 
											'name' 		=> 'data[Game][' . $l['Configuration']['id'] . '][' . $l['Game'][0]['Game']['id'] . ']'));
		}
	}
	
	$imageRow .= $this->Html->div('row no-margin margin-bottom-5 values-embrace', $r);
}

$final = $this->Html->div('col-md-8 col-md-offset-2 col-sm-12 no-padding', $imageRow);

$vheading = '';
foreach($heading as $h) {
	$vheading .= $h;
}
$vheading = $this->Html->div('col-md-8 col-md-offset-2 col-sm-12 no-padding', $vheading);
if($id != 77) {
	echo $this->Html->div('row no-margin margin-bottom-10', $vheading);
}
echo $this->Html->div('row no-margin margin-bottom-20 sorting-small', $final);
?>