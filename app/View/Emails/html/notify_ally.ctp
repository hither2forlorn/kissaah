Hey Ally <?php echo $data['Ally']['MyAlly']['name']; ?>, 

"If you want to go fast, go alone. If You want to go far, go together"  African Proverb
As you see, please help <?php echo $this->Session->read('Auth.User.name'); ?> make progress towards their commitments, which are

<?php 
foreach($data['answers'][181]['children'] as $answer) {
	if(isset($answer['Dependent'][0]['answer'])) {
		echo $this->Html->tag('h4', $answer['Configuration']['title']);
		echo $this->Html->para('', $answer['Dependent'][0]['answer']);
	}
}
?> 

Shall we meet in 30 days to keep the momentum going?