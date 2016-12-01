<?php
echo $this->Html->script(array(
		'https://cdn.webrtc-experiment.com/RecordRTC.js', 
		'https://cdn.webrtc-experiment.com/gumadapter.js',
		'pages/video'
));

$answer = '';
if(empty($selfdata['Configuration']['dependent_id'])) {
	if(!empty($selfdata['Game'][0]['Game']['answer'])) {
		$answer = '<source src="/files/img/large/' . $selfdata['Game'][0]['Game']['answer'] . '" type="vidoe/webm">';
		//<source src="movie.mp4" type="video/mp4">
	}
	$id = $selfdata['Configuration']['id'];
	
} else {
	if(!empty($selfdata['Dependent'][0]['answer'])) {
		$answer = '/files/img/large/' . $selfdata['Dependent'][0]['answer'];
		$answer = '<source src="/files/img/large/' . $selfdata['Dependent'][0]['answer'] . '" type="vidoe/webm">';
	}
	$id = $selfdata['Configuration']['dependent_id'];
}

$video_class = 'col-md-12 col-sm-12 col-xs-12 padding-0 recordrtc';

if($summary) {
	$video = '<video controls muted>' . $answer . '</video>';
	echo $this->Html->div($video_class, $video);
	
} else {
	$options = array('WebM' => 'WebM', 'Mp4' => 'Mp4', 'WAV' => 'WAV', 'Ogg' => 'Ogg', 'Gif' => 'Gif');
	
	$video_control = $this->Html->div('col-md-4 padding-0',
			$this->Form->input('Recording.Type', array('class' => 'form-control recording-media', 'type' => 'select')) .
			$this->Form->input('Recording.Format', array('class' => 'form-control media-container-format', 'type' => 'select', 'options' => $options)) .
			$this->Form->button('Start Recording', array('class' => 'btn margin-top-5')) .
			$this->Form->button('Save To Disk', array('class' => 'btn margin-top-5 hidden', 'id' => 'save-to-disk')) .
			$this->Form->button('Open New Tab', array('class' => 'btn margin-top-5 hidden', 'id' => 'open-new-tab')));
	
	$video = $this->Html->div('col-md-8 padding-right-0', '<video controls muted>' . $answer . '</video>');
	
	$actions = '';
	$actions  = $this->Form->create('Game' . $id . 'Upload', array(
			'class' => 'btn-file pull-left fileupload',
			'data-save' => $this->Html->url(array('controller' => 'games', 'action' => 'upload', 'video'))));
	$actions .= $this->Html->tag('i', '', array('class' => 'fa fa-upload fa-2x')) . '&nbsp;';
	$actions .= $this->Form->input($id, array('type' => 'file', 'label' => false, 'class' => 'default', 'div' => false));
	$actions .= $this->Form->end();
	
	if(!empty($selfdata['Game'][0]['Game']['answer'])) {
		$actions .= $this->Html->link(
				$this->Html->tag('i', '', array('class' => 'fa fa-remove fa-2x', 'title' => 'Remove Image')),
				array('controller' => 'games', 'action' => 'remove_image', $id),
				array('escape' => false)) . '&nbsp;';
	}
	$text = $this->Html->para('pull-left', 'Once the video is recroded please upload from here -');
	$video .= $this->Html->div('margin-top-10 image-icon col-md-12 col-xs-12', $text . $actions);
	
	$child_field = '';
	if(isset($selfdata['children'])) {
		foreach($selfdata['children'] as $child) {
			$child_field = $this->Render->display($child['Configuration']['type'], $child, 1, $summary, true);
		}
	}
	
	if($selfdata['Configuration']['sub_txt'] != '') {
		$video_class = str_replace('col-md-4', 'col-md-3', $video_class);
		echo $this->Html->div('col-md-9 col-sm-8 col-xs-12 padding-left-0', $selfdata['Configuration']['sub_txt'] . $child_field);
		echo $this->Html->div($video_class, $video);
	
	} else {
		echo $this->Html->div($video_class, $video_control . $video . $child_field);
	
	}
}

?>
<script type="text/javascript">
jQuery(document).ready(function() {
<?php if(!$summary) { ?>
	Video.init();
<?php } ?>
});
</script>