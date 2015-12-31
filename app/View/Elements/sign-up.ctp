<?php if(!$this->Session->read('Auth.User') && $this->request->action != "forgetpassword"){ ?>
<div class="portlet-body form sign-in">
	<div class="margin-bottom-10">Sign In</div>
	<?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'login')); ?>
		<div class="form-body margin-bottom-20">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"> <i class="fa fa-envelope"></i> </span>
					<?php echo $this->Form->input('email', array(
											'label' 		=> false, 
											'div' 			=> false, 'error' => false,
											'class' 		=> 'form-control placeholder-no-fix', 
											'type' 			=> 'text', 
											'placeholder' 	=> 'Email')); ?>
				</div>
				<?php echo $this->Form->error('email', null, array('class' => 'error-message')); ?>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"> <i class="fa fa-user"></i> </span>
					<?php echo $this->Form->input('password', array(
											'label' 		=> false, 
											'div' 			=> false, 'error' => false,
											'class' 		=> 'form-control placeholder-no-fix', 
											'type' 			=> 'password', 
											'placeholder' 	=> 'Password')); ?>
				</div>
				<?php echo $this->Form->error('password', null, array('class' => 'error-message')); ?>
			</div>
			<div class="form-group">
				<div class="checkbox-list">
					<label class="checkbox-inline">
						<div class="checker" id="uniform-inlineCheckbox1">
							<span>
								<?php echo $this->Form->input('remember_me', array(
														'label' 		=> false, 
														'div' 			=> false, 'error' => false,
														'type' 			=> 'checkbox')); ?>
							</span>
						</div> Remember Me </label>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<div class="form-group">
				<?php 
				echo $this->Form->submit(__('Sign In'), array('class' => 'btn btn-primary collapsed', 'div' => false));
				echo $this->Facebook->login(array('custom' => true, 'label' => 'Log In with Facebook',
												  'class' => 'btn btn-primary pull-right collapsed'));
				?>
			</div>
			<?php 
			//For login Attempts
			$class = 'link-forget-password pull-right';
			if (isset($loginAttempts)){
				if($loginAttempts >= 3){
					$class = 'link-forget-password pull-right highlighted';
				}
			}
			?>
			<div class="form-group">
				<?php 
				echo $this->Html->link(__('Create an account'), '#', array('class' => 'link-create-an-account'));
				echo $this->Html->link(__('Forgot Password?'), '#', 
							array('class' => $class)); ?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>

<div class="portlet-body form forgot-password">
	<div class="margin-bottom-10">Forgot Password</div>
	<?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'forgetpassword')); ?>
		<div class="form-body margin-bottom-20">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"> <i class="fa fa-envelope"></i> </span>
					<?php echo $this->Form->input('email', array(
											'label' 		=> false, 
											'div' 			=> false, 'error' => false,
											'class' 		=> 'form-control placeholder-no-fix', 
											'type' 			=> 'text', 
											'placeholder' 	=> 'Email')); ?>
				</div>
				<?php echo $this->Form->error('email', null, array('class' => 'error-message')); ?>
			</div>
		</div>
		<div class="form-actions">
			<div class="form-group">
				<?php 
				echo $this->Form->submit(__('Reset Password'), array('class' => 'btn btn-primary collapsed', 'div' => false));
				?>
			</div>
			<div class="form-group">
				<?php echo $this->Html->link(__('Sign In'), '#', array('class' => 'link-sign-in')); ?>
				<?php echo $this->Html->link(__('Create an account'), '#', array('class' => 'link-create-an-account pull-right')); ?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>

<div class="portlet-body form create-an-account">
	<div class="margin-bottom-10">Create an account</div>
	<?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register')); ?>
		<div class="form-body margin-bottom-20">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"> <i class="fa fa-user"></i> </span>
					<?php echo $this->Form->input('name', array(
											'label' 		=> false, 
											'div' 			=> false, 'error' => false,
											'class' 		=> 'form-control placeholder-no-fix', 
											'type' 			=> 'text', 
											'placeholder' 	=> 'Name')); ?>
				</div>
				<?php 
				echo $this->Form->error('name', null, array('class' => 'error-message'));
				/* if(!$this->Form->error('name')) {
						echo $this->Html->tag('span', 'This is how your name will be displayed.', 
											  array('class' => 'font-color-white'));
				}*/
				?>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"> <i class="fa fa-envelope"></i> </span>
					<?php echo $this->Form->input('email', array(
											'label' 		=> false, 
											'div' 			=> false, 'error' => false,
											'class' 		=> 'form-control placeholder-no-fix', 
											'type' 			=> 'text', 
											'placeholder' 	=> 'Email')); ?>
				</div>
				<?php echo $this->Form->error('email', null, array('class' => 'error-message')); ?>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"> <i class="fa fa-user"></i> </span>
					<?php echo $this->Form->input('password', array(
											'label' 		=> false, 
											'div' 			=> false, 'error' => false,
											'class' 		=> 'form-control placeholder-no-fix', 
											'type' 			=> 'password', 
											'placeholder' 	=> 'Password')); ?>
				</div>
				<?php echo $this->Form->error('password', null, array('class' => 'error-message')); ?>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"> <i class="fa fa-user"></i> </span>
					<?php echo $this->Form->input('confirmpassword', array(
											'label' 		=> false, 
											'div' 			=> false, 'error' => false,
											'class' 		=> 'form-control placeholder-no-fix', 
											'type' 			=> 'password', 
											'placeholder' 	=> 'Confirm Password')); ?>
				</div>
				<?php echo $this->Form->error('confirmpassword', null, array('class' => 'error-message')); ?>
			</div>
		</div>
		<div class="form-actions">
			<div class="form-group">
				<?php 
				echo $this->Form->submit(__('Join Kissaah'), array('class' => 'btn btn-primary collapsed', 'div' => false));
				echo $this->Facebook->login(array('custom' => true, 'label' => 'Log In with Facebook',
												  'class' => 'btn btn-primary pull-right collapsed'), 'Log In with Facebook'); 
				?>
			</div>
			<div class="form-group">
				<?php echo $this->Html->link(__('Sign In'), '#', array('class' => 'link-sign-in')); ?>
				<?php echo $this->Html->link(__('Forget Password?'), '#', array('class' => 'link-forget-password pull-right')); ?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<?php 
}
?>