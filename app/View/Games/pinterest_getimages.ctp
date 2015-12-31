<div class="no-margin row">
	<div class="col-md-12 col-sm-12 margin-bottom-15">
		<h3>Connect to Pinterest</h3>
		<div class="form-group">
			<label for="firstname">Pinterest Username <span class="require">*</span></label>
			<?php 
			$pinterest_user = $this->Session->read('PinterestUserName');
			echo $this->Form->input('pinterest_user', array(
										'type' 	=> 'text',
										'div'  	=> false, 
										'label'	=> false, 
										'value' => $pinterest_user,
										'class'	=> 'form-control margin-bottom-10'));
			echo $this->Form->input('configure_id', array(
										'type' 	=> 'hidden',
										'div'  	=> false, 
										'label'	=> false, 
										'value' => $cid,
										'class'	=> 'form-control'));
			echo $this->Html->link('Submit', '#', array('class' => 'btn btn-primary pull-left collapsed', 'id' => 'pinterest-username'));
			?>
		</div>
	</div>
<?php 
if(isset($img)){
	if(empty($img)) {
		echo $this->Html->div('col-md-12 col-sm-12',
							  $this->Html->para(null, 'Unable to retrieve images.') .
							  $this->Html->para(null, 'Please check your Pinterest UserName and Try again.'));
	} else {
?>
	<div class="col-md-12 col-sm-12 pinterest-images">
		<h3>Your Pinterest Images</h3>
		<div class="row">
		<?php
		foreach($img as $i){
			if(isset($i)){
				echo $this->Html->div('col-md-4 col-sm-4 pin-images',
						$this->Html->image($i, array('class' => 'img-responsive thumbnail')) .
						$this->Html->link('Upload to Kissaah', '#', array('class' => 'pinterest-upload', 'data' => $cid)));
			}
		}
		?>
		</div>
	</div>
<?php
	} 
} else { 
?>
	<div class="col-md-12 col-sm-12">
		<h3>How to get your Pinterest Username</h3>
		<ol>
			<li>Log Into your Pinterest Account</li>
			<li>Go to <a href="https://www.pinterest.com/settings/">https://www.pinterest.com/settings/</a></li>
			<li>Click on Profile tab.</li>
			<li>You can see your Username on the textbox.</li>
		</ol>
		<?php echo $this->Html->image('PinterestHelp1.png', array('class' => 'thumbnail img-responsive')); ?>
	</div>
<?php } ?>
</div>
<script>
	$(document).ready(function() {
		FileUpload.UploadPinterestImage();
	});
</script>