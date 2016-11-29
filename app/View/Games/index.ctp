<script type="text/javascript">var xvalue = {};var yvalue = {};var sortvalue = {};</script>
<?php
$default_image = 'http://placehold.it/300x300&text=X';
$title_text = $points = $place_images = $activity_images = $path_images = array();
$show_narration = 1;

foreach ($vision as $key => $list) {
    if ($list['Configuration']['step-complete'] == 0) {
        $btnclass = 'col-md-12 col-xs-12 btn btn-step btn-start';
		$brdclass = $this->Html->image('level-start.jpg', array('class' => 'img-responsive level-' . $key . ' level-' . $list['Configuration']['id'], 'id' => 'tour-step-06'));
		
    } elseif ($list['Configuration']['step-complete'] == 1) {
    	$show_narration = 0;
        $btnclass = 'col-md-12 col-xs-12 btn btn-step btn-in-progress';
		$brdclass = $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-' . $key . ' level-' . $list['Configuration']['id']));
		
    } else {
    	$show_narration = 0;
        $btnclass = 'col-md-12 col-xs-12 btn btn-step btn-finished';
		$brdclass = $this->Html->image('level-finished.jpg', array('class' => 'img-responsive level-' . $key . ' level-' . $list['Configuration']['id']));
		
    }
	
	$url  = array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => $list['Configuration']['id']));
	//$smry = array('controller' => 'games', 'action' => 'game_step', '?' => array('st' => 276));
	$smry = array('controller' => 'games', 'action' => 'summary', 'summary', $list['Configuration']['id']);
    $points[$key] = array(
    				'link'  => $this->Html->link($list['Configuration']['sub_txt'], $url, array('class' => $btnclass, 'data' => 'btn-' . $list['Configuration']['id'])),
    				'title' => $list['Configuration']['title'] .
    						   $this->Html->tag('span', $list['Configuration']['naration_txt'], array('class' => 'sub-title')),
    				'smry'	=> $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-th-list fa-lg')), $smry, array('class' => 'btn-step', 'escape' => false)),
					'level' => $brdclass);
					
	$strgs = '';
	if(isset($list['Steps'])) {
		foreach($list['Steps'] as $data) {
			if($data['Configuration']['type'] == 1) {
		    	$image = (empty($data['Game']['answer']))? $default_image: '/files/img/medium/' . $data['Game']['answer'];
		    	$points[$key]['display'][1][] = $this->Html->image($image, array('class' => 'img-responsive', 
		    																  	 'data'  => 'medium-' . $data['Configuration']['id']));
				
			} elseif($data['Configuration']['type'] == 8) {
				if(empty($data['Game']['answer'])) {
					$strgs .= $this->Html->div('btn-start btn-featured', '', array('data' => 'dropsummary-' . $data['Configuration']['id']));
				} else {
					$strgs .= $this->Html->div('btn-in-progress btn-featured', $data['Game']['answer'], array('data' => 'dropsummary-' . $data['Configuration']['id']));
				}
	
			} elseif($data['Configuration']['type'] == 9) {
				if(empty($data['Game']['answer'])) {
					$image = $default_image;
					
				} else {
					$ally = $this->requestAction(array('controller' => 'allies', 'action' => 'ally_detail', $data['Game']['answer']));
					$image = '/files/img/medium/' . $ally['User']['slug'];
					
				}
		    	
		    	$points[$key]['display'][9][] = $this->Html->image($image, array('class' => 'img-responsive', 
		    																  	 'data'  => 'medium-' . $data['Configuration']['id']));
			}
		}
	}
	if($strgs != '') $points[$key]['display'][8] = $strgs;
}
?>
<div class="row">
	<div class="col-md-12 col-xs-12 game-area">
		<div class="row"><?php
			/* Level 1 */
			$id = 0; $images = '';
			foreach($points[$id]['display'][1] as $display) {
				$images .= $this->Html->div('col-md-3 col-sm-3 col-xs-6 margin-bottom-5', $display);
			}
			$title 	= $this->Html->tag('h3', $points[$id]['title'], array('class' => 'text-center margin-top-20'));
			$title 	= $this->Html->div('row no-margin margin-bottom-15', $this->Html->div('col-md-12', $title));
			$images = $this->Html->div('row no-margin level-display margin-bottom-20', $images);
			$btn	= $this->Html->div('row no-margin level-display', $this->Html->div('col-md-12', $points[$id]['link']));
			$smmary = $this->Html->link('Review', array('controller' => 'games', 'action' => 'summary'), 
												  array('class' => 'btn-step btn-summary hidden-xs', 'id' => 'tour-step-04'));
			$circle	= $this->Html->div('row no-margin', 
							$this->Html->div('col-md-2 col-sm-2 col-md-offset-5 col-sm-offset-5 margin-top-20 text-center margin-bottom-20', $points[$id]['smry']) .
							$this->Html->div('col-md-5 col-sm-5 pull-right no-padding hidden-xs', $points[$id]['level']) . $smmary);
			
			echo $this->Html->div('col-md-6 col-xs-12 main-component no-padding', $title . $images . $btn . $circle);
			
			/* Level 2 */
			$id = 1; $images = $this->Html->div('col-md-2 col-sm-2 col-xs-12', '');

			if(isset($points[$id]['display'][1])) {
				foreach($points[$id]['display'][1] as $display) {
					$images .= $this->Html->div('col-md-3 col-sm-3 col-xs-4', $display);
				}
			}
			$title 	= $this->Html->tag('h3', $points[$id]['title'], array('class' => 'text-center margin-top-20'));
			$title 	= $this->Html->div('row no-margin margin-bottom-20', $this->Html->div('col-md-12', $title));
			$images = $this->Html->div('row no-margin level-display margin-bottom-20', $images);
			$btn	= $this->Html->div('row no-margin level-display', $this->Html->div('col-md-offset-2 col-md-9 col-sm-9 col-sm-offset-2', $points[$id]['link']));
			$circle	= $this->Html->div('row no-margin', 
							$this->Html->div('col-md-5 col-sm-5 no-padding hidden-xs', $points[$id]['level']) . 
							$this->Html->div('col-md-2 col-sm-2 margin-top-20 text-center margin-bottom-20', $points[$id]['smry']));
			
			echo $this->Html->div('col-md-6 col-xs-12 main-component no-padding', $title . $images . $btn . $circle);
			
		?></div>
		
		<div class="row"><?php
			/* Execute: Level 4 */
			$id = 3; $images = ''; $strgs = '';
			if(isset($points[$id]['display'][9])) {
				foreach($points[$id]['display'][9] as $display) {
					$images .= $this->Html->div('col-md-2 col-xs-12', $display);
				}
			}

			$title 	= $this->Html->tag('h3', $points[$id]['title'], array('class' => 'text-center'));
			$images = $this->Html->div('row no-margin level-display level-4 margin-bottom-45', $images);
			$btn	= $this->Html->div('row no-margin level-display margin-bottom-20', $this->Html->div('col-md-12', $points[$id]['link']));
			$circle	= $this->Html->div('row no-margin margin-bottom-20', 
							$this->Html->div('col-md-6 no-padding col-md-offset-3 col-sm-9', $title) .
							$this->Html->div('col-md-3 pull-right no-padding hidden-xs', $points[$id]['level']));
			$smmry	= $this->Html->div('row no-margin margin-top-10 margin-bottom-20', $this->Html->div('col-md-12 text-center', $points[$id]['smry']));
			
			$level4 = $this->Html->div('col-md-6 col-xs-6 main-component no-padding', $circle . $images . $btn .$smmry);
			
			/* Design: Level 3 */
			$id = 2; $images = ''; $strgs = '';
			if(isset($points[$id]['display'][1])) {
				foreach($points[$id]['display'][1] as $display) {
					$images .= $this->Html->div('col-md-3 col-xs-4 col-sm-3', $display);
				}
			}
			
			if(isset($points[$id]['display'][8])) {
				$images .= $this->Html->div('col-md-9 col-xs-8 col-sm-9', $points[$id]['display'][8]);
			}

			$title 	= $this->Html->tag('h3', $points[$id]['title'], array('class' => 'text-center'));
			$images = $this->Html->div('row no-margin level-display margin-bottom-20', $images);
			$btn	= $this->Html->div('row no-margin level-display margin-bottom-20', $this->Html->div('col-md-12', $points[$id]['link']));
			$circle	= $this->Html->div('row no-margin margin-bottom-20', 
							$this->Html->div('col-md-3 no-padding hidden-xs col-sm-3', $points[$id]['level']) . 
							$this->Html->div('col-md-6 no-padding col-sm-7', $title));
			$smmry	= $this->Html->div('row no-margin margin-top-10 margin-bottom-20', $this->Html->div('col-md-12 text-center', $points[$id]['smry']));
			
			$level3 = $this->Html->div('col-md-6 col-xs-6 main-component no-padding', $circle . $images . $btn . $smmry);
			
			$screen_width = $this->Session->read('Screen.width');
			if(is_null($screen_width)) {
				$screen_width = 768;
			}
			if($screen_width > 767) {
				echo $level4 . $level3;
			} else {
				echo $level3 . $level4;
			}
		?></div>
	</div>
