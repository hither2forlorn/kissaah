<div class="col-md-8 col-md-offset-2 save-answer">
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
		<div class="col-md-12 col-sm-12">
			<div class="row margin-bottom-15">
				<div class="col-md-3 col-sm-3 col-xs-12"></div>
				<div class="col-md-3 col-sm-3 col-xs-12 btn-in-progress">Learning</div>
				<div class="col-md-3 col-sm-3 col-xs-12 btn-in-progress">Date Added</div>
				<div class="col-md-3 col-sm-3 col-xs-12 btn-in-progress">Context</div>
			</div>
			<?php 
			foreach($next as $key => $value) {
				$text  = $this->Html->div('col-md-3 col-sm-3 col-xs-12 padding-left-0', $value['Game']['answer']);
				$text .= $this->Html->div('col-md-3 col-sm-3 col-xs-12 padding-0', 
						$this->Form->input('Challenge.title', array('class' => 'form-control', 'placeholder' => '', 'div' => false, 'label' => false)));
				$text .= $this->Html->div('col-md-3 col-sm-3 col-xs-12 padding-0', 
						$this->Form->input('Challenge.title', array('class' => 'form-control', 'placeholder' => '', 'div' => false, 'label' => false)));
				$text .= $this->Html->div('col-md-3 col-sm-3 col-xs-12 padding-0', 
						$this->Form->input('Challenge.title', array('class' => 'form-control', 'placeholder' => '', 'div' => false, 'label' => false)));
				
				echo $this->Html->div('row margin-bottom-15', $text);
			}
			?>
		</div>
	</div>
	<div class="row no-margin padding-bottom-20 margin-bottom-20">
		<div class="col-md-4 col-sm-4 col-xs-12 padding-0">
			Development <a href="#" class="add-more" data="data[Game][218][0]" data-add="218"><i class="fa fa-lg fa-plus-circle"></i></a>
			<input name="data[Challenge][complete_by]" class="form-control" placeholder="Development" type="text">
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 padding-right-0">
			Exposure <a href="#" class="add-more" data="data[Game][218][0]" data-add="218"><i class="fa fa-lg fa-plus-circle"></i></a>
			<input name="data[Challenge][complete_by]" class="form-control" placeholder="Exposure" type="text">
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 padding-right-0">
			Connections <a href="#" class="add-more" data="data[Game][218][0]" data-add="218"><i class="fa fa-lg fa-plus-circle"></i></a>
			<input name="data[Challenge][complete_by]" class="form-control" placeholder="Connections" type="text">
		</div>
	</div>
</div>