<?php 
echo $this->Html->css(array('../plugins/OrgChart/dist/css/jquery.orgchart'));
echo $this->Html->script(array('../plugins/OrgChart/dist/js/jquery.orgchart')); 
?>
<div id="chart-container"></div>
<?php 
$maps = array();
$maps = substr(json_encode($maps), 1, -1);
?>
<script type="text/javascript">
var data_map = <?php echo $maps; ?>;
jQuery(document).ready(function() {
	OrganizationMap.init(data_map);
});
</script>
