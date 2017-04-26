<div class="row users index">
	<div class="col-md-12 col-sm-12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-user"></i><?php echo __('Users List : '); ?></div>
				<?php if($this->Session->read('Auth.User.role_id') == 1) { ?>
				<div class="actions">
					<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add User'), 
													array('action' => 'add'), array('class' => 'btn btn-default btn-sm', 'escape' => false));
					
					
					echo $this->Form->create('User', array('class' => 'btn-file fileupload margin-top-10', 'type' => 'file'));
					echo $this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o', 'id' => 'upl' . $this->Session->read('Auth.User.id')));
					echo $this->Form->input('bulk_file', array(
							'type' => 'file', 'label' => false, 'class' => 'default', 'div' => false));
					echo $this->Form->end();
					?>					
				</div>
				<?php } ?>
			</div>
			<div class="portlet-body user-list">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="users_index">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Password</th>
							</tr>
						</thead>
						<tbody><?php 
						if (isset($filename) && ($handle = fopen('files/users/' . $filename, 'r')) !== FALSE) {
							while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
								echo '<tr>';
								foreach($data as $d) {
									echo '<td>' . $d . '</td>';
								}
								echo '</tr>';
							}
							fclose($handle);
						} elseif(isset($faild)) {
							foreach($faild as $fail) {
								echo '<tr>';
								foreach($fail as $d) {
									echo '<td>' . $d . '</td>';
								}
								echo '</tr>';
							}
						}
						?></tbody>
					</table>
					<div class="row no-margin">
						<div class="pull-right"><?php
						if (isset($filename)) {
							echo $this->Html->link('Submit',
									array('controller' => 'users', 'action' => 'bulk_upload', $filename),
									array('class' => 'btn blue', 'escape' => false));
						}
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function() {
	$('.fileupload').change(function(ev) {
		$('#UserAdminBulkUploadForm').submit();
	}); 
}); 
</script>