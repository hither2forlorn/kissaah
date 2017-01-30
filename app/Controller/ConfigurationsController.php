<?php
class ConfigurationsController extends AppController {
	
	public function admin_locTree() {
		$this->autoRender = false;
		$tree_list = array();
	
		if($this->request->is('ajax')) {
			$this->Configuration->recursive = 0;
			$parent = $this->request->query['parent'];
			if($parent == '#') {
				$parent = null;
			}
			$options['conditions'] = array('Configuration.parent_id' => $parent);
			$options['order'] = array('Configuration.lft ASC');
			$configurations = $this->Configuration->find('all', $options);
			
			foreach($configurations as $key => $configuration) {
				$tree_list[$key]['id'] 		 = $configuration['Configuration']['id'];
				$tree_list[$key]['text'] 	 = $configuration['Configuration']['title'];
				$tree_list[$key]['children'] = ($this->Configuration->childCount($configuration['Configuration']['id']) > 0)? true: false;
			}
		}
		
		return json_encode($tree_list);
	}
	
	function admin_index($id = null){
		if($this->request->is('ajax')) {
			$options['contain'] = false;
			$options['conditions'] = array('Configuration.id' => $id);
			$configuration = $this->Configuration->find('first', $options);
			
			if(!empty($configuration['Configuration'])) {
				
				if(!empty($configuration['Configuration']['parent_id'])) {
					$options['conditions'] = array('Configuration.id' => $configuration['Configuration']['parent_id']);
					$configuration['Configuration']['parent'] = $this->Configuration->field('Configuration.title', $options['conditions']);
				} else {
					$configuration['Configuration']['parent'] = '';
				}
					
				if(!empty($configuration['Configuration']['dependent_id'])) {
					$options['conditions'] = array('Configuration.id' => $configuration['Configuration']['dependent_id']);
					$configuration['Configuration']['dependent'] = $this->Configuration->field('Configuration.title', $options['conditions']);
				} else {
					$configuration['Configuration']['dependent'] = '';
				}
					
				$this->set(compact('configuration', $configuration));
				
			}
		}
	}
	
