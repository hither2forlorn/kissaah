<?php
echo $this->Html->css(array('login'));
echo $this->Html->script(array('../plugins/jquery-validation/js/jquery.validate.min', 'pages/intropage', 'pages/login'));
?>
<div class="row margin-bottom-20">
	<div class="col-md-6 login">
		<div class="content">
			<?php 
			echo $this->Session->flash();
			echo $this->Session->flash('auth'); 
			?>
			<!-- BEGIN LOGIN FORM -->
			<?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'login-form', 
														 'inputDefaults' => array('div' => false, 'label' => false, 
														 						  'class' => 'form-control placeholder-no-fix'))); ?>
				<h3 class="form-title">Sign In</h3>
				<div class="alert alert-danger display-hide">
					<button data-close="alert" class="close"></button>
					<span>Enter any username and password. </span>
				</div>
				<div class="form-group">
					<label class="control-label">Username</label>
					<?php echo $this->Form->input('email', array('error' => false, 'placeholder' => 'Email')); ?>
					<?php echo $this->Form->error('email', null, array('class' => 'error-message')); ?>
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
					<?php echo $this->Form->input('password', array('error' => false, 'placeholder' => 'Password')); ?>
					<?php echo $this->Form->error('password', null, array('class' => 'error-message')); ?>
				</div>
				<div class="form-actions">
					<?php echo $this->Form->submit(__('Sign In'), array('class' => 'btn btn-primary collapsed', 'div' => false)); ?>
					<label class="rememberme check">
					<span><input type="checkbox" value="1" name="data[User][remember_me]"></span> Remember </label>
					<a class="forget-password" id="forget-password" href="javascript:;">Forgot Password?</a>
					<p class="margin-top-10">By clicking Sign In, you are agreeing to <a href="http://www.kissaah.com/terms-of-service/" target="_blank">
						Terms of Service </a>&amp; <a href="http://www.kissaah.com/privacy-policy" target="_blank">Privacy Policy </a> </p>
				</div>
				<?php /*
				<div class="login-options">
					<h4>Or login with</h4>
					<?php echo $this->Facebook->login(array('custom' => true, 'label' => 'Facebook',
														  'class' => 'btn btn-primary pull-right collapsed')); ?>
				</div>
				*/  ?>
				<div class="create-account">
					<p>Not a user yet?&nbsp;&nbsp;&nbsp;<a class="uppercase" id="register-btn" href="javascript:;">Join Now!</a></p>
				</div>
			<?php echo $this->Form->end(); ?>
			<!-- END LOGIN FORM -->
			
			<!-- BEGIN FORGOT PASSWORD FORM -->
			<?php echo $this->Form->create('User', array('action' => 'forgetpassword', 'class' => 'forget-form', 
														 'inputDefaults' => array('div' => false, 'label' => false, 
														 						  'class' => 'form-control placeholder-no-fix'))); ?>
				<h3>Forget Password ?</h3>
				<p>Enter your e-mail address below to reset your password.</p>
				<div class="form-group">
					<?php echo $this->Form->input('email', array('error' => false, 'placeholder' => 'Email')); ?>
					<?php echo $this->Form->error('email', null, array('class' => 'error-message')); ?>
				</div>
				<div class="form-actions">
					<button class="btn btn-default" id="back-btn" type="button">Back</button>
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-primary collapsed pull-right', 'div' => false)); ?>
				</div>
			<?php echo $this->Form->end(); ?>
			<!-- END FORGOT PASSWORD FORM -->
			
			<!-- BEGIN REGISTRATION FORM -->
			<?php echo $this->Form->create('User', array('action' => 'register', 'class' => 'register-form', 
														 'inputDefaults' => array('div' => false, 'label' => false, 
														 						  'class' => 'form-control placeholder-no-fix'))); ?>
				<h3>Sign Up</h3>
				<p class="hint">Enter your personal details below:</p>
				<div class="form-group">
					<label class="control-label">Full Name</label>
					<?php echo $this->Form->input('name', array('error' => false, 'placeholder' => 'Name')); ?>
					<?php echo $this->Form->error('name', null, array('class' => 'error-message')); ?>
				</div>
				<div class="form-group">
					<label class="control-label">Email (Username)</label>
					<?php echo $this->Form->input('email', array('error' => false, 'placeholder' => 'Email')); ?>
					<?php echo $this->Form->error('email', null, array('class' => 'error-message')); ?>
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
					<?php echo $this->Form->input('password', array('error' => false, 'placeholder' => 'Password')); ?>
					<?php echo $this->Form->error('password', null, array('class' => 'error-message')); ?>
				</div>
				<div class="form-group">
					<label class="control-label">Re-type Your Password</label>
					<?php echo $this->Form->input('confirmpassword', array( 'error' => false, 'type' => 'password', 
																			'placeholder' => 'Re-type Your Password')); ?>
					<?php echo $this->Form->error('confirmpassword', null, array('class' => 'error-message')); ?>
				</div>
				<div class="form-group margin-top-20 margin-bottom-20">
					<label class="check">
						<span><input type="checkbox" name="tnc"></span> I agree to the <a href="#">
						Terms of Service </a>&amp; <a href="#">Privacy Policy </a>
					</label>
					<div id="register_tnc_error"></div>
				</div>
				<div class="form-actions">
					<button class="btn btn-default" id="register-back-btn" type="button">Back</button>
					<?php echo $this->Form->submit(__('Join Kissaah'), array('class' => 'btn btn-primary pull-right collapsed', 'div' => false)); ?>
				</div>
			<?php echo $this->Form->end(); ?>
			<!-- END REGISTRATION FORM -->
		</div>
	</div>
	
	<div class="col-md-6 game-area">
		<div class="row"><?php
			/* Discover: Level 1 */
			$title 	= $this->Html->tag('h3', 'Discover', array('class' => 'text-center margin-top-20'));
			$images = $this->Html->div('row no-margin level-display', $this->Html->image('discover-new.png', array('class' => 'img-responsive')));
			$circle	= $this->Html->div('row no-margin', $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-187')));
			
			echo $this->Html->div('col-md-6 col-xs-6 main-component', $title . $images . $circle);
			
			/* Envision: Level 2 */
			$title 	= $this->Html->tag('h3', 'Envision', array('class' => 'text-center margin-top-20'));
			$images = $this->Html->div('row no-margin level-display', $this->Html->image('envision.png', array('class' => 'img-responsive')));
			$circle	= $this->Html->div('row no-margin', $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-188')));
			
			echo $this->Html->div('col-md-6 col-xs-6 main-component', $title . $images . $circle);
			
		?></div>
		
		<div class="row"><?php
			/* Execute: Level 4 */
			$title 	= $this->Html->tag('h3', 'Execute', array('class' => 'text-center'));
			$images = $this->Html->div('row no-margin level-display', $this->Html->image('execute.png', array('class' => 'img-responsive')));
			$circle	= $this->Html->div('row no-margin', $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-190')));
			
			echo $this->Html->div('col-md-6 col-xs-6 main-component', $circle . $title . $images);
			
			/* Design: Level 3 */
			$title 	= $this->Html->tag('h3', 'Design', array('class' => 'text-center'));
			$images = $this->Html->div('row no-margin level-display', $this->Html->image('design-new.png', array('class' => 'img-responsive')));
			$circle	= $this->Html->div('row no-margin', $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-189')));
			
			echo $this->Html->div('col-md-6 col-xs-6 main-component', $circle . $title . $images);
			
		?></div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 margin-bottom-15 text-center">
				We've developed Kissaah through our extensive study in how people articulate their life stories to bring about 
				positive change and well-being. Find out more about our research <a href="http://www.kissaah.com/academic-references/" target="_blank">here</a>.
			</div>
		</div>
	</div>
</div>

<?php
//$rght_block = $this->requestAction(array('controller' => 'posts', 'action' => 'page_content', 1624));
?>
<?php 
$action = '.link-sign-in';
if ($this->action == 'register') {
	$action = '.link-create-an-account';
} elseif ($this->action == 'forgetpassword') {
	$action = '.link-forget-password';
}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		IntroPage.AccountManagement();
		IntroPage.init('<?php echo $action; ?>');
		Login.init();
	});
</script>
