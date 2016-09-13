<?php
App::uses('Security', 'Utility', 'Sanitize');

Class User extends AppModel {
	
	public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false), 'Containable');
	
	var $validate = array(
		'name' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'No larger than 50 characters long'),
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide your full name.')
		),
		/* 'username' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 20),
				'message' => 'No larger than 20 characters long'),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'Oops that username has already been taken.'),
		), */
		'password' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter the password'),
			'lengthRule' 	=> array(
	 			'rule'		=> array('minLength', 6),
				'last'		=> true,
				'message' 	=> 'Password has to be at least 6 characters.'),
		),
		'confirmpassword'  => array(
			'requiredRule'	=> array(
				'rule'		=> 'notEmpty',
				'last'		=> true,
 				'message'	=> 'Please enter confirm password.'),
	 		'lengthRule' 	=> array(
	 			'rule'		=> array('minLength', 6),
				'last'		=> true,
				'message' 	=> 'Password has to be at least 6 characters.'),
	 		'confirmRule'	=> array(
				'rule'		=> 'confirmPassword',
 				'message'	=> 'Password and confirm password don\'t match.')
		),
		'email' => array(
			'email' => array(
				'rule' 		=> array('email'),
				'allowEmpty'=> false,
				'message' 	=> 'Not a valid e-mail address.'),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'This email is already registered.'),
		),
		'city' => array(
				'notempty' => array(
						'rule' => 'notEmpty',
						'message' => 'Please provide your city.')
		),
		'country' => array(
				'notempty' => array(
						'rule' => 'notEmpty',
						'message' => 'Please provide your country.')
		),
		'gender' => array(
				'notempty' => array(
						'rule' => 'notEmpty',
						'message' => 'Please provide your gender.')
		),
		'dob' => array(
				'notempty' => array(
						'rule' => 'notEmpty',
						'message' => 'Please provide your date of birth.')
		),
	);
	
	public $hasMany = array(
		'Ally' => array(
			'className'  => 'Ally',
			'foreignKey' => 'user_id',
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
			'foreignKey' => 'user_id',
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
			'foreignKey' => 'user_id',
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
			'foreignKey' => 'user_id',
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
		'UserGameStatus' => array(
			'className' => 'UserGameStatus',
			'foreignKey' => 'user_id',
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
		'Challenge' => array(
			'className' => 'Challenge',
			'foreignKey' => 'user_id',
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
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'user_id',
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
	
	var $belongsTo = array(
		'Role' => array(
			'className' 	=> 'Role',
			'foreignKey'	=> 'role_id'
		)
	);
	
	var $hasAndBelongsToMany = array(
		'CompanyGroup' => array(
			'className' => 'CompanyGroup',
			'joinTable' => 'company_groups_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'company_group_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with' => ''
		)
	);
	
	function beforeValidate($options = Array()){
		return true;
	}
	
	function beforeSave($options = Array()){
		if(!($this->id))
			$this->data[$this->alias]['created_date'] = date('Y:m:d h:i:s');
		if(isset($this->data[$this->alias]['password'])){
			$this->_beforeRegistration();
			$this->data[$this->alias]['password'] = $this->hash($this->data[$this->alias]['password']);
		}
		/* if(isset($this->data[$this->alias]['name'])){
			$this->data[$this->alias]['name'] = Sanitize::html($this->data[$this->alias]['name'],array('remove' => true));
		} */
		return true;
	}
	
	public function verifyEmail($token = null) {
		$user = $this->find('first', array(
			'contain' => array(),
			'conditions' => array(
				$this->alias . '.email_verified' => 0,
				$this->alias . '.email_token' => $token),
			'fields' => array(
				'id', 'email', 'email_token_expires', 'role')));

		if (empty($user)) {
			throw new RuntimeException(__d('users', 'Invalid token, please check the email you were sent, and retry the verification link.'));
		}

		$expires = strtotime($user[$this->alias]['email_token_expires']);
		if ($expires < time()) {
			throw new RuntimeException(__d('users', 'The token has expired.'));
		}

		$data[$this->alias]['active'] = 1;
		$user[$this->alias]['email_verified'] = 1;
		$user[$this->alias]['email_token'] = null;
		$user[$this->alias]['email_token_expires'] = null;

		$user = $this->save($user, array(
			'validate' => false,
			'callbacks' => false));
		$this->data = $user;
		return $user;
	}
	
	public function validateToken($token = null, $reset = false, $now = null) {
		if (!$now) {
			$now = time();
		}

		$data = false;
		$match = $this->find('first', array(
			'contain' => array(),
			'conditions' => array(
				$this->alias . '.email_token' => $token),
			'fields' => array(
				'id', 'email', 'email_token_expires', 'role')));

		if (!empty($match)) {
			$expires = strtotime($match[$this->alias]['email_token_expires']);
			if ($expires > $now) {
				$data[$this->alias]['id'] = $match[$this->alias]['id'];
				$data[$this->alias]['email'] = $match[$this->alias]['email'];
				$data[$this->alias]['email_verified'] = '1';
				$data[$this->alias]['role'] = $match[$this->alias]['role'];

				if ($reset === true) {
					$newPassword = $this->generatePassword();
					$data[$this->alias]['password'] = $this->hash($newPassword, null, true);
					$data[$this->alias]['new_password'] = $newPassword;
					$data[$this->alias]['password_token'] = null;
				}

				$data[$this->alias]['email_token'] = null;
				$data[$this->alias]['email_token_expires'] = null;
			}
		}

		return $data;
	}
	
	function confirmPassword() {
		return ($this->data[$this->alias]['password'] == $this->data[$this->alias]['confirmpassword'])? true : false;
	}

	public function hash($string, $type = null, $salt = true) {
		return Security::hash($string, $type, $salt);
	}
	
	protected function _beforeRegistration($postData = array()) {
		//$this->data[$this->alias]['email_token'] = $this->generateToken();
	}
	
	function register($data){
		$this->data = $this->_beforeRegistration();
		//$this->data[$this->alias]['email_token'] = $this->generateToken();
		//$this->data[$this->alias]['confirmpassword']= $this->hash($data[$this->alias]['confirmpassword']);
	}
	
	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['role_id'])) {
			$roleId = $this->data['User']['role_id'];
		} else {
			$roleId = $this->field('role_id');
		}
		if (!$roleId) {
			return null;
		} else {
			return array('Role' => array('id' => $roleId));
		}
	}
	
	public function bindNode($user) {
	    return array('model' => 'Role', 'foreign_key' => $user['User']['role_id']);
	}
}