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
					$count = count($development);
					if($count == 0) {
						$table[] = array('Development', '', 'Due', '10%', 'Mark', 'Comment');
						
					} else {
						foreach($development as $key => $value) {
							if($key == 0) {
								//debug($this->requestAction(array('controller' => 'challenges', 'action' => 'get_challenge_user', $value['Game']['id'])));
								$table[] = array(array('Development', array('rowspan' => $count)), $value['Game']['answer'], 'Due', '10%', 'Mark', 'Comment');
							
							} else {
								$table[] = array($value['Game']['answer'], 'Due', '10%', 'Mark', 'Comment');
							}
						}
					}

					$count = count($exposure);
					if($count == 0) {
						$table[] = array('Exposure', '', 'Due', '10%', 'Mark', 'Comment');
						
					} else {
						foreach($exposure as $key => $value) {
							if($key == 0) {
								$table[] = array(array('Exposure', array('rowspan' => $count)), $value['Game']['answer'], 'Due', '10%', 'Mark', 'Comment');
							
							} else {
								$table[] = array($value['Game']['answer'], 'Due', '10%', 'Mark', 'Comment');
							}
						}
					}
					
					$count = count($connection);
					if($count == 0) {
						$table[] = array('Connections', '', 'Due', '10%', 'Mark', 'Comment');
						
					} else {
						foreach($connection as $key => $value) {
							if($key == 0) {
								$table[] = array(array('Connections', array('rowspan' => $count)), $value['Game']['answer'], 'Due', '10%', 'Mark', 'Comment');
							
							} else {
								$table[] = array($value['Game']['answer'], 'Due', '10%', 'Mark', 'Comment');
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
					<tbody>
					<?php 
					$table = array();
					foreach($next as $key => $value) {
						$count = count($value['Challenge']);
						if($count == 0) {
							$table[] = array($value['Game']['answer'], '', '', '');

						} else {

							foreach($value['Challenge'] as $k => $v) {
								if($k == 0) {
									$table[] = array(array($value['Game']['answer'], array('rowspan' => $count)), 
													 $v['name'], $v['complete_by'], $v['description']);
								} else {
									$table[] = array($v['name'], $v['complete_by'], $v['description']);
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
</div>
