<?php
if($selfdata['Configuration']['sub_txt'] != '') {
	//debug($selfdata);
	$sub_txt = $this->Html->div('col-md-8 col-xs-12', $selfdata['Configuration']['sub_txt']);
}
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

$image_form  = $this->Form->create('Game' . $id . 'Upload', array('class' => 'btn-file pull-left fileupload'));
$image_form .= $this->Html->tag('i', '', array('class' => 'fa fa-upload fa-2x'));
//$image_form .= $this->Html->image('Upload.png', array('id' => 'upl' . $id));
$image_form .= $this->Form->input($id, array('type' => 'file', 'label' => false, 'class' => 'default', 'div' => false));
$image_form .= $this->Form->end();
$image_form .= $this->Html->link(
		$this->Html->tag('i', '', array('class' => 'fa fa-pinterest fa-2x', 'title' => 'Get Images From Pinterest')),
		array('controller' => 'games', 'action' => 'pinterest_getimages', '?' => array('cid' => $id)), 
		array('escape' => false));
//$image_form .= $this->Html->image('pinterest.png', array('title' => 'Get Images From Pinterest', 'data' => $id, 'id' => 'pin'));
$image_form .= $this->Html->link(
		$this->Html->tag('i', '', array('class' => 'fa fa-instagram fa-2x', 'title' => 'Get Images From Instagram')),
		array('controller' => 'games', 'action' => 'instagram_getImages', '?' => array('cid' => $id, 'game_step' => $this->request->query['st'])), 
		array('escape' => false));
//$image_form .= $this->Html->image('Instagram.png', array('title' => 'Get Images From Instagram', 'data' => $id, 'id' => 'ins'));

if(!empty($selfdata['Game'][0]['Game']['answer'])) {
	$image_form .= $this->Html->link(
			$this->Html->tag('i', '', array('class' => 'fa fa-remove fa-2x', 'title' => 'Remove Image')), 
			array('controller' => 'games', 'action' => 'remove_image', $id), 
			array('escape' => false));
	//$image_form .= $this->Html->image('removeimage.png', array('title' => 'Remove', 'data' => $id, 'id' => 'rem'));
}

$screen_size = $this->Session->read('Screen.width');
if($count == 1 || $screen_size <= 767) {
	echo $this->Html->div('col-md-4 col-sm-4 col-xs-2 clear', '');
}

$image_box = $this->Html->image($answer, array('class' => 'img-responsive margin-bottom-5 margin-top-10', 'data' => 'medium-' . $id));

if(!$summary) {
	$image_box .= $this->Html->div('image-icon', $image_form, array('id' => 'tour-step-04'));
}

if(isset($selfdata['children'])) {
	foreach($selfdata['children'] as $child) {
		$image_box .= $this->Render->display($child['Configuration']['type'], $child, 1, $summary);
	}
}
echo $this->Html->div('col-md-4 col-sm-4 col-xs-8 image-box', $image_box);

if($count == 1 || $screen_size <= 767) {
	echo $this->Html->div('col-md-4 col-sm-4 col-xs-2', '');
}
echo $sub_txt;
?>