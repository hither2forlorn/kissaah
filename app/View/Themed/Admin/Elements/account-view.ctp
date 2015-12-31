<div class="col-md-12">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bell-o"></i>Order List
                <?php echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add'), 
                                                 array('controller' => 'orders', 'action' => 'save', $this->request->params['pass'][0], $start_date, $end_date), 
                                                 array('class' => 'btn btn-xs blue add-transaction fancybox fancybox.ajax', 'escape' => false)); ?>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                        <tr>
                            <th><?php echo __('#'); ?></th>
                            <th><?php echo __('Order Date'); ?></th>
                            <th><?php echo __('Product'); ?></th>
                            <th><?php echo __('Status'); ?></th>
                            <th><?php echo __('MRP'); ?></th>
                            <th><?php echo __('Referer Fee'); ?></th>
                            <th><?php echo __('Delivery Fee'); ?></th>
                            <th><?php echo __('Balance'); ?></th>
                            <th class="col-md-1"><?php echo __('Note'); ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $mrp = $referrer_fee = $delivery_fee = $balance = 0;

                        if(isset($orders)) :
                            foreach ($orders as $sale):
                                $mrp 			+= $sale['Order']['mrp'];
                                $referrer_fee 	+= $sale['Order']['referrer_fee'];
                                $delivery_fee 	+= $sale['Order']['delivery_fee'];
                                $balance 		+= $sale['Order']['balance'];
                        ?>
                        <tr>
                            <td><?php echo $sale['Order']['invoice_number']; ?></td>
                            <td><?php echo $sale['Order']['order_date']; ?></td>
                            <td><?php echo $sale['Order']['product']; ?></td>
                            <td><?php echo $sale['Order']['status']; ?></td>
                            <td class="amount">Rs. <?php echo number_format($sale['Order']['mrp'], 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($sale['Order']['referrer_fee'], 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($sale['Order']['delivery_fee'], 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($sale['Order']['balance'], 2); ?></td>
                            <td><?php echo $sale['Order']['note']; ?></td>
                            <td><?php
                            if($sale['Order']['status'] != 'Completed') {
                            	echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-edit')) . ' ' . __(''), 
                                     array('controller' => 'orders', 'action' => 'edit', $sale['Order']['id'], $start_date, $end_date), 
                                     array('class' => 'btn default btn-xs blue fancybox fancybox.ajax', 'escape' => false));
                            } 
                                echo $this -> Form -> postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')) . ' ' . __(''), 
                                     array('controller' => 'orders', 'action' => 'delete', $sale['Order']['id']), 
                                     array('class' => 'btn default btn-xs grey', 'escape' => false), 
                                     __('Are you sure you want to delete # %s?', $sale['Order']['id'])); ?></td>
                        </tr>
                        <?php 
                            endforeach; 
                        endif; ?>                       
                        <tr class="transaction-total">
                            <td><?php echo count($orders); ?></td>
                            <td colspan="3"></td>
                            <td class="amount">Rs. <?php echo number_format($mrp, 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($referrer_fee, 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($delivery_fee, 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($balance, 2); ?></td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>

<div class="col-md-12">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bell-o"></i>Payments
                <?php echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add'), 
                                                 array('controller' => 'transactions', 'action' => 'save', $this->request->params['pass'][0], $start_date, $end_date), 
                                                 array('class' => 'btn btn-xs blue add-transaction fancybox fancybox.ajax', 'escape' => false)); ?>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                        <tr>
                            <th><?php echo __('#'); ?></th>
                            <th><?php echo __('Invoice'); ?></th>
                            <th><?php echo __('Transaction'); ?></th>
                            <th><?php echo __(''); ?></th>
                            <th><?php echo __('VAT'); ?></th>
                            <th><?php echo __('Sub Total'); ?></th>
                            <th><?php echo __('Discount'); ?></th>
                            <th><?php echo __('Taxable'); ?></th>
                            <th><?php echo __('Vat'); ?></th>
                            <th><?php echo __('Total'); ?></th>
                            <th><?php echo __('R/P'); ?></th>
                            <th class="col-md-1"><?php echo __('Note'); ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sub_total = $discount = $taxable_amount = $vat = $grand_total = $transaction_total = 0;

                        if(isset($transactions)) :
                            foreach ($transactions as $transaction):
								$sign 				= $transaction['Transaction']['debit_credit_flag'];
                                $sub_total 			+= ($transaction['Transaction']['sub_total'] * $sign);
                                $discount 			+= ($transaction['Transaction']['discount'] * $sign);
                                $taxable_amount 	+= ($transaction['Transaction']['taxable_amount'] * $sign);
                                $vat 				+= ($transaction['Transaction']['vat_billed'] * $sign);
                                $grand_total 		+= ($transaction['Transaction']['grand_total'] * $sign);
								$transaction_total 	+= ($transaction['Transaction']['transaction_total'] * $sign);
								$tran_class = ($transaction['Transaction']['debit_credit_flag'] == 1)? 'success': ' danger';
                        ?>
                        <tr>
                            <td class="<?php echo $tran_class ?>"><?php echo $transaction['Transaction']['invoice_number']; ?></td>
                            <td><?php echo $transaction['Transaction']['invoice_date']; ?></td>
                            <td><?php echo $transaction['Transaction']['transaction_date']; ?></td>
                            <td><?php echo ($transaction['Transaction']['cash_credit_flag'])? 'Cash': 'Credit'; ?></td>
                            <td><?php echo ($transaction['Transaction']['vat_flag'])? 'Yes': 'No'; ?></td>
                            <td class="amount">Rs. <?php echo number_format($transaction['Transaction']['sub_total'], 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($transaction['Transaction']['discount'], 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($transaction['Transaction']['taxable_amount'], 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($transaction['Transaction']['vat_billed'], 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($transaction['Transaction']['grand_total'], 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($transaction['Transaction']['transaction_total'], 2); ?></td>
                            <td><?php echo $transaction['Transaction']['note']; ?></td>
                            <td><?php echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-edit')) . ' ' . __(''), 
                                                                 array('controller' => 'transactions', 'action' => 'edit', $transaction['Transaction']['id'], $start_date, $end_date), 
                                                                 array('class' => 'btn default btn-xs blue fancybox fancybox.ajax', 'escape' => false)); ?>
                                <?php echo $this -> Form -> postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')) . ' ' . __(''), 
                                                                 array('controller' => 'transactions', 'action' => 'delete', $transaction['Transaction']['id']), 
                                                                 array('class' => 'btn default btn-xs grey', 'escape' => false), 
                                                                 __('Are you sure you want to delete # %s?', $transaction['Transaction']['id'])); ?></td>
                        </tr>
                        <?php 
                            endforeach; 
                        endif; ?>                       
                        <tr class="transaction-total">
                            <td><?php echo count($transactions); ?></td>
                            <td colspan="4"></td>
                            <td class="amount">Rs. <?php echo number_format($sub_total, 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($discount, 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($taxable_amount, 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($vat, 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($grand_total, 2); ?></td>
                            <td class="amount">Rs. <?php echo number_format($transaction_total, 2); ?></td>
                            <td></td>
                            <td><?php echo $this -> Html -> link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . ' ' . __('Add'), 
                                                 array('controller' => 'transactions', 'action' => 'save', $this->request->params['pass'][0], $start_date, $end_date), 
                                                 array('class' => 'btn btn-xs blue add-transaction fancybox fancybox.ajax', 'escape' => false)); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>