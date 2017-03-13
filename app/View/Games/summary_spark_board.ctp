<?php 
foreach($development as $key => $value) {
	$data[$value['User']['id']][$key][0]  = $value['User']['name'];
	$data[$value['User']['id']][$key][1]  = $value['Challenge']['name'];
	$data[$value['User']['id']][$key][2]  = $value['Challenge']['complete_by'];
	$data[$value['User']['id']][$key][3]  = '10%';
}
foreach($exposure as $key => $value) {
	$data[$value['User']['id']][$key][0] = $value['User']['name'];
	$data[$value['User']['id']][$key][4] = $value['Challenge']['name'];
	$data[$value['User']['id']][$key][5] = $value['Challenge']['complete_by'];
	$data[$value['User']['id']][$key][6] = '10%';
}
foreach($connection as $key => $value) {
	$data[$value['User']['id']][$key][0] = $value['User']['name'];
	$data[$value['User']['id']][$key][7] = $value['Challenge']['name'];
	$data[$value['User']['id']][$key][8] = $value['Challenge']['complete_by'];
	$data[$value['User']['id']][$key][9] = '10%';
}

foreach($data as $key => $value) {
	foreach($value as $k => $v) {
		if($k == 0) {
			$table[] = array(array($v[0], array('rowspan' => count($value))), $v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], '', '');
		} else {
			$table[] = array($v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], '', '');
		}
	}
}
?>
<div class="col-md-12">
	<div class="row no-margin padding-top-20">
		<div class="col-md-2 col-sm-2">
			<h3 class="activitytitle">Sort by:</h3>
		</div>
		<div class="col-md-10 col-sm-10">
			<h3 class="activitytitle">Summary of individual Catalyst Plans</h3>
			<div class="table-scrollable">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th colspan="3">Development</th>
							<th colspan="3">Exposure</th>
							<th colspan="3">Connections</th>
							<th colspan="2">Ally Feedback</th>
						</tr>
						<tr>
							<th></th>
							<th>Development</th>
							<th>Due</th>
							<th>%</th>
							<th>Exposure</th>
							<th>Due</th>
							<th>%</th>
							<th>Connections</th>
							<th>Due</th>
							<th>%</th>
							<th>Rating</th>
							<th>Comments</th>
						</tr>
					</thead>
					<tbody><?php echo $this->Html->tableCells($table); ?></tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row no-margin padding-bottom-20">
		<div class="col-md-2 col-sm-2">
			<h3 class="activitytitle">#Give</h3>
			<div class="table-bordered"></div>
		</div>
		<div class="col-md-5 col-sm-5">
			<h3 class="activitytitle">Purpose</h3>
			<div class="table-bordered"></div>
		</div>
		<div class="col-md-5 col-sm-5">
			<h3 class="activitytitle">Aspirations</h3>
			<div class="table-bordered"></div>
		</div>
	</div>
	<div class="row no-margin padding-bottom-20 margin-bottom-20">
		<div class="col-md-2 col-sm-2">
			<h3 class="activitytitle">#Ask</h3>
			<div class="table-bordered"></div>
		</div>
		<div class="col-md-10 col-sm-10">
			<h3 class="activitytitle">Motivation</h3>
			<div class="table-bordered"></div>
		</div>
	</div>
</div>
<?php debug($development); ?>