<?php
App::uses('AppModel', 'Model');
/**
 * Challenge Model
 *
 * @property User $User
 * @property Ally $Ally
 * @property Message $Message
 * @property Badge $Badge
 * @property UserGameStatus $UserGameStatus
 */
class Challenge extends AppModel {
	
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'complete_by' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter a complete by date',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created_on' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ChallengeFrom' => array(
			'className' => 'User',
			'foreignKey' => 'challenge_from_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		'Goal' => array(
			'className' => 'Game',
			'foreignKey' => 'goal_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
	public $hasMany = array(
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'challenge_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
 */

/**
 * hasAndBelongsToMany associations
 *
 * @var array
	public $hasAndBelongsToMany = array(
		'UserGameStatus' => array(
			'className' => 'UserGameStatus',
			'joinTable' => 'challenges_user_game_statuses',
			'foreignKey' => 'challenge_id',
			'associationForeignKey' => 'user_game_status_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
 */

}
