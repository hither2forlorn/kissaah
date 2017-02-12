<?php
App::uses('AppModel', 'Model');

class Ally extends AppModel{
	
	public $actsAs = array('Containable');
	
	public $belongsTo = array(
		'User' => array(
			'className'		=> 'User',
			'foreignKey'	=> 'user_id'
		),
		'MyAlly' => array(
				'className'		=> 'User',
				'foreignKey'	=> 'ally'
		),
		'UserGameStatus' => array(
			'className'		=> 'UserGameStatus',
			'foreignKey'	=> 'user_game_status_id'
		)
	);
}
