<?php 
App::uses('AppController', 'Controller');
App::uses('String', 'Utility');
App::import('Vendor', 'Uploader.Uploader');
App::import('Vendor', 'Unirest', array('file' => 'Unirest/lib/Unirest.php'));

class GamesController extends AppController {
	
	public $uses = array('Configuration', 'Game', 'UserGameStatus');
	public $helpers = array('Render');
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Uploader = new Uploader();
		$this->Uploader->setup(array('tempDir' => TMP));
	}
	
/**
 * Index of the Game which will show the game board
 * Also returns the completed steps information
 *
 * @return null
 * @access public
 */
	public function index() {
		$this->Session->write('Narration', 1);
		$options['conditions'] = array( 'OR' => array('Ally.user_id' => $this->Session->read('Auth.User.id'),
													  'Ally.ally' => $this->Session->read('Auth.User.id')),
										'Ally.ally_notification IS NOT NULL');
		$allies_notification = $this->Game->User->Ally->find('all', $options);
		
		$options['conditions'] = array( 'Ally.user_id' => $this->Session->read('Auth.User.id'),
										'Ally.feedback_notification IS NOT NULL');
		$feedback_notification = $this->Game->User->Ally->find('all', $options);		
		
		$this->Session->write('allies_notification', $allies_notification);
		$this->Session->write('feedback_notification', $feedback_notification);
		
		$configuration_id = $this->Session->read('ActiveGame.configuration_id');
		if(is_null($configuration_id) || $configuration_id == '') {
			$configuration_id = 81;
		}
		$vision = $this->Configuration->children($configuration_id, true);
		$this->Session->write('Vision', $vision);
		
		$featured = $this->Session->read('Configuration.featured');
		if($featured == false) {
			$this->redirect(array('action' => 'game_step', '?' => array('st' => $vision[0]['Configuration']['id'])));
		}

		foreach($vision as $key => $value) {
			if($value['Configuration']['status']) {
				$vision[$key]['Configuration']['step-complete'] = $this->step_complete($value['Configuration']['id']);
				if($vision[$key]['Configuration']['step-complete'] != 0) {
					$this->Session->write('Narration', 0);
				}
				
				if($value['Configuration']['id'] == 187 && $vision[$key]['Configuration']['step-complete'] == 0) {
					$this->Session->write('Current.game_step', $value['Configuration']['id']); 
				}
				
			} else {
				unset($vision[$key]);
			}
			
			$steps = $this->Configuration->children($value['Configuration']['id']);
			foreach($steps as $step) {
				//if(!in_array($step['Configuration']['type'], array(0, 4, 6, 12, 13))) {
				if($step['Configuration']['featured']) {
					$vision[$key]['Steps'][$step['Configuration']['id']] =  
									$this->Game->find('first', array('contain' => false, 
																	 'conditions' => array('configuration_id' => $step['Configuration']['id'])));
					$vision[$key]['Steps'][$step['Configuration']['id']]['Configuration'] = $step['Configuration'];
				}
			}
		}

		$this->set(compact('vision'));
	}
	
	/**
	* Returns the 
	*
	* @return string
	* @access public
	*/
	public function game_step() {
		$configuration_id = $this->Session->read('ActiveGame.configuration_id');
		$id = isset($this->request->query['st'])? $this->request->query['st'] : $configuration_id;
		if($this->Session->check('Current.game_step')) {
			$this->Session->delete('Current.game_step');
		}
		
		if($this->request->is('ajax')) {
			$step_information = $this->Game->Configuration->findById($id);
			
			$childrens = $this->Game->Configuration->children($id);
			$game_step = array();
			foreach ($childrens as $a){
				$game_step[$a['Configuration']['parent_id']][] = $a;
			}
			
			$parent['Configuration']['id'] 		= $id;
			$parent['Configuration']['type'] 	= 0;
			$games = $this->__createTree($game_step, array($parent));
			
			$this->set(compact('games', 'step_information'));
			
		} else {
			$this->Session->write('Current.game_step', $id);
			
			$step_information = $this->Game->Configuration->findById($id);
				
			$childrens = $this->Game->Configuration->children($id);
			$game_step = array();
			foreach ($childrens as $a){
				$game_step[$a['Configuration']['parent_id']][] = $a;
			}

			$parent['Configuration']['id'] 		= $id;
			$parent['Configuration']['type'] 	= 0;
			$games = $this->__createTree($game_step, array($parent));

			$this->set(compact('games', 'step_information'));
		}
	}
	
 	public function summary($display = 'summary', $id = null, $road_map = 'current') {
 		if(is_null($id)) {
 			$tree_list = $this->Game->Configuration->generateTreeList(array('Configuration.status' => '1', 'Configuration.type' => 0));
 		} else {
 			$tree_list[$id] = '';
 		}
 		
 		$step_games = array();
 		foreach($tree_list as $key => $value) {
 			$childrens = $this->Game->Configuration->children($key);
 			$game_step = array();
 			foreach ($childrens as $a){
 				if($a['Configuration']['status']) {
 					$game_step[$a['Configuration']['parent_id']][] = $a;
 				}
 			}
 			
 			$parent['Configuration']['id'] 		= $key;
 			$parent['Configuration']['type'] 	= 0;
 			if($this->request->is('requested')) {
 				$step_games = $this->__createTree($game_step, array($parent));
 			} else {
 				$step_games[$key] = $this->__createTree($game_step, array($parent));
 			}
 		}
 		
 		if($this->request->is('requested')) {
 			return $step_games;
 		} else {
	 		$this->set(compact('step_games'));
 		}
 		
 		if($display == 'export') {
 			$this->render('export_to_word');
 		}
 	}
 	
	public function spark_board() {
		$this->Session->write('Game.query_all', 1);

		$options['contain'] = array('Challenge' => array('ChallengesUser' => array('User')));
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 59);
		$development = $this->Game->find('all', $options);
		
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 118);
		$exposure = $this->Game->find('all', $options);
		
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 185);
		$connection = $this->Game->find('all', $options);

		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 111);
		$next = $this->Game->find('all', $options);
		
		$this->set(compact('development', 'exposure', 'connection', 'next'));
		$this->Session->write('Game.query_all', 0);
	}
	
	public function summary_spark_board() {
		$this->Session->write('Game.query_all', 1);
		
		$options['contain'] = array('Challenge', 'User');
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 59);
		$development = $this->Game->find('all', $options);
		
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 118);
		$exposure = $this->Game->find('all', $options);
		
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 185);
		$connection = $this->Game->find('all', $options);
		
		$options['contain'] = false;
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 194);
		$purpose = $this->Game->find('all', $options);
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 200);
		$aspiration = $this->Game->find('all', $options);
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 176);
		$give_strength = $this->Game->find('all', $options);
		$options['conditions'] = array('Game.user_id' => $this->Session->read('ActiveGame.user_id'), 'configuration_id' => 179);
		$ask_strength = $this->Game->find('all', $options);
		
		$this->set(compact('development', 'exposure', 'connection', 'give_strength', 'ask_strength', 'purpose', 'aspiration'));
		$this->Session->write('Game.query_all', 0);
	}
	
	public function __createTree(&$list, $parent){
		$tree = array();
		foreach ($parent as $k => $l){
			if(!empty($l['Configuration']['dependent_id']) && $l['Configuration']['dependent_id'] > 0) {
				$dependent = $this->Game->findAllByConfigurationId($l['Configuration']['dependent_id']);
				foreach($dependent as $dept) {
					$dept['Game']['type'] = $dept['Configuration']['type'];
					$l['DependentConf'] = $dept['Configuration'];
					$l['Dependent'][] = $dept['Game'];
				}
			}
			if(!in_array($l['Configuration']['type'], array(0, 4, 6, 13))) {
				$game = $this->Game->find('all', array('contain' => false, 'conditions' => array('Game.configuration_id' => $l['Configuration']['id'])));
				$l['Game'] = $game;
			}
			if(isset($list[$l['Configuration']['id']])){
				$l['children'] = $this->__createTree($list, $list[$l['Configuration']['id']]);
			}
			$tree[$l['Configuration']['id']] = $l;
		}
		return $tree;
	}
	
	public function step_complete($step_id = null) {
		if($this->request->is('ajax')){
			$this->autoRender = false;
			$step_id = $this->request->data;
		}
		
		$step_complete = 0;
		if(!is_null($step_id)) {
			$steps = $this->Game->Configuration->children($step_id);
			$step_complete = 2;
			$step_ids = array();
			foreach($steps as $step) {
				if(!in_array($step['Configuration']['type'], array(0, 3, 4, 6, 12, 13, 14, 15, 16)) 
						&& $step['Configuration']['status'] && is_null($step['Configuration']['dependent_id'])) {
					$step_ids[] = $step['Configuration']['id'];
				}
			}
			
			$step_answer_count = $this->Game->find('count', array('conditions' => array('Game.configuration_id' => $step_ids, 'Game.answer NOT' => '')));
			
			if($step_answer_count === 0) {
				$step_complete = 0; //No Answers
			} elseif ($step_answer_count < count($step_ids)) {
				$step_complete = 1; //At least one Answer
			} elseif ($step_answer_count >= count($step_ids)) {
				$step_complete = 2; //All Answered
			}
		}
		return $step_complete;
	}
		
	//2014-5-22,#8511,Badri added this function
	//This function takes configuration_id as parameter and deletes the image associated with that id.
	public function remove_image($id = null){
		$this->autoRender = false;
		
		$data = $this->Game->find('first', array(
							'conditions' => array('Game.configuration_id' => $id)));
		
		$return['success'] 	= 0;
		$return['cid']		= $id;
		if(!empty($data)){
			$image = $data['Game']['answer'];
			$path = WWW_ROOT . 'files' . DS . 'img' . DS;
			if (file_exists($path.'large'.DS.$image)) {unlink($path.'large'.DS.$image);}
			if (file_exists($path.'medium'.DS.$image)) {unlink($path.'medium'.DS.$image);}
			if (file_exists($path.'small'.DS.$image)) {unlink($path.'small'.DS.$image);}
			if ($this->Game->delete($data['Game']['id'], true)){
				$dependent = $this->Game->find('all', array(
						'conditions' => array('Configuration.dependent_id' => $id)));
				foreach($dependent as $d){
					$this->Game->delete($d['Game']['id']);
				}
				$return['success'] = 1;
			};
		}
		echo json_encode($return);
	}
	
	/**
	* Initializes the view type for comments widget
	*
	* @return string
	* @access public
	*/
	function get_sortlist($sorting_type = null){
		$this->loadModel('ValueStrengthCategory');
		$conditions = array();
		if($sorting_type == 74) {
			$conditions = array('ValueStrengthCategory.type' => 'Values');
		} elseif($sorting_type == 77) {
			$conditions = array('ValueStrengthCategory.type' => 'Strengths');
		} else {
			$conditions = array();
		}
		$sortlist = $this->ValueStrengthCategory->find('list', array('conditions' => $conditions, 'order' => array('title')));
		return $sortlist;
		
	}
	
	public function invite_feedback() {
		$id = isset($this->request->query['st'])?$this->request->query['st']:$this->curLevel;
		$invite = isset($this->request->query['invite'])?$this->request->query['invite']:'';
		if(!empty($id) && !empty($invite)){
			if($invite == 'feedback'){
				$this->autoRender = false;
				return $this->offer($id);
			}
		}
	}
	
	public function save(){
		$this->autoRender = false;
		$this->Game->create();
		$data = $this->request->data;
		
		foreach($data['Game'] as $configure => $game) {
			$data['Game']['configuration_id'] = $configure;
			foreach($game as $id => $answer) {
				if($id != 0) { 
					$data['Game']['id'] = $id;
				}
				$data['Game']['answer'] = $answer;
			}
		}
		
		$data['Game']['user_id'] = $this->Session->read('ActiveGame.user_id');
		$data['Game']['user_game_status_id'] = $this->Session->read('ActiveGame.id');
		
		if(!isset($data['Game']['id']) && $data['Game']['answer'] == '') {
			$return['success'] = 0;
			
		} elseif(isset($data['Game']['id']) && ($data['Game']['answer'] == '' || $data['Game']['configuration_id'] == 0)) {
			$this->Game->id = $data['Game']['id'];
			if($this->Game->delete()) {
				$return['id'] = 0;
				$return['success'] = 1;
				$return['cid'] = $data['Game']['configuration_id'];
				
			} else {
				$return['success'] = 0;
			}
			
		} elseif($this->Game->save($data)) {
			$return['id'] = $this->Game->id;
			$return['success'] = 1;
			$return['cid'] = $data['Game']['configuration_id'];
		
		} else {
			$return['success'] = 0;
		}
		
		return json_encode($return);
	}
	
	public function save_rating($id, $rating){
		$this->autoRender = false;
		$this->Game->id = $id;
		$this->Game->saveField('rating', $rating);
		return str_replace('games/game_step', 'users/start_vision', $this->referer());
	}
	
	//2014-10-28, Badri
	// this function will populate dreampath titles from image paths captions if dreampath titles are empty
	function _saveDreamPaths($id , $d){
		$save = false;
		$data['Game']['user_id'] = $this->Session->read('ActiveGame.user_id');
		$data['Game']['user_game_status_id'] = $this->Session->read('ActiveGame.id');
		$configuration_id = array(	'101' => '105',
								'102' => '109',
								'103' => '58');
		$answer = $this->Game->find('first', array('contain' => false,
							'conditions' => array('Game.configuration_id' => $configuration_id[$id])));
		
		$data['Game']['configuration_id'] = $configuration_id[$id];
		
		if(empty($answer)) {
			$data['Game']['answer'] = $d;
			$save = true;
			
		} else if(($answer['Game']['answer']) == ''){
			$data['Game']['answer'] = $d;
			$data['Game']['id']		= $answer['Game']['id'];
			$save = true;
		}
		if($save == true){
			$this->Game->create();
			if($this->Game->save($data)){
				return true;
			} else {
				return false;
			}
		}
	}
	
	function uploadAll($id = null){
		$this->autoRender = false;
		$data = $this->request->data;
		foreach($data as $parent => $files) {
			$parent_id	= substr($parent, 5, strlen($parent));
			$configures = $this->Game->Configuration->children($parent_id);
			foreach($configures as $configure) {
				if($configure['Configuration']['type'] == 1) {
					$this->request->data = null;
					foreach($files['files'] as $id => $file) {
						if(empty($file)){
							unset($files['files'][$id]);
							$return[$id]['success'] = 0;
							$return[$id]['flash'] = 'Please select a valid image file';
						} else {
							$this->request->data['GameUpload'][$configure['Configuration']['id']] = $file;
							unset($files['files'][$id]);
							$return[] = json_decode($this->upload());
							break;
						}
					}
				}
			}
		}
		return json_encode($return);
	}
	
	function upload($type = 'image'){
		$this->autoRender = false;
		$this->Game->create();
		#Check the Session Data to match if it is valid or not then only save the data
		$data = $this->request->data;
		$saveto = 'Game';
		foreach($data as $id => $d) {
			if($id == 'User') {
				$saveto = 'User';
				$image = $data['User'][$this->Auth->user('id')];
				if($this->Session->read('Auth.User.slug') != '') {
					$oldimage = $this->Session->read('Auth.User.slug');
				}
			} else {
				$data['Game'] = $d;
				$data['Game']['configuration_id'] = key($d);
				$image = $data['Game'][$data['Game']['configuration_id']];
				$answer = $this->Game->find('first', array('contain' => false,
													'conditions' => array('Game.configuration_id' => $data['Game']['configuration_id'])));
				if(!empty($answer)) {
					$data = $answer;
					$return['kid'] = $data['Game']['id'];
					$oldimage = $data['Game']['answer'];
				}
			}
		}
		if(Uploader::checkMimeType(strtolower(Uploader::ext($image['name'])), $image['type']) == $type) {
			
			$this->Uploader->uploadDir = '/files/img/large';
			$uploadimage = $this->Uploader->upload($image, array(
															'overwrite' => false, 
															'name' 		=> $this->__fileName(), 
															'multiple' 	=> false));
			$this->Uploader->uploadDir = '/files/img/medium';
			$this->Uploader->crop(array('width' => 300,  'height' => 300, 'append' => false));
			$this->Uploader->uploadDir = '/files/img/small';
			$this->Uploader->crop(array('width' => 100,  'height' => 100, 'append' => false));
				
			if($uploadimage){
				$img_path = explode('/', $uploadimage['path']); 
				$imagename = end($img_path);
				$data['Game']['answer'] = $imagename;
				$data['Game']['user_id'] = $this->Session->read('ActiveGame.user_id');
				$data['Game']['user_game_status_id'] = $this->Session->read('ActiveGame.id');
				
				if($saveto == 'User') {
					$this->Game->User->id = $this->Auth->user('id');
					$this->Game->User->saveField('slug', $imagename);
					$this->Session->write('Auth.User.slug', $imagename);
					$return['filename'] = $imagename;
					$return['success'] = 1;
					$return['label'] = 'Change Image';
					$return['cid'] = $this->Auth->user('id');
				} else {
					if($this->Game->save($data)){
						if(empty($return['kid'])){
							$return['kid'] = $this->Game->getLastInsertId();
						}
						$return['filename'] = $imagename;
						$return['success'] = 1;
						$return['label'] = 'Change Image';
						$return['cid'] = $data['Game']['configuration_id'];
					} else {
						$return['success'] = 0;
					}
				}
				
				if(isset($oldimage)){
					$this->Uploader->delete('files' . DS . 'img' . DS . 'large' . DS . $oldimage);
					$this->Uploader->delete('files' . DS . 'img' . DS . 'medium' . DS . $oldimage);
					$this->Uploader->delete('files' . DS . 'img' . DS . 'small' . DS . $oldimage);
				}
			} else {
				$return['success'] = 0;
			}
		} elseif(Uploader::checkMimeType(strtolower(Uploader::ext($image['name'])), $image['type']) == $type) {
			
			$this->Uploader->uploadDir = '/files/video';
			$uploadimage = $this->Uploader->upload($image, array(
															'overwrite' => false, 
															'name' 		=> $this->__fileName(), 
															'multiple' 	=> false));

			if($uploadimage){
				$img_path = explode('/', $uploadimage['path']); 
				$imagename = end($img_path);
				$data['Game']['answer'] = $imagename;
				$data['Game']['user_id'] = $this->Session->read('ActiveGame.user_id');
				$data['Game']['user_game_status_id'] = $this->Session->read('ActiveGame.id');
				
				if($this->Game->save($data)){
					if(empty($return['kid'])){
						$return['kid'] = $this->Game->getLastInsertId();
					}
					if(isset($oldimage)){
						$this->Uploader->delete('files' . DS . 'video' . DS . $oldimage);
					}
					
					$return['filename'] = $imagename;
					$return['success'] = 1;
					$return['label'] = 'Change Image';
					$return['cid'] = $data['Game']['configuration_id'];
				} else {
					$return['success'] = 0;
				}
			} else {
				$return['success'] = 0;
			}
		} else {
			$allowedExts = Configure::read('Uploader.mimeTypes');
			$allowed = implode(',', $allowedExts[$type]);
			$return['success'] = 0;
			$return['flash'] = 'Files of type :' . $image['type'] . ', can not be uploaded ' . ' Allowed Image Types :' . $allowed;
		}
		return json_encode($return);
	}
	
	protected function __fileName(){
		$filehashname = md5(date('Ymdhis') . rand());
		return $filehashname ;
	}
	
	/**
	 * This function gets ConfigureID and requests Pinterest Username from User which is used later in the function below
	 * To retrieve Images from Pinterest
	 * @param string $user
	 */
	public function pinterest_getimages($pinterest_user = null){
		$this->layout = null;
		$cid = $this->request->query('cid');
		$this->set(compact('cid'));
		
		if(is_null($pinterest_user)) {
			$pinterest_user = $this->Session->read('PinterestUserName');
		} else {
			$this->Session->write('PinterestUserName', $pinterest_user);
		}
		
		if(!is_null($pinterest_user)){
			Unirest::verifyPeer(false);
			$response = Unirest::get('https://ismaelc-pinterest.p.mashape.com/' . $pinterest_user . '/pins',
						array('X-Mashape-Authorization' => 'qNmcpxBvG6mshprCvV9PDbnaMwf1p1dceGbjsnM2uc4hySaHRV'), null);
			
			if(!empty($response)){
				$res 	= $response->raw_body;
				$r		= json_decode($res,false);
				$img	= array();
				
				if(!empty($r->body)){
					$data = $r->body;
					if(!empty($data)){
						foreach($data as $d){
							$img[] = $d->src;
						}
					}
				}
			}
			$this->set(compact('img'));
		}
	}
	
	/**
	 * This function is to Upload Images From Pinterest
	 * @return string
	 */
	function upload_image_pinterest(){
		$this->autoRender = false;
		$image_file_name = '';
		if(!empty($this->request->data)) {
			$link = json_decode($this->request->data, true);
			if($link){
				$this->Game->create();

				$data['Game']['configuration_id'] = $link['cid'];
				
				$answer = $this->Game->find('first', array('contain' => false,
						'conditions' => array('Game.configuration_id' => $data['Game']['configuration_id'])));
				
				if(empty($answer)) {
				} else {
					$data = $answer;
					$return['kid'] = $data['Game']['id'];
					$oldimage = $data['Game']['answer'];
				}
				
				$this->Uploader->uploadDir = '/files/img/large';
				$uploadimage = $this->Uploader->importRemote($link['src'], array('name' => $this->__fileName(), 'overwrite' => false));
				$this->Uploader->uploadDir = '/files/img/medium';
				$this->Uploader->crop(array('width' => 300,  'height' => 300, 'append' => false));
				$this->Uploader->uploadDir = '/files/img/small';
				$this->Uploader->crop(array('width' => 100,  'height' => 100, 'append' => false));

				if($uploadimage){
					$imagenamearray = explode('/', $uploadimage['path']);
					$imagename = end($imagenamearray);
					$data['Game']['answer'] = $imagename;
					$data['Game']['user_id'] = $this->Session->read('ActiveGame.user_id');
					$data['Game']['user_game_status_id'] = $this->Session->read('ActiveGame.id');
				
					if($this->Game->save($data)){
						if(empty($return['kid'])){
							$return['kid'] = $this->Game->getLastInsertId();
						}

						if(isset($oldimage)){
							$this->Uploader->delete('files' . DS . 'img' . DS . 'large' . DS . $oldimage);
							$this->Uploader->delete('files' . DS . 'img' . DS . 'medium' . DS . $oldimage);
							$this->Uploader->delete('files' . DS . 'img' . DS . 'small' . DS . $oldimage);
						}
						$return['filename'] = $imagename;
						$return['success'] = 1;
						$return['cid'] = $data['Game']['configuration_id'];
					} else {
						$return['success'] = 0;
					}
				} else {
					$return['success'] = 0;
				}
			}
		}
		return json_encode($return);
	}
	
	//This function allows users to connect to Instagram,if successfully connected,then sets session variables for
	// access token and user_id
	public function instagram(){
		$this->layout = null;
		$this->Session->write('Instagram', $this->request->query);
		
		//For Instagram Login
		if(isset($this->request->query['code'])){
			$code = $this->request->query['code'];
			//To check Kissaah.org or .com
			if(strpos(Router::url('/', true), 'kissaah.org') !== false || strpos(Router::url('/', true), 'kissaah.org') !== false) {
				$fields = array(
						'client_id' 	=> 'aaa83efcc635473d8580c2e992d13b42',
						'client_secret' => '6ae8ed62c4144e40aefdf14baf174307',
						'grant_type' 	=> 'authorization_code',
						'redirect_uri' 	=> 'http://kissaah.org/games/instagram',
						'code' 			=> $code
				);
			} elseif(strpos(Router::url('/', true), 'kissaah.com') !== false || strpos(Router::url('/', true), 'kissaah.com') !== false) {
				$fields = array(
						'client_id' 	=> '87bfa076695d48248eeb40ae863cb889',
						'client_secret' => 'a9015ad4c7d5436fb32824f3675817f3',
						'grant_type' 	=> 'authorization_code',
						'redirect_uri' 	=> 'http://game.kissaah.com/games/instagram',
						'code' 			=> $code
				);
			} elseif(strpos(Router::url('/', true), 'humancatalyst') !== false) {
				$fields = array(
						'client_id' 	=> 'df23a7d4793e45efb058518380458c2b',
						'client_secret' => '96144a1af03242ed8c21c56e9c8400c6',
						'grant_type' 	=> 'authorization_code',
						'redirect_uri' 	=> 'http://hc.humancatalyst.co/devel/games/instagram',
						'code' 			=> $code
				);
			}
			
			$fields_string = '';
			foreach($fields as $key => $value) { 
				$fields_string .= $key.'='.$value.'&'; 
			}
			rtrim($fields_string, '&');
			
			$url = 'https://api.instagram.com/oauth/access_token';
			$ch  = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
				
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			$result = curl_exec($ch);
			curl_close($ch);
			
			if($result == false){
				$this->Session->write('Instagram.error_reason', 'access_denied');
			} else {
				$result = json_decode($result);
				
				$access_token 	= $result->access_token;
				$user_id		= $result->user->id;
					
				$this->set(compact('user_id', 'access_token'));
				
				if(isset($user_id) && isset($access_token)){
					$this->Session->write('Instagram.success', 1);
					$this->Session->write('Instagram.user_id', $user_id);
					$this->Session->write('Instagram.access_token', $access_token);
				}
			}
		}
		$this->redirect(array('controller' => 'games', 'action' => 'index'));
	}

	//This function retrieves images from Instagram using access_token and user_id
	public function instagram_getImages(){
		$this->layout = null;
		$cid = $this->request->query['cid'];
		
		if(!empty($cid)) {
			$this->Session->write('Current.action', 'ins');
			$this->Session->write('Current.configuration_id', $cid);
			$this->Session->write('Current.game_step', $this->request->query['game_step']);
		}
		
		$this->set(compact('cid'));
		//Set the link to Connect to Instagram according to Doamain
		if(strpos(Router::url('/', true), 'kissaah.org') !== false || 
				strpos(Router::url('/', true), 'kissaah.org') !== false) {
			$link = 'https://api.instagram.com/oauth/authorize/?client_id=aaa83efcc635473d8580c2e992d13b42&redirect_uri=http://kissaah.org/games/instagram&response_type=code' ;
			
		} elseif(strpos(Router::url('/', true), 'kissaah.com') !== false || 
				strpos(Router::url('/', true), 'kissaah.com') !== false) {
			$link = 'https://api.instagram.com/oauth/authorize/?client_id=87bfa076695d48248eeb40ae863cb889&redirect_uri=http://game.kissaah.com/games/instagram&response_type=code' ;
		} else {
			$link = 'https://instagram.com/';
		}
		
		if($this->Session->check('Instagram.success') && $this->Session->check('Instagram.user_id')){
			$user_id		= $this->Session->read('Instagram.user_id');
			$access_token	= $this->Session->read('Instagram.access_token');
			$url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . $access_token;
			$ch  = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			$result = curl_exec($ch);
			curl_close($ch);
				
			$data	= json_decode($result, true);
			if(empty($data['data'])) {
				$this->Session->delete('Instagram');
			} else {
				$images	= $data['data'];
				foreach($images as $img){
					$instagram_images[] = $img['images']['low_resolution']['url'];
				}
				$this->set(compact('instagram_images'));
			}
		}
		$this->set(compact('link'));
	}
	
	public function hash_tag($hash_tag) {
		$this->Session->write('Game.query_all', 1);
		$users_with_tag = $this->Game->find('all', array(
								'contain' 		=> array('User'),
								'conditions'	=> array('Game.answer LIKE' => '%' . $hash_tag . '%',
														  'Game.user_id NOT' => $this->Session->read('ActiveGame.user_id'))));
		$this->Session->write('Game.query_all', 0);
		$this->set(compact('users_with_tag'));
	}
	
	public function reset($confirm = false) {
		debug($confirm);
		debug($this->request->data);
		if($this->request->is('post')) {
			if(strtoupper($this->request->data['Game']['confirm']) == 'CONFIRM') {
				$this->_reset_roadmap($this->Session->read('ActiveGame.id'));
				$this->redirect(array('controller' => 'games', 'action' => 'index'));
			} else {
				$this->redirect(array('controller' => 'users', 'action' => 'profile'));
			}
		}
	}
	
	public function collage_signup() {}
	
	public function collage_roadmap_completed(){}
	
	public function admin_collage($activity) {
		$companyAdmin = $this->Session->read('AdminAccess.company');
		$isAdmin = ($this->Auth->user('role_id') == 1) ? true : false;
		if(empty($companyAdmin) && !$isAdmin) {
			$this->redirect($this->referer());
		}
		$this->set('title_for_layout', 'Collage of ' . $activity);
		$this->Session->write('Game.query_all', 1);
		$dependent_id = $this->Game->Configuration->find('list', array(
								'contain' => false,
								'fields' => array('Configuration.id'),
								'conditions' => array('Configuration.type' => 1, 'Configuration.title' => $activity)));

		$conditions = array('OR' => array(array('Configuration.type' => 1, 'Configuration.title' => $activity),
									  array('Configuration.type' => 7, 'Configuration.dependent_id' => $dependent_id)));
		if(!$isAdmin ) {
			$this->loadModel('CompanyGroupsUser');
			if(empty($companyAdmin)) $companyAdmin = 0;
			$companyList = $this->CompanyGroupsUser->CompanyGroup->find('list', array('fields' => array('id', 'id'), 'conditions' => array('OR' => array('CompanyGroup.id' => $this->companyAdmin, 'CompanyGroup.parent_id' => $this->companyAdmin)), 'contain' => false));
			$conditions['Game.user_id'] = $this->CompanyGroupsUser->find('list', array('fields' => array('user_id', 'user_id'), 'conditions' => array('company_group_id' => $companyList), 'contain' => false));
		}
		$images = $this->Game->find('all', array(
								'contain' => array('Configuration'),
								'conditions' => $conditions));
		$collage = array();
		foreach($images as $image) {
			if($image['Configuration']['type'] == 1) {
				$collage[$image['Game']['user_game_status_id']][$image['Configuration']['id']][] = $image['Game']['answer'];
			} else {
				$collage[$image['Game']['user_game_status_id']][$image['Configuration']['dependent_id']][] = $image['Game']['answer'];
			}
		}
		$this->Session->delete('Game.query_all');
		$this->set(compact('collage'));
	}
	
	public function typeahead_allies() {
		$this->autoRender = false;
		$query = $this->request->query['query'];

		$this->loadModel('Ally');
		$options['conditions'] 	= array('Ally.user_id' => $this->Auth->user('id'));
		$options['fields'] 		= array('Ally.id', 'Ally.ally');
		$ally = $this->Ally->find('list', $options);
		
		$options['conditions'] 	= array('Game.answer' => $ally);
		$options['fields'] 		= array('Game.configuration_id', 'Game.answer');
		$ally = $this->Game->find('list', $options);
		
		$options = array();
		$options['contain'] = false;
		$options['conditions'] = array('User.name LIKE' => '%' . $query . '%', 'User.id' => $ally);
		$users = $this->Game->User->find('all', $options);
		
		$results = array();
		
		foreach($users as $user) {
			$goal = array_search($user['User']['id'], $ally);
			$this->Game->Configuration->id = $goal;
			
			$image = (empty($user['User']['slug']))? '/../../img/profile.png': '/../../files/img/medium/' . $user['User']['slug'];
			$results[] = array(
					'id'	=> $user['User']['id'],
					'name'	=> $user['User']['name'],
					'img' 	=> Router::url(null, true) . $image,
					'email'	=> $user['User']['email'],
					'goal'	=> $this->Game->Configuration->field('title')
			);
		}
		echo json_encode($results);
	}
	
}
?>