<?php
if(!isset($company_group_id)) {
	$company_group_id = null;
}
$parent_id = (!empty($this->request->pass[0]))? $this->request->pass[0]: '';
if(!$this->request->isAjax) {
	echo $this->Html->css(array('../plugins/jstree/dist/themes/default/style.min'), null, array('inline' => false));
	echo $this->Html->script(array('../plugins/jstree/dist/jstree.min'), array('inline' => false));
}
$options = array('1' => 'Org Map');
?>
<?php if(!$this->request->isAjax) { ?>
<div class="row categories index">
	<div class="col-md-4 col-sm-4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-cogs"></i><?php echo __('Organizations List'); ?></div>
			</div>
			<div class="portlet-body"><div id="tree-setup"></div></div>
		</div>
	</div>
	<div id="tree-list" class="col-md-8 col-sm-8">
<?php } ?>
		<div class="portlet box yellow">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-user"></i><?php echo __('Organizations'); ?></div>
				<div class="actions"><?php 
				if(isset($organization) && !empty($organization['Organization'])) {
					$company_group_id = $organization['Organization']['company_group_id'];
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil')) . ' ' . __('Edit'), 
							array('action' => 'edit', $organization['Organization']['id'], $company_group_id), 
							array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-up')) . ' ' . __('Move Up'), 
							array('action' => 'moveup', $organization['Organization']['id'], 1), 
							array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-down')) . ' ' . __('Move Down'), 
							array('action' => 'movedown', $organization['Organization']['id'], 1), 
							array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash')) . ' ' . __('Delete'), 
							array('action' => 'delete', $organization['Organization']['id']), 
							array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-sitemap')) . ' ' . __('Organization Map'),
							array('action' => 'index', $company_group_id, 'admin' => false),
							array('class' => 'btn btn-default btn-sm', 'target' => '_blank', 'escape' => false));
					echo '&nbsp;';
				}
				echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add New'), 
						array('action' => 'add', $parent_id, $company_group_id), 
						array('class' => 'btn btn-default btn-sm', 'escape' => false));
				?></div>
			</div>
			<?php if(isset($organization) && !empty($organization['Organization'])): ?>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="Configurationes_view">
					<tbody>
						<tr>
							<td><?php echo __('Id'); ?></td>
							<td><?php echo h($organization['Organization']['id']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Title'); ?></td>
							<td><?php echo h($organization['Organization']['title']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Description'); ?></td>
							<td><?php echo h($organization['Organization']['description']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Type'); ?></td>
							<td><?php
							if(isset($options[$organization['Organization']['type']])) {
								echo h($options[$organization['Organization']['type']]);
							} ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Status'); ?></td>
							<td><?php echo ($organization['Organization']['status'])? 'Active': 'In-active'; ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Parent'); ?></td>
							<td><?php echo h($organization['Organization']['parent']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Featured'); ?></td>
							<td><?php echo ($organization['Organization']['featured'])? 'Yes': 'No'; ?>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php endif; ?>
		</div>
<?php if(!$this->request->isAjax) { ?>
	</div>
</div>
<?php echo $this->Html->scriptBlock('var link = "' . $this->Html->url(array('controller' => 'organizations'), true) . '";'); ?>
<script>
jQuery(document).ready(function() {
	Admin.contextualMenu(link, <?php echo $parent_id; ?>);
}); 
</script>
<?php } ?>
