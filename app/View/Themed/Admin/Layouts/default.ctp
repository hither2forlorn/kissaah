<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php //echo $cakeDescription ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->fetch('meta');
		echo $this->Html->meta('icon');

		// BEGIN GLOBAL MANDATORY STYLES
		echo $this->Html->css('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all');
        echo $this->Html->css(array('../plugins/font-awesome/css/font-awesome.min',
                                    '../plugins/simple-line-icons/simple-line-icons.min',
                                    '../plugins/bootstrap/css/bootstrap.min',
                                    '../plugins/uniform/css/uniform.default',
                                    '../plugins/bootstrap-switch/css/bootstrap-switch.min'));

		// END GLOBAL MANDATORY STYLES
		// BEGIN THEME STYLES
        echo $this->Html->css(array('../plugins/select2/select2',
        							'../plugins/datatables/plugins/bootstrap/dataTables.bootstrap'));
		
		echo $this->fetch('css');
        echo $this->Html->css('components', array('id' => 'style_components'));
		echo $this->Html->css(array('plugins', 'layout'));
		echo $this->Html->css('themes/darkblue', array('id' => 'style_color'));
		echo $this->Html->css('custom');

        /* START CORE PLUGINS */
        echo $this->Html->script(array( '../plugins/respond.min',
                                        '../plugins/excanvas.min',
										'../plugins/jquery.min',
                                 		'../plugins/jquery-migrate.min',
        								'../plugins/moment.min',
                                        '../plugins/jquery-ui/jquery-ui.min',
                                        '../plugins/bootstrap/js/bootstrap.min',
                                        '../plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min',
                                        '../plugins/jquery.blockui.min',
                                        '../plugins/uniform/jquery.uniform.min',
                                        '../plugins/bootstrap-switch/js/bootstrap-switch.min'));
		/* END CORE PLUGINS */
        echo $this->Html->script(array('../plugins/select2/select2.min',
                                       '../plugins/datatables/media/js/jquery.dataTables.min',
                                       '../plugins/datatables/plugins/bootstrap/dataTables.bootstrap'));
				
		echo $this->Html->script(array('metronic', 'layout', 'demo', 'pages/admin'));
		echo $this->fetch('script');
	?>
	<script type="text/javascript">var host_url = '<?php echo Router::url('/', true); ?>';</script>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content ">
	<?php echo $this->element('header'); ?>
	<div class="clearfix"></div>

		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
			<?php echo $this->element('sidebar'); ?>
			<!-- END SIDEBAR -->
			
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
					<?php echo $this->element('modal'); ?>
					<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
					
					<!-- BEGIN BREADCRUMBS -->
					<?php echo $this->element('breadcrumb'); ?>
					<!-- END BREADCRUMBS -->
					
					<!-- BEGIN DASHBOARD STATS -->
					<?php //echo $this->element('dashboard-stats'); ?>
					<!-- END DASHBOARD STATS -->
					
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content'); ?>
				</div>
			</div>
			<!-- END CONTENT -->
			
		</div>
		<!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <?php echo $this->element('footer'); ?>
    <?php echo $this->element('sql_dump'); ?>
    <!-- END FOOTER -->
<script>
jQuery(document).ready(function() {   
	// initiate layout and plugins
	Metronic.init();	//init metronic core components
	Layout.init(); 		//init current layout
	Demo.init(); 		//init demo features
});
</script>
<!-- END JAVASCRIPTS -->
</body>
</html>