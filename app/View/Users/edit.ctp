<?php echo $this->Html->script(array('pages/profile-countries', 'pages/profile')); ?>
<div class="row no-margin">
	<div class="col-md-12 col-xm-12">
		<?php echo $this->Html->tag('h3', 'Update User Information', array('class' => 'activitytitle')); ?>
	</div>
</div>
<div class="row no-margin">
<?php 
	if ($action == 'additional_user_info') {
		echo '<div class="col-md-4 col-sm-4"></div>';
		echo '<div class="col-md-4 col-sm-4">';
			$id = $this->Session->read('Profile.Game.id');
			$configure = $this->Session->read('Profile.Game.configure_id');
			$image = $this->Session->read('Profile.Game.answer');
			if($image == '') {
				$image = 'http://placehold.it/198x198&text=Profile Picture';
			} else {
				$image = '/files/img/medium/' . $image;
			}
			echo $this->Html->image($image, array('class' => 'img-responsive thumbnail margin-bottom-5 margin-top-10', 
												 'data' => 'medium-' . $configure));
			$image_form = $this->Form->create('Game' .$id. 'Upload', array('class' => 'btn-file pull-left fileupload'));
			$image_form .= $this->Html->image('upload-lightblue.png', array('id' => 'upl'.'36'));
			$image_form .= $this->Form->input($configure, array(
											'type' 		=> 'file', 
											'label' 	=> false, 
											'class'		=> 'default', 
											'div' 		=> false));
			$image_form .= $this->Form->end();
			
			echo $this->Html->div('image-icon', $image_form );
			echo '</div>';
			echo '<div class="col-md-4 col-sm-4"></div>';
 	}
?>
	<div class="col-md-12 col-sm-12">
		<?php echo $this->Form->create('User', array('inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
		<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
		<?php if ($action == 'profile') { ?>
			<div class="form-group">
				<label>Screen Name</label>
				<?php echo $this->Form->input('name', array('placeholder' => 'Name')); ?>
			</div>
			<div class="form-group">
				<label>Email</label>
				<?php echo $this->Form->input('email', array('placeholder' => 'Email')); ?>
			</div>
		<?php 
		} 
		if ($action == 'password') {
		?>
			<div class="form-group">
				<label>Current Password</label>
				<?php echo $this->Form->input('current_password', array('type' 			=> 'password',
																		'placeholder'	=> 'Your Current Password')); ?>
			</div>
			<div class="form-group">
				<label>New Password</label>
				<?php echo $this->Form->input('password', array('placeholder' => 'New Password')); ?>
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<?php echo $this->Form->input('confirmpassword', array('type' 			=> 'password',
																	   'placeholder'	=> 'Confirm Password')); ?>
			</div>
		<?php } 
		if ($action == 'profile' || $action == 'additional_user_info') { ?>
			<div class="form-group">
				<label>Your Current City</label>
				<?php echo $this->Form->input('city', array('placeholder' => 'Your Current City')); ?>
			</div>
			<div class="form-group">
				<label>Your Current Country</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-search"></i></span>
					<?php echo $this->Form->input('country', array('placeholder' => 'Your Current Country')); ?>
				</div>
			</div>
			<div class="form-group">
				<label>Date for birth</label>
				<?php echo $this->Form->input('dob', array( 'type'			=> 'text',
															'class' 		=> 'form-control date-mask',
															'placeholder' 	=> 'Date Of Birth')); ?>
			</div>
			<div class="form-group">
				<label>Gender</label>
				<?php echo $this->Form->radio('gender', array('M' => 'Male', 'F' => 'Female'), array(
															'div' 			=> 'radio-list',
															'label'			=> false,
															'legend'		=> false,
															'separator'		=> '&nbsp;&nbsp;&nbsp;')); ?>
			</div>
			<?php if(empty($this->request->data['User']['company'])) { ?>
			<div class="form-group">
				<label>Code</label>
				<?php echo $this->Form->input('company', array('placeholder' => 'Your Kissaah Code')); ?>
			</div>
			<?php } ?>
			<div class="form-group">
				<label class="check">
					<span><?php echo $this->Form->input('collage_status', array('type' => 'checkbox', 'class' => false, 'div' => false)); ?></span> 
					Contribute to Image Bank
				</label>
			</div>
		<?php } ?>
			<div class="form-group">
				<?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script>
	$('.date-mask').inputmask('dd/mm/yyyy', {
		'placeholder' : 'dd/mm/yyyy'
	});
	ProfileCountries.init();
	FileUpload.UploadFileImage();
	Profile.Save();
</script>