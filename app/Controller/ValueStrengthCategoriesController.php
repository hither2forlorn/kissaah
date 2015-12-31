<?php
App::uses('AppController', 'Controller');
/**
 * ValueStrengthCategories Controller
 *
 * @property ValueStrengthCategory $ValueStrengthCategory
 * @property PaginatorComponent $Paginator
 */
class ValueStrengthCategoriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->ValueStrengthCategory->recursive = 0;
		$this->set('valueStrengthCategories', $this->Paginator->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ValueStrengthCategory->create();
			if ($this->ValueStrengthCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The value strength category has been saved.'), 
										'default', array('class' => 'alert alert-success alert-dismissable'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The value strength category could not be saved. Please, try again.'), 
										'default', array('class' => 'alert alert-danger alert-dismissable'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->ValueStrengthCategory->exists($id)) {
			throw new NotFoundException(__('Invalid value strength category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ValueStrengthCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The value strength category has been saved.'), 
										'default', array('class' => 'alert alert-success alert-dismissable'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The value strength category could not be saved. Please, try again.'), 
										'default', array('class' => 'alert alert-danger alert-dismissable'));
			}
		} else {
			$options = array('conditions' => array('ValueStrengthCategory.' . $this->ValueStrengthCategory->primaryKey => $id));
			$this->request->data = $this->ValueStrengthCategory->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->ValueStrengthCategory->id = $id;
		if (!$this->ValueStrengthCategory->exists()) {
			throw new NotFoundException(__('Invalid value strength category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ValueStrengthCategory->delete()) {
			$this->Session->setFlash(__('The value strength category has been deleted.'), 
									'default', array('class' => 'alert alert-success alert-dismissable'));
		} else {
			$this->Session->setFlash(__('The value strength category could not be deleted. Please, try again.'), 
									'default', array('class' => 'alert alert-danger alert-dismissable'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
