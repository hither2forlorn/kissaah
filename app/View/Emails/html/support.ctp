<?php
	echo '<p style="text-align: center;">
		<strong>' . $this->Session->read('Company.name') . ' </strong>- story/ tale in Sanskrit - operationalizes academic research in cognitive, 
		behavioral and decision sciences.</p>';
?>
<table>
	<tr>
		<td>Ticket No.</td>
		<td>
			<?php
            if(isset($data['ticket_no'])) {
                echo $data['ticket_no'];
            }
        ?>
		</td>
	</tr>
	<tr>
        <td>Department</td>
        <td><?php
            if(isset($data['department'])) {
                echo $data['department'];
            }
        ?></td>
        <td>Priority</td>
         <td><?php
            if(isset($data['priority'])) {
                echo $data['priority'];
            }
        ?></td>
    </tr>
    <tr>
        <td>From</td>
        <td><?php
            if(isset($data['user'])) {
                echo $data['user'];
            }
        ?></td>
    </tr>
    <tr>
        <td>Subject</td>
        <td><?php
            if(isset($data['subject'])) {
                echo $data['subject'];
            }
        ?></td>
    </tr>
    <tr>
        <td>Issue</td>
        <td><?php
            if(isset($data['issue'])) {
                echo $data['issue'];
            }
        ?></td>
    </tr>
</table>

<?php
	echo '<br />';
	echo '<br />';
	echo "Please do not reply to this email as your message will not be read. If you need help from a ' . $this->Session->read('Company.name') . ' team member, please email support@kissaah.com";
?>