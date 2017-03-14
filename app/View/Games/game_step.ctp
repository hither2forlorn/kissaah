<?php
$featured = $this->Session->read('Configuration.featured');
if($featured == false) {
	echo '<div class="col-md-6 col-md-offset-3 save-answer">';
}
$next_btn = '';
$screen_width = $this->Session->read('Screen.width');
if($screen_width > 767 && $featured == true) {
	$next_btn = ' btn-step';
}
?>
<div class="row no-margin margin-bottom-20">
<?php
$visions = $this->Session->read('Vision');
$nxt_txt = 'next_link';
$nxt_lnk = '';
$counts = count($visions);
$cols = 'pull-left margin-right-20';

foreach($visions as $vision) {
	$selected = 'caption-subject font-grey-sharp bold uppercase';
	
	if($nxt_txt == '') {

		$nxt_txt = $vision['Configuration']['title'];
		$nxt_lnk = array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => $vision['Configuration']['id']));

		if($this->request->query['st'] == 292) {
			$vision_date = $this->Session->read('ActiveGame.vision_date');
			if(!is_null($vision_date) || $vision_date != '') {
				$nxt_txt = 'Capture';
				
			} else {
				$nxt_txt = 'Start';
				$nxt_lnk = array('controller' => 'users', 'action' => 'start_vision', '?' => array('st' => $vision['Configuration']['id']));
				
			}
		}
	}
	
	if(in_array($vision['Configuration']['id'], array($step_information['Configuration']['id'], $step_information['Configuration']['dependent_id']))) {
	   	$selected = 'caption-subject font-orange-sharp bold uppercase';
	   	if($vision['Configuration']['id'] == $step_information['Configuration']['dependent_id']) {
	   		$nxt_txt = 'Next';
	   	} else {
	   		$nxt_txt = '';
	   	}
	}
	
	if($vision['Configuration']['title'] != '**NP**') {
		echo $this->Html->div($cols,
				$this->Html->link($vision['Configuration']['title'],
						array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => $vision['Configuration']['id'])),
						array('class' => $selected . $next_btn)));
	}
}
?>
</div>
<?php
foreach($games[$step_information['Configuration']['id']]['children'] as $game) {
	
	if($game['Configuration']['status'] && $game['Configuration']['type'] != 16) {
		$display_game = $summary = '';

		$title = $subtx = '';
		if($game['Configuration']['title'] != '**NH**' && $game['Configuration']['title'] != '') {
			$title = $this->Html->tag('h3', $game['Configuration']['title'], array('class' => 'activitytitle'));
		}
		if($game['Configuration']['sub_txt'] != '') {
			$subtx = $this->Html->tag('h5', nl2br($game['Configuration']['sub_txt']), array('class' => 'activitytitle'));
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
						$summary 		= ' game-summary padding-top-20';
						$depen_id 		= $item['Configuration']['dependent_id'];
						$summary_items 	= $this->requestAction(array('controller' => 'games', 'action' => 'summary', 'summary', $depen_id));
						$count 			= count($summary_items[$depen_id]['children']);
						
						foreach($summary_items[$depen_id]['children'] as $item => $summary_item) {
							/* Dirty fix to not show values and strength you continue to embrace */
							if($item != 102 && $item != 243) {
								$display_game .= $this->Render->display($summary_item['Configuration']['type'], $summary_item, $count, true);
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

if($step_information['Configuration']['id'] == 191) {
	$changed = array();
	$changed[0]['Steps'] = array();
	foreach($games as $step_id => $game) {
		$changed[0]['Configuration'] = $game['Configuration'];
		$changed[0]['dependent_id'][$game['Configuration']['id']] = $game['Configuration']['dependent_id'];
		$changed[0]['Steps'] = array_merge($changed[0]['Steps'], $game['Steps']);
	}
	$games = $changed;
}

if($step_information['Configuration']['id'] == 189) {
	
	echo $this->Html->div('row no-margin text-center margin-bottom-20',
			$this->Html->link('Allies and feedback',
					array('controller' => 'allies', 'action' => 'allies'),
					array('class' => 'btn btn-save fbox-toolbox', 'id' => 'tour-step-05', 'data-width' => 600)));
}

if($nxt_txt != '' && $nxt_txt != 'next_link') {
	if($nxt_txt == '**NP**')
		$nxt_txt = 'Next';
	
	echo $this->Html->div('row no-margin text-center margin-bottom-20 pull-right',
			$this->Html->link($nxt_txt, $nxt_lnk, array('class' => 'btn-save ' . $next_btn, 'id' => 'tour-step-05')));
	
}

if($featured == false) {
	echo '</div>';
}
?>
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