<?php
	echo $this->Html->div('row no-margin margin-top-10', 
			$this->Html->div('col-md-12 col-sm-12',
				$this->Html->div('', '', array('id' => 'calendar'))));
?>
<script>
$(document).ready(function(){
	Challenges.Calendar();
});
</script>