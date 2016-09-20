<div class="no-margin row">
	<div class="col-md-12 col-sm-12 margin-bottom-15">
	<?php if(!$this->Session->check('Instagram.success')) {
		echo $this->Html->tag('h3', 'Connect to Instagram');
		if($this->Session->read('Instagram.error_reason') == 'user_denied') {
			echo $this->Html->para(null, 'Unable to retrieve images.');
			echo $this->Html->para(null, 'You have denied access from Kissaah to your Instagram account.');
		}
		echo 'Click the link to get started:&nbsp;&nbsp;&nbsp;';
		echo $this->Html->link('CONNECT', $link);
	}?>
	</div>
<?php 
if(isset($instagram_images)){
	if(empty($instagram_images)) {
		echo $this->Html->div('col-md-12 col-sm-12',
							  $this->Html->para(null, 'Unable to retrieve images.') .
							  $this->Html->para(null, 'Please connect and try again.'));
	} else {
?>
	<div class="col-md-12 col-sm-12 pinterest-images">
		<h3>Your Instagram Images</h3>
		<div class="row">
		<?php
		foreach($instagram_images as $image){
			echo $this->Html->div('col-md-4 col-sm-4 pin-images',
					$this->Html->image($image, array('class' => 'img-responsive thumbnail')) .
					$this->Html->link('Upload to Kissaah', '#', array('class' => 'pinterest-upload', 'data' => $cid)));
		}
		?>
		</div>
	</div>
<?php
	} 
}
?>	
</div>

<script>
	$(document).ready(function() {
		FileUpload.UploadPinterestImage();
	});
</script>