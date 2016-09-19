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
					/*
					 * TODO: Its set currently for one company and one group so force reset of old records
					 * else set 'unique' => 'keepExisting'
					 */
					'unique' => true
			)
	);
	
	var $belongsTo = array(
			'Admin' => array(
					'className' => 'User',
					'foreignKey' => 'admin_id'
			)
	);
}