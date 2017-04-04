<?php 
class AlliesController extends AppController{
	
	public $paginate = array(
		'limit'		=> 25,
		'contain'	=> false
	);
	
	/*
	 * Ally Status
	 *  0 : Sent Ally request, but not approved
	 *  1 : Request Sent and approved
	 * -1 : Blocked User
	 */
	public function allies() {
		$current_allies = $this->Ally->find('all', array(
									'contain' => array('MyAlly', 'UserGameStatus'),
									'conditions' => array('Ally.user_id' => $this->Session->read('ActiveGame.user_id'),
														  'Ally.status != -1')));
		$allies_of = $this->Ally->find('all', array(
									'contain' => array('User', 'UserGameStatus'),
									'conditions' => array('Ally.ally' => $this->Session->read('ActiveGame.user_id'),
														  'Ally.status != -1')));
		/*
		$this->Ally->updateAll(array('Ally.ally_notification' => ''),
							   array('Ally.ally_notification' => 'Requested', 
							   		 'Ally.user_id' => $this->Session->read('ActiveGame.user_id')));
		
		$this->Ally->updateAll(array('Ally.ally_notification' => ''),
							   array('Ally.ally_notification' => 'Accepted',
									 'Ally.ally' => $this->Session->read('ActiveGame.user_id')));
		*/
		
		$this->set('current_allies', $current_allies);
		$this->set('allies_of', $allies_of);
		
		if(isset($this->request->params['requested']) && $this->request->params['requested']) {
			return $current_allies;
		}
	}
	
	public function allies_list($action) {
		$searchText = $this->request->data['search'];
		$users 		= array();
		$message	= '';
		
		if(!empty($searchText)) {
			
			if($searchText == $this->Auth->User('email') || $searchText == $this->Auth->User('name')) {
				$message = 'This is you. Please add your friends as ally.';
				
			} else {
				
				$options['fields']		= array('Ally.ally', 'Ally.ally_email');
				$options['conditions']  = array('OR' => 
											array('Ally.user_id' => $this->Session->read('ActiveGame.user_id'),
												  'AND' => array('Ally.ally' => $this->Session->read('ActiveGame.user_id'),
																 'Ally.status' => -1)));
				$allies = $this->Ally->find('list', $options);
				
				if(!empty($allies)) {
					$allies = array('User.email NOT' => $allies);
				}

				$options['contain']		= false;
				$options['fields']		= array('User.id', 'User.name', 'User.city', 'User.email', 'User.slug');
				$options['conditions']  = array(
							'OR' => array('User.email LIKE' => '%' . $searchText . '%', 'User.name LIKE' => '%' . $searchText . '%'),
							'User.id !=' => $this->Session->read('ActiveGame.user_id'), $allies);
					
				$users = $this->Ally->User->find('all', $options);
			}
			
		}
		
		$this->set('message', $message);
		$this->set('answers', $users);
	}
	
	public function request_action($action, $id) {
		
		$this->loadModel('Feedback');
		$this->autoRender = false;
		if($action == 'delete') {
			$user_id = $this->Ally->field('ally', array('Ally.id' => $id));
			
			if($this->Ally->delete($id, true)) {
			
				$condition = array('Feedback.user_id' => $user_id, 'Feedback.user_game_status_id' => $this->Session->read('ActiveGame.id'));
				$this->Feedback->deleteAll($condition, false);
				$return['success']   = 1;
				$return['condition'] = 'delete';
				$return['id']		 = $id;
				
			} else {
				$return['success'] = 0;
			}
			
		} elseif($action == 'accept') {
			$ally = array('id' => $id, 'status' => 1, 'ally_notification' => 'Accepted');
			
			if($this->Ally->save($ally)) {
				$return['success'] 	 = 1;
				$return['condition'] = 'accept';
				$return['id']		 = $id;
				
			} else {
				$return['success'] = 0;
			}
			
		} elseif($action == 'block') {
			$ally = array('id' => $id, 'status' => -1, 'ally_notification' => '', 'feedback_notification' => '');
				
			if($this->Ally->save($ally)) {
				$return['success'] 	 = 1;
				$return['condition'] = 'block';
				$return['id']		 = $id;
			
			} else {
				$return['success'] = 0;
			}
		}
		
		return(json_encode($return));
	}

	/*2014-10-29, Badri
	 * Allies Notification
	 * 'ally_notification' : 0 => no notification
	 * 					   : 1 => notification for user
	 * 					   : 2 => notification for ally	
	 */
	
