<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		//echo $this->Html->meta('favicon.ico', $this->webroot.'khumbaya-favicon.ico', array('type' => 'icon'));
		echo $this->Html->css(array('SuperAdmin.doubleblue', 'SuperAdmin.cpanel', 'SuperAdmin.stats'));
		echo $this->Html->script(array('SuperAdmin.jquery-1.7.2.min', 'SuperAdmin.jscal2', 'SuperAdmin.json-2.2', 'SuperAdmin.jquery.ck','SuperAdmin.admin_entry',
									'SuperAdmin.khum_admin_js_libraries', 'SuperAdmin.cpanel', 'SuperAdmin.record'));
		echo $scripts_for_layout;
		echo $this->Html->scriptBlock('__HOST_NAME__ = "'.substr(Router::url('/', true), 0, -1).'";');
	?>

</head>
<body>
<div id="container">
	<div id="inner-container">
		<div id="header">
			<div id="user-info">
				<p><?php
				
					if ($this->Session->check('Auth.User.id')) {
						echo __('Welcome', true).' <b>'.__('Administrator', true).'</b> (';
						echo $this->Html->link(__('Logout', true), $cpanelOption['logoutAction'], array('rel' => 'allowDefault')).')';
					}
				?></p>
				</div>
			<div id="logo"><?php echo $this->Html->link('', '/') ?></div>
		</div><!-- end header -->
		<div id="content">
			<?php
				echo $this->Session->flash();
				echo $this->Session->flash('auth');
				echo $content_for_layout;
			?>
		</div><!-- end content -->
	</div><!-- end inner-container -->
	<div id="bottom">&nbsp;</div>
	<div id="footer"><p>HimalayanTechies.com</p></div>
</div><!-- end container -->
<?php //echo $this->element('sql_dump'); ?>
</body>
</html>