<div class="row categories form">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-gift"></i><?php echo __('Add User'); ?></div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('User', array('class' => 'form-horizontal form-bordered form-row-stripped', 
															 'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control'))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Name'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('name'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Password'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('password'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Role'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('role_id'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Verified'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('verified'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Email'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('email'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Code'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('company'); ?></div>
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