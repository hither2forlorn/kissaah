<div class="game-header row">
	<div class="col-md-12 col-xm-12">
		<?php echo $this->Html->tag('h3', 'Welcome to Kissaah', array('class' => 'activitytitle')); ?>
	</div>
</div>
<div class="no-margin row">
	<div class="col-md-12 col-sm-12">
		<?php echo $this->requestAction(array('controller' => 'posts', 'action' => 'page_content', $id)); ?>
	</div>
	<?php
	echo $this->Html->div('col-md-12 col-xm-12',  
		$this->Html->link('Continue', '#', array('class' => 'btn btn-primary collapsed game-posts', 'id' => $id)));
	?>
</div>

<script type = "text/javascript">
$(document).ready(function() {
	Game.GamePosts();
});
</script>