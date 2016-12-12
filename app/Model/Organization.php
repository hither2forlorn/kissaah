<?php
App::uses('Sanitize', 'Utility');

Class Organization extends AppModel {
	
	public $actsAs = array('Tree', 'Containable');
	
	public $belongsTo = array(
			'CompanyGroup' => array(
					'className'		=> 'CompanyGroup',
					'foreignKey'	=> 'company_group_id'
			)
	);
}