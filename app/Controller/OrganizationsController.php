<?php
class OrganizationsController extends AppController {
	
	public $helpers = array('TreeList');
	
	public function index() {
		$organizations = $this->Organization->find('all', array(
				'contain' => false,
				'conditions' => array('parent_id' => null)));

		$levels = array();
		foreach($organizations as $org) {
			$levels[$org['Organization']['id']] = $this->Organization->children($org['Organization']['id']);
		}
		
		$this->set(compact('organizations', 'levels'));
	}
	
	public function map($id) {
		$lists[$id] = $id;
		
		$level = $this->Organization->children($id, false, 'id');
		foreach($level as $value) {
			$lists[$value['Organization']['id']] = $value['Organization']['id'];
		}
		
		$options['contain'] = false;
		$options['conditions'] = array('type' => null, 'company_group_id' => null, 'id' => $lists);
		$level = $this->Organization->find('threaded', $options);

		$options['conditions'] = array('type' => 1, 'company_group_id' => null, 'id' => $lists);
		$options['fields'] = array('id', 'title', 'description', 'parent_id');
		$org_map = $this->Organization->find('threaded', $options);
		
		$this->set(compact('level', 'org_map'));
	}
	
	public function admin_locTree() {
		$this->autoRender = false;
		$tree_list = array();
	
		if($this->request->is('ajax')) {
			$this->Organization->recursive = 0;
			$parent = $this->request->query['parent'];
			if($parent == '#') {
				$parent = null;
			}
			$options['conditions'] = array('Organization.parent_id' => $parent);
			$options['order'] = array('Organization.lft ASC');
			$organizations = $this->Organization->find('all', $options);
			
			foreach($organizations as $key => $organization) {
				$tree_list[$key]['id'] 		 = $organization['Organization']['id'];
				$tree_list[$key]['text'] 	 = $organization['Organization']['title'];
				$tree_list[$key]['children'] = ($this->Organization->childCount($organization['Organization']['id']) > 0)? true: false;
			}
		}
		
		return json_encode($tree_list);
	}
	
	function admin_index($id = null){
		if($this->request->is('ajax')) {
			$options['contain'] = false;
			$options['conditions'] = array('Organization.id' => $id);
			$organization = $this->Organization->find('first', $options);
			
			if(!empty($organization['Organization'])) {
				
				if(!empty($organization['Organization']['parent_id'])) {
					$options['conditions'] = array('Organization.id' => $organization['Organization']['parent_id']);
					$organization['Organization']['parent'] = $this->Organization->field('Organization.title', $options['conditions']);
				} else {
					$organization['Organization']['parent'] = '';
				}
					
				if(!empty($organization['Organization']['company_group_id'])) {
					$options['conditions'] = array('Organization.id' => $organization['Organization']['company_group_id']);
					$organization['Organization']['dependent'] = $this->Organization->field('Organization.title', $options['conditions']);
				} else {
					$organization['Organization']['dependent'] = '';
				}
					
				$this->set(compact('organization', $organization));
				
			}
		}
	}
	
	public function admin_add(){
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Organization->save($this->request->data)) {
				$this->Session->setFlash(__('The Organization has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Organization could not be saved. Please, try again.'));
			}
			
		}
		
		$parent_id = $this->Organization->generateTreeList(null, null, null, '---');
		$this->set(compact('parent_id'));
	}
	
	public function admin_edit($id = null) {
		if (!$this->Organization->exists($id)) {
			throw new NotFoundException(__('Invalid Organization'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Organization->save($this->request->data)) {
				$this->Session->setFlash(__('The Organization has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Organization could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Organization.' . $this->Organization->primaryKey => $id), 'contain' => false);
			$this->request->data = $this->Organization->find('first', $options);
			
		}
		
		$parent_id = $this->Organization->generateTreeList(null, null, null, '---');
		$this->set(compact('parent_id'));
	}
	
	public function admin_moveup($id = null, $delta = null) {
		$this->Organization->id = $id;
		if (!$this->Organization->exists()) {
			throw new NotFoundException(__('Invalid Configuration'));
		}
		if ($delta > 0) {
			$this->Organization->moveUp($id, abs($delta));
		} else {
			$this->Session->setFlash('Please provide a number of positions the Configuration should be moved up.');
		}
		return $this->redirect($this->referer());
	}
	
	public function admin_movedown($id = null, $delta = null) {
		$this->Organization->id = $id;
		if (!$this->Organization->exists()) {
			throw new NotFoundException(__('Invalid Configuration'));
		}
		if ($delta > 0) {
			$this->Organization->moveDown($this->Organization->id, abs($delta));
		} else {
			$this->Session->setFlash('Please provide the number of positions the field should be moved down.');
		}
		return $this->redirect($this->referer());
	}
	
	function admin_delete($id = null){
		$this->Organization->id = $id;
		if (!$this->Organization->exists()) {
			throw new NotFoundException(__('Invalid Configuration'));
		}
		
		if ($this->Organization->removeFromTree($this->Organization->id, true)) {
			$this->Session->setFlash(__('The Configuration has been deleted.'));
		} else {
			$this->Session->setFlash(__('The Configuration could not be deleted. Please, try again.'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
?>