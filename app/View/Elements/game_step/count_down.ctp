<?php 
$default = $this->Html->tag('span', 
	$this->Html->tag('span', $this->Html->tag('span', '100', array('class' => 'countdown_amount')) . '<br />Days', array('class' => 'countdown_section')) .
	$this->Html->tag('span', $this->Html->tag('span', '0', array('class' => 'countdown_amount')) . '<br />Hours', array('class' => 'countdown_section')) .
	$this->Html->tag('span', $this->Html->tag('span', '0', array('class' => 'countdown_amount')) . '<br />Minutes', array('class' => 'countdown_section')) .
	$this->Html->tag('span', $this->Html->tag('span', '0', array('class' => 'countdown_amount')) . '<br />Seconds', array('class' => 'countdown_section')), 
	array('class' => 'countdown_row countdown_show4'));

$count_down = $this->Html->div('col-md-8 padding-0', $default, array('id' => 'defaultCountdown'));

echo $this->Html->div('row no-margin text-center margin-bottom-20',
		$count_down . 
		$this->Html->link('Start', 
				array('controller' => 'users', 'action' => 'start_vision'), 
				array('class' => 'btn-save btn-start-vision')));
?>