<?php
	$spider_data = $this->requestAction(array('controller' => 'games', 'action' => 'graph_data'));
?>
<div class="active-image-spider"></div>
<script>
$(document).ready(function(){
	spider_data = <?php echo $spider_data ?>;
	Game.DrawSpider(spider_data, "active-image-spider");
});
	
$(window).bind('load', function() {
	Game.DrawSpider(spider_data, "active-image-spider");
});
</script>
