<?php
App::uses('AppController', 'Controller');
/**
 * Challenges Controller
 *
 * @property Challenge $Challenge
 * @property PaginatorComponent $Paginator
 */

class ChallengesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function menu() {
		$options['conditions'] = array('Challenge.status' => 'New', 'Challenge.user_id' => $this->Auth->user('id'));
		$new = $this->Challenge->find('count', $options);

		$options['conditions'] = array('Challenge.notification' => 1, 'Challenge.user_id' => $this->Auth->user('id'));
		$myself = $this->Challenge->find('count', $options);

		$options['conditions'] = array('Challenge.notification' => 2, 'Challenge.challenge_from_id' => $this->Auth->user('id'));
		$ally = $this->Challenge->find('count', $options);
		
		$this->set('new', $new);
		$this->set('myself', $myself);
		$this->set('ally', $ally);
	}
	
/*
 * INSERT INTO `kissaah_game`.`dev_challenges_user_game_statuses` (`id`, `challenge_id`, `user_game_status_id`, `modified`, `created`) VALUES (NULL, '3', '1184', '2015-04-06', '2015-04-06');
 * INSERT INTO `kissaah_game`.`dev_challenges_user_game_statuses` (`id`, `challenge_id`, `user_game_status_id`, `modified`, `created`) VALUES (NULL, '3', '1417', '2015-04-06', '2015-04-06');
 * INSERT INTO `kissaah_game`.`dev_challenges_user_game_statuses` (`id`, `challenge_id`, `user_game_status_id`, `modified`, `created`) VALUES (NULL, '3', '1418', '2015-04-06', '2015-04-06');
 */
	
	public function challenges($status) {
		$options['contain'] = array('User', 'Message');
		//$options['limit'] = 4;
		$options['order'] = array('Challenge.complete_by DESC');
		
		if($status == 'new') {
			$options['conditions'] = array(	'Challenge.user_id' => $this->Auth->user('id'), 
											'Challenge.status' => 'New');
		} elseif($status == 'myself') {
			$options['conditions'] = array( 'Challenge.user_id' => $this->Auth->user('id'), 
											'Challenge.status !=' => 'New');
		} else {
			$options['conditions'] = array( 'Challenge.challenge_from_id' => $this->Auth->user('id'),
											'Challenge.user_id !=' => $this->Auth->user('id'));
		}
		
		$challenges = $this->Challenge->find('all', $options);
		
		foreach($challenges as $key => $challenge) {
			$options = array();
			if($challenge['Challenge']['challenge_from_id'] != $challenge['Challenge']['user_id']
				&& $challenge['Challenge']['challenge_from_id'] != $this->Auth->user('id')) {
					
				$options['contain'] = false;
				$options['conditions'] = array('User.id' => $challenge['Challenge']['challenge_from_id']);
				$challenge_from = $this->Challenge->User->find('first', $options);
				
			} else {
				$challenge_from = $this->Session->read('Auth');
				
			}
			$challenges[$key]['ChallengeFrom'] = $challenge_from['User'];
		}
		
		$this->set('challenges', $challenges);
	}
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null, $view = 'view') {
		if (!$this->Challenge->exists($id)) {
			throw new NotFoundException(__('Invalid value strength category'));
		}
		
		$options['conditions'] = array('Challenge.' . $this->Challenge->primaryKey => $id);
		$challenge = $this->Challenge->find('first', $options);
		
		if($challenge['Challenge']['challenge_from_id'] != $challenge['Challenge']['user_id'] 
			&& $challenge['Challenge']['challenge_from_id'] != $this->Auth->user('id')) {
			
			$options['contain'] 	= false;
			$options['conditions'] 	= array('User.id' => $challenge['Challenge']['challenge_from_id']);
			$challenge_from 		= $this->Challenge->User->find('first', $options);
		} else {
			$challenge_from = $this->Session->read('Auth');
		}
		$challenge['ChallengeFrom'] = $challenge_from['User'];
		
		if($view == 'challenge_road_map') {
			$options['fields'] 		= array('UserGameStatus.id', 'UserGameStatus.roadmap');
			$options['conditions'] 	= array('UserGameStatus.user_id' => $this->Auth->user('id'));
			$road_maps 				= $this->Challenge->UserGameStatus->find('list', $options);
			
			$this->set('road_maps', $road_maps);
		}
		
		if($challenge['Challenge']['user_id'] == $this->Auth->user('id')) {
			if($challenge['Challenge']['status'] == 'Created' || $challenge['Challenge']['status'] == 'Accepted') {
				$this->Challenge->id = $challenge['Challenge']['id'];
				$this->Challenge->saveField('status', 'Active', false);
				
			} elseif(in_array($challenge['Challenge']['action_status'], array('Extension Approved', 'Extension Unapproved'))) {
				$this->Challenge->id = $challenge['Challenge']['id'];
				//$this->Challenge->saveField('action_status', '', false);
				
			}
			
		} else {
			if($challenge['Challenge']['status'] == 'Created') {
				$this->Challenge->id = $challenge['Challenge']['id'];
				$this->Challenge->saveField('status', 'New', false);
				
			}
		}
		
		//debug($challenge);
		$this->set('challenge', $challenge);
		$this->render($view);
	}
		
	public function accept($id) {
		$this->autoRender = false;
		
		if (!$this->Challenge->exists($id)) {
			throw new NotFoundException(__('Invalid value strength category'));
		}
		
		$this->Challenge->id = $id;
		$this->Challenge->saveField('status', 'Accepted', false);
		$this->redirect(array('controller' => 'challenges', 'action' => 'view', $id));
	}
	
	public function set_challenge() {
		if(($this->request->is('put') || $this->request->is('post'))) {
			$this->autoRender = false;
			
			if(empty($this->request->data['Challenge']['complete_by'])) {
				unset($this->request->data['Challenge']['complete_by']);
				$return['complete_by'] = '';
			} else {
				$this->request->data['Challenge']['complete_by'] = date('Y-m-d' , strtotime($this->request->data['Challenge']['complete_by']));
				$return['complete_by'] = $this->request->data['Challenge']['complete_by'];
			}
			if(isset($this->request->data['Challenge']['new_complete_by'])) {
				$this->request->data['Challenge']['new_complete_by'] = date('Y-m-d' , strtotime($this->request->data['Challenge']['new_complete_by']));
			}
			if(isset($this->request->data['Challenge']['action_status']) && $this->request->data['Challenge']['action_status'] == 'Extension Approved') {
				$this->request->data['Challenge']['complete_by'] = $this->request->data['Challenge']['new_complete_by'];
			}
			if(empty($this->request->data['Challenge']['id'])) {
				$this->request->data['Challenge']['created_on'] = date('Y-m-d');
				$this->request->data['Challenge']['status'] 	= 'Created';
			}
			
			if(isset($this->request->data['UserGameStatus'])) {
				$usergamestatus = $this->request->data['UserGameStatus'];
				$usergame = array();
					
				foreach($usergamestatus as $id => $value) {
					if($value) {
						$usergame[] = $id;
					}
				}
				$this->request->data['UserGameStatus'] = $usergame;
			}
			
			if($this->Challenge->saveAll($this->request->data)) {
				$return['goal_id'] 	= $this->request->data['Challenge']['goal_id'];
				$return['success'] 	= 1;
				$return['id'] 		= $this->Challenge->id;
				$return['link'] 	= Router::url(array('controller' => 'challenges', 'action' => 'view', $return['id']), true);
				
			} else {
				//debug($this->Challenge->validationErrors);
				$return['success'] = 0;
			}
			if ($this->request->is('ajax')) {
				return json_encode($return);		
			} else {
				$this->redirect($this->referer());
			}
		}
		$options['fields'] = array('UserGameStatus.id', 'UserGameStatus.roadmap');
		$options['conditions'] = array('UserGameStatus.user_id' => $this->Auth->user('id'));
		$road_maps = $this->Challenge->UserGameStatus->find('list', $options);
		$this->set('road_maps', $road_maps);
	}

	public function set_challenge_user($action = 'add', $challenge, $user) {
		$this->autoRender = false;
		$this->request->data['ChallengesUser']['challenge_id'] = $challenge;
		$this->request->data['ChallengesUser']['user_id'] = $user;
		
		if($action == 'delete') {
			$options = array('ChallengesUser.challenge_id' => $challenge, 'ChallengesUser.user_id' => $user);
			if($this->Challenge->ChallengesUser->deleteAll($options)) {
				return Router::url(array('action' => 'set_challenge_user', 'add'), true);
			}
		} else {
			if($this->Challenge->ChallengesUser->save($this->request->data)) {
				return Router::url(array('action' => 'set_challenge_user', 'delete'), true);
			}
		}

		return false;
	}
	
	public function get_challenge_user($challenge) {
		$this->autoRender = false;
		$this->request->data['ChallengesUser']['challenge_id'] = $challenge;
		
		$options['condition'] = array('ChallengesUser.challenge_id' => $challenge);
		$challenge = $this->Challenge->ChallengesUser->find('all', $options);
		
		return $challenge;
	}
	
	public function typeahead_allies() {
		$this->autoRender = false;
		$query = $this->request->query['query'];
		$this->loadModel('Ally');
		
		$options['conditions'] = array('Ally.user_id' => $this->Auth->user('id'));
		$options['fields'] = array('Ally.id', 'Ally.ally');
		$ally = $this->Ally->find('list', $options);
		
		$options = array();
		$options['contain'] = array('UserGameStatus');
		$options['conditions'] = array('User.name LIKE' => '%' . $query . '%', 'User.id' => $ally);
		$users = $this->Challenge->User->find('all', $options);
		
		$results = array();
		
		foreach($users as $user) {
			$image = (empty($user['User']['slug']))? '/../../img/profile.png': '/../../files/img/medium/' . $user['User']['slug'];
			$results[] = array(
					'id'	=> $user['User']['id'],
					'name'	=> $user['User']['name'],
					'img' 	=> Router::url(null, true) . $image,
					'email'	=> $user['User']['email'],
					'usergamestatus' => $user['UserGameStatus']
			);
		}
		echo json_encode($results);
	}
	
	public function view_stats($status = 'myself') {
		$options['contain'] 	= false;
		$options['fields'] 		= array('Challenge.status', 'COUNT(Challenge.status) AS stats');
		$options['group'] 		= array('Challenge.status');
		$options['conditions'] 	= array('Challenge.user_id' => $this->Auth->user('id'));
		
		$stats = $this->Challenge->find('all', $options);
		$this->set('stats', $stats);
	}
	
	public function goal($goal_id) {
		$options['conditions'] = array('Challenge.goal_id' => $goal_id);
		$goal = $this->Challenge->find('first', $options);
		
		if(!empty($goal) && $goal['Challenge']['challenge_from_id'] != $this->Session->read('Auth.User.id')) {
			$this->loadModel('Game');
			$options['conditions'] = array('Game.answer' => $goal['Challenge']['challenge_from_id']);
			$game = $this->Game->field('configuration_id', $options['conditions']);
			
			$this->loadModel('Configuration');
			$this->Configuration->id = $game;
			$goal['Challenge']['goal'] = $this->Configuration->field('title');
		}
		
		return $goal;
	}
	
	public function calendar() {
		if($this->request->is('ajax')) {
			if(isset($this->request->query['start']) && isset($this->request->query['end'])) {
				$this->autoRender = false;
				
				$options['conditions'] = array(
					'OR' => array('Challenge.complete_by BETWEEN ? AND ?' => array($this->request->query['start'], $this->request->query['end'])),
					'OR' => array('Challenge.challenge_from_id' => $this->Auth->User('id'), 'Challenge.user_id' => $this->Auth->User('id'))
				);
				
				$calendar = array();
				$challenges = $this->Challenge->find('all', $options);
				
				foreach($challenges as $key => $value) {
					$background = '#17B2E8';
					if($value['Challenge']['status'] == 'Completed') {
						$background = '#F68E20';
					}
					$calendar[] = array(
									'title' 	=> $value['Challenge']['name'],
									'start'		=> date('m/d/Y', strtotime($value['Challenge']['complete_by'])),
									'allDay'	=> true,
									'backgroundColor' 	=> $background,
									'borderColor'		=> $background
					);
				}
				
				//debug($calendar);
				return json_encode($calendar);
			}
		}
	}
}