<?php
App::uses('Sanitize','Utility');
Class CompanyGroupsUser extends AppModel {
	
	public $actsAs = array('Containable');
	
	var $belongsTo = array(
			'User' => array(
				'className' => 'User',
				'foreignKey' => 'user_id'
			),
			'CompanyGroup' => array(
				'className' => 'CompanyGroup',
				'foreignKey' => 'company_group_id'
			)
	);
}