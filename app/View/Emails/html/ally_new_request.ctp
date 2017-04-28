<?php
	echo $this->Html->para('', 'Dear ' . $data['Ally']['ally_name'] . ',');
	
	echo $this->Html->para('', 'Greetings from ' . $this->Session->read('Company.name') . '.' . $data['name'] . ' is completing a 90-day 
			personal development plan and peer to peer coaching process during which ' . $data['name'] . ' will:');
	
	if(isset($data['Ally']['need_ally_to']) && $data['Ally']['need_ally_to'] != '') $calling[] = $data['Ally']['need_ally_to'];
	if(isset($data['Ally']['help_with']) && $data['Ally']['help_with'] != '') 		$calling[] = $data['Ally']['help_with'];
	if(isset($data['Ally']['from_there']) && $data['Ally']['from_there'] != '')		$calling[] = $data['Ally']['from_there'];
	
	$calling = array();
	$calling[] = 'Develop a new skill';
	$calling[] = 'Gain exposure to an area of their current work environment or another environment that is of interest to them';
	$calling[] = 'Connect with a leader or peer';
	echo $this->Html->nestedList($calling);
	
	echo $this->Html->para('', $data['name'] . ' is inviting you to be their ally. 
			In the next few days ' . $data['name'] . ' will contact you to set a time to meet and discuss their 
			90-day journey and how they think you can help.');
	
	echo $this->Html->para('', $this->Session->read('Company.name') . ' leverages the increasing trend of self-directed and peer-coached development, 
			linking each person\'s individual goals with their employer\'s. 
			Individuals are prompted to chart their own personal growth plans to connect with and learn about other people and 
			segments of their organization, outside of their silo. 
			This is all supported by peer-to-peer network to support and mentor each other to be their best.');

	echo $this->Html->para('', 'Thank you for being a ' . $this->Session->read('Company.name') . ' Ally!');
	echo $this->Html->para('', '-----------------------------------------------------------------------------------------------');
	echo $this->Html->para('', 'Join the ' . $this->Session->read('Company.name') . ' community at http://www.humancatlyst.co!');
	echo $this->Html->para('', 'Find us on:');

	$spacing = '&nbsp;&nbsp;&nbsp;';
	$social  = $this->Html->image('social/FB-f-Logo__blue_29.png', 
			array('fullBase' => true, 'url' => 'https://www.facebook.com/humancatalyst100')) . $spacing; //kissaah
	$social .= $this->Html->image('social/Twitter-Logo__blue_29.png', 
			array('fullBase' => true, 'url' => 'https://twitter.com/HumanCatalyst3')) . $spacing;
							//array('fullBase' => true, 'url' => 'https://twitter.com/Kissaah_Inc')); 
	$social .= $this->Html->image('social/Pinterest_Badge_Red.png', 
			array('fullBase' => true, 'url' => 'http://www.pinterest.com/kissaah/')) . $spacing; 
	$social .= $this->Html->image('social/Instagram_Badge.png', 
			array('fullBase' => true, 'url' => 'http://instagram.com/kissaah_inc')) . $spacing; 
	$social .= $this->Html->image('social/google_plus_badge.png', 
			array('fullBase' => true, 'url' => 'https://plus.google.com/u/0/117567618205944659526/posts')) . $spacing;
	//https://www.linkedin.com/company/15206484?trk=tyah&trkInfo=clickedVertical:company,clickedEntityId:15206484,idx:2-1-2,tarId:1483656898605,tas:human%20cata
							
	echo $this->Html->div('', $social); 
?>