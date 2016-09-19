<div class="row users form">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-gift"></i><?php echo __('Change User Information'); ?></div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('User', array(
																'class' => 'form-horizontal form-bordered form-row-stripped', 
																'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control'))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Name'); ?></label>
							<div class="col-md-5">
								<?php echo $this->Form->input('id'); ?>
								<span class="help-block"><?php echo  $this->request->data['User']['name']; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Email'); ?></label>
							<div class="col-md-5"><span class="help-block"><?php echo $this->request->data['User']['email']; ?></span></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Signed up'); ?></label>
							<div class="col-md-5"><span class="help-block"><?php echo $this->request->data['User']['created']; ?></span></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Last Seen'); ?></label>
							<div class="col-md-5"><span class="help-block"> <?php echo $this->request->data['User']['last_login']; ?></span> </div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Last login IP'); ?></label>
							<div class="col-md-5"><span class="help-block"> <?php echo  $this->request->data['User']['login_ip'];?> </span></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Verified'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('verified', array('type' => 'checkbox')); ?></div>
						</div>
						<?php if(!empty($roles)) { ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Role'); ?></label>
							<div class="col-md-5">
								<?php echo $this->Form->input('role_id'); ?>
								<span class="help-block"> This is inline help </span>
							</div>
						</div>
						<?php } ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Company'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('company_id', array('options' => $companies, 'hiddenField' => false, 'multiple' => false, 'empty' => '--SELECT--')); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Company Admin'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('company_admin', array('type' => 'checkbox', 'hiddenField' => false)); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Group'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('group_id', array('options' => $groups, 'hiddenField' => false, 'multiple' => false, 'empty' => '--SELECT--')); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Group Admin'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('group_admin', array('type' => 'checkbox', 'hiddenField' => false)); ?></div>
						</div>
					</div>
					<div class="form-actions right">
						<button class="btn green" type="submit"><i class="fa fa-check"></i> Save</button>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
		</div>
	</div>
</div>