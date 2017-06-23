<?php echo $this->Html->script('../plugins/jquery.quicksearch.js', array('inline' => false)); ?>
<?php $parent = (!empty($this->request->pass))? $this->request->pass[0]: ''; ?>
<div class="row company_groups form">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-gift"></i>Add to group</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('CompanyGroupsUser', array(
						'class' => 'form-horizontal form-bordered form-row-stripped',
						'inputDefaults' => array('div' => false, 'label' => false, 'class' => 'form-control'))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Parent'); ?></label>
							<div class="col-md-5"><?php echo $this->Form->input('company_group_id', array('value' => $parent)); ?></div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?php echo __('Group Members'); ?></label>
							<div class="col-md-5"><?php 
							echo $this->Form->input('user_id', array(
									'multiple' => 'multiple', 'class' => 'multi-select')); 
							?></div>
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
<script>
jQuery(document).ready(function() {
	Admin.handleMultiSelect();
}); 
</script>