	public function request($user_id = null) {
		if($this->request->is('post')) {
			debug($this->request->data);
			debug($this->request->query);
			exit;
			$this->request->data['Ally']['status'] 				= 0;
			$this->request->data['Ally']['ally_notification'] 	= 'Requested';
			$this->request->data['Ally']['user_id']				= $this->Session->read('ActiveGame.user_id');
			
			$data = $this->request->data;
			$exists = $this->Ally->find('first', array('conditions' => array('Ally.user_id' => $this->request->data['Ally']['user_id'],
																 	 		 'Ally.ally_email' => $this->request->data['Ally']['ally_email'])));
			if(empty($exists)) {
				$this->Ally->create();
				if($this->Ally->save($this->request->data['Ally'])){
					$this->autoRender = false;
					$options = array(
							'subject' 	=> $this->Session->read('Company.name') . ' : ' . $this->Auth->User('name') . ' wants to add you as an ally',
							'template' 	=> 'ally_request',
							'to'		=>  $this->request->data['Ally']['ally_email']
					);
					$this->request->data['Ally']['user_email'] = $this->Auth->User('email');
					$data['name'] = $this->Auth->User('name');
					$data['roadmap'] = $this->Session->read('ActiveGame.roadmap');
					
					$this->_sendEmail($options, $data);
				}
				
			} else {
				$this->autoRender = false;
				if($exists['Ally']['status'] == 0) {}
				
			}
			$this->Session->setFlash('Congratulations! Allies Request Sent');
			$this->redirect(array('controller' => 'allies', 'action' => 'allies'));
		}
		if(!empty($user_id)) {
			$options['contain'] 	= false;
			$options['conditions']	= array('User.id' => $user_id);
			$ally = $this->Ally->User->find('first', $options);

			$options['fields'] 		= array('UserGameStatus.id', 'UserGameStatus.roadmap');
			$options['conditions'] 	= array('UserGameStatus.user_id' => $this->Session->read('ActiveGame.user_id'));
			$user_game_status_id = $this->Ally->UserGameStatus->find('list', $options);
			
			$this->set('user_game_status_id', $user_game_status_id);
		}
		
		$this->set('ally', $ally);
	}

	public function invite() {
		$email = $this->request->data['email'];
		if(!empty($email)) {
			$user_exists = $this->Ally->User->field('email',array('User.email'=> $email));
			if($user_exists == false){
				$ally = $this->Ally->User->find('first', array(
						'contain'	 => false,
						'conditions' => array('User.email' => $email)));
					
				if(empty($ally)) {
					$ally['User']['id'] = '';
					$ally['User']['name'] = '';
					$ally['User']['city'] = '';
					$ally['User']['email'] = $email;
				}
				$this->set('ally', $ally);
				$this->render('request');
			}else{
				$this->Session->setFlash('This User has already registered with ' . $this->Session->read('Company.name') . '. Please Search again.');
				$this->redirect(array('controller' => 'allies', 'action' => 'allies'));
			}
		}
	}

	public function ally_detail($id) {
		return $this->Ally->User->find('first', array(
												'contain'	 => false,
												'conditions' => array('User.id' => $id)));
	}
	
	public function notification($field, $id) {
		$this->autoRender = false;
		$this->Ally->id = $id;
		$this->Ally->saveField($field, null);
	}
	
	public function notify_ally() {
		$this->autoRender = false;
		
		$summary_items 	= $this->requestAction(array('controller' => 'games', 'action' => 'summary', 'summary', 181));
		$data['answers'] = $summary_items;
		
		$allies = $this->Ally->find('all', array(
				'contain' => array('MyAlly'),
				'conditions' => array(
						'Ally.user_id' => $this->Session->read('ActiveGame.user_id'), 
						'Ally.user_game_status_id' => $this->Session->read('ActiveGame.id'))));
		
		foreach($allies as $ally) {
			$data['Ally'] = $ally;
			$options = array(
					'subject' 	=> 'Human Catalyst 100 : ' . $this->Auth->User('name') . ' wants you to help',
					'template' 	=> 'notify_ally',
					'from'		=> $this->Auth->User('email'),
					'to'		=> $ally['MyAlly']['email']
			);
			$this->_sendEmail($options, $data);
		}
		$return['success'] = 1;
		return json_encode($return);
	}
}
?>