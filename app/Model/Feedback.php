<?php 
App::uses('Sanitize','Utility');
Class Feedback extends AppModel {
	
	public $actsAs = array('Containable');
	
	public $belongsTo = array(
			'Configuration'=> array(
					'className'=> 'Configuration',
					'foreignKey'=>'configure_id'
			),
			'User'=> array(
					'className'=> 'User',
					'foreignKey'=>'user_id'
			),
			'UserGameStatus' => array(
					'className' => 'UserGameStatus',
					'foreignKey' => 'user_id'
			),
	);
}

?>