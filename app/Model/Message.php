<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property Challenge $Challenge
 * @property Message $ParentMessage
 * @property Message $ChildMessage
 */
class Message extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'message';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'message' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
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
		'Challenge' => array(
			'className' => 'Challenge',
			'foreignKey' => 'challenge_id',
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
		),
				
		/* 'ParentMessage' => array(
			'className' => 'Message',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		) */
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		/* 'ChildMessage' => array(
			'className' => 'Message',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		) */
	);

}
