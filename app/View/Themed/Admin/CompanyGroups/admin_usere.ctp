<div class="row company_groups form">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-gift"></i><?php echo (empty($parent_id)) ? __('Edit Company') : __('Edit Group'); ?></div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('User Edit', array(
																'class' => 'form-horizontal form-bordered form-row-stripped', 
																'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control'))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Usser Name'); ?></label>
							<div class="col-md-5">
								<?php echo $this->Form->input('id'); ?>
								<?php echo $this->Form->input('Name'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Email'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('email'); ?></div>
						</div>
                                            <div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Company Name'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('title'); ?></div>
						</div>
						<?php if(!empty($admins)) { ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Admin'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('admin_id', array('empty' => '--SELECT--')); ?></div>
						</div>
						<?php } ?>
						
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
