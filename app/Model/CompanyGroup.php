<?php
App::uses('Sanitize','Utility');
Class CompanyGroup extends AppModel {
	
	public $actsAs = array('Tree', 'Containable');
	
	var $hasAndBelongsToMany = array(
			'User' => array(
					'className' => 'User',
					'joinTable' => 'company_groups_users',
					'foreignKey' => 'company_group_id',
					'associationForeignKey' => 'user_id',
					'unique' => 'keepExisting'
			)
	);
	
	var $belongsTo = array(
			'Admin' => array(
					'className' => 'User',
					'foreignKey' => 'admin_id'
			)
	);
}