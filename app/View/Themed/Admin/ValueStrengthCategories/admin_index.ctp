<div class="row valueStrengthCategories index">
	<div class="col-md-12 col-sm-12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-user"></i><?php echo __('Value Strength Categories'); ?>
				</div>
				<div class="actions">
					<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add Value Strength Categories'), 
												 array('action' => 'add'), array('class' => 'btn btn-default btn-sm', 'escape' => false)); ?>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="ValueStrengthCategorys_index">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('id'); ?></th>
								<th><?php echo $this->Paginator->sort('title'); ?></th>
								<th><?php echo $this->Paginator->sort('active'); ?></th>
								<th><?php echo $this->Paginator->sort('type'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($valueStrengthCategories as $valueStrengthCategory): ?>
							<tr>
								<td><?php echo h($valueStrengthCategory['ValueStrengthCategory']['id']); ?></td>
								<td><?php echo h($valueStrengthCategory['ValueStrengthCategory']['title']); ?></td>
								<td><?php echo ($valueStrengthCategory['ValueStrengthCategory']['active'])? 'Active':'Inactive'; ?></td>
								<td><?php echo h($valueStrengthCategory['ValueStrengthCategory']['type']); ?></td>
								<td class="actions">
									<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')) . ' ' . __('Edit'), 
																 array('action' => 'edit', $valueStrengthCategory['ValueStrengthCategory']['id']), 
																 array('class' => 'btn default btn-xs blue', 'escape' => false)); ?>
									<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')) . ' ' . __('Delete'), 
																	 array('action' => 'delete', $valueStrengthCategory['ValueStrengthCategory']['id']), 
																	 array('class' => 'btn default btn-xs grey', 'escape' => false), 
																	 __('Are you sure you want to delete # %s?', $valueStrengthCategory['ValueStrengthCategory']['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-5 col-sm-12">
						<div class="dataTables_info"><?php
						echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
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
			</div>
		</div>
	</div>
</div>