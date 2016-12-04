<?php 
echo 'Hey Ally ' . $data['Ally']['MyAlly']['name'] . ',';

echo $this->Html->para('"If you want to go fast, go alone. If You want to go far, go together"  African Proverb');
echo $this->Html->para('As you see, please help ' . $this->Session->read('Auth.User.name') . ' make progress towards their commitments, which are:');

foreach($data['answers'][181]['children'] as $answer) {
	if(isset($answer['Dependent'][0]['answer'])) {
		echo $this->Html->tag('h4', $answer['Configuration']['title']);
		echo $this->Html->para('', $answer['Dependent'][0]['answer']);
	}
}

echo $this->Html->para('Shall we meet in 30 days to keep the momentum going?');
?> 