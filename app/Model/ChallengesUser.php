<?php
App::uses ( 'AppModel', 'Model' );
/**
 * ChallengesUser Model
 *
 * @property Challenge $Challenge
 * @property User $User
 */
class ChallengesUser extends AppModel {
	public $actsAs = array (
			'Containable' 
	);
	
	// The Associations below have been created with all possible keys, those that are not needed can be removed
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array (
			'Challenge' => array (
					'className' => 'Challenge',
					'foreignKey' => 'challenge_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			),
			'User' => array (
					'className' => 'User',
					'foreignKey' => 'user_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			),
			'Ally' => array (
					'className' => 'Ally',
					'foreignKey' => 'ally_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			) 
	);
}
