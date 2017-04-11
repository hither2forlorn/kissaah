<?php
	echo $this->Html->para('', 'Dear ' . $data['Ally']['ally_name'] . ',');
	echo $this->Html->para('', $data['name'] . ' has invited you to be an Ally as part of the ' . $data['Ally']['roadmap'] . ' RoadMap.');
	echo $this->Html->para('', $data['name'] . ' is calling upon your expertise and has asked if you can:');
	
	if(isset($data['Ally']['need_ally_to'])) 	$calling[] = $data['Ally']['need_ally_to'];
	if(isset($data['Ally']['help_with'])) 		$calling[] = $data['Ally']['help_with'];
	if(isset($data['Ally']['from_there'])) 		$calling[] = $data['Ally']['from_there'];
	echo $this->Html->nestedList($calling);
	
	echo $this->Html->para('', $data['name'] . ' appreciates your help! You can also ask for help back by making ' . $data['name'] . ' your Ally too!');
	
	echo $this->Html->link('Accept Request',
			array('controller' => 'allies', 'action' => 'request_action', 'accept', $data['span']),
			array('style' => 'display:inline-block;padding:6px 12px;margin-bottom:0;text-align:center;vertical-align:middle;touch-action:manipulation;
							cursor:pointer;background-color:#17b3e8;border:1px solid transparent;color:#FFF;', 'fullBase' => true));

	/* echo $this->Html->para('', 'If you\'re not a ' . $this->Session->read('Company.name') . ' user, no worries at all! ' . 
			$this->Html->link('Click here', array('controller' => 'users', 'action' => 'register', 'full_base' => true), array('fullBase' => true)) . 
			' to follow the brief steps, and start being a recognized ' . $this->Session->read('Company.name') . ' Ally!'); */

	echo $this->Html->para('', 'Thank you for your contribution to ' . $data['name'] . '\'s journey on ' . $this->Session->read('Company.name') . '.');

	echo $this->Html->para('', 'Best,<br />The ' . $this->Session->read('Company.name') . ' team');
	
	echo $this->Html->para('', 'PS. You will not be bombarded by any marketing emails. 
								This email is purely because you\'ve been specifically requested as an Ally, and we hope you can help!');
	
	echo $this->Html->para('', 'Join the ' . $this->Session->read('Company.name') . ' Community, and find us on:');

	$social  = $this->Html->image('social/FB-f-Logo__blue_29.png', 
							array('fullBase' => true, 'url' => 'https://www.facebook.com/kissaah'));
	$social .= '&nbsp;&nbsp;&nbsp;';
	$social .= $this->Html->image('social/Twitter-Logo__blue_29.png', 
							array('fullBase' => true, 'url' => 'https://twitter.com/Kissaah_Inc')); 
	$social .= '&nbsp;&nbsp;&nbsp;';
	$social .= $this->Html->image('social/Pinterest_Badge_Red.png', 
							array('fullBase' => true, 'url' => 'http://www.pinterest.com/kissaah/')); 
	$social .= '&nbsp;&nbsp;&nbsp;';
	$social .= $this->Html->image('social/Instagram_Badge.png', 
							array('fullBase' => true, 'url' => 'http://instagram.com/kissaah_inc')); 
	$social .= '&nbsp;&nbsp;&nbsp;';
	$social .= $this->Html->image('social/google_plus_badge.png', 
							array('fullBase' => true, 'url' => 'https://plus.google.com/u/0/117567618205944659526/posts'));
							
	echo $this->Html->div('', $social); 
?>