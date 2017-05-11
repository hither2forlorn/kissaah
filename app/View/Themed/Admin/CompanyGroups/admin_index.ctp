<?php
$parent = (!empty($this->request->pass))? $this->request->pass[0]: '';
if(!$this->request->is('ajax')) {
	echo $this->Html->css(array('../plugins/jstree/dist/themes/default/style.min'), null, array('inline' => false));
	echo $this->Html->script(array('../plugins/jstree/dist/jstree.min'), array('inline' => false));
}
?>
<?php if(!$this->request->is('ajax')) { ?>
<div class="row categories index">
	<div class="col-md-4 col-sm-4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-cogs"></i><?php echo __('Company/Groups List'); ?></div>
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
				<div class="caption"><i class="fa fa-user"></i><?php echo empty($company_group['CompanyGroup']['parent']) ? __('Company') : __('Sub Company'); ?></div>
				<div class="actions"><?php 
				if(isset($company_group) && !empty($company_group['CompanyGroup'])) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil')) . ' ' . __('Edit'), 
											array('action' => 'edit', $company_group['CompanyGroup']['id']), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-up')) . ' ' . __('Move Up'), 
											array('action' => 'moveup', $company_group['CompanyGroup']['id'], 1), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-down')) . ' ' . __('Move Down'), 
											array('action' => 'movedown', $company_group['CompanyGroup']['id'], 1), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash')) . ' ' . __('Delete'), 
											array('action' => 'delete', $company_group['CompanyGroup']['id']), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					if($company_group['CompanyGroup']['parent'] == '') {
						echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash')) . ' ' . __('Organization'),
								array('controller' => 'organizations', 'action' => 'index', $company_group['CompanyGroup']['id']),
								array('class' => 'btn btn-default btn-sm', 'escape' => false));
						echo '&nbsp;';
					}
				}
				echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add New'), 
									array('action' => 'add', $parent), 
									array('class' => 'btn btn-default btn-sm', 'escape' => false));

				?></div>
			</div>
			<?php if(isset($company_group) && !empty($company_group['CompanyGroup'])): ?>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="CompanyGroupes_view">
					<tbody>
						<tr>
                            <td><b><?php echo __('ID'); ?></b></td>
							<td><?php echo h($company_group['CompanyGroup']['id']); ?>&nbsp;</td>
						</tr>
						<tr>
                            <td><b><?php echo __('Name'); ?></b></td>
							<td><?php echo h($company_group['CompanyGroup']['title']); ?>&nbsp;</td>
						</tr>
						<tr>
                            <td><b><?php echo __('Code'); ?></b></td>
							<td><?php echo h($company_group['CompanyGroup']['code']); ?>&nbsp;</td>
						</tr>
						<tr>
                            <td><b><?php echo __('Admin'); ?></b></td>
							<td><?php echo h($company_group['User']['name']); ?>&nbsp;</td>
						</tr>
						<tr>
                            <td><b><?php echo __('Parent'); ?></b></td>
							<td><?php echo h($company_group['CompanyGroup']['parent']); ?>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php endif; ?>
		</div>
		<div class="portlet box yellow">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-user"></i>Groups User</div>
				<div class="actions"><?php 
				echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add New'), 
										array('action' => 'company_user', $parent), 
										array('class' => 'btn btn-default btn-sm', 'escape' => false));
				?></div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="users_index">
						<thead>
							<tr>
								<th> Name </th>
								<th> Email </th>
								<th> Role </th>
								<th class="actions"><?php echo __('Action'); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php
						if(isset($company_group['CompanyGroupsUser'])) {
							foreach ($company_group['CompanyGroupsUser'] as $user): ?>
							<tr>
								<td><?php echo h($user['User']['name']); ?></td>
								<td><?php echo h($user['User']['email']); ?></td>
								<td><?php echo $this->Form->input('role_id', array(
										'div' => false, 'label' => false, 'class' => 'form-control', 'value' => $user['role_id'], 'empty' => '--SELECT ROLE--',
										'data-save' => $this->Html->url(array('controller' => 'company_groups', 'action' => 'save', $user['id'])))); ?></td>
								<td class="actions">
	                            <?php if($actions['delete']) {
	                            	echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')),
	                            			array('action' => 'company_user_delete', $user['id'], 'admin' => true),
	                            			array('class' => 'btn default btn-xs grey user-delete', 'escape' => false));
								} ?>
								</td>
							</tr>
						<?php endforeach;
					} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
<script>
jQuery(document).ready(function() {
	Admin.SaveGroupUserRole();
}); 
</script>
<?php if(!$this->request->is('ajax')) { ?>
	</div>
</div>
<?php echo $this->Html->scriptBlock('var link = "' . $this->Html->url(array('controller' => 'company_groups'), true) . '";'); ?>
<script>
jQuery(document).ready(function() {
	Admin.contextualMenu(link);
}); 
</script>
<?php } ?>
