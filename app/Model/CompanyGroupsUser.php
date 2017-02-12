<?php
App::uses('AppModel', 'Model');

Class CompanyGroupsUser extends AppModel {
	
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