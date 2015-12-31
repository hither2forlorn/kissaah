<?php App::uses('Controller', 'AppController');
class RolesController extends AppController	{

	var $name = 'Roles';

	function beforeFilter()	{
		parent::beforeFilter();
	}


	function index() {
		$this->autoRender = false;
		$data['Role'][0]['id'] = 1;
		$data['Role'][0]['name'] = 'Admin';
		$data['Role'][1]['id'] = 2;
		$data['Role'][1]['name'] = 'User';
 		debug($this->Role->saveMany($data['Role']));
	}
}
?>