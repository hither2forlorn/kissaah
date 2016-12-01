<?php
echo $this->Html->script(array(
		'https://cdn.webrtc-experiment.com/RecordRTC.js', 
		'https://cdn.webrtc-experiment.com/gumadapter.js',
		'pages/video'
));

$answer = '';
if(empty($selfdata['Configuration']['dependent_id'])) {
	if(!empty($selfdata['Game'][0]['Game']['answer'])) {
		$answer = '/files/img/large/' . $selfdata['Game'][0]['Game']['answer'];
	}
	$id = $selfdata['Configuration']['id'];
	
} else {
	if(!empty($selfdata['Dependent'][0]['answer'])) {
		$answer = '/files/img/large/' . $selfdata['Dependent'][0]['answer'];
	}
	$id = $selfdata['Configuration']['dependent_id'];
}

$options = array('WebM' => 'WebM', 'Mp4' => 'Mp4', 'WAV' => 'WAV', 'Ogg' => 'Ogg', 'Gif' => 'Gif');

$video_control = $this->Html->div('col-md-4 padding-0', 
		$this->Form->input('Recording.Type', array('class' => 'form-control recording-media', 'type' => 'select')) .
		$this->Form->input('Recording.Format', array('class' => 'form-control media-container-format', 'type' => 'select', 'options' => $options)) .
		$this->Form->button('Start Recording', array('class' => 'btn margin-top-5')));
		
$video = $this->Html->div('col-md-8 padding-right-0', '<video controls muted></video>');

$video_class = 'col-md-12 col-sm-12 col-xs-12 padding-0 recordrtc';

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
$video .= $this->Html->div('image-icon col-md-12 col-xs-12', $actions);

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
?>    
    <style>
        .recordrtc option[disabled] {
            display: none;
        }
    </style>
            <div style="text-align: center; display: none;">
                <button id="save-to-disk">Save To Disk</button>
                <button id="open-new-tab">Open New Tab</button>
            </div>
<script type="text/javascript">
jQuery(document).ready(function() {
	Video.init();
});
</script>