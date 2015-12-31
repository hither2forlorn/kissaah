<?php
$config = array('Cpanel' => array(
	'perm' => array(), // default permission for userModel or Role as defined
	'roleModel' => 'Role', // aros->model of roleModel
	'rolePrefix' => '', // Prefix to be placed on aros->alias for roleModel
	'aroRoleKey' => 'url', // aros->foreign_key for roleModel
	'aroUserKey' => 'url', // aros->foreign_key for roleModel
	'roleKey' => 'role_id', // userModel associated foreignKey for roleModel
	'userModel' => 'User', // aros->model of userModel
	'userPrefix' => '', // Prefix to be placed on aros->alias for userModel
	'aroUserKey' => 'url', // aros->foreign_key for roleModel
	'aroRoleName' => 'name', // roleModel display name for cpanel
	'aroUserName' => 'name', // userModel display name for cpanel
	
	'coreController' => 'Controller', // root for access control
	'logoutAction' => array('controller' => 'users', 'action' => 'logout', 'admin' => false, 'plugin' => false),	
	'mainAco' => array('Plugin' => 'SuperAdmin', 'Controller' => 'ControlPanels', 'action' => 'index'), // main page to be displayed for cpanel
	
	'images' => array(
		'permission' => 'permissions.png',
		'allow' => 'allow.png',
		'deny' => 'deny.png',
		'add' => 'add.png',
		'delete' => 'delete.png',
	),
	)
);
?>