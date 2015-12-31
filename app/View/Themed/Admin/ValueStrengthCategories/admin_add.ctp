<div class="row attributes form">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-gift"></i><?php echo __('Add Value Strength Category'); ?></div>
				<div class="actions">
					<div class="btn-group">
						<a class="btn btn-default btn-sm" href="#" data-toggle="dropdown"> <i class="fa fa-cogs"></i> Actions <i class="fa fa-angle-down"></i> </a>
					</div>
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('ValueStrengthCategory', array(
																'class' => 'form-horizontal form-bordered form-row-stripped', 
																'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control'))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Name'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('title'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Document Type'); ?></label>
							<div class="col-md-5">
								<?php echo $this->Form->input('type', array('options' => array('Strengths' => 'Strengths', 'Values' => 'Values'), 
																			'empty' => '--SELECT--')); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Active'); ?></label>
							<div class="col-md-5">
								<?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Created By'); ?></label>
							<div class="col-md-5"><?php echo $this->Session->read('Auth.User.name'); ?></div>
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
