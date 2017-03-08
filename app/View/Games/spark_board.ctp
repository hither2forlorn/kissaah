<div class="col-md-8 col-md-offset-2">
	<div class="row no-margin padding-bottom-20 padding-top-20">
		<h3 class="activitytitle">Catalyst Plans</h3>
		<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
			<div class="table-scrollable">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Type</th>
							<th>Title</th>
							<th>Due</th>
							<th>%</th>
							<th>Ally</th>
							<th>Comments</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$sss = array();
					$count = 0;
					foreach($development as $key => $value) {
						$cnt = count($value['Challenge']['ChallengesUser']);
						
						if($cnt == 0) {
							$sss[$key][] = array($value['Game']['answer'], $value['Challenge']['complete_by'], '', '', '');
							$count++;
						} else {
							foreach($value['Challenge']['ChallengesUser'] as $k => $v) {
								$sss[$key][] = array($value['Game']['answer'], $value['Challenge']['complete_by'], '', $v['User']['name'], 'Comment');
								$count++;
							}
						}
					}
					
					foreach($sss as $key => $value) {
						foreach($value as $k => $v) {
							
						}
						
						//$table[] = array(array())
					}
					
					debug($sss);
					debug($count);
					
					$count = count($development);
					if($count == 0) {
						$table[] = array('Development', '', '', '', '', '');
						
					} else {
						foreach($development as $key => $value) {
							$ally_count = count($value['Challenge']['ChallengesUser']);
							
							if($ally_count == 0) {
							} elseif($ally_count == 1) {
								
							} else {
								$count += $ally_count;
							}
							
							if($key == 0) {
								$table[$key] = array(array('Development', array('rowspan' => $count)), 
												 array($value['Game']['answer'], array('rowspan' => $ally_count)), 
												 array($value['Challenge']['complete_by'], array('rowspan' => $ally_count)), 
												 array('10%', array('rowspan' => $ally_count)), '', '');
							
							} else {
								$table[$key] = array(array($value['Game']['answer'], array('rowspan' => $ally_count)), 
												 array($value['Challenge']['complete_by'], array('rowspan' => $ally_count)), 
												 array('10%', array('rowspan' => $ally_count)), '', '');
							}
							foreach($value['Challenge']['ChallengesUser'] as $k => $v) {
							}
						}
					}
					
					/*
					$count = count($exposure);
					if($count == 0) {
						$table[] = array('Exposure', '', '', '', '', '');
						
					} else {
						foreach($exposure as $key => $value) {
							if($key == 0) {
								$table[] = array(array('Exposure', array('rowspan' => $count)), $value['Game']['answer'], $value['Challenge']['complete_by'], '10%', 'Mark', 'Comment');
							
							} else {
								$table[] = array($value['Game']['answer'], '', '', '', '', '');
							}
						}
					}
					
					$count = count($connection);
					if($count == 0) {
						$table[] = array('Connections', '', '', '', '', '');
						
					} else {
						foreach($connection as $key => $value) {
							if($key == 0) {
								$table[] = array(array('Connections', array('rowspan' => $count)), $value['Game']['answer'], $value['Challenge']['complete_by'], '10%', 'Mark', 'Comment');
							
							} else {
								$table[] = array($value['Game']['answer'], '', '', '', '', '');
							}
						}
					}
					*/
					echo $this->Html->tableCells($table);
					debug($table);
					?> 
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row no-margin padding-bottom-20">
		<h3 class="activitytitle">My Next 3-12 months</h3>
		<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
			<div class="table-scrollable">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th></th>
							<th><div class="col-md-12 col-sm-12 col-xs-12 btn-in-progress">Learning</div></th>
							<th><div class="col-md-12 col-sm-12 col-xs-12 btn-in-progress">Date Added</div></th>
							<th><div class="col-md-12 col-sm-12 col-xs-12 btn-in-progress">Context</div></th>
						</tr>
					</thead>
					<tbody><?php 
					$table_prep = $table = array();
					foreach($next as $key => $value) {
						$table_prep[$value['Game']['answer']][] = array(
								$value['Challenge']['name'], $value['Challenge']['complete_by'], $value['Challenge']['description']);
					}
					
					foreach($table_prep as $key => $value) {
						$count = count($value);
						foreach($value as $k => $v) {
							if($k == 0) {
								$table[] = array(array($key, array('rowspan' => $count)), $v[0], $v[1], $v[2]);

							} else {
								$table[] = array($v[0], $v[1], $v[2]);
							
							}
						}
					}

					echo $this->Html->tableCells($table);
					?></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
