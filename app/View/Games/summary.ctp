<?php
$arrival = (file_get_contents('http://www.xe.com/currencytables/?from=USD&date=2015-08-22'));
$start_position = strpos($arrival, 'Nepalese Rupee');
$end_position = strpos($arrival, '</tr>', $start_position);
$flight_monitor = substr($arrival, $start_position, ($end_position - $start_position));


/*
foreach($step_games as $key => $games) {

	if(isset($games[$key]['children'])) {

		foreach($games[$key]['children'] as $game) {
			$summary = true;
			$each_step = $all_games_each_step = '';
			
			if($game['Configuration']['type'] != 12 && $game['Configuration']['id'] != 224) {

				$all_games_each_step .= $this->Html->tag('h3', $game['Configuration']['title'], array('class' => 'activitytitle'));

				if($game['Configuration']['type'] == 16) {
					$summary = false;
					$all_games_each_step .= $this->Html->tag('h5', $game['Configuration']['sub_txt'], array('class' => 'activitytitle'));
				}
				
				if(isset($game['children'])) {
					$count = count($game['children']);
					if($game['Configuration']['type'] == 4) {
						$each_step .= $this->Render->display($game['Configuration']['type'], $game, $count, $summary);
						
					} else {
						foreach($game['children'] as $item) {
							if($item['Configuration']['status']) {
								$each_step .= $this->Render->display($item['Configuration']['type'], $item, $count, $summary);
							}
						}
					}
					
					$all_games_each_step .= $this->Html->div('col-md-12 col-sm-12', $this->Html->div('row no-margin margin-bottom-15', $each_step));
				}
					
				$all_games_each_step .= $this->Html->div('col-md-offset-3 col-md-6 border-bottom col-sm-offset-3 col-sm-6', '');
				
				echo $this->Html->div('row no-margin margin-bottom-20', $all_games_each_step);
			}
		}
	}
}
*/
?>
<script>
$(document).ready(function(){
	Game.handleRating();
	Game.SaveGame();
	Game.SaveAndCloseGame();
});
</script>