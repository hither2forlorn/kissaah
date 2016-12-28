<?php
class CompanyGroupsController extends AppController {
	
	public $helpers = array('TreeList');
	protected $isAdmin = false;
	protected $companyAdmin = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->companyAdmin = $admin_company = $this->Session->read('AdminAccess.company');
		$this->isAdmin = $admin = ($this->Auth->user('role_id') == 1) ? true : false;
		if(empty($admin_company) && !$admin) {
			$this->redirect($this->referer());
		}
	}
	public function admin_locTree() {
		$this->autoRender = false;
		$tree_list = array();
	
		if($this->request->is('ajax')) {
			$this->CompanyGroup->recursive = 0;
			$parent = $this->request->query['parent'];
			if($parent == '#') {
				$parent = null;
			}
			$options['conditions'] = array('CompanyGroup.parent_id' => $parent);
			$options['order'] = array('CompanyGroup.lft ASC');
			if(!$this->isAdmin) $options['conditions']['OR'] = array('CompanyGroup.id' => $this->companyAdmin, 'CompanyGroup.parent_id' => $this->companyAdmin);
			$company_groups = $this->CompanyGroup->find('all', $options);
			
			foreach($company_groups as $key => $company_group) {
				$tree_list[$key]['id'] 		 = $company_group['CompanyGroup']['id'];
				$tree_list[$key]['text'] 	 = $company_group['CompanyGroup']['title'];
				$tree_list[$key]['children'] = ($this->CompanyGroup->childCount($company_group['CompanyGroup']['id']) > 0)? true: false;
			}
		}
		
		return json_encode($tree_list);
	}
	
	function admin_index($id = null){
		$actions = array('new' => false, 'edit' => false, 'move_up' => false, 'move_down' => false, 'delete' => false);
		if($this->isAdmin) $actions = array('new' => true, 'edit' => false, 'move_up' => false, 'move_down' => false, 'delete' => false);
		if($this->request->is('ajax')) {
			$options['contain'] = array('Admin');
			$options['conditions'] = array('CompanyGroup.id' => $id);
			if(!$this->isAdmin) $options['conditions']['OR'] = array('CompanyGroup.id' => $this->companyAdmin, 'CompanyGroup.parent_id' => $this->companyAdmin);
			$company_group = $this->CompanyGroup->find('first', $options);
			$company_group_users = $this->CompanyGroup->User->find('all', array('recursive'=>-1, 'conditions'=>array('User.company'=>$company_group['CompanyGroup']['code'])));
			if(!empty($company_group['CompanyGroup'])) {
				if($this->isAdmin) {
					$actions = array('new' => true, 'edit' => true, 'move_up' => true, 'move_down' => true, 'delete' => true);
				} else {
					$com_grp = $this->CompanyGroup->find('list', array('fields' => array('id', 'id'), 'conditions' => array('id' => $this->companyAdmin, 'parent_id IS NULL')));
					if(!empty($com_grp)) {
						$actions = array('new' => true, 'edit' => true, 'move_up' => true, 'move_down' => true, 'delete' => true);
					}
				}
				if(!empty($company_group['CompanyGroup']['parent_id'])) {
					$options['conditions'] = array('CompanyGroup.id' => $company_group['CompanyGroup']['parent_id']);
					$company_group['CompanyGroup']['parent'] = $this->CompanyGroup->field('CompanyGroup.title', $options['conditions']);
				} else {
					$company_group['CompanyGroup']['parent'] = '';
					$actions['delete'] = false;
					$actions['move_up'] = false;
					$actions['move_down'] = false;
				}
				
				$this->set(compact('company_group', 'company_group_users'));
				
			}
		}
		$this->set(compact('actions'));
	}
	
	public function admin_add(){
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CompanyGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The CompanyGroup has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The CompanyGroup could not be saved. Please, try again.'));
			}
			
		}
		if(!$this->isAdmin) $conditions['OR'] = array('CompanyGroup.id' => $this->companyAdmin, 'CompanyGroup.parent_id' => $this->companyAdmin);
		$parent_id = $this->CompanyGroup->generateTreeList($conditions, null, null, '---');
		$admins = $this->CompanyGroup->Admin->find('list');
		$this->set(compact('parent_id', 'admins'));
	}
	
	public function admin_edit($id = null) {
		if (!$this->CompanyGroup->exists($id)) {
			throw new NotFoundException(__('Invalid CompanyGroup'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CompanyGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The CompanyGroup has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The CompanyGroup could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CompanyGroup.' . $this->CompanyGroup->primaryKey => $id));
			$this->request->data = $this->CompanyGroup->find('first', $options);
			
		}
		$conditions = array('CompanyGroup.id != ' => $id);
		if(!$this->isAdmin) {
			$conditions['OR'] = array('CompanyGroup.id' => $this->companyAdmin, 'CompanyGroup.parent_id' => $this->companyAdmin);
			if(empty($this->companyAdmin) || empty($this->request->data['CompanyGroup']['parent_id'])) {
				$conditions[] = 'CompanyGroup.id = 0';
			}
		}
		$parent_id = $this->CompanyGroup->generateTreeList($conditions, null, null, '---');
		$admin_conditions = array();
		if(!$this->isAdmin) {
			$this->loadModel('CompanyGroupsUser');
			if(empty($companyAdmin)) $companyAdmin = 0;
			$companyList = $this->CompanyGroup->find('list', array('fields' => array('id', 'id'), 'conditions' => array('OR' => array('CompanyGroup.id' => $this->companyAdmin, 'CompanyGroup.parent_id' => $this->companyAdmin)), 'contain' => false));
			$admin_conditions['Admin.id'] = $this->CompanyGroupsUser->find('list', array('fields' => array('user_id', 'user_id'), 'conditions' => array('company_group_id' => $companyList), 'contain' => false));
		}
		$admins = $this->CompanyGroup->Admin->find('list', array('conditions' => $admin_conditions));
		$this->set(compact('parent_id', 'admins'));
	}
	
	public function admin_moveup($id = null, $delta = null) {
		$this->CompanyGroup->id = $id;
		if (!$this->CompanyGroup->exists()) {
			throw new NotFoundException(__('Invalid CompanyGroup'));
		}
		if ($delta > 0) {
			$this->CompanyGroup->moveUp($id, abs($delta));
		} else {
			$this->Session->setFlash('Please provide a number of positions the CompanyGroup should be moved up.');
		}
		return $this->redirect($this->referer());
	}
	
	public function admin_movedown($id = null, $delta = null) {
		$this->CompanyGroup->id = $id;
		if (!$this->CompanyGroup->exists()) {
			throw new NotFoundException(__('Invalid CompanyGroup'));
		}
		if ($delta > 0) {
			$this->CompanyGroup->moveDown($this->CompanyGroup->id, abs($delta));
		} else {
			$this->Session->setFlash('Please provide the number of positions the field should be moved down.');
		}
		return $this->redirect($this->referer());
	}
	
	function admin_delete($id = null){
		$this->CompanyGroup->id = $id;
		if (!$this->CompanyGroup->exists()) {
			throw new NotFoundException(__('Invalid CompanyGroup'));
		}
		
		if ($this->CompanyGroup->removeFromTree($this->CompanyGroup->id, true)) {
			$this->Session->setFlash(__('The CompanyGroup has been deleted.'));
		} else {
			$this->Session->setFlash(__('The CompanyGroup could not be deleted. Please, try again.'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
?>