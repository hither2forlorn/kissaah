<?php
$parent = (!empty($this->request->pass))? $this->request->pass[0]: '';
if(!$this->request->isAjax) {
	/* BEGIN PAGE LEVEL PLUGINS */
	echo $this->Html->css(array('../plugins/jstree/dist/themes/default/style.min'), null, array('inline' => false));
	echo $this->Html->script(array('../plugins/jstree/dist/jstree.min'), array('inline' => false));
	/* END PAGE LEVEL PLUGINS */
}
?>
<?php if(!$this->request->isAjax) { ?>
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
				<div class="caption"><i class="fa fa-user"></i><?php echo empty($company_group['CompanyGroup']['parent']) ? __('Company') : __('Company Details'); ?></div>
				<div class="actions"><?php 
				if(isset($company_group) && !empty($company_group['CompanyGroup'])) {
					if($actions['edit']) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil')) . ' ' . __('Edit'), 
											array('action' => 'edit', $company_group['CompanyGroup']['id']), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					}
					if($actions['move_up']) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-up')) . ' ' . __('Move Up'), 
											array('action' => 'moveup', $company_group['CompanyGroup']['id'], 1), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					}
					if($actions['move_down']) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-down')) . ' ' . __('Move Down'), 
											array('action' => 'movedown', $company_group['CompanyGroup']['id'], 1), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					}
					if($actions['delete']) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash')) . ' ' . __('Delete'), 
											array('action' => 'delete', $company_group['CompanyGroup']['id']), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					}
				}
				if($actions['new']) {
				echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add New'), 
										array('action' => 'add', $parent), 
										array('class' => 'btn btn-default btn-sm', 'escape' => false));
				}

				?></div>
			</div>
			<?php if(isset($company_group) && !empty($company_group['CompanyGroup'])): ?>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="CompanyGroupes_view">
					<tbody>
						<tr>
							<td><?php echo __('Company Id:'); ?></td>
							<td><?php echo h($company_group['CompanyGroup']['id']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Company Name:'); ?></td>
							<td><?php echo h($company_group['CompanyGroup']['title']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Company Manager:'); ?></td>
							<td><?php echo h($company_group['Admin']['name']); ?>&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo __('Parent'); ?></td>
							<td><?php echo h($company_group['CompanyGroup']['parent']); ?>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php endif; ?>
		</div>
            <div class="portlet box red">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-user"></i><?php echo empty($company_group['CompanyGroup']['parent']) ? __('Company') : __('Company Users List'); ?></div>
				<div class="actions"><?php 
				if(isset($company_group) && !empty($company_group['CompanyGroup'])) {
					if($actions['edit']) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil')) . ' ' . __('Edit'), 
											array('action' => 'edit', $company_group['CompanyGroup']['id']), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					}
					if($actions['move_up']) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-up')) . ' ' . __('Move Up'), 
											array('action' => 'moveup', $company_group['CompanyGroup']['id'], 1), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					}
					if($actions['move_down']) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-down')) . ' ' . __('Move Down'), 
											array('action' => 'movedown', $company_group['CompanyGroup']['id'], 1), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					}
					if($actions['delete']) {
					echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash')) . ' ' . __('Delete'), 
											array('action' => 'delete', $company_group['CompanyGroup']['id']), 
											array('class' => 'btn btn-default btn-sm', 'escape' => false));
					echo '&nbsp;';
					}
				}
				if($actions['new']) {
				echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add New'), 
										array('action' => 'add', $parent), 
										array('class' => 'btn btn-default btn-sm', 'escape' => false));
				}

				?></div>
			</div>
			<?php //debug ($company_group_users); ?>
                        <?php if(isset($company_group_users) && !empty($company_group_users)): ?>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="CompanyGroupes_view">
					<tbody>
						<tr>
                                                    <td><b><?php echo __('User Id'); ?></b></td>
                                                     <td><b><?php echo __('User Name'); ?></b></td>
                                                     <td><b><?php echo __('User Email'); ?></b></td>
                                                     <td><b><?php echo __('Company Name'); ?></b></td>
                                                    <td><b><?php echo __('Line Manage'); ?></b></td>
						</tr>
                                                 <?php //debug ($company_group_users); ?>

                                                <?php  foreach($company_group_users as $company_group_user) { ?>
						<tr>
							<td><?php echo h($company_group_user['User']['id']); ?>&nbsp;</td>
							<td><?php echo h($company_group_user['User']['name']); ?>&nbsp;</td>
							<td><?php echo h($company_group_user['User']['email']); ?>&nbsp;</td>
							<td><?php echo h($company_group['CompanyGroup']['title']); ?>&nbsp;</td>
                                                        <td><?php echo h($company_group['Admin']['name']); ?>&nbsp;</td>
						</tr>
                                                 <?php } ?>
					</tbody>
				</table>
			</div>
			<?php endif; ?>
		</div>
            
<?php if(!$this->request->isAjax) { ?>
	</div>
</div>
<?php echo $this->Html->scriptBlock('var link = "' . $this->Html->url(array('controller' => 'company_groups'), true) . '";'); ?>
<script>
jQuery(document).ready(function() {
	Admin.contextualMenu(link);
}); 
</script>
<?php } ?>
