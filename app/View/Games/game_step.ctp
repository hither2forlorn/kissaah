<?php
$featured = $this->Session->read ('Configuration.featured');
$offset = ' col-md-6 col-md-offset-3';
if ($featured) {
	$offset = ' data-width-600';
}
?>
<div class="save-answer<?php echo $offset; ?>">
<?php
$nxt_lnk = $nxt_txt = '';

$screen_width = $this->Session->read('Screen.width');
$next_btn = ($screen_width > 767 && $featured == true)? ' btn-step' : '';

$visions = $this->Session->read('Vision');
$active = 0;
foreach ($visions as $key => $vision) {
	$wizard = 'complete';
	$selected = '';
	
	if($nxt_txt == '' && $this->request->query['st'] != 292) {
		$nxt_txt = $vision['Configuration']['title'];
		$nxt_lnk = array ('controller' => 'games', 'action' => 'game_step', '?' => array ('st' => $vision['Configuration']['id']));
		if($nxt_txt == '**NP**') $nxt_txt = 'Next';
	}

	if($vision['Configuration']['id'] == $this->request->query['st']) {
		$wizard  = 'active';
		$active  = $key;
		$nxt_lnk = $nxt_txt = '';
		$selected = ' btn btn-finished';
	}
	
	$progress[$key] = $this->Html->div('col-xs-4 bs-wizard-step text-center ' . $wizard,
			$this->Html->div('text-center bs-wizard-stepnum', '&nbsp;') .
			$this->Html->div('progress', $this->Html->div('progress-bar', '')) .
			$this->Html->link('', array('controller' => 'games', 'action' => 'game_step',
					'?' => array('st' => $vision['Configuration']['id'])), array('class' => 'bs-wizard-dot' . $next_btn)) .
			$this->Html->div('bs-wizard-info text-center' . $selected, $vision['Configuration']['title']));
}
if($active < 1) {
	$progress = array($progress[0], $progress[1], $progress[2]);

} elseif($active > 0 && $active < (count($progress) - 1)) {
	$progress = array($progress[$active - 1], $progress[$active], $progress[$active + 1]);

} else {
	$progress = array($progress[$active - 2], $progress[$active - 1], $progress[$active]);
}
echo $this->Html->div('row bs-wizard no-margin margin-bottom-20', implode('', $progress));
//$selected = 'caption-subject font-grey-sharp bold uppercase';

foreach ( $games[$step_information['Configuration']['id']]['children'] as $game ) {
	
	if ($game['Configuration']['status'] && $game['Configuration']['type'] != 16) {
		$display_game = $summary = '';
		
		$title = $subtx = '';
		if ($game['Configuration']['title'] != '**NH**' && $game['Configuration']['title'] != '') {
			$title = $this->Html->tag ( 'h3', $game['Configuration']['title'], array ('class' => 'activitytitle'));
		}
		if ($game['Configuration']['sub_txt'] != '') {
			$subtx = $this->Html->tag ( 'h5', nl2br ( $game['Configuration']['sub_txt'] ), array ('class' => 'activitytitle'));
		}
		
		$count = (isset($game['children']))? count($game['children']): 1;
		if($game['Configuration']['type'] == 4) {
			$display_game .= $this->Render->display($game['Configuration']['type'], $game, $count);
			
		} elseif($game['Configuration']['type'] == 12 && !isset($game['children'])) {
			$summary 		= ' game-summary padding-top-20';
			$depen_id 		= $game['Configuration']['dependent_id'];
			$summary_items 	= $this->requestAction(array('controller' => 'games', 'action' => 'summary', 'summary', $depen_id));
			$count 			= count($summary_items[$depen_id]['children']);

			foreach($summary_items[$depen_id]['children'] as $summary_item) {
				$summary_item['Dependent'] = $game['Configuration'];
				$display_game .= $this->Render->display($summary_item['Configuration']['type'], $summary_item, $count, true);
			}
			
		} else {
			foreach($game['children'] as $item) {
				if($item['Configuration']['status']) {
					/* This is summary only */
					if($item['Configuration']['type'] == 12) {
						$summary 	   = ' game-summary padding-top-20';
						$depen_id 	   = $item['Configuration']['dependent_id'];
						$summary_items = $this->requestAction(array('controller' => 'games', 'action' => 'summary', 'summary', $depen_id));
						$count 		   = count($summary_items[$depen_id]['children']);
						
						foreach($summary_items[$depen_id]['children'] as $item => $summary_item) {
							/* Dirty fix to not show values and strength you continue to embrace */
							if($item != 102 && $item != 243) {
								$display_game .= $this->Render->display($summary_item['Configuration']['type'], 
																		$summary_item, $count, true);
							}
						}
						
					} else {
						$display_game .= $this->Render->display($item['Configuration']['type'], $item, $count);
					}
				}
			}
		}
		
		$display_game = $this->Html->div('col-md-12 col-sm-12', $this->Html->div('row no-margin margin-bottom-15', $display_game));
		
		$border = '';
		if($game['Configuration']['title'] != '**NH**' && $game['Configuration']['title'] != '') {
			$border = $this->Html->div('col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6 border-bottom', '');
		}
		
		echo $this->Html->div('row no-margin padding-bottom-20' . $summary, $title . $subtx . $display_game . $border);
	}
}

if($step_information['Configuration']['id'] == 189) {
	echo $this->Html->div('row no-margin text-center margin-bottom-20',
			$this->Html->link('Allies and feedback',
					array('controller' => 'allies', 'action' => 'allies'),
					array('class' => 'btn btn-save fbox-toolbox', 'id' => 'tour-step-05', 'data-width' => 600)));
}

if($nxt_txt != '') {
	echo $this->Html->div('row no-margin text-center margin-bottom-20 pull-right',
			$this->Html->link($nxt_txt, $nxt_lnk, array('class' => 'btn-save ' . $next_btn, 'id' => 'tour-step-05')));
}
?>
</div>
<script>
$(document).ready(function(){
	Game.SaveGame();
	Game.SaveAndCloseGame();
	Game.GameToolBar();
	//Game.TakeSurvey();
	Game.HashTag();
	Game.AddMore();
	Game.handleDatePicker();
	Game.SelectAlly();
	Game.StartVision();
	Allies.NotifyAlly();

	FileUpload.UploadFileImage();
	FileUpload.UploadMultipleImages();
	FileUpload.ImageActions();
	
	SortingValues.DragAndDrop();

	if($('.addthisevent').length > 0) {
		Game.initAddToCalendar();
		addthisevent.refresh();
	}
	if($('.ally-selection').length > 0) {
		Game.ChallengeAlly();
	}
});
</script>