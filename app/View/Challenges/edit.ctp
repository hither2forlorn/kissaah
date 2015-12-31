<div class="challenges form">
<?php echo $this->Form->create('Challenge'); ?>
	<fieldset>
		<legend><?php echo __('Edit Challenge'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('user_game_status_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('created_on');
		echo $this->Form->input('finish_by');
		echo $this->Form->input('status');
		echo $this->Form->input('reject_reason');
		echo $this->Form->input('reject_comment');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Challenge.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Challenge.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Challenges'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Game Statuses'), array('controller' => 'user_game_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Game Status'), array('controller' => 'user_game_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Messages'), array('controller' => 'messages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Message'), array('controller' => 'messages', 'action' => 'add')); ?> </li>
	</ul>
</div>
