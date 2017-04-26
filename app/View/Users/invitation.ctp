<?php 
$offset = ' col-md-6 col-md-offset-3';
if ($this->request->is('ajax')) {
	$offset = ' data-width-600';
}
?>
<div class="<?php echo $offset; ?>">
	<?php echo $this->Html->tag('h3', 'Profile Picture', array('class' => 'activitytitle')); ?>
	<div class="col-md-12 col-sm-12 col-xs-12 no-padding"><?php
		$image = $this->Session->read('Auth.User.slug');
		if(empty($image)) {
			$image = 'http://placehold.it/220x220&text=Profile';
		} else {
			$image = '/files/img/medium/' . $image;
		}
		
		echo $this->Html->image($image, array('alt' => $this->Session->read('Auth.User.name'), 
											  'class' => 'img-responsive',
											  'data' => 'medium-' . $this->Session->read('Auth.User.id')));

		echo $this->Form->create('User', array('class' => 'btn-file fileupload margin-top-10',
				'data-save' => $this->Html->url(array('controller' => 'games', 'action' => 'upload', 'image'))));
		echo $this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o', 'id' => 'upl' . $this->Session->read('Auth.User.id')));
		echo $this->Html->tag('span', ' Profile Picture', array('class' => ''));
		echo $this->Form->input($this->Session->read('Auth.User.id'), array(
				'type' 		=> 'file',
				'label' 	=> false,
				'class'		=> 'default',
				'div' 		=> false));
		echo $this->Form->end();
	?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	FileUpload.UploadFileImage();
});
</script>
