<?php 
$class = $start_btn = $startCounter = '';
$current_date = date_create(date('Y-m-d H:i:s'));

$vision_date = $this->Session->read('ActiveGame.vision_date');

if(is_null($vision_date)) {
	$vision_date = date_create(date('Y-m-d H:i:s', strtotime('+100 Days')));
} else {
	$startCounter = $vision_date;
	$vision_date = date_create(date('Y-m-d H:i:s', strtotime($vision_date)));
}
$interval = date_diff($vision_date, $current_date);

$default = $this->Html->tag('span', 
	$this->Html->tag('span', $this->Html->tag('span', $interval->days, array('class' => 'countdown_amount')) . '<br />Days', array('class' => 'countdown_section')) .
	$this->Html->tag('span', $this->Html->tag('span', $interval->h, array('class' => 'countdown_amount')) . '<br />Hours',   array('class' => 'countdown_section')) .
	$this->Html->tag('span', $this->Html->tag('span', $interval->i, array('class' => 'countdown_amount')) . '<br />Minutes', array('class' => 'countdown_section')) .
	$this->Html->tag('span', $this->Html->tag('span', $interval->s, array('class' => 'countdown_amount')) . '<br />Seconds', array('class' => 'countdown_section')), 
	array('class' => 'countdown_row countdown_show4'));


if($startCounter != '') {
	$class = ' col-md-offset-2';
?>
<script>
	var d = new Date('<?php echo $startCounter; ?>');
	$('#defaultCountdown').countdown({until: d});
</script>
<?php 
} else {
	$start_btn = $this->Html->link('Start', array('controller' => 'users', 'action' => 'start_vision'), array('class' => 'btn-save btn-start-vision'));
}

$count_down = $this->Html->div('col-md-8 padding-0' . $class, $default, array('id' => 'defaultCountdown'));
echo $this->Html->div('row no-margin text-center margin-bottom-20', $count_down . $start_btn);
?>