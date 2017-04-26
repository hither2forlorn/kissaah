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
							<!-- <th>%</th> -->
							<th>Ally</th>
							<!-- <th>Comments</th> -->
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($spark as $name => $type) {
						$count = count($type);
						$row = 0;
						if($count == 0) {
							$table[] = array($name, '', '', ''); //array($name, '', '', '', '', '');
							
						} else {
							foreach($type as $key => $value) {
								if(isset($value['Challenge']['ChallengesUser'])) {
									$ally_count = count($value['Challenge']['ChallengesUser']);
								} else {
									$ally_count = 1;
								}
								
								if($ally_count == 0) 	$ally_count = 1;
								else 					$count += $ally_count;
								
								if($key == 0) {
									$table[] = array(
											array($name, array('rowspan' => 1)),
											array($value['Game']['answer'], array('rowspan' => $ally_count)),
											array($value['Challenge']['complete_by'], array('rowspan' => $ally_count)),
											//array('10%', array('rowspan' => $ally_count)), 
											//'', 
											'');
									$row = count($table) - 1;
		
								} else {
									$table[$row][0][1]['rowspan'] = $table[$row][0][1]['rowspan'] + 1;
									$table[] = array(
											array($value['Game']['answer'], array('rowspan' => $ally_count)),
											array($value['Challenge']['complete_by'], array('rowspan' => $ally_count)),
											//array('10%', array('rowspan' => $ally_count)), 
											//'', 
											'');
								}
								
								if(isset($value['Challenge']['ChallengesUser'])) {
									$last_count = count($table) - 1;
									foreach($value['Challenge']['ChallengesUser'] as $k => $v) {
										if($k == 0) {
											$table[$last_count][count($table[$last_count]) - 1] = $v['User']['name'];
											//$table[$last_count][count($table[$last_count]) - 2] = $v['User']['name'];
											
										} else {
											$table[$row][0][1]['rowspan'] = $table[$row][0][1]['rowspan'] + 1;
											$table[] = array($v['User']['name']); //array($v['User']['name'], '');
											
										}
									}
								}
							}
						}
					}

					echo $this->Html->tableCells($table);
					?> 
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row no-margin padding-bottom-20">
		<h3 class="activitytitle">My Learning Log</h3>
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
