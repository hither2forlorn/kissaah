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
);

$parent = (!empty($this->request->pass))? $this->request->pass[0]: '';
if(!$this->request->isAjax) {
	echo $this->Html->css(array('../plugins/jstree/dist/themes/default/style.min'), null, array('inline' => false));
	echo $this->Html->script(array('../plugins/jstree/dist/jstree.min'), array('inline' => false));
}
?>
<?php if(!$this->request->isAjax) { ?>
<div class="row categories index">
	<div class="col-md-4 col-sm-4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-cogs"></i><?php echo __('Configurations List'); ?></div>
			</div>
			<div class="portlet-body">
				<div id="tree-setup"></div>
			</div>
		</div>
	</div>
	<div id="tree-list" class="col-md-8 col-sm-8">
<?php } ?>
		<div class="portlet box yellow">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-user"></i><?php echo __('Configurations'); ?></div>
				<div class="actions"><?php 
				if(isset($configuration) && !empty($configuration['Configuration'])) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil')) . ' ' . __('Edit'), 
											array('action' => 'edit', $configuration['Configuration']['id']), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-up')) . ' ' . __('Move Up'), 
											array('action' => 'moveup', $configuration['Configuration']['id'], 1), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-down')) . ' ' . __('Move Down'), 
											array('action' => 'movedown', $configuration['Configuration']['id'], 1), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash')) . ' ' . __('Delete'), 
											array('action' => 'delete', $configuration['Configuration']['id']), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
				}
				echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add New'), 
										array('action' => 'add', $parent), 
										array('class' => 'btn btn-default btn-sm', 'escape' => false));

				?></div>
			</div>
			<?php if(isset($configuration) && !empty($configuration['Configuration'])): ?>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="Configurationes_view">
					<tbody>
						<tr>
							<td><?php echo __('Id'); ?></td>
							<td><?php echo h($configuration['Configuration']['id']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Title'); ?></td>
							<td><?php echo h($configuration['Configuration']['title']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Type'); ?></td>
							<td><?php echo h($options[$configuration['Configuration']['type']]); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Narration Text'); ?></td>
							<td><?php echo h($configuration['Configuration']['naration_txt']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Sub Text'); ?></td>
							<td><?php echo h($configuration['Configuration']['sub_txt']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Summary Text'); ?></td>
							<td><?php echo h($configuration['Configuration']['help_bubble']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Status'); ?></td>
							<td><?php echo ($configuration['Configuration']['status'])? 'Active': 'In-active'; ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Parent'); ?></td>
							<td><?php echo h($configuration['Configuration']['parent']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Dependent to'); ?></td>
							<td><?php echo h($configuration['Configuration']['dependent']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Feedback'); ?></td>
							<td><?php echo ($configuration['Configuration']['feedback'])? 'Yes': 'No'; ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Featured'); ?></td>
							<td><?php echo ($configuration['Configuration']['featured'])? 'Yes': 'No'; ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Total Points'); ?></td>
							<td><?php echo h($configuration['Configuration']['total_points']); ?>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php endif; ?>
		</div>
<?php if(!$this->request->isAjax) { ?>
	</div>
</div>
<?php echo $this->Html->scriptBlock('var link = "' . $this->Html->url(array('controller' => 'configurations'), true) . '";'); ?>
<script>
jQuery(document).ready(function() {
	Admin.contextualMenu(link);
}); 
</script>
<?php } ?>
