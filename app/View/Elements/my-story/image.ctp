<?php
$activity = '';
foreach($sdata[$pos] as $dkey => $d){
	if($d['GameConfigure']['type'] == 1){
		$activity .='<tr>';
		$activity .='<td>';
			$activity .='<div class = "det-img-act">';
				$activity .='<div class = "det-image">';
				$activity .=!empty($d['Answer']['answer'])?$this->Html->image('/files/img/medium/'.$d['Answer']['answer']):'<img src="http://placehold.it/200x200&text=No Image Uploaded" />';
				$activity .='</div>';
				foreach($sdata[$pos] as $dep){
					if($d['GameConfigure']['id'] == $dep['GameConfigure']['dependent_id']){
						if(!empty($dep['Answer']['answer'])){
							$activity .= '<div class = "det-caption">';
							$activity .= !empty($dep['Answer']['answer'])?$dep['Answer']['answer']:'No Answer';
							$activity .= '</div>';
						}
					}
				}
			$activity .='</div>';
		$activity .='</td>';
		foreach($sdata[$posAssoc] as $dkey => $da){
			if($da['GameConfigure']['type']==5 && in_array($da['GameConfigure']['id'], array(24, 26, 27, 28, 29, 30, 31, 32, 33)) && $da['GameConfigure']['dependent_id'] == $d['GameConfigure']['id']){
				$activity .='<td>';
				$activity .= $da['Answer']['answer'];
				$activity .='</td>';
			}
		}
		$activity .='</tr>';
	}
}
//debug($pos);
//debug($gameConfig);
//debug($sdata);
?>

<div id = 'fav_acts_story' class = "story acts">
<?php 
	echo '<div class = "det-step">';
	echo '<div class = "det-header">'.$gameConfig[$pos]['GameConfigure']['title'].'</div>';
	echo '<span class = "det-naration">'.$gameConfig[$pos]['GameConfigure']['naration_txt'].'</span>';
?>
	<table>
		<tr><th>Activity</th><th>It makes me feel...</th><th>It makes me think...</th><th>It makes me want to...</th></tr>
		<?php echo $activity; ?>
	</table>
<?php 
	echo '</div>';
?>
</div>