</div>
<?php echo $this->element('tours');?>

<script type="text/javascript">
$(window).bind('load', function() {
	start_tour = <?php echo ($this->Session->check('start-tour'))? 1: 0; ?>;
	if(start_tour == 1) {
		$('#game-tour').trigger('click');
	}
});

$(document).ready(function() {

	open_game = <?php echo ($this->Session->check('Current.game_step'))? $this->Session->read('Current.game_step'): 0 ?>;
	conf_id  = <?php echo ($this->Session->check('Current.configuration_id'))? $this->Session->read('Current.configuration_id'): 0 ?>;
	
	narration = <?php echo $show_narration; ?>;
	user_info = <?php echo ($this->Session->check('Auth.User.gender'))? 1: 0; ?>;
	
	facebook_warning = <?php echo $this->Session->read('Auth.User.facebook_warning')? 1: 0; ?>;
	consent_for_collage = <?php echo $this->Session->check('Auth.User.collage_status')? 1: 0; ?>;

	<?php $roadmap = $this->Session->read('ActiveGame.roadmap'); ?>
	road_map = <?php echo (empty($roadmap))? 0: 1; ?>;
	thriving_scale = <?php echo isset($step_complete[192])? $step_complete[192]: 2; ?>;

	Game.init(narration, user_info, facebook_warning, consent_for_collage, road_map, thriving_scale, open_game, conf_id);
	
});
</script>