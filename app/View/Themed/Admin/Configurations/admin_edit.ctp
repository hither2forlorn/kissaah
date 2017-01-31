<?php
$options = array(
		0 	=> '(0) Step', 
		1 	=> '(1) Upload', 
		2 	=> '(2) Date', 
		3 	=> '(3) Text add more', 
		4 	=> '(4) Sorting Group', 
		5 	=> '(5) Text Area', 
		6 	=> '(6) Label', 
		7 	=> '(7) Text (Caption)', 
		8 	=> '(8) Sorting Answer', 
		9 	=> '(9) Allies', 
		10 	=> '(10) Assessment Group',
		11 	=> '(11) Assessment Child',
		12 	=> '(12) Summary',
		13	=> '(13) Re-sorting Parent',
		14	=> '(14) Re-sorting Child',
		15	=> '(15) Challenges',
		16	=> '(16) Challenge Summary',
		17	=> '(17) Calendar',
		18	=> '(18) Video',
		19	=> '(19) Confirm',
		20	=> '(20) Competencies',
		21	=> '(21) Org Maps',
		22	=> '(22) Countdown',
		23	=> '(23) Confirm Summary',
		24	=> '(24) Capture Learning',
);
?>
<div class="row categories form">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-gift"></i><?php echo __('Edit Category'); ?></div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Configuration', array(
																'class' => 'form-horizontal form-bordered form-row-stripped', 
																'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control'))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Title'); ?></label>
							<div class="col-md-5">
								<?php echo $this->Form->input('id'); ?>
								<?php echo $this->Form->input('title'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Narration Text'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('naration_txt'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Sub Text'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('sub_txt'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Summary Text'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('help_bubble'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Type'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('type', array('options' => $options, 'empty' => '--SELECT--')); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Parent'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('parent_id', array('options' => $parent_id, 'empty' => '--SELECT--')); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Dependent on'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('dependent_id', array('options' => $parent_id, 'empty' => '--SELECT--')); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Status'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('status', array('options' => array(0 => 'Disable', 1 => 'Active'))); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Feedback'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('feedback'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Featured'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('featured'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Total Points'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('total_points'); ?></div>
						</div>
					</div>
					<div class="form-actions right">
						<?php echo $this->Html->link('Cancel', $this->request->referer(), array('class' => 'btn default')); ?>
						<button class="btn green" type="submit"><i class="fa fa-check"></i> Submit</button>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
		</div>
	</div>
</div>