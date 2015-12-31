<?php
App::uses('AppModel', 'Model');
/**
 * UserGameStatus Model
 *
 * @property User $User
 */
class UserGameStatus extends AppModel {

	var $actsAs = array('Containable');
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $validate = array(
			'roadmap' => array(
					'notempty' => array(
							'rule' 		 => 'notEmpty',
							'allowEmpty' => true,
							'message' 	 => 'Please enter your roadmap name.')
			),
	);
	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' 	=> 'User',
			'foreignKey' 	=> 'user_id',
			'conditions'	=> '',
			'fields' 		=> '',
			'order' 		=> ''
		)
	);

	public $hasMany = array(
		'Ally' => array(
			'className'  => 'Ally',
			'foreignKey' => 'user_game_status_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Feedback' => array(
			'className'  => 'Feedback',
			'foreignKey' => 'user_game_status_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SelfNote' => array(
			'className'  => 'SelfNote',
			'foreignKey' => 'user_game_status_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Game' => array(
			'className' => 'Game',
			'foreignKey' => 'user_game_status_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
	
}
