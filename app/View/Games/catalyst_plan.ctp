<?php
$featured = $this->Session->read ('Configuration.featured');
$offset = ' col-md-6 col-md-offset-3';
if ($featured) {
	$offset = ' data-width-600';
}
?>
<div class="<?php echo $offset; ?>"><?php
$screen_width = $this->Session->read('Screen.width');
$next_btn = ($screen_width > 767 && $featured == true)? ' btn-step' : '';

foreach ( $games[$step_information['Configuration']['id']]['children'] as $game ) {
	
	if ($game['Configuration']['status'] && in_array($game['Configuration']['id'], array(108, 289))) {
		$display_game = '';
		
		$title = $subtx = '';
		if ($game['Configuration']['title'] != '**NH**' && $game['Configuration']['title'] != '') {
			$title = $this->Html->tag ( 'h3', $game['Configuration']['title'], array ('class' => 'activitytitle'));
		}
		if ($game['Configuration']['sub_txt'] != '') {
			$subtx = $this->Html->tag ( 'h5', nl2br ( $game['Configuration']['sub_txt'] ), array ('class' => 'activitytitle'));
		}
		
		$count = (isset($game['children']))? count($game['children']): 1;
		foreach($game['children'] as $item) {
			if($item['Configuration']['status']) {
				$display_game .= $this->Render->display($item['Configuration']['type'], $item, $count);
			}
		}
		
		$display_game = $this->Html->div('col-md-12 col-sm-12', $this->Html->div('row no-margin margin-bottom-15', $display_game));
		
		echo $this->Html->div('row no-margin padding-bottom-20', $title . $subtx . $display_game);
	}
}

echo $this->Html->div('row no-margin text-center margin-bottom-20 pull-right',
		$this->Html->link('Goto Game', array('action' => 'game_step', '?' => array('st' => 287)), array('class' => 'btn-save ' . $next_btn)));
?></div>
<script>
$(document).ready(function(){
	Game.handleDatePicker();
});
</script>