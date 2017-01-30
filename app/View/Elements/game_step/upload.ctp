<?php
$vision_date = $this->Session->read('ActiveGame.vision_date');

$answer = 'http://placehold.it/300x300&text=X';
if(empty($selfdata['Configuration']['dependent_id'])) {
	if(!empty($selfdata['Game'][0]['Game']['answer'])) {
		$answer = '/files/img/medium/' . $selfdata['Game'][0]['Game']['answer'];
	}
	$id = $selfdata['Configuration']['id'];
	
} else {
	if(!empty($selfdata['Dependent'][0]['answer'])) {
		$answer = '/files/img/medium/' . $selfdata['Dependent'][0]['answer'];
	}
	$id = $selfdata['Configuration']['dependent_id'];
}
$image = $this->Html->image($answer, array('class' => 'img-responsive margin-bottom-5', 'data' => 'medium-' . $id));

$actions = '';
if($summary || !is_null($vision_date) || $vision_date != '') {
	$image_class = 'col-md-4 col-sm-4 col-xs-8 padding-0 image-box-summary';
	
} else {
	$image_class = 'col-md-4 col-sm-4 col-xs-8 padding-0 image-box';
	
	$actions  = $this->Form->create('Game' . $id . 'Upload', array(
			'class' => 'btn-file pull-left fileupload',
			'data-save' => $this->Html->url(array('controller' => 'games', 'action' => 'upload', 'image'))));
	$actions .= $this->Html->tag('i', '', array('class' => 'fa fa-upload fa-2x')) . '&nbsp;';
	//$actions .= $this->Html->image('Upload.png', array('id' => 'upl' . $id));
	$actions .= $this->Form->input($id, array('type' => 'file', 'label' => false, 'class' => 'default', 'div' => false));
	$actions .= $this->Form->end();
	$actions .= $this->Html->link(
			$this->Html->tag('i', '', array('class' => 'fa fa-pinterest fa-2x', 'title' => 'Get Images From Pinterest')),
			array('controller' => 'games', 'action' => 'pinterest_getimages', '?' => array('cid' => $id)),
			array('escape' => false)) . '&nbsp;';
			//$actions .= $this->Html->image('pinterest.png', array('title' => 'Get Images From Pinterest', 'data' => $id, 'id' => 'pin'));
	$actions .= $this->Html->link(
			$this->Html->tag('i', '', array('class' => 'fa fa-instagram fa-2x', 'title' => 'Get Images From Instagram')),
			array('controller' => 'games', 'action' => 'instagram_getImages', '?' => array('cid' => $id, 'game_step' => $this->request->query['st'])),
			array('escape' => false)) . '&nbsp;';
			//$actions .= $this->Html->image('Instagram.png', array('title' => 'Get Images From Instagram', 'data' => $id, 'id' => 'ins'));

	if(!empty($selfdata['Game'][0]['Game']['answer'])) {
		$actions .= $this->Html->link(
				$this->Html->tag('i', '', array('class' => 'fa fa-remove fa-2x', 'title' => 'Remove Image')),
				array('controller' => 'games', 'action' => 'remove_image', $id),
				array('escape' => false)) . '&nbsp;';
				//$actions .= $this->Html->image('removeimage.png', array('title' => 'Remove', 'data' => $id, 'id' => 'rem'));
	}
	$image .= $this->Html->div('image-icon col-md-12 col-xs-12', $actions, array('id' => 'tour-step-04'));
}

$child_field = '';
if(isset($selfdata['children'])) {
	foreach($selfdata['children'] as $child) {
		$child_field = $this->Render->display($child['Configuration']['type'], $child, 1, $summary, true);
	}
}

if($selfdata['Configuration']['sub_txt'] != '') {
	$image_class = str_replace('col-md-4', 'col-md-3', $image_class);
	echo $this->Html->div('col-md-9 col-sm-8 col-xs-12 padding-left-0', nl2br($selfdata['Configuration']['sub_txt'] . $child_field));
	echo $this->Html->div($image_class, $image);
	
} else {
	if($count == 1) {
		$image_class .= ' col-md-offset-4';
	}
	echo $this->Html->div($image_class, $image . $child_field);
}

$screen_size = $this->Session->read('Screen.width');
if($count == 1 || $screen_size <= 767) {}
?>