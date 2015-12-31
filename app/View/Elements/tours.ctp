<?php 
$data = $this->requestAction(array('controller' => 'posts', 'action' => 'tour'));
?>
<ol class="tourbus-legs" id="tourbus">
<?php 
foreach($data as $post) {
	$tour_settings = array();
	foreach($post['Postmeta'] as $postmeta) {
		if(strpos($postmeta['meta_key'], 'data-') === 0) {
			$tour_settings[$postmeta['meta_key']] = $postmeta['meta_value'];
		}
	}
	echo $this->Html->tag('li', $post['Post']['post_content'], $tour_settings);
}
?>
</ol> 