	public function admin_add(){
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Configuration->save($this->request->data)) {
				$this->Session->setFlash(__('The Configuration has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Configuration could not be saved. Please, try again.'));
			}
			
		}
		
		$parent_id = $this->Configuration->generateTreeList(null, null, null, '---');
		$this->set(compact('parent_id'));
	}
	
	public function admin_edit($id = null) {
		if (!$this->Configuration->exists($id)) {
			throw new NotFoundException(__('Invalid Configuration'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Configuration->save($this->request->data)) {
				$this->Session->setFlash(__('The Configuration has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Configuration could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Configuration.' . $this->Configuration->primaryKey => $id), 'contain' => false);
			$this->request->data = $this->Configuration->find('first', $options);
			
		}
		
		$parent_id = $this->Configuration->generateTreeList(null, null, null, '---');
		$this->set(compact('parent_id'));
	}
	
	public function admin_moveup($id = null, $delta = null) {
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid Configuration'));
		}
		if ($delta > 0) {
			$this->Configuration->moveUp($id, abs($delta));
		} else {
			$this->Session->setFlash('Please provide a number of positions the Configuration should be moved up.');
		}
		return $this->redirect($this->referer());
	}
	
	public function admin_movedown($id = null, $delta = null) {
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid Configuration'));
		}
		if ($delta > 0) {
			$this->Configuration->moveDown($this->Configuration->id, abs($delta));
		} else {
			$this->Session->setFlash('Please provide the number of positions the field should be moved down.');
		}
		return $this->redirect($this->referer());
	}
	
	function admin_delete($id = null){
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid Configuration'));
		}
		
		if ($this->Configuration->removeFromTree($this->Configuration->id, true)) {
			$this->Session->setFlash(__('The Configuration has been deleted.'));
		} else {
			$this->Session->setFlash(__('The Configuration could not be deleted. Please, try again.'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
	
	public function admin_collage($activity) {
		debug('line 143'); exit;
		$this->set('title_for_layout', 'Collage of ' . $activity);
		if($activity=='Cartoon Upload'){
			$configuration_id = $this->Configuration->find('all',array('conditions' => array('Configuration.title'=>$activity)));
			$configuration_id = $configuration_id[0]['Configuration']['id'];
			$ConfigureIDForCaption = $this->Configuration->find('all',array(
					'conditions' => array('Configuration.dependent_id' => $configuration_id, 'Configuration.title'=>'Add Caption'),
					'order' => 'Answer.id DESC', 'limit' => 100));
			$data=array();
			$i=1;
			foreach($ConfigureIDForCaption as $cid){
				$data[$i]['user_id']=$cid['Answer']['user_id'];
				$data[$i]['configuration_id']=$cid['Answer']['configuration_id'];
				$data[$i]['answer']=$cid['Answer']['answer'];
				$i++;
			}
			$image_answers = $this->Configuration->find('all',
					array('conditions' => array( 'Configuration.type' => 1, 'Configuration.title' => $activity,
							'OR' => array('Answer.answer is not null', 'Answer.answer != ' => '')),
							'contain' => array('Answer'),
							'order' => 'Answer.id DESC', 'limit' => 100));
			//'fields' => array('Answer.answer'), 'order' => 'Answer.id DESC', 'limit' => 100));
			$images=array();
			$i=0;
			foreach($image_answers as $ia){
				$images[$i]['user_id']=$ia['Answer']['user_id'];
				$images[$i]['configuration_id']=$ia['Answer']['configuration_id'];
				$images[$i]['answer']=$ia['Answer']['answer'];
				$i++;
			}
			$answers=array();
			$i=0;
			foreach($images as $img){
				$userID=$img['user_id'];
				foreach($data as $d){
					if($d['user_id']==$userID){
						$answers[$i]['user_id']=$d['user_id'];
						$answers[$i]['configuration_id']=$d['configuration_id'];
						$answers[$i]['answer']=$d['answer'];
						$answers[$i]['image']=$img['answer'];
					}else{
						$answers[$i]['user_id']=$img['user_id'];
						$answers[$i]['configuration_id']=$img['configuration_id'];
						$answers[$i]['image']=$img['answer'];
					}
				}
				$i++;
			}
			$image_answers=$answers;
			$this->set(compact('image_answers'));
		} else {
			$configuration_id = $this->Configuration->find('all',array('conditions' => array('Configuration.title'=>$activity),
															'fields'=>'Configuration.id','contain'=>false));
			$ids=array();
			foreach($configuration_id as $cid){
				array_push($ids,$cid['Configuration']['id']);
			}
			$captions = $this->Configuration->find('all',array('conditions' => array(
																			'Configuration.dependent_id IN'=>$ids,
																			'Configuration.title'=>'Add Caption'),
																'order' => 'Answer.id DESC', 'limit' => 100));
			$data=array();
			$i=0;
			foreach($captions as $cap){
				$data[$i]['dependent_id']=$cap['Configuration']['dependent_id'];
				$data[$i]['configuration_id']=$cap['Answer']['configuration_id'];
				$data[$i]['answer']=$cap['Answer']['answer'];
				$data[$i]['user_id']=$cap['Answer']['user_id'];
				
				$i++;
			}
			$image_answers = $this->Configuration->find('all',
					array('conditions' => array( 'Configuration.type' => 1, 'Configuration.title' => $activity,
							'OR' => array('Answer.answer is not null', 'Answer.answer != ' => '')),
							'contain' => array('Answer'),
							'order' => 'Answer.id DESC', 'limit' => 100));
			$images=array();
			$i=0;
			foreach($image_answers as $ia){
				$images[$i]['user_id']=$ia['Answer']['user_id'];
				$images[$i]['configuration_id']=$ia['Answer']['configuration_id'];
				$images[$i]['answer']=$ia['Answer']['answer'];
				$i++;
			}
			$answers=array();
			$i=0;
			foreach($images as $img){
				$userID=$img['user_id'];
				foreach($data as $d){
					if($d['user_id']==$userID && $d['dependent_id']==$img['configuration_id']){
						$answers[$i]['user_id']=$d['user_id'];
						$answers[$i]['configuration_id']=$d['configuration_id'];
						$answers[$i]['answer']=$d['answer'];
						$answers[$i]['image']=$img['answer'];
					}
				}
				$i++;
			}
			$image_answers=$answers;
			$this->set(compact('image_answers'));
		}
	}
}
?>