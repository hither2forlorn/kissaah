<?php App::uses('Model', 'AppModel');
class Role extends AppModel {
	
	var $useTable = 'userroles';
	var $name = 'Role';
	
	public $actsAs = array('Acl' => array('type' => 'requester'), 'Containable');
	
	var $order = 'Role.name';

	var $validate = array(
		'name' => array(
			'name-unique' => array(
				'rule' 		=> 'isUnique',
				'message' 	=> 'The User Role is already taken.'
			),
			'name-notBlank' => array(
				'rule' 		=> 'notBlank',
				'message' 	=> 'The name cannot be empty.'
			)
		),
	);
	
	var $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'role_id',
			'dependent' => true
		)
	);
	
	public function parentNode() {
		return null;
	}

	/* function parentNode() {
		return $this->pNode();
	} */
}
?>