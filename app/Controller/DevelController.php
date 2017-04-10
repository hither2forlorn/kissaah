<?php
class DevelController extends AppController {
	
	public function beforeRender() {
		$this->redirect(array('controller' => 'pages'));
	}
	
	public function index() {
		$this->redirect(array('controller' => 'pages'));
	}
}