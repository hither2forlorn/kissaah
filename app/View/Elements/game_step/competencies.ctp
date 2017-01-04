<?php
$data = $this->requestAction(array('controller' => 'games', 'action' => 'get_sortlist'));
$li = '';
foreach($data as $key => $list) {
	$li .= $this->Html->tag('li', $list, array('class' => 'draggable-list col-xs-4', 'id' => $key));

}
$ul = $this->Html->div('col-md-12 col-sm-12 col-xs-12 value-list', $li);
$ulxs = $this->Html->div('col-md-12 col-sm-12 col-xs-12 value-list-xs', $li);

echo $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding padding-left-10 hidden-xs',
		$this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10', 'All Competencies') . $ul);

$drophere = 'Drop <br />Here';
$r = '';
foreach($selfdata['children'] as $key => $value) {

	if(empty($value['Game'][0]['Game']['answer'])) {
		$value['Game'][0]['Game']['id'] = 0;
		$answer = $this->Html->tag('li', $drophere, array('class' => 'draggable-drop-here'));

	} else {
		$answer	= $this->Html->tag('li', $value['Game'][0]['Game']['answer'], array('class' => 'draggable-list'));
	}

	echo $this->Html->div('col-md-4 col-sm-4 col-xs-4 droppable-answer margin-bottom-5', 
			$this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10', $value['Configuration']['title']) . $answer, array(
			'data-conf' => $value['Configuration']['id'],
			'data-id' 	=> $value['Game'][0]['Game']['id'],
			'data'		=> 'drop-' . $value['Configuration']['id'],
			'name' 		=> 'data[Game][' . $value['Configuration']['id'] . '][' . $value['Game'][0]['Game']['id'] . ']'));
}
?>
