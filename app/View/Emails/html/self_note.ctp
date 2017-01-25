Here are the notes and reminder for you
 <table>
 <?php 
 $cnt = 0;
 if(isset($data['Notes to take'])) {
 		echo '<tr><td style="border:1px solid #000000;padding:5px 10px;" colspan="2">Notes to take</td></tr>';
	 	foreach($data['Notes to take'] as $notes){
	 		echo '<tr>';
	 		echo '<td style="border:1px solid #000000;padding:5px 10px;">'.$notes['text'].'</td>';
			echo '<td style="border:1px solid #000000;padding:5px 10px;">'.$notes['complete_by'].'</td>';
			echo '</tr>';
	 	}
	 }
 $cnt = 0;
 if(isset($data['People to see'])) {
 		echo '<tr><td style="border:1px solid #000000;padding:5px 10px;" colspan="2">People to see</td></tr>';
	 	foreach($data['People to see'] as $notes){
	 		echo '<tr>';
	 		echo '<td style ="border:1px solid #000000;padding:5px 10px;">'.$notes['text'].'</td>';
			echo '<td style ="border:1px solid #000000;padding:5px 10px;">'.$notes['complete_by'].'</td>';
			echo '</tr>';
	 	}
	 }
 $cnt = 0;
 if(isset($data['Things to do'])) {
 		echo '<tr><td style="border:1px solid #000000;padding:5px 10px;" colspan="2">Things to do</td></tr>';
	 	foreach($data['Things to do'] as $notes){
	 		echo '<tr>';
	 		echo '<td style ="border:1px solid #000000;padding:5px 10px;">'.$notes['text'].'</td>';
			echo '<td style ="border:1px solid #000000;padding:5px 10px;">'.$notes['complete_by'].'</td>';
			echo '</tr>';
	 	}
	 }
 ?>
</table>
<?php
	echo '<br />';
	echo '<br />';
	echo "Please do not reply to this email as your message will not be read. If you need help from a ' . $this->Session->read('Company.name') . ' team member, please email support@kissaah.com";
	
?>