<?php 
class FeedbacksController extends AppController{
	
	public function index($show, $ally_id) {
		$options['conditions'] = array('Configuration.feedback' => 1, 'Configuration.status' => 1);
		$feedback_list = $this->Feedback->Configuration->generateTreeList($options['conditions']);
		
		if($show == 'myself') {
			$this->set('disabled', 1);
				
		} elseif($show == 'ally') {
			$this->set('disabled', 0);
		
		}
		
		$ally = $this->Feedback->User->Ally->findById($ally_id);
		
		$feedbacks = array();
		$this->Session->write('Game.query_all', 1);
		foreach($feedback_list as $key => $value) {
			
			$options['contain'] 	= array('Game' => array('conditions' => array('Game.user_game_status_id' => $ally['Ally']['user_game_status_id'])));
			$options['conditions'] 	= array('Configuration.id' => $key);
				
			$feedbacks[$key] = $this->Feedback->Configuration->find('first', $options);
			
			$options = array();
			$options['contain'] 	= false;
			$options['conditions'] 	= array('Feedback.configure_id' 		=> $key,
											'Feedback.user_id' 				=> $ally['MyAlly']['id'],
											'Feedback.user_game_status_id' 	=> $ally['Ally']['user_game_status_id']);
			
			$feedback = $this->Feedback->find('first', $options);
			if(!empty($feedback)) {
				$feedbacks[$key]['Feedback'] = $feedback['Feedback'];
			}
		}
		
		$this->Session->delete('Game.query_all');
		
		$this->set('feedback_for_user', $ally);
		$this->set('feedback_list', $feedback_list);
		$this->set('feedbacks', $feedbacks);
	}
	
	public function save(){
		$this->autoRender = false;
		$this->Feedback->create();
		$data = $this->request->data;
		$data['Feedback']['user_id'] = $this->Session->read('ActiveGame.user_id');
		$user_status_id = 0;
		$save_field = '';
		
		if(isset($data['Feedback']['comment'])) {
			$save_field = 'comment';
			
		} elseif(isset($data['Feedback']['answer'])) {
			$save_field = 'answer';
			
		}
		foreach($data['Feedback'][$save_field] as $id => $d) {
			$user_status_id = $data['Feedback']['user_game_status_id'];
			$data['Feedback']['configure_id'] = $id;
			$answer = $this->Feedback->find('first', array('contain' => false,
					'conditions' => array('Feedback.configure_id' => $data['Feedback']['configure_id'],
										  'Feedback.user_id' => $data['Feedback']['user_id'],
										  'Feedback.user_game_status_id' => $data['Feedback']['user_game_status_id'])));
			if(!empty($answer)) {
				$data = $answer;
			}
			$data['Feedback'][$save_field] = $d;
		}
		
		if($this->Feedback->save($data)){
			if($user_status_id > 0) {
				$this->Feedback->User->Ally->updateAll( array('Ally.feedback_notification' => '\'Feedback\''), 
														array('Ally.user_game_status_id' => $user_status_id, 
															  'Ally.ally' => $data['Feedback']['user_id']));
			}
			$return['success'] = 1;
			$return['cid'] = $data['Feedback']['configure_id'];
		} else {
			$return['success'] = 0;
		}
		return json_encode($return);
	}
}
?>