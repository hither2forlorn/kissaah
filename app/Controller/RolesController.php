<?php App::uses('Controller', 'AppController');
class RolesController extends AppController	{

	var $name = 'Roles';

	function beforeFilter()	{
		parent::beforeFilter();
	}


	function index() {
		$this->autoRender = false;
		$data['Role'][0]['id'] = 3;
		$data['Role'][0]['name'] = 'Leader';
		$data['Role'][1]['id'] = 4;
		$data['Role'][1]['name'] = 'Champion';
 		debug($this->Role->saveMany($data['Role']));
	}
}
?>