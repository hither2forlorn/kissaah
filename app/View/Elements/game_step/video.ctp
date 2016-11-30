<?php
echo $this->Html->script(array(
		'https://cdn.webrtc-experiment.com/RecordRTC.js', 
		'https://cdn.webrtc-experiment.com/gumadapter.js',
		'pages/video'
));

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
if($summary) {
	$image_class = 'col-md-4 col-sm-4 col-xs-8 padding-0 image-box-summary';
	
} else {
	$image_class = 'col-md-4 col-sm-4 col-xs-8 padding-0 image-box';
	
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
	echo $this->Html->div('col-md-9 col-sm-8 col-xs-12 padding-left-0', $selfdata['Configuration']['sub_txt'] . $child_field);
	echo $this->Html->div($image_class, $image);
	
} else {
	echo $this->Html->div($image_class, $image . $child_field);
	
}

$screen_size = $this->Session->read('Screen.width');
?>    
    
    
    <style>
        .recordrtc option[disabled] {
            display: none;
        }
    </style>

        <section class="experiment recordrtc">
                <select class="recording-media"></select>

                into
                <select class="media-container-format">
                    <option>WebM</option>
                    <option disabled>Mp4</option>
                    <option disabled>WAV</option>
                    <option disabled>Ogg</option>
                    <option>Gif</option>
                </select>

                <button>Start Recording</button>

            <div style="text-align: center; display: none;">
                <button id="save-to-disk">Save To Disk</button>
                <button id="open-new-tab">Open New Tab</button>
            </div>

            <br>

            <video controls muted></video>
        </section>
<script type="text/javascript">
jQuery(document).ready(function() {
	Video.init();
});
</script>