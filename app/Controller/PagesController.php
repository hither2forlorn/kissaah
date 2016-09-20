<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 */
Configure::load('linkedin');
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	//public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 */
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allowedActions = array('display');
	}
	
	public function display() {
		if($this->Auth->user()){
			$this->redirect(array('controller' => 'games', 'action' => 'index'));
		}
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	function admin_edit($id = null){
		#S : Issue 4240
		if(is_numeric($id)){
			$this->Page->id = $id;
			if($this->Page->exists()){
			if ($this->request->is('post') || $this->request->is('put')) {
					if ($this->Page->save($this->request->data)) {
						$this->Session->setFlash(__('Page has been updated', 'flash_success'));
						//$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('The page could not be saved. Please, try again.', 'flash_error'));
					}
				} else {
					$this->request->data = $this->Page->read(null,$id);
				}
			}else{
				throw new NotFoundException(__('Invalid Page'));
			}
		}
		#E : Issue 4240
	}
}
