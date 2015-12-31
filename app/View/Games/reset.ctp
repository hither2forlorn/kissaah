<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo $this->Html->tag('h4', 'Confirm Roadmap Reset'); ?>
</div>
<?php 
echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12',
					  $this->Html->para(null, 
					  		'Please note that you will loose all your current Roadmap data. <br />Enter CONFIRM to really reset the Roadmap.'));
?>
<div class="col-md-12 col-sm-12">
	<?php echo $this->Form->create('Game', array('action' => 'reset')); ?>
		<div class="form-group">
			<?php echo $this->Form->input('confirm', array('label' => false, 
														'div' 			=> false,
														'class' 		=> 'form-control',
														'placeholder' 	=> '')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->button('Reset', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>