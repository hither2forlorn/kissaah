<?php 
echo $this->Html->para(null, 'Password has been reset<br />Username: ' . $data['User']['email'] . '<br />New Password: ' . $data['User']['password']);

echo $this->Html->para(null, '---------------------------------------------------------------------------------------------------');

echo $this->Html->para(null, 
		'<strong>' . $this->Session->read('Company.name') . '(n): </strong>- Life story; tale (Sanskrit).', 
		array('style' => 'text-align:center;'));

echo $this->Html->para(null, 'We all have a story to tell.');

echo $this->Html->para(null, 'Our stories describe our hopes, dreams, and ideas. Studies show our personal narratives guide our decisions and 
		help us achieve our goals. In short, telling our life stories can help us figure out who we are and where we want to be.', 
		array('style' => 'text-align:center;'));

echo $this->Html->para(null, 'What Is ' . $this->Session->read('Company.name') . '?', array('style' => 'text-align:center;'));

echo $this->Html->para(null, $this->Session->read('Company.name') . ' is research-based framework for storytelling that fosters insight, inspires self-reflection, 
		and generates an individualized action plan that can be shared with others. ' . $this->Session->read('Company.name') . ' combines words and images to help
		you identify your values and hone your goals. Share your story, and let ' . $this->Session->read('Company.name') . ' help get you where you want to be.', 
		array('style' => 'text-align:center;'));

echo $this->Html->para(null, $this->Html->link('Click Here', array('controller' => 'users', 'action' => 'login', 'full_base' => true)) . ' to get started.');

echo $this->Html->para(null, '---------------------------------------------------------------------------------------------------');

echo $this->Html->para(null, 'The ' . $this->Session->read('Company.name') . ' Team');
echo $this->Html->para(null, 'Join the ' . $this->Session->read('Company.name') . ' Community, find us on:');
?>
<div><?php 
	echo $this->Html->image('social/FB-f-Logo__blue_29.png', 
							array('fullBase' => true, 'url' => 'https://www.facebook.com/kissaah'));
	echo '&nbsp;&nbsp;&nbsp;';
	echo $this->Html->image('social/Twitter-Logo__blue_29.png', 
							array('fullBase' => true, 'url' => 'https://twitter.com/Kissaah_Inc')); 
	echo '&nbsp;&nbsp;&nbsp;';
	echo $this->Html->image('social/Pinterest_Badge_Red.png', 
							array('fullBase' => true, 'url' => 'http://www.pinterest.com/kissaah/')); 
	echo '&nbsp;&nbsp;&nbsp;';
	echo $this->Html->image('social/Instagram_Badge.png', 
							array('fullBase' => true, 'url' => 'http://instagram.com/kissaah_inc')); 
	echo '&nbsp;&nbsp;&nbsp;';
	echo $this->Html->image('social/google_plus_badge.png', 
							array('fullBase' => true, 'url' => 'https://plus.google.com/u/0/117567618205944659526/posts')); 
?></div>
