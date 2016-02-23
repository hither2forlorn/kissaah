<p>Dear <?php echo $data['User']['name']; ?></p>
<?php 
	$link = $this->Html->link('click here', 
					array('controller' => 'users', 'action' => 'manuallogin', 
						  '?' => array('e' => $data['User']['email'], 'p' => $data['User']['password']), 'full_base' => true));
	
	echo $this->Html->para(null, 'Thank you for signing up to Kissaah!');
	//echo $this->Html->para(null, 'Please ' . $link . ' to confirm your email.');
	echo $this->Html->para(null, 'Your request has been approved. Please ' . $link . ' to login and get started.');
	echo $this->Html->para(null, 'We hope you enjoy changing your story with Kissaah.');
?>

<p>The Kissaah Team</p>
<p>Join the Kissaah Community, find us on:</p>
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
