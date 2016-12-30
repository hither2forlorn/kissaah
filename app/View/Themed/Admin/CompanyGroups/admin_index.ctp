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
				<div class="caption"><i class="fa fa-user"></i><?php echo empty($company_group['CompanyGroup']['parent']) ? __('Company') : __('Group'); ?></div>
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
                                                    <td><b><?php echo __('Company ID'); ?></b></td>
							<td><?php echo h($company_group['CompanyGroup']['id']); ?>&nbsp;</td>
						</tr>
						<tr>
                                                    <td><b><?php echo __('Company Name'); ?></b></td>
							<td><?php echo h($company_group['CompanyGroup']['title']); ?>&nbsp;</td>
						</tr>
						<tr>
                                                    <td><b><?php echo __('Admin'); ?></b></td>
							<td><?php echo h($company_group['Admin']['name']); ?>&nbsp;</td>
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
           <div class="portlet box green">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-user"></i><?php echo empty($company_group['CompanyGroup']['parent']) ? __('Company') : __('Group'); ?></div>
				<div class="actions"><?php 
				if(isset($company_group) && !empty($company_group['CompanyGroup'])) {
					
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
					
				}
				

				?></div>
			</div>
			</div>
			<?php //debug ($company_group_users); ?>
                        <?php if(isset($company_group_users) && !empty($company_group_users)): ?>
			<div class="portlet-body user-list">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="users_index">
				
					<thead>
						<tr>
                                                    <th><b><?php echo __('User Id'); ?></b></th>
                                                     <th><b><?php echo __('User Name'); ?></b></th>
                                                     <th><b><?php echo __('User Email'); ?></b></th>
                                                     <th><b><?php echo __('Company Name'); ?></b></th>
                                                    <th><b><?php echo __('Line Manage'); ?></b></th>
                                                    <th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
                                        </thead>
                                                 <?php //debug ($company_group_users); ?>
                                        <tbody>
                                                <?php  foreach($company_group_users as $company_group_user) { ?>
						<tr>
							<td><?php echo h($company_group_user['User']['id']); ?>&nbsp;</td>
							<td><?php echo h($company_group_user['User']['name']); ?>&nbsp;</td>
							<td><?php echo h($company_group_user['User']['email']); ?>&nbsp;</td>
							<td><?php echo h($company_group['CompanyGroup']['title']); ?>&nbsp;</td>
                                                        <td><?php echo h($company_group['Admin']['name']); ?>&nbsp;</td>
                                                        
                                                     <td class="actions">
                                                          
	                            <?php if($actions['edit']) {
	                            	echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-pencil')) . ' ' . __('Edit'), 
	                                                             array('controller'=>'CompanyGroups', 'action' => 'admin_usere',  $company_group_user['User']['id'], 'admin' => true), 
	                                                             array('class' => 'btn default btn-xs blue', 'escape' => false, 'target' => '_blank')); 
								} ?>
                                                       
	                            <?php if($actions['delete']) {
	                            	echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')), 
	                                                             array('controller'=>'CompanyGroups', 'action' => 'delete', $company_group_user['User']['id'], 'admin' => true), 
	                                                             array('class' => 'btn default btn-xs grey user-delete', 'escape' => false));
								} ?>
	                            
								</td>
                                                                <?php } ?>
							</tr>
                                                
					</tbody>
				</table>
                            </div>
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
