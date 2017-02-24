<p>Dear <?php echo $data['User']['name']; ?></p>
<?php 
$link = $this->Html->link('click here', 
				array('controller' => 'users', 'action' => 'verify', $data['User']['email'], $data['User']['hash'], 'full_base' => true),
				array('fullBase' => true));

echo $this->Html->para(null, 'Thank you for signing up to ' . $this->Session->read('Company.name') . '!');
//echo $this->Html->para(null, 'Please ' . $link . ' to confirm your email.');
echo $this->Html->para(null, 'We have received your request for an account with Kissaah. 
		Our team is working to verify the request and provide you with an account.');
echo $this->Html->para(null, 'We hope you enjoy changing your story with Kissaah.');

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
