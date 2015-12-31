<?php $paid = $this->requestAction(array('controller' => 'transactions', 'action' => 'payment_pending')); ?>
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Pending Invoices
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
                    <th> Invoiced Amount </th>
                    <th> Paid Up Amount </th>
                    <th> Difference </th>
                </tr>
            </thead>
            <tbody>
            <?php
            $invoice_balance = 0;
			$paid_balance = 0;
            $open_account_balance = 0;
            $close_account_balance = 0;
            foreach($paid as $account):
				
				$invoice_balance += $account['VwAccountsTransaction']['invoiced'];
				$paid_balance	 += $account['VwAccountsTransaction']['received'];
                if($account['VwAccountsTransaction']['closed']) {
                    $close_account_balance += ($account['VwAccountsTransaction']['invoiced'] - $account['VwAccountsTransaction']['received']);
                } else {
                    $open_account_balance += ($account['VwAccountsTransaction']['invoiced'] - $account['VwAccountsTransaction']['received']);
                }
            ?>
                <tr>
                    <td> <?php 
                    echo $this->Html->link(h($account['VwAccountsTransaction']['name']), 
                                               array('controller' => 'accounts', 'action' => 'view', $account['VwAccountsTransaction']['id']));
                    ?>&nbsp; </td>
                    <td class="amount">Rs. <?php echo number_format($account['VwAccountsTransaction']['invoiced'], 2) ?> </td>
                    <td class="amount">Rs. <?php echo number_format($account['VwAccountsTransaction']['received'], 2) ?> </td>
                    <td class="amount">Rs. <?php echo number_format($account['VwAccountsTransaction']['difference'], 2) ?> </td>
                </tr>
			<?php
			endforeach ?>
                <tr>
                    <td> Open Account Balance:</td>
                    <td class="amount">Rs. <?php echo number_format($invoice_balance, 2) ?> </td>
                    <td class="amount">Rs. <?php echo number_format($paid_balance, 2) ?> </td>
                    <td class="amount">Rs. <?php echo number_format($open_account_balance, 2) ?> </td>
                </tr>
                <tr>
                    <td colspan="3"> Closed Account Balance:</td>
                    <td class="amount">Rs. <?php echo number_format($close_account_balance, 2) ?> </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
