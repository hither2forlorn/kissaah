<?php $renewal = $this->requestAction(array('controller' => 'accounts', 'action' => 'renewal')); ?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Renewal List
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"> </a>
			<a class="config" data-toggle="modal" href="#portlet-config"> </a>
			<a class="reload" href="javascript:;"> </a>
			<a class="remove" href="javascript:;"> </a>
		</div>
	</div>
	<div class="portlet-body">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th> Name </th>
					<th> Renewal Date </th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($renewal as $account):
                    $label = ($account['Account']['renewal_date'] > date("Y-m-d"))? "label-success": "label-danger"; 
			?>
				<tr>
					<td> <?php 
                    echo $this->Html-> link(h($account['Account']['name']), 
                                               array('controller' => 'accounts', 'action' => 'view', $account['Account']['id']));
                    ?>&nbsp; </td>
					<td><span class="label <?php echo $label ?>"> <?php echo $account['Account']['renewal_date'] ?> </span></td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
