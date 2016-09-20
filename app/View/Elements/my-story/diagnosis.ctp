<?php
echo '<div class = "det-step">';
echo '<div class = "det-header">'.$gameConfig[$pos]['GameConfigure']['title'].'</div>';
echo '<span class = "det-naration">'.$gameConfig[$pos]['GameConfigure']['naration_txt'].'</span>';

echo '<table class = "det-val">';
$dependent_length = 0;
echo '<tr>';
foreach($ddata[9] as $key=>$list){
	echo '<th>';
	echo  !empty($list['Answer']['answer'])?$list['Answer']['answer']:'No Answer';
	echo '</th>';
	$dependent_length++;
}
echo '</tr>';

$c = 0;
foreach($sdata[$pos] as $k => $l){
	if($c%3==0) echo '<tr>';
	if($l['GameConfigure']['type']==8){
		echo '<td class = "det-val-td">';
		$value =  empty($l['Answer']['answer'])?"No Answer":$l['Answer']['answer'];
		echo '<dl>';
		echo '<dt>';
		echo !empty($l['GameConfigure']['title'])?$l['GameConfigure']['title']:'No Answer';
		echo '</dt>';
		echo '<dd>';
		echo $value;
		echo '</dd>';
		echo '</td>';
	}
	if($c%3==2) echo '</tr>';
	$c++;
}
echo '</table>';

echo '</div>';