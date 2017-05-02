<?php
class OrganizationsController extends AppController {
	
	public function index($id = null) {
		$organizations = $this->Organization->find('all', array(
				'contain' => false,
				'conditions' => array('company_group_id' => $id, 'parent_id' => null)));
		
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

		if($this->request->is('requested') == false) {
			$options['conditions'] = array('type' => null, 'company_group_id' => null, 'id' => $lists);
			$level = $this->Organization->find('threaded', $options);
		}

		$options['conditions'] = array('type' => 1, 'company_group_id' => null, 'id' => $lists);
		$options['fields'] = array('id', 'title', 'description', 'parent_id');
		$org_map = $this->Organization->find('threaded', $options);
		
		if($this->request->is('requested')) {
			return $org_map;
		} else {
			$this->set(compact('level', 'org_map'));
		}
	}
	
	public function get_competencies() {
		$options['contain'] 	= false;
		$options['conditions'] 	= array('parent_id' => 1, 'title' => 'Competencies');
		$compet = $this->Organization->find('first', $options);
	
		if(!empty($compet)) {
			$options['conditions'] 	= array('parent_id' => $compet['Organization']['id']);
			$compet = $this->Organization->find('list', $options);
		}
		return $compet;
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
			$options['conditions']['Organization.parent_id'] = $parent;
			$options['conditions']['Organization.company_group_id'] = null;
			if(isset($this->request->query['company_group_id']) && !empty($this->request->query['company_group_id'])) {
				$options['conditions']['Organization.company_group_id'] = $this->request->query['company_group_id'];
			}
			$options['order'] = array('Organization.lft ASC');
			$options['contian'] = false;
			$organizations = $this->Organization->find('all', $options);
			
			foreach($organizations as $key => $organization) {
				$tree_list[$key]['id'] 		 = $organization['Organization']['id'];
				$tree_list[$key]['text'] 	 = $organization['Organization']['title'];
				$tree_list[$key]['children'] = ($this->Organization->childCount($organization['Organization']['id']) > 0)? true: false;
			}
		}
		
		return json_encode($tree_list);
	}
	
	public function admin_index($id = null) {
		
		if($this->request->is('ajax')) {
			$options['contain'] = false;
			$options['conditions'] = array('id' => $id);
			$organization = $this->Organization->find('first', $options);
			
			if(!empty($organization['Organization'])) {
				
				$organization['Organization']['parent'] = '';
				if(!empty($organization['Organization']['parent_id'])) {
					$options['conditions'] = array('id' => $organization['Organization']['parent_id']);
					$organization['Organization']['parent'] = $this->Organization->field('Organization.title', $options['conditions']);
				}
				$this->set(compact('organization', $organization));
			}
			
		} else {
			$company = $this->Organization->find('count', array(
					'contain' => false, 'conditions' => array('company_group_id' => $id)));
			
			if($company === 0) {
				$options['conditions'] 	= array('company_group_id' => null);
				$options['contain'] 	= false;
				$options['order'] 		= array('lft ASC');
				$options['fields'] 		= array('id', 'title', 'type', 'status', 'parent_id', 'featured', 'description');
				$organization = $this->Organization->find('all', $options);
				
				foreach($organization as $org) {
					$oid = $org['Organization']['id'];
					unset($org['Organization']['id']);
					$org['Organization']['company_group_id'] = $id;
					
					if($org['Organization']['parent_id'] != null) {
						$org['Organization']['parent_id'] = $name[$org['Organization']['parent_id']];
					}
					
					$this->Organization->create();
					if($this->Organization->save($org)) {
						$name[$oid] = $this->Organization->id;
					}
				}
			}
			$this->set('company_group_id', $id);
		}
	}
	
	public function admin_add($parent_id = null, $company_group_id = null){
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Organization']['company_group_id'] = $company_group_id;
			if ($this->Organization->save($this->request->data)) {
				$this->Session->setFlash(__('The Organization has been saved.'));
				return $this->redirect(array('action' => 'index', $company_group_id));
			} else {
				$this->Session->setFlash(__('The Organization could not be saved. Please, try again.'));
			}
		}
		
		$options = array('company_group_id' => $company_group_id);
		$parent_id = $this->Organization->generateTreeList($options, null, null, '---');
		$this->set(compact('parent_id'));
	}
	
	public function admin_edit($id, $company_group_id = null) {
		if (!$this->Organization->exists($id)) {
			throw new NotFoundException(__('Invalid Organization'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Organization->save($this->request->data)) {
				$this->Session->setFlash(__('The Organization has been saved.'));
				return $this->redirect(array('action' => 'index', $company_group_id));
			} else {
				$this->Session->setFlash(__('The Organization could not be saved. Please, try again.'));
			}
			
		} else {
			$options['contain'] = false;
			$options['conditions'] = array('Organization.' . $this->Organization->primaryKey => $id);
			$this->request->data = $this->Organization->find('first', $options);
		}
		
		$options = array('company_group_id' => $company_group_id);
		$parent_id = $this->Organization->generateTreeList($options, null, null, '---');
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
		
		return $this->redirect($this->referer());
	}
}
?>