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
/*
$fu_words = $this->Html->div('fuwords-view pull-right', $this->Html->image('my-frequently-used-words.png'));
$fuwords = $this->Html->tag('h3', 'Frequently Used Words');
foreach ($frequentlyuw as $answer) {
	$fuwords .= $this->Html->div('', $answer['Game']['answer']);
}
$fu_words .= $this->Html->div('fuwords', $fuwords);

$help_view  = $this->Html->div('help-view pull-right', $this->Html->image('my-help.png'));
$help_view .= $this->Html->div('help-text', $step_information['Configuration']['help_bubble'], array('id' => 'tour-step-05'));

echo $this->Html->div('col-md-6 col-xm-6', $this->Html->div('conf-title', $step_information['Configuration']['title']));
echo $this->Html->div('col-md-6 col-xm-6', $fu_words . $help_view);
*/
$visions = $this->Session->read('Vision');
$nxt_lnk = '';
$nxt_txt = 'next_link';
foreach($visions as $vision) {
	$selected = 'caption-subject font-grey-sharp bold uppercase';
	if($nxt_txt == '') {
		$nxt_txt = $vision['Configuration']['title'];
		$nxt_lnk = array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => $vision['Configuration']['id']));
	}
	if($step_information['Configuration']['id'] == $vision['Configuration']['id']) {
		$selected = 'caption-subject font-orange-sharp bold uppercase';
		$nxt_txt = '';
	}
	echo $this->Html->div('col-md-3 col-xm-3', 
				$this->Html->link($vision['Configuration']['title'], 
						array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => $vision['Configuration']['id'])),
						array('class' => $selected . $next_btn)));
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
			$subtx = $this->Html->tag('h5', $game['Configuration']['sub_txt'], array('class' => 'activitytitle'));
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

if($nxt_txt != '') {
	echo $this->Html->div('row no-margin text-center margin-bottom-20',
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
	Game.TakeSurvey();
	Game.HashTag();
	Game.AddMore();
	Game.handleDatePicker();
	Game.SelectAlly();

	FileUpload.UploadFileImage();
	FileUpload.UploadMultipleImages();
	FileUpload.ImageActions();
	
	SortingValues.DragAndDrop();
});
</script>