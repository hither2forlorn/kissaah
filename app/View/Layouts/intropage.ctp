<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
	<meta charset="utf-8">
	<title>Kissaah</title>
	<meta name="description" content="">
	<meta name="author" content="Kissaah by Victoria Woo">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<script type="text/javascript">var host_url = '<?php echo Router::url('/', true); ?>';</script>
	
	<?php
	echo $this->Facebook->html();
	
	//echo $this->Html->meta('icon', $this->Html->url('http://kissaah.com/wp-content/uploads/KissaahFlower2015.png'));
	echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon'));
    
    echo $this->Html->css(array('../plugins/font-awesome/css/font-awesome.min', 
								'../plugins/bootstrap/css/bootstrap.min'));
    
    echo $this->Html->css(array('style'));
    
    echo $this->Html->script(array( '../plugins/jquery.min',
    								'../plugins/jquery-migrate.min',
									'../plugins/bootstrap/js/bootstrap.min'));

    echo $this->Html->script(array('metronic'));

	echo '<!--[if lt IE 9]>';
	echo $this->Html->css(array('ie'));
    echo $this->Html->script(array( '../plugins/respond.min', '../plugins/excanvas.min'));
	echo '<![endif]-->';
	?>
</head>

<!-- Body BEGIN -->
<body class=""><!-- add class page-header-fixed, if you want to fix header -->intropage is this users?
	<div class="page-slider margin-bottom-40">
		<div class="container">
			<div class="margin-bottom-40"></div>
			<div class="row">
				<div class="col-md-12 highlighted"></div>
			</div>
		</div>
	</div>

    <div class="main">
		<div class="container"></div>
    </div>

    <!-- BEGIN FOOTER -->
    <?php echo $this->element('footer'); ?>
    <!-- END FOOTER -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		Metronic.init(); // init metronic core componets
	});
</script>
</body>
<?php echo $this->Facebook->init(); ?>
</html>