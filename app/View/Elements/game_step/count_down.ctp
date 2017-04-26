<?php 
$startCounter = '';
$current_date = date_create(date('Y-m-d H:i:s'));

$vision_date = $this->Session->read('ActiveGame.vision_date');

if(is_null($vision_date)) {
	$vision_date = date_create(date('Y-m-d H:i:s', strtotime($selfdata['Configuration']['naration_txt'])));
} else {
	$startCounter = $vision_date;
	$vision_date = date_create(date('Y-m-d H:i:s', strtotime($vision_date)));
}

$interval = date_diff($vision_date, $current_date);

$default = $this->Html->tag('span', 
	$this->Html->tag('span', 
			$this->Html->tag('span', $interval->days, array('class' => 'countdown_amount')) . '<br />Days', array('class' => 'countdown_section col-md-4')) .
	$this->Html->tag('span', 
			$this->Html->tag('span', $interval->h, array('class' => 'countdown_amount')) . '<br />Hours', array('class' => 'countdown_section col-md-4')) .
	$this->Html->tag('span', 
			$this->Html->tag('span', $interval->i, array('class' => 'countdown_amount')) . '<br />Minutes', array('class' => 'countdown_section col-md-4')),
	//$this->Html->tag('span', $this->Html->tag('span', $interval->s, array('class' => 'countdown_amount')) . '<br />Seconds', array('class' => 'countdown_section')), 
	array('class' => 'countdown_row'));

$count_down = $this->Html->div('col-md-12 padding-0', $default, array('id' => 'defaultCountdown'));
echo $this->Html->div('row no-margin margin-bottom-20', $count_down);

if($startCounter != '') { ?>
<script>
	var d = moment('<?php echo $startCounter; ?>', 'YYYY-MM-DD HH:mm:ss').toDate();
	console.log(d);
	$('#defaultCountdown').countdown({until: d, format: 'dHM'});
</script>
<?php } ?>