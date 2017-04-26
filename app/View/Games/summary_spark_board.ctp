<?php 
foreach($development as $key => $value) {
	if(!is_null($value['Challenge']['name'])) {
		$test[$value['User']['id']]['name'] = $value['User']['name'];
		//$test[$value['User']['id']]['d'][] = array($value['Challenge']['name'], $value['Challenge']['complete_by'], '10%');
		$test[$value['User']['id']]['d'][] = array($value['Challenge']['name'], $value['Challenge']['complete_by']);
	}
}
foreach($exposure as $key => $value) {
	if(!is_null($value['Challenge']['name'])) {
		$test[$value['User']['id']]['name'] = $value['User']['name'];
		//$test[$value['User']['id']]['e'][] = array($value['Challenge']['name'], $value['Challenge']['complete_by'], '10%');
		$test[$value['User']['id']]['e'][] = array($value['Challenge']['name'], $value['Challenge']['complete_by']);
	}
}
foreach($connection as $key => $value) {
	if(!is_null($value['Challenge']['name'])) {
		$test[$value['User']['id']]['name'] = $value['User']['name'];
		//$test[$value['User']['id']]['c'][] = array($value['Challenge']['name'], $value['Challenge']['complete_by'], '10%');
		$test[$value['User']['id']]['c'][] = array($value['Challenge']['name'], $value['Challenge']['complete_by']);
	}
}

foreach($test as $key => $value) {
	$row_count = max(count($value['d']), count($value['e']), count($value['c']));
	for($i = 0; $i < $row_count; $i++) {
		$row = array();
		if(isset($value['d'][$i])) {
			$row = array_merge($row, $value['d'][$i]);
		} else {
			$row = array_merge($row, array('', '', ''));
		}
		if(isset($value['e'][$i])) {
			$row = array_merge($row, $value['e'][$i]);
		} else {
			$row = array_merge($row, array('', '', ''));
		}
		if(isset($value['c'][$i])) {
			$row = array_merge($row, $value['c'][$i]);
		} else {
			$row = array_merge($row, array('', '', ''));
		}
		if($i == 0) {
			$table[] = array_merge(array(array($value['name'], array('rowspan' => $row_count))), $row, array('', ''));
		} else {
			$table[] = array_merge($row, array('', ''));
		}
	}
}
?>
<div class="col-md-12">
	<div class="row no-margin padding-top-20">
		<div class="col-md-2 col-sm-2 no-padding">
			<h3 class="activitytitle">Sort by:</h3>
		</div>
		<div class="col-md-10 col-sm-10 padding-right-0">
			<h3 class="activitytitle">Summary of Individual Catalyst Plans</h3>
			<div class="table-scrollable">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th colspan="2">Development</th>
							<th colspan="2">Exposure</th>
							<th colspan="2">Connections</th>
							<th colspan="2">Ally Feedback</th>
						</tr>
						<tr>
							<th></th>
							<th>Development</th>
							<th>Due</th>
							<!-- <th>%</th> -->
							<th>Exposure</th>
							<th>Due</th>
							<!-- <th>%</th> -->
							<th>Connections</th>
							<th>Due</th>
							<!-- <th>%</th> -->
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
		<div class="col-md-4 col-sm-4 no-padding">
			<h3 class="activitytitle">Signature Strengths</h3>
			<div class="table-bordered"><?php 
			foreach($give_strength as $value) {
				echo $this->Html->para('', $value['Game']['answer']);
			}
			?></div>
		</div>
		<div class="col-md-4 col-sm-4 padding-right-0">
			<h3 class="activitytitle">Work Joy</h3>
			<div class="table-bordered pull-left padding-top-10 padding-bottom-10"><?php
			foreach($purpose as $value) {
				$answer = '/files/img/medium/' . $value['Game']['answer'];
				$link = '/files/img/large/' . $value['Game']['answer'];
				echo $this->Html->link($this->Html->image($answer, array('class' => 'img-responsive')), 
						$answer, array('escape' => false, 'data-fancybox' => 'images', 'class' => 'col-md-3'));
			}
			?></div>
		</div>
		<div class="col-md-4 col-sm-4 padding-right-0">
			<h3 class="activitytitle">Superhero/Role model</h3>
			<div class="table-bordered pull-left padding-top-10 padding-bottom-10"><?php
			foreach($aspiration as $value) {
				$answer = '/files/img/medium/' . $value['Game']['answer'];
				$link = '/files/img/large/' . $value['Game']['answer'];
				echo $this->Html->link($this->Html->image($answer, array('class' => 'img-responsive')), 
						$answer, array('escape' => false, 'data-fancybox' => 'images', 'class' => 'col-md-3'));
			}
			?></div>
		</div>
	</div>
	<div class="row no-margin padding-bottom-20 margin-bottom-20">
		<div class="col-md-4 col-sm-6 no-padding">
			<h3 class="activitytitle">Aspirational Strengths</h3>
			<div class="table-bordered"><?php 
			foreach($ask_strength as $value) {
				echo $this->Html->para('', $value['Game']['answer']);
			}
			?></div>
		</div>
		<div class="col-md-8 col-sm-6 padding-right-0">
			<h3 class="activitytitle">Future Map 3-12 Months</h3>
			<div class="table-bordered"><?php 
			foreach($motivation[0] as $value) {
				echo $this->Html->para('', $value['Game']['answer']);
			}
			foreach($motivation[1] as $value) {
				echo $this->Html->para('', $value['Game']['answer']);
			}
			?></div>
		</div>
	</div>
</div>
