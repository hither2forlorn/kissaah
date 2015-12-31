<?php
App::uses('AppController', 'Controller');
class SuperAdminAppController extends AppController{

	public function beforeFilter() {
		parent::beforeFilter();
		$this->viewClass = 'View';
	}
	
	public function beforeRender() {
		//parent::beforeRender();
		$this->theme = null;
	}
	
}
?>