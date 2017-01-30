<p>Dear Admin,</p>
<?php 
	$link = $this->Html->link('click here', 
					array('controller' => 'users', 'action' => 'verify', $data['User']['email'], $data['User']['hash'], 'full_base' => true),
					array('fullBase' => true));
	
	echo $this->Html->para(null, $data['User']['name'] . ' has requested an account with ' . $this->Session->read('Company.name') . '!');
	//echo $this->Html->para(null, 'Please ' . $link . ' to confirm your email.');
	echo $this->Html->para(null, 'Please head on to the admin screen to approve the new user and get them started on their way.');
?>
<p>The <?php echo $this->Session->read('Company.name');?> Team</p>
<p>Join the <?php echo $this->Session->read('Company.name'); ?> Community, find us on:</p>
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
