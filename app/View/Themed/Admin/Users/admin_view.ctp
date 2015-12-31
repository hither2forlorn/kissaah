<?php if(!$this->request->params['isAjax']) { ?>
<div class="row users index">
	<div class="col-md-12 col-sm-12">
		<div class="portlet box yellow">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-user"></i><?php echo __('Users'); ?></div>
				<div class="actions">
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add User'), 
										array('action' => 'add'), 
										array('class' => 'btn btn-default btn-sm', 'escape' => false));?>					
				<?php echo $this->Form->input('SearchText', array('div' => false, 'label' => false, 'class' => 'form-control in-line',  
													'type' => 'text', 'placeholder' => 'Search For Users',
													'data-link' => $this->Html->url(array('action' => 'view', 'admin' => true)))); ?>
				</div>
			</div>
			<div class="portlet-body user-list">
<?php } ?>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="users_index">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('id'); ?></th>
								<th><?php echo $this->Paginator->sort('name'); ?></th>
								<th><?php echo $this->Paginator->sort('email'); ?></th>
								<th><?php echo $this->Paginator->sort('company', 'Code'); ?></th>
								<th><?php echo $this->Paginator->sort('city'); ?></th>
								<th><?php echo $this->Paginator->sort('country'); ?></th>
								<th><?php echo $this->Paginator->sort('gender'); ?></th>
								<th><?php echo $this->Paginator->sort('dob'); ?></th>
								<th><?php echo __('Answers', true);?></th>
								<th><?php echo $this->Paginator->sort('User.created', 'Signed Up'); ?></th>
								<th><?php echo $this->Paginator->sort('User.last_login', 'Last Seen'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($userlist as $user): ?>
							<tr>
								<td><?php echo h($user['User']['id']); ?></td>
								<td><?php echo h($user['User']['name']); ?></td>
								<td><?php echo h($user['User']['email']); ?></td>
								<td><?php echo h($user['User']['company']); ?></td>
								<td><?php echo h($user['User']['city']); ?></td>
								<td><?php echo h($user['User']['country']); ?></td>
								<td><?php echo h($user['User']['gender']); ?></td>
								<td><?php echo h($user['User']['dob']); ?></td>
								<td><?php echo $user['User']['UserGameStatus'] . ' - ' . $user['User']['Game'] . ' - ' . $user['User']['Files'];?></td>
								<td><?php echo date('Y-m-d', strtotime($user['User']['created'])); ?></td>
								<td><?php echo $user['User']['last_login'];?></td>
								<td class="actions">
	                            <?php echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-share')), 
	                                                             array('action' => 'login', $user['User']['id'], 'admin' => true), 
	                                                             array('class' => 'btn default btn-xs green', 'escape' => false, 'target' => '_blank')); ?>
	                            
	                            <?php echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), 
	                                                             array('action' => 'detail', $user['User']['id'], 'admin' => true), 
	                                                             array('class' => 'btn default btn-xs green', 'escape' => false, 'target' => '_blank')); ?>
	                            
	                            <?php echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')), 
	                                                             array('action' => 'delete', $user['User']['id'], 'admin' => true), 
	                                                             array('class' => 'btn default btn-xs grey user-delete', 'escape' => false)); ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-5 col-sm-12">
						<div class="dataTables_info"><?php
						echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, 
																			starting on record {:start}, ending on {:end}')));
						?></div>
					</div>
					<div class="col-md-7 col-sm-12">
						<div class="dataTables_paginate paging_bootstrap_full_number">
			                <ul class="pagination"><?php
		                    echo $this -> Paginator -> prev(
		                                $this->Html->tag('i', '', array('class' => 'fa fa-angle-left')), 
		                                array('escape' => false, 'tag' => 'li'), 
		                                $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-angle-left')), '#', array('escape' => false)), 
		                                array('class' => 'prev disabled', 'escape' => false, 'tag' => 'li'));
		                                
		                    echo $this -> Paginator -> numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a'));
		                    
		                    echo $this -> Paginator -> next(
		                                $this->Html->tag('i', '', array('class' => 'fa fa-angle-right')), 
		                                array('escape' => false, 'tag' => 'li'), 
		                                $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-angle-right')), '#', array('escape' => false)), 
		                                array('class' => 'prev disabled', 'escape' => false, 'tag' => 'li'));
		                    ?></ul>
						</div>
					</div>
				</div>
<?php if(!$this->request->params['isAjax']) { ?>
			</div>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function() {
	Admin.SearchUser();
}); 
</script>
<?php } ?>