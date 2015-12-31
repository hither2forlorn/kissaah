	<div id="registerbox">
	<div id="register-inner">
	<?php echo $this->Form->create('User',array($this->here)); ?>
	<div class="box32">
		<span><label>Screen Name</label></span>
			<?php echo $this->Form->input('name', array('label'=>false, 'class'=>'login-inp'));?>
	</div>
	
	<div class="box25">
		<?php echo $this->Form->submit('Change Detail', array('class'=>'submit-button right', 'div' => false)); ?>
	</div>
	<?php echo $this->Form->end();?>
	</div>
	<div class="clearfix"></div>
	</div>
