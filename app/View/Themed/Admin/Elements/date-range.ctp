<?php
    $accountingyears = $this->requestAction(array('controller' => 'accounting_years', 'action' => 'date_range'));
?>

<script>
jQuery(document).ready(function() {
    ranges = {
        <?php 
        foreach($accountingyears as $accountingyear) :
            echo '\'' . $accountingyear['AccountingYear']['name'] . '\': [\'' . $accountingyear['AccountingYear']['start_date'] . '\', \'' . $accountingyear['AccountingYear']['end_date'] . '\'],';
        endforeach;
		echo '\'All\': [\'' . $accountingyears[0]['AccountingYear']['start_date'] . '\', \'' . $accountingyears[count($accountingyears) - 1]['AccountingYear']['end_date'] . '\'],';
        ?>

        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
        'Last 7 Days': [moment().subtract('days', 6), moment()],
        'Last 30 Days': [moment().subtract('days', 29), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
    };
    
    AccountingPeriod.init();
});
</script>
