<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
<?php 
if(strpos(Router::url('/', true), 'humancatalyst') !== false || strpos(Router::url('/', true), 'localhost') !== false) {
	$favicon = 'hcfavicon.gif';
} else {
	$favicon = 'favicon.ico';
}
?>
	<meta charset="utf-8">
	<title><?php echo $this->Session->read('Company.name'); ?></title>
	<meta name="description" content="">
	<meta name="author" content="<?php echo $this->Session->read('Company.name'); ?> by Victoria Woo">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<script type="text/javascript">var host_url = '<?php echo Router::url('/', true); ?>';</script>

	<?php
	echo $this->Html->meta($favicon, '/' . $favicon, array('type' => 'icon'));
	//echo $this->Html->css('http://fonts.googleapis.com/css?family=Signika:400,300,600,700&subset=all');
	//echo $this->Html->css('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all');
	echo $this->Html->css('http://fonts.googleapis.com/css?family=Josefin+Sans:400,400i&subset=all');
	
    echo $this->Html->css(array('../plugins/font-awesome/css/font-awesome.min',
    	'../plugins/simple-line-icons/simple-line-icons.min',
		'../plugins/bootstrap/css/bootstrap.min',
        '../plugins/uniform/css/uniform.default',
    	'../plugins/bootstrap-switch/css/bootstrap-switch.min',
		'../plugins/bootstrap-fileinput/bootstrap-fileinput',
		'../plugins/bootstrap-datepicker/css/bootstrap-datepicker',
		'../plugins/fancybox/dist/jquery.fancybox',
		'../plugins/jquery-tourbus/dist/jquery-tourbus.min',
		'../plugins/typeahead/typeahead',
		'../plugins/fullcalendar/fullcalendar.min',
		'../plugins/raty/lib/jquery.raty'));
    echo $this->fetch('css');
	echo $this->Html->css(array('components', 'plugins', 'style', 'challenges', 'custom'));
    
	echo '<!--[if lt IE 9]>';
	echo $this->Html->css(array('ie'));
    echo $this->Html->script(array( '../plugins/respond.min', '../plugins/excanvas.min'));
	echo '<![endif]-->';

    echo $this->Html->script(array(
    		'../plugins/jquery.min',
    		'../plugins/jquery-migrate.min',
    		'../plugins/moment.min',
    		'../plugins/jquery-ui/jquery-ui.min',
    		'../plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min',
    		'../plugins/jquery.form',
			'../plugins/bootstrap/js/bootstrap.min',
			'../plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min',
            '../plugins/jquery-slimscroll/jquery.slimscroll.min',
            '../plugins/jquery.blockui.min',
            '../plugins/uniform/jquery.uniform.min',
            '../plugins/bootstrap-switch/js/bootstrap-switch.min',
            '../plugins/select2/select2.min',
            '../plugins/datatables/media/js/jquery.dataTables.min',
            '../plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'../plugins/bootstrap-datepicker/js/bootstrap-datepicker',
			'../plugins/fancybox/dist/jquery.fancybox',
			'../plugins/bootstrap-fileinput/bootstrap-fileinput',
			'../plugins/jquery.scrollTo/jquery.scrollTo.min',
			'../plugins/jquery-tourbus/dist/jquery-tourbus.min',
			'../plugins/jquery-inputmask/jquery.inputmask.bundle.min',
			'../plugins/typeahead/handlebars.min',
			'../plugins/typeahead/typeahead.bundle.min',
			'../plugins/fullcalendar/fullcalendar.min',
			'../plugins/raty/lib/jquery.raty',
    		'../plugins/countdown/jquery.countdown.min',
    		'https://addthisevent.com/libs/ate-latest.min.js'
    ));
	echo $this->Html->script(array('metronic', 'pages/game', 'pages/allies', 'pages/challenges', 'pages/profile', 'pages/profile-countries'));
	echo $this->fetch('script');
?>
</head>
<script type="text/javascript">
	(function(i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] ||
		function() {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o), m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

	ga('create', 'UA-19274647-23', 'kissaah.org');
	ga('send', 'pageview');
</script>
<?php 
$screen_width = $this->Session->read('Screen.width');
if(is_null($screen_width)) {
	$screen_width = 768;
}
?>
<body class="for-line">
	<div class="mask"></div>
    <?php echo $this->element('header'); ?>
    <div class="main">
		<div class="container"><?php 
			echo $this->Session->flash('email');
			echo $content_for_layout;
		?></div>
    </div>
    <?php 
    if(!$this->Session->check('Auth.User')) {
		echo $this->element('footer');
	}
    echo $this->element('sql_dump');
    echo $this->Html->div('', debug($this->Session->read('Auth')));
    echo $this->Html->div('', debug($this->Session->read('ActiveGame')));
    echo $this->Html->div('', debug($this->Session->read('Company')));
    echo $this->Html->div('', debug($this->Session->read('Game')));
    echo $this->Html->div('', debug($this->Session->read('Current')));
    echo $this->Html->div('', debug($this->Session->read('Vision')));
    echo $this->Html->div('', debug($this->Session->read('Profile')));
    ?>
<script type="text/javascript">
$(window).bind('load', function() {
	Game.TourGame();
	Game.ToolBoxLoadLink();
});

$(document).ready(function() {
	Metronic.init();
	Game.UpdateNotification();

	screen_width = <?php echo ($screen_width != '')? 800: $screen_width; ?>;
	if(screen_width > 767) {
		Game.StartGame();
		Game.Support();
	}

	<?php if($this->Session->read('Auth.User')) { ?>

	narration = <?php echo ($this->Session->check('Narration'))? 1: 1; ?>;
	user_info = <?php echo ($this->Session->check('Auth.User.gender'))? 1: 0; ?>;
	
	facebook_warning = <?php echo $this->Session->read('Auth.User.facebook_warning')? 1: 0; ?>;
	consent_for_collage = <?php echo $this->Session->check('Auth.User.collage_status')? 1: 0; ?>;

	<?php $roadmap = $this->Session->read('ActiveGame.roadmap'); ?>
	road_map = <?php echo (empty($roadmap))? 0: 1; ?>;
	thriving_scale = <?php echo isset($step_complete[192])? $step_complete[192]: 2; ?>;

	Game.init(narration, user_info, facebook_warning, consent_for_collage, road_map, thriving_scale);
	<?php } ?>
});
</script>
</body>
</html>