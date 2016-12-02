Hey Ally A, 

"If you want to go fast, go alone. If You want to go far, go together"  African Proverb
As you see, please help User A make progress towards their commitments, which are 

DEVELOPMENT: 
Exceed sales quota by 15% with new sales effectiveness tool and help of my team 
By Jan 15, 2017

EXPOSURE:
Meet with finance, understand how to get customers through credit faster
Jan 25, 2017

CONNECTIONS
James Fong Accounting
David Mayers Accounts Receivable 
Jan 27, 2017
99 DAYS: 20 HRS: 45 Min is left.  Shall we meet in 30 days to keep the momentum going?

<?php
	echo $this->Html->para('', 'Dear ' . $data['Ally']['ally_name'] . ',');
	echo $this->Html->para('', $data['name'] . ' has invited you to be an Ally as part of the ' . $data['Ally']['roadmap'] . ' RoadMap.');
	echo $this->Html->para('', $data['name'] . ' is calling upon your expertise and has asked if you can:');
	
	if(isset($data['Ally']['need_ally_to'])) {
		$calling[] = $data['Ally']['need_ally_to'];
	}
	if(isset($data['Ally']['help_with'])) {
		$calling[] = $data['Ally']['help_with'];
	}
	if(isset($data['Ally']['from_there'])) {
		$calling[] = $data['Ally']['from_there'];
	}
	echo $this->Html->nestedList($calling);
	
	echo $this->Html->para('', $data['name'] . ' appreciates your help! 
								You can also ask for help back by making ' . $data['name'] . ' your Ally too!');
								
	echo $this->Html->para('', 'If you\'re not a kissaah user, no worries at all! ' . 
								$this->Html->link('Click here', array('controller' => 'users', 'action' => 'register', 'full_base' => true), 
												   array('fullBase' => true)) . 
								' to follow the brief steps, and start being a recognized kissaah Ally!');

	echo $this->Html->para('', 'Thank you for your contribution to ' . $data['name'] . '\'s journey on kissaah.');

	echo $this->Html->para('', 'Best,<br />The Kissaah team');
	
	echo $this->Html->para('', 'PS. You will not be bombarded by any marketing emails. 
								This email is purely because you\'ve been specifically requested as an Ally, and we hope you can help!');
	
	echo $this->Html->para('', 'Join the Kissaah Community, and find us on:');

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