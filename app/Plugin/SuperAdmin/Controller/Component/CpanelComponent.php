<?php
Configure::load('SuperAdmin.cpanel');
if (file_exists(APP . 'Config' . DS . 'cpanel.php')) {
	Configure::load('cpanel');
}
class CpanelComponent extends Component {
	
	protected $controller;
	public $options = array();
	
	function __construct(&$Components, $options = array()) {
		$CpanelSettings = Configure::read('Cpanel');
		$this->options = array_merge($CpanelSettings, $options);
	}
	
	function initialize(Controller $Controller){
		$this->controller = &$Controller;
		$this->data = $this->controller->data;
		$this->params = $this->controller->params;
		$this->controller->Auth->userModel = $this->options['userModel'];
		$this->controller->Auth->authorize = array('Actions' => array('actionPath' => $this->options['coreController']));
	}
	
	function startup(Controller $Controller){
	}
	
	function check($url) {
		$user_id = $this->controller->Auth->user('id');
		if(!$user_id || !$url){
			return false;
		}else{
			$node = array();
			if(!empty($url['plugin'])) $node['Plugin'] = Inflector::camelize($url['plugin']);
			if(!empty($url['controller'])) {
				$node['Controller'] = Inflector::camelize($url['controller']);
				if(!empty($url['action'])) {
					$node['Action'] = $url['action'];
					if($url['admin']) {
						$node['Action'] = 'admin_'.$node['Action'];
					}
				}
			}
			$this->controller->loadModel($this->cpanelOption['userModel']);
			$this->acoClass = new Aco();
			$mainCpanelAcoNode = $this->options['coreController'].'/'.implode('/', array_filter($node));
			$acoNode = $this->acoClass->node($mainCpanelAcoNode);
			if($acoNode) {
				//$authNode = $this->controller->{$this->options['userModel']}->node(array($this->options['userModel'] => array('id' => $this->controller->Auth->user('id'))));
					return $this->controller->Acl->check(array($this->options['userModel'] => array('id' => $user_id)), $mainCpanelAcoNode);
			} else return false;
		}
	}
}
?>
