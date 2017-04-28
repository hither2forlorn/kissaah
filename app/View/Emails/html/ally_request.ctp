<?php
echo $this->Html->para('', 'Dear ' . $data['Ally']['ally_name'] . ',');
echo $this->Html->para('', 'Greetings from ' . $this->Session->read('Company.name') . '.');

echo $this->Html->para('', $data['name'] . ' has selected you to be their ally. ' . $data['name'] . ' is calling upon your expertise 
		and needs your help to ' . $data['Ally']['need_ally_to'] . ' as part of their 90-day Catalyst Plan.');

echo $this->Html->para('', 'Thank you for being a ' . $this->Session->read('Company.name') . ' Ally! ' . $data['name'] . ' appreciates your help! ');

echo $this->Html->link('Accept Request',
		array('controller' => 'allies', 'action' => 'accept_ally', $data['span'], 'full_base' => true),
		array('style' => 'display:inline-block;padding:6px 12px;margin-bottom:0;text-align:center;vertical-align:middle;touch-action:manipulation;
						cursor:pointer;background-color:#17b3e8;border:1px solid transparent;color:#FFF;'));
		
echo $this->Html->para('', 'Note that notifications from your ally or the ' . $this->Session->read('Company.name') . ' Platform are found on the 
		upper left corner of your Human Catalyst landing page with a red number in a circle and a bell.');

echo $this->Html->para('', 'Sample:' . $this->Html->img('notification.png', array('fullBase' => true)));
echo $this->Html->para('', 'Best,<br />The ' . $this->Session->read('Company.name') . ' team');

echo $this->Html->para('', 'PS. You will not be bombarded by any marketing emails. 
							This email is purely because you\'ve been specifically requested as an Ally, and we hope you can help!');
?>