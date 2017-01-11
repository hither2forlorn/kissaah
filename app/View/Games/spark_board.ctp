<div class="col-md-8 col-md-offset-2 save-answer">
	<div class="row no-margin padding-bottom-20 padding-top-20">
		<h3 class="activitytitle">Catalyst Plans</h3>
		<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
			<div class="table-scrollable">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th colspan="3"><?php echo __('Development'); ?></th>
							<th colspan="3"><?php echo __('Exposure'); ?></th>
							<th colspan="3"><?php echo __('Connections'); ?></th>
							<th colspan="2"><?php echo __('Ally Feedback'); ?></th>
						</tr>
						<tr>
							<th><?php echo __('Development'); ?></th>
							<th><?php echo __('Due'); ?></th>
							<th><?php echo __('%'); ?></th>
							<th><?php echo __('Exposure'); ?></th>
							<th><?php echo __('Due'); ?></th>
							<th><?php echo __('%'); ?></th>
							<th><?php echo __('Connections'); ?></th>
							<th><?php echo __('Due'); ?></th>
							<th><?php echo __('%'); ?></th>
							<th><?php echo __('Rating'); ?></th>
							<th><?php echo __('Comments'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $spark_ans['Development']; ?></td>
							<td>2017-08-25</td>
							<td>10%</td>
							<td><?php echo $spark_ans['Exposure']; ?></td>
							<td>2017-08-25</td>
							<td>10%</td>
							<td><?php echo $spark_ans['Connections'] ?></td>
							<td>2017-04-25</td>
							<td>50%</td>
							<td>Mark</td>
							<td>Comments</td>
						</tr>
						
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
				<div class="col-md-3 col-sm-3 col-xs-12 btn-in-progress">Capture Learning</div>
				<div class="col-md-3 col-sm-3 col-xs-12 btn-in-progress">Add Date</div>
				<div class="col-md-3 col-sm-3 col-xs-12 btn-in-progress">Add Context</div>
			</div>
			<div class="row margin-bottom-15">
				<div class="col-md-3 col-sm-3 col-xs-12 padding-left-0">Relationship Building</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-right-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-right-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
			</div>
			<div class="row margin-bottom-15">
				<div class="col-md-3 col-sm-3 col-xs-12 padding-left-0">Creative</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-right-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-right-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
			</div>
			<div class="row margin-bottom-15">
				<div class="col-md-3 col-sm-3 col-xs-12 padding-left-0">Consciencious</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-right-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 padding-right-0">
					<input name="data[Challenge][complete_by]" class="form-control" placeholder="Complete by" type="text">
				</div>
			</div>
		</div>
	</div>
	<div class="row no-margin padding-bottom-20 margin-bottom-20">
		<div class="col-md-4 col-sm-4 col-xs-12 padding-0">
			Development <a href="#" class="add-more" data="data[Game][218][0]" data-add="218"><i class="fa fa-lg fa-plus-circle"></i></a>
			<input name="data[Challenge][complete_by]" class="form-control" placeholder="Development" type="text" value="<?php echo $spark_ans['Development']; ?>">
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 padding-right-0">
			Exposure <a href="#" class="add-more" data="data[Game][218][0]" data-add="218"><i class="fa fa-lg fa-plus-circle"></i></a>
			<input name="data[Challenge][complete_by]" class="form-control" placeholder="Exposure" type="text" value="<?php echo $spark_ans['Exposure']; ?>">
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 padding-right-0">
			Connections <a href="#" class="add-more" data="data[Game][218][0]" data-add="218"><i class="fa fa-lg fa-plus-circle"></i></a>
			<input name="data[Challenge][complete_by]" class="form-control" placeholder="Connections" type="text" value="<?php echo $spark_ans['Connections'] ?>">
		</div>
	</div>
</div>
