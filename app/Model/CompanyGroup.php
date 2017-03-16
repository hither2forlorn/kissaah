<?php
App::uses('Sanitize','Utility');
Class CompanyGroup extends AppModel {
	
	public $actsAs = array('Tree', 'Containable');
	
	/*
	var $hasAndBelongsToMany = array(
			'User' => array(
					'className' => 'User',
					'joinTable' => 'company_groups_users',
					'foreignKey' => 'company_group_id',
					'associationForeignKey' => 'user_id',
					'unique' => true
			)
	);
	*/
	
	var $belongsTo = array(
			'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id'
			)
	);
	
	var $hasMany = array(
		'CompanyGroupsUser' => array(
				'className' => 'CompanyGroupsUser',
				'foreignKey' => 'company_group_id'
		)	
	);
}