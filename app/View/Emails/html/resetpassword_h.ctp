<?php 
echo $this->Html->para(null, 'Thank you for contacting Human Catalyst. Your password has been temporarily reset.
		Please use the following new password and when you logon update your password as directed.');

echo $this->Html->para(null, 'Username: ' . $data['User']['email'] . '<br />Temporary Password: ' . $data['User']['password']);

echo $this->Html->para(null, 'Thank you for contacting Human Catalyst.');

echo $this->Html->para(null, '-----------------------------------------------------------------------------------------------------------------------------');

echo $this->Html->para(null, 'Human Catalyst leverages the increasing trend of self-directed and peer-coached development, 
		linking each person\'s individual goals with their employer\'s.  Individuals are prompted to chart their own personal 
		growth plans to connect with and learn about other people and segments of their organization, outside of their silo. 
		This is all supported by peer-to-peer network to support and mentor each other to be their best.');

echo $this->Html->para(null, 'Human Catalyst\'s simple and visual 4-step framework:<br />
		1. Discover  2. Embark 3. Design 4. Execute<br />
		HC encourages participants to capture via text, photos and videos what motivates them, areas where they want to grow at work 
		by improving engagement and performance.');

echo $this->Html->para(null, 'The outcomes for:');

echo $this->Html->para(null, 'Leaders: Created through our interactive process, manager\'s dashboards provide tangible, aggregated data 
		and insights for an organization\'s leadership to fuel its talent strategy.');

echo $this->Html->para(null, 'Talent: Employees can better navigate an organization with an individually designed 90-day Catalyst Plan 
		that charts development, improves team understanding and fosters everyone to be their best.');

echo $this->Html->para(null, 'Join the Human Catalyst community at humancatlyst.co and find us on:');
?>
<div><?php 
	echo $this->Html->image('social/FB-f-Logo__blue_29.png', 
							array('fullBase' => true, 'url' => 'https://www.facebook.com/humancatalyst100'));
	echo '&nbsp;&nbsp;&nbsp;';
	echo $this->Html->image('social/Twitter-Logo__blue_29.png', 
							array('fullBase' => true, 'url' => 'https://twitter.com/HumanCatalyst3')); 
	echo '&nbsp;&nbsp;&nbsp;';
	echo $this->Html->image('social/linkedin_blue_29.png', 
							array('fullBase' => true, 'url' => 'https://www.linkedin.com/company/15206484')); 
?></div>
