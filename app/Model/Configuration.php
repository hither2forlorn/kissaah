<?php
App::uses('Sanitize','Utility');
Class Configuration extends AppModel {
	
	public $actsAs = array('Tree', 'Containable');
	
	public $hasMany = array(
		'Game' => array(
			'className'=>'Game',
			'foreignKey'=>'configuration_id'
			)
	);
}