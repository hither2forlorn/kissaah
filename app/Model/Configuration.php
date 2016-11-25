<?php
App::uses('Sanitize','Utility');
Class Configuration extends AppModel {
	//var $useTable = 'configures';
	
	public $actsAs = array('Tree', 'Containable');
	
	/* public $belongsTo = array(
		'GameLevel'=> array(
			'className'=> 'GameLevel',
			'foreignKey'=>'game_level_id'),
	); */
	
	public $hasMany = array(
		'Game' => array(
			'className'=>'Game',
			'foreignKey'=>'configuration_id'
			)
	);
}