<?php
$parent = (!empty($this->request->pass))? $this->request->pass[0]: '';
?>
<div class="row company_groups form">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-gift"></i><?php echo empty($parent) ? __('Edit Company') : __('Edit Group'); ?></div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('CompanyGroup', array(
																'class' => 'form-horizontal form-bordered form-row-stripped', 
																'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control'))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Title'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('title'); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Code'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('code'); ?></div>
						</div>
						<?php if(!empty($admins)) { ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Admin'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('admin_id', array('empty' => '--SELECT--')); ?></div>
						</div>
						<?php } ?>
						<?php if(!empty($parent_id)) { ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Parent'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('parent_id', array('options' => $parent_id, 'empty' => '--SELECT--', 'value' => $parent)); ?></div>
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