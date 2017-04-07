<?php
App::uses ( 'AppModel', 'Model' );
class CompanyGroupsUser extends AppModel {
	
	public $actsAs = array (
			'Containable' 
	);
	
	var $belongsTo = array (
			'User' => array (
					'className' => 'User',
					'foreignKey' => 'user_id' 
			),
			'CompanyGroup' => array (
					'className' => 'CompanyGroup',
					'foreignKey' => 'company_group_id' 
			),
			'Role' => array (
					'className' => 'Role',
					'foreignKey' => 'role_id' 
			) 
	);
}