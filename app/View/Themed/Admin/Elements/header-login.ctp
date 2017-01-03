<!-- BEGIN USER LOGIN DROPDOWN -->
<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-user">
	<?php
	$image = $this->Session->read('Auth.User.slug');
	if (!empty($image)) :
		$image = '../files/img/small/' . $image;
	else :
		$image = 'profilecover.jpg';
	endif;
	echo $this->Html->link($this->Html->image($image, array('class' => 'img-circle', 'height' => '29px')) . 
						     $this->Html->tag('span', ' ' . $this->Session->read('Auth.User.name') . ' ', array('class' => 'username username-hide-on-mobile')) .
						     $this->Html->tag('i', '', array('class' => 'fa fa-angle-down')),
						   '#', array('class' => 'dropdown-toggle', 'escape' => false, 'data-close-others' => 'true',
						   			  'data-toggle' => 'dropdown', 'data-hover' => 'dropdown'));
	
	$list = array(
		$this->Html->link($this->Html->tag('i', '', array('class' => 'icon-user')) . ' My Profile',
							array('controller' => 'users', 'action' => 'profile', 'plugin' => false, 'admin' => false), array('escape' => false)),
		
		$this->Html->link($this->Html->tag('i', '', array('class' => 'icon-envelope-open')) . ' Back to Game ', 
						  array('controller' => 'games', 'action' => 'index', 'plugin' => false, 'admin' => false), array('escape' => false)),
						  
		/* <li class="divider"></li> */
						  
		$this->Html->link($this->Html->tag('i', '', array('class' => 'icon-key')) . ' Log Out', 
						  array('controller' => 'users', 'action' => 'logout'), array('escape' => false))
	);
	echo $this->Html->nestedList($list, array('class' => 'dropdown-menu dropdown-menu-default'));	
	?>

</li>
<!-- END USER LOGIN DROPDOWN -->