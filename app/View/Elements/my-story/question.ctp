<?php
$dependentAnswers = array();
foreach($ddata[$pos] as $key=>$list){
		if(!empty($list['Answer']['answer'])){
			$dependentAnswers[$list['GameConfigure']['id']] =  $list['Answer']['answer']; 
		}
	}
echo '<div class = "det-step">';
echo '<div class = "det-header">'.$gameConfig[$pos]['GameConfigure']['title'].'</div>';
echo '<span class = "det-naration">'.$gameConfig[$pos]['GameConfigure']['naration_txt'].'</span>';
$dependent_config_id = '';
foreach($sdata[$pos] as $dkey => $d){
	if(!empty($d['GameConfigure']['title'])){
		if($dependent_config_id != $d['GameConfigure']['dependent_id']){
			if(!empty($dependentAnswers[$d['GameConfigure']['dependent_id']])){
				echo '<h4>'.$dependentAnswers[$d['GameConfigure']['dependent_id']].'</h4>';
			}
			$dependent_config_id = $d['GameConfigure']['dependent_id'];
		}
		echo '<dl>';
		echo '<dt>'.$d['GameConfigure']['title'].'</dt>';
		echo '<dd>';
		echo (!empty($d['Answer']['answer']))?$d['Answer']['answer']:'No Answer';
		echo '</dd>';
		echo '</dl>';
	}
}
echo '</div>';