<?php
echo $this->Html->div('row no-margin margin-top-10 data-width-600', 
		$this->Html->div('col-md-12 col-sm-12',
			$this->Html->div('', '', array(
					'id' => 'calendar', 'data-url' => $this->Html->url(array('controller' => 'challenges', 'action' => 'calendar'))))));
?>
<script>
$(document).ready(function() {
	Challenges.Calendar($('#calendar').attr('data-url'));
});
</script>