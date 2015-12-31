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
        							'../plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
                                    '../plugins/bootstrap-daterangepicker/daterangepicker-bs3',
									'../plugins/bootstrap-datepicker/css/datepicker'));
		
		echo $this->fetch('css');
        echo $this->Html->css('components', array('id' => 'style_components'));
		echo $this->Html->css(array('plugins', 'layout'));
		echo $this->Html->css('themes/darkblue', array('id' => 'style_color'));
		echo $this->Html->css('custom');

        /* START CORE PLUGINS */
        echo $this->Html->script(array('../plugins/respond.min',
                                       '../plugins/excanvas.min',
                                       '../plugins/jquery.min',
                                       '../plugins/jquery-migrate.min',
                                       '../plugins/jquery-ui/jquery-ui.min',
                                       '../plugins/bootstrap/js/bootstrap.min',
                                       '../plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min',
                                       '../plugins/jquery.blockui.min',
                                       '../plugins/jquery.cokie.min',
                                       '../plugins/uniform/jquery.uniform.min',
                                       '../plugins/bootstrap-switch/js/bootstrap-switch.min'));
		/* END CORE PLUGINS */
        echo $this->Html->script(array('../plugins/select2/select2.min',
                                       '../plugins/datatables/media/js/jquery.dataTables.min',
                                       '../plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
									   '../plugins/bootstrap-daterangepicker/moment.min',
									   '../plugins/bootstrap-daterangepicker/daterangepicker',
									   '../plugins/bootstrap-datepicker/js/bootstrap-datepicker'));
				
		echo $this->Html->script(array('metronic', 'layout', 'demo', 'pages/admin'));
		echo $this->fetch('script');
	?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
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