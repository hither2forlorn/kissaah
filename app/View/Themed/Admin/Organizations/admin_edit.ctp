<?php $options = array('1' => 'Org Map'); ?>
<div class="row categories form">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-gift"></i><?php echo __('Edit Organization'); ?></div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('Organization', array(
																'class' => 'form-horizontal form-bordered form-row-stripped', 
																'inputDefaults' => array(
																		'div' => false, 'label' => false, 'class' => 'form-control', 'empty' => '--SELECT--'
																))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Title'); ?></label>
							<div class="col-md-5">
								<?php echo $this->Form->input('id'); ?>
								<?php echo $this->Form->input('title'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Description'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('description'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Type'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('type', array('options' => $options)); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Parent'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('parent_id', array('options' => $parent_id)); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Status'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('status', array('options' => array(0 => 'Disable', 1 => 'Active'))); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Featured'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('featured'); ?></div>
						</div>
					</div>
					<div class="form-actions right">
						<?php echo $this->Html->link('Cancel', $this->request->referer(), array('class' => 'btn default')); ?>
						<button class="btn green" type="submit"><i class="fa fa-check"></i> Submit</button>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>