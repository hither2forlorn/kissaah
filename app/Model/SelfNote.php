<?php
App::uses('AppModel', 'Model');
/**
 * SelfNote Model
 *
 * @property UserGameStatus $UserGameStatus
 * @property User $User
 */
class SelfNote extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'text';

	public $actsAs = array('Containable');
	
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'UserGameStatus' => array(
			'className' => 'UserGameStatus',
			'foreignKey' => 'user_game_status_id',
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
	
	public function beforeFind($queryData) {
		$queryData['conditions'][$this->alias.'.user_id'] = CakeSession::read('ActiveGame.user_id'); //AuthComponent::user('id');
		$queryData['conditions'][$this->alias.'.user_game_status_id'] = CakeSession::read('ActiveGame.id');
		return $queryData;
	}

	public function beforeSave($options = array()) {
		$this->data[$this->alias]['user_id'] = CakeSession::read('ActiveGame.user_id');
		$this->data[$this->alias]['user_game_status_id'] = CakeSession::read('ActiveGame.id');
		return true;
    }
}
