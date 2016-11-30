<?php
echo $this->Html->css(array('login'));
echo $this->Html->script(array('../plugins/jquery-validation/js/jquery.validate.min', 'pages/login'));

if(strpos(Router::url('/', true), 'humancatalyst') !== false) {
	$company = 'Human Catalyst';
} else {
	$company = 'Kissaah';
}
?>

<div class="row margin-bottom-20">
	<div class="col-md-6 col-sm-6 col-xs-12 login">
		<div class="content">
			<?php 
			echo $this->Session->flash();
			echo $this->Session->flash('auth'); 
			?>
			<!-- BEGIN LOGIN FORM -->
			<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login'), 
					'class' => 'login-form', 
					'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control placeholder-no-fix'))); ?>
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
					<span><?php echo $this->Form->input('remember_me', array( 'error' => false, 'type' => 'checkbox', 'checked')); ?></span> Remember </label>
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
				<div class="login-options">
					<h4>Or login with</h4>
					<?php
					$linkedInConfig = Configure::read('LinkedIn');
					echo $this->Html->image('Sign-in-Small---Default.png', array('url' => 'https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id='.$linkedInConfig['clientID'].'&redirect_uri='.Router::url(array('controller' => 'users', 'action' => 'oauth', 'linkedin'), true), 'class' => 'btn btn-primary pull-right collapsed')); ?>
				</div>
				<div class="create-account">
					<p>Not a user yet?&nbsp;&nbsp;&nbsp;<a class="uppercase" id="register-btn" href="javascript:;">Request an account now!</a></p>
				</div>
			<?php echo $this->Form->end(); ?>
			<!-- END LOGIN FORM -->
			
			<!-- BEGIN FORGOT PASSWORD FORM -->
			<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'forgetpassword'), 
					'class' => 'forget-form', 
					'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control placeholder-no-fix'))); ?>
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
			<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'register'), 
					'class' => 'register-form', 
					'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control placeholder-no-fix'))); ?>
				<h3>Request Account</h3>
				<div class="form-actions">
					<p class="margin-top-10">Submit the form below to request for an account on <?php echo $company; ?>. 
						Once an account is created a login link will be emailed to you.</p>
				</div>
				<div class="form-group">
					<label class="control-label">Full Name</label>
					<?php echo $this->Form->input('id', array('error' => false, 'type' => 'hidden')); ?>
					<?php echo $this->Form->input('name', array('error' => false, 'placeholder' => 'Name')); ?>
					<?php echo $this->Form->error('name', null, array('class' => 'error-message')); ?>
				</div>
				<div class="form-group">
					<label class="control-label">Email (Username)</label>
					<?php echo $this->Form->input('email', array('error' => false, 'placeholder' => 'Email')); ?>
					<?php echo $this->Form->error('email', null, array('class' => 'error-message')); ?>
				</div>
				<?php
				$label = $this->Form->label('password', 'Password', array('class' => 'control-label'));
				$field = $this->Form->input('password', array('error' => false, 'placeholder' => 'Password'));
				$error = $this->Form->error('password', null, array('class' => 'error-message'));
				//echo $this->Html->div('form-group', $label . $field . $error);

				$label = $this->Form->label('password', 'Re-type Your Password', array('class' => 'control-label'));
				$field = $this->Form->input('confirmpassword', array('error' => false, 'type' => 'password', 'placeholder' => 'Re-type Your Password'));
				$error = $this->Form->error('confirmpassword', null, array('class' => 'error-message'));
				//echo $this->Html->div('form-group', $label . $field . $error);
				?>
				<div class="form-group margin-top-20 margin-bottom-20">
					<label class="check">
						<span><?php echo $this->Form->input('terms_conditions', array( 'error' => false, 'type' => 'checkbox', 'checked')); ?></span> 
						I agree to the <a href="#">
						Terms of Service </a>&amp; <a href="#">Privacy Policy </a>
					</label>
					<div id="register_tnc_error"></div>
				</div>
				<div class="form-actions">
					<button class="btn btn-default" id="register-back-btn" type="button">Back</button>
					<?php echo $this->Form->submit(__('Request Account'), array('class' => 'btn btn-primary pull-right collapsed', 'div' => false)); ?>
				</div>
			<?php echo $this->Form->end(); ?>
			<!-- END REGISTRATION FORM -->

			<!-- BEGIN UPDATE FORM -->
			<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'manualLogin'), 
					'class' => 'update-form', 
					'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control placeholder-no-fix'))); ?>
				<h3>Update Profile</h3>
				<div class="form-group">
					<label class="control-label">Full Name</label>
					<?php echo $this->Form->input('id', array('error' => false, 'type' => 'hidden')); ?>
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
						<span><?php echo $this->Form->input('terms_conditions', array( 'error' => false, 'type' => 'checkbox', 'checked')); ?></span> 
						I agree to the <a href="#">
						Terms of Service </a>&amp; <a href="#">Privacy Policy </a>
					</label>
					<div id="register_tnc_error"></div>
					<label class="check">
						<span><?php echo $this->Form->input('remember_me', array( 'error' => false, 'type' => 'checkbox', 'checked')); ?></span> Remember 
					</label>
				</div>
				<div class="form-actions">
				<button class="btn btn-default hidden" id="manual-login" type="button">Back</button>
					<?php echo $this->Form->submit(__('Update & Login'), array('class' => 'btn btn-primary pull-right collapsed', 'div' => false)); ?>
				</div>
			<?php echo $this->Form->end(); ?>
			<!-- END UPDATE FORM -->
		</div>
	</div>
	
	<div class="col-md-6 col-sm-6 col-xs-12 game-area">
		<div class="row"><?php
			/* Discover: Level 1 */
			$title 	= $this->Html->tag('h3', 'Discover', array('class' => 'text-center margin-top-20'));
			$images = $this->Html->div('row', $this->Html->image('discover-new.png', array('class' => 'img-responsive kissaah-step')));
			$circle	= $this->Html->div('row no-margin', $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-0')));
			
			echo $this->Html->div('col-md-6 col-xs-6 home-main-component no-padding', $title . $images . $circle);
			
			/* Envision: Level 2 */
			$title 	= $this->Html->tag('h3', 'Envision', array('class' => 'text-center margin-top-20'));
			$images = $this->Html->div('row', $this->Html->image('envision.png', array('class' => 'img-responsive kissaah-step')));
			$circle	= $this->Html->div('row no-margin', $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-1')));
			
			echo $this->Html->div('col-md-6 col-xs-6 home-main-component no-padding', $title . $images . $circle);
			
		?></div>
		
		<div class="row"><?php
			/* Execute: Level 4 */
			$title 	= $this->Html->tag('h3', 'Execute', array('class' => 'text-center margin-top-5'));
			$images = $this->Html->div('row', $this->Html->image('execute.png', array('class' => 'img-responsive kissaah-step')));
			$circle	= $this->Html->div('row no-margin', $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-3')));
			
			echo $this->Html->div('col-md-6 col-xs-6 home-main-component no-padding', $circle . $title . $images);
			
			/* Design: Level 3 */
			$title 	= $this->Html->tag('h3', 'Design', array('class' => 'text-center margin-top-5'));
			$images = $this->Html->div('row', $this->Html->image('design-new.png', array('class' => 'img-responsive kissaah-step')));
			$circle	= $this->Html->div('row no-margin', $this->Html->image('level-in-progress.jpg', array('class' => 'img-responsive level-2')));
			
			echo $this->Html->div('col-md-6 col-xs-6 home-main-component no-padding', $circle . $title . $images);
			
		?></div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 margin-bottom-15 text-center">
				We've developed <?php echo $company; ?> through our extensive study in how people articulate their life stories to bring about 
				positive change and well-being. Find out more about our research <a href="http://www.kissaah.com/academic-references/" target="_blank">here</a>.
			</div>
		</div>
	</div>
</div>

<?php 
//$rght_block = $this->requestAction(array('controller' => 'posts', 'action' => 'page_content', 1624)); 
$action = '';
if ($this->action == 'register') {
	$action = '#register-btn';
} elseif ($this->action == 'forgetpassword') {
	$action = '#forget-password';
} elseif ($this->action == 'manualLogin') {
	$action = '#manual-login';
}
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	Login.init('<?php echo $action; ?>');
});
</script>
