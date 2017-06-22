<?php
class CompanyGroupsController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
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
			$options['contain'] = false;
			$options['order'] = array('CompanyGroup.lft ASC');
			$company_groups = $this->CompanyGroup->find('all', $options);
			
			foreach($company_groups as $key => $company_group) {
				$tree_list[$key]['id'] 		 = $company_group['CompanyGroup']['id'];
				$tree_list[$key]['text'] 	 = $company_group['CompanyGroup']['title'];
				$tree_list[$key]['children'] = ($this->CompanyGroup->childCount($company_group['CompanyGroup']['id']) > 0)? true: false;
			}
		}
		
		return json_encode($tree_list);
	}
	
	public function admin_index($id = null) {
		if($this->request->is('ajax')) {
			
			$options['contain'] = array('User', 'CompanyGroupsUser' => array('User' => array('fields' => array('name', 'email'))));
			$options['conditions'] = array('CompanyGroup.id' => $id);
			$company_group = $this->CompanyGroup->find('first', $options);
			
			if(!empty($company_group)) {

				if(!empty($company_group['CompanyGroup']['parent_id'])) {
					$options['conditions'] = array('CompanyGroup.id' => $company_group['CompanyGroup']['parent_id']);
					$company_group['CompanyGroup']['parent'] = $this->CompanyGroup->field('CompanyGroup.title', $options['conditions']);
				} else {
					$company_group['CompanyGroup']['parent'] = '';
				}
			}
			
			$roles = $this->CompanyGroup->CompanyGroupsUser->Role->find('list', array('fields' => array('id', 'name')));
			$this->set(compact('company_group', 'company_group_users', 'roles'));
		}
	}
	
	public function admin_add() {
		if ($this->request->is(array('post', 'put'))) {
			debug($this->request->data);
			if ($this->CompanyGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The CompanyGroup has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The CompanyGroup could not be saved. Please, try again.'));
			}
		}
		
		$parents = $this->CompanyGroup->generateTreeList(null, null, null, '---');
 		$users = $this->CompanyGroup->User->find('list');
		$this->set(compact('parents', 'users'));
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

		$parents = $this->CompanyGroup->generateTreeList(null, null, null, '---');
 		$users = $this->CompanyGroup->User->find('list');
		$this->set(compact('parents', 'users'));
	}
	
	public function admin_save($id = null) {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$this->CompanyGroup->CompanyGroupsUser->id = $id;
			$this->CompanyGroup->CompanyGroupsUser->saveField('role_id', $this->request->data['role_id']);
		}
	}
	
	public function admin_company_user() {
		if ($this->request->is(array('post', 'put'))) {
			foreach($this->request->data['CompanyGroupsUser']['user_id'] as $user_id) {
				
				$this->CompanyGroup->CompanyGroupsUser->create();
				$data['CompanyGroupsUser']['company_group_id'] = $this->request->data['CompanyGroupsUser']['company_group_id'];
				$data['CompanyGroupsUser']['user_id'] = $user_id;
				
				if ($this->CompanyGroup->CompanyGroupsUser->save($data)) {
					$this->Session->setFlash(__('The Company Group has been saved.'));
				} else {
					$this->Session->setFlash(__('The Company Group could not be saved. Please, try again.'));
					break;
				}
			}
			
			return $this->redirect(array('action' => 'index'));
		}
		
		$companyGroups = $this->CompanyGroup->generateTreeList(null, null, null, '---');
 		$users = $this->CompanyGroup->User->find('list', array('order' => array('User.name ASC')));
		$this->set(compact('companyGroups', 'users'));
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

	public function admin_delete($id = null){
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
	
	public function admin_company_user_delete($id = null){
		$this->CompanyGroup->CompanyGroupsUser->id = $id;
		if (!$this->CompanyGroup->CompanyGroupsUser->exists()) {
			throw new NotFoundException(__('The user is not associated to this group'));
		}
		
		if ($this->CompanyGroup->CompanyGroupsUser->delete($this->CompanyGroup->id, true)) {
			$this->Session->setFlash(__('The user id deleted from the group.'), 'default', array('class' => 'flashSuccess'));
		} else {
			$this->Session->setFlash(__('The user cannot be deleted from the group.'), 'default', array('class' => 'flashError'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
	
	public function company_group_users() {
		$user_id = $this->Auth->user('id');
		$options['conditions'] = array('user_id' => $user_id);
		$company = $this->CompanyGroup->CompanyGroupsUser->field('company_group_id', $options['conditions']);
		
		$options['fields'] = array('id', 'user_id');
		$options['conditions'] = array('company_group_id' => $company, 'user_id !=' => $user_id);
		$groups = $this->CompanyGroup->CompanyGroupsUser->find('list', $options);
		
		$options = array();
		$options['contain'] 	= false;
		$options['fields'] 		= array('id', 'slug');
		$options['conditions'] 	= array('User.id' => $groups);
		$users = $this->CompanyGroup->User->find('list', $options);
		
		return $users;
	}
}
?>
