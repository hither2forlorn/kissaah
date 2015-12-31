<?php
App::uses('SuperAdminAppController', 'SuperAdmin.Controller');
class ControlPanelsController extends SuperAdminAppController {

	public $name = 'ControlPanels';
	public $uses = false;
	public $cpanelOption;
	public $aroClass = null;
	public $acoClass = null;
	
	public function beforeFilter() {
		$this->cpanelOption = $this->Cpanel->options;
		$this->loadModel($this->cpanelOption['userModel']);
		$this->loadModel($this->cpanelOption['roleModel']);
		$this->set('cpanelOption', $this->cpanelOption);
		$this->aroClass = new Aro();
		$this->aroClass->Behaviors->attach('Containable');
		$this->acoClass = new Aco();
		$this->acoClass->Behaviors->attach('Containable');
		$this->permissionClass = new Permission();
		$this->permissionClass->Behaviors->attach('Containable');
		parent::beforeFilter();
		if($this->Auth->user()) {
			$this->is_allowed();
		}
	}

	// Page when logged in
	public function index() {
		$roleList = $this->__getRoleLists();
		$pluginList = $this->__getPluginLists();
		$userList = $controllerList = array();
		$this->set(compact('roleList', 'userList', 'pluginList', 'controllerList'));
	}

	private function __getRoleLists() {
		$roles = $this->{$this->cpanelOption['roleModel']}->find('list', array(
					'fields' => array($this->cpanelOption['roleModel'].'.'.$this->cpanelOption['aroRoleKey'],
						$this->cpanelOption['roleModel'].'.'.$this->cpanelOption['aroRoleName']),
					'order' => array($this->cpanelOption['roleModel'].'.'.$this->cpanelOption['aroRoleName'] => 'ASC')));
		return $roles;
		/* if($this->cpanelOption['rolePrefix']) {
			$roleList = array();
			foreach($roles as $key => $val) {
				$roleList[$this->cpanelOption['rolePrefix'].$key] = $val;
			}
			return $roleList;
		} else {
			return $roles;
		} */
	}

	public function getUserLists($role = null) {
		if(isset($this->request->data['role'])) $role = $this->request->data['role'];
		$this->set('userList', $this->__getUserLists($role));
	}
	
	private function __getUserLists($role = null) {
		$role_id = $this->{$this->cpanelOption['roleModel']}->field('id', array($this->cpanelOption['aroUserKey'] => $role));
	
		$assoc = $this->{$this->cpanelOption['userModel']}->belongsTo;
		$assocConditions = array();
		foreach($assoc as $key => $val) {
			if($key == $this->cpanelOption['roleModel']) {
				$foreign_key = $val['foreignKey'];
				if(!empty($assocConditions)) $conditions = $val['conditions'];
			}
		}
		$conditions = array_merge(array($this->cpanelOption['userModel'].'.'.$foreign_key => $role_id), $assocConditions);
	
		$users = $this->{$this->cpanelOption['userModel']}->find('list', array(
								'conditions' => $conditions,
								'fields' => array($this->cpanelOption['userModel'].'.'.$this->cpanelOption['aroUserKey'],
		$this->cpanelOption['userModel'].'.'.$this->cpanelOption['aroUserName']),
								'order' => array($this->cpanelOption['userModel'].'.'.$this->cpanelOption['aroUserName'] => 'ASC')));
		/* if($this->cpanelOption['userPrefix']) {
		 $userList = array();
		foreach($users as $key => $val) {
		$userList[$this->cpanelOption['userPrefix'].$key] = $val;
		}
		} else {
		$userList = $users;
		}
		return $userList; */
		return $users;
	}

	public function getControllerLists($plugin = null, $path = null, $cache = false) {
		if(isset($this->request->data['plugin'])) $plugin = $this->request->data['plugin'];
		$this->set('controllerList', $this->__getControllerLists($plugin, $path, $cache));
	}
	
	private function __getControllerLists($plugin = null, $path = null, $cache = false) {
		$controllerList = array();
		if (!$plugin || $plugin == 'APP') {
			$controllers = App::objects('Controller', $path, $cache);
		} else {
			$controllers = App::objects($plugin.'.Controller', $path, $cache);
		}
		foreach($controllers as $controller) {
			$key = substr($controller, 0, strrpos($controller, 'Controller'));
			$controllerList[$key] = $controller;
		}
		return $controllerList;
	}

	private function __getPluginLists($path = null, $cache = false) {
		$plugins = App::objects('plugin', $path, $cache);
		$pluginList['APP'] = 'APP';
		foreach($plugins as $plugin) {
			if(CakePlugin::loaded($plugin)) $pluginList[$plugin] = $plugin;
		}
		asort($pluginList);
		return $pluginList;
	}
	
	private function __getMethodLists($controller = null, $plugin = null) {
		$methodList = array();
		$className = $controller.'Controller';
		if($plugin && $plugin != 'APP') App::uses($className, $plugin.'.Controller');
		else App::uses($className, 'Controller');
		$reflectionClass = new ReflectionClass($className);
		$actions = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
		foreach($actions as $actionObj) {
			if($actionObj->class == $className) {
				$methodList[$actionObj->name] = $actionObj->name;
			}
		}
		asort($methodList);
		return $methodList;
	}

	public function getPermissions(){
		if(($this->RequestHandler->isAjax())) {
			$userRole = $this->request->data['role'];
			$user = $this->request->data['user'];
			$plugin = $this->request->data['plugin'];
			$controller = $this->request->data['controller'];
			if(empty($userRole) || empty($plugin)) {
				$this->autoRender = false;
				exit;
			} else {
				$aroTree = $this->__aroTreeList($userRole, $user);
				$acoTree = $this->__acoTreeList($plugin, $controller);
				$permissionTree = $this->__permissionList($aroTree, $acoTree);
				$this->set(compact('userRole', 'user', 'plugin', 'controller', 'aroTree', 'acoTree', 'permissionTree'));
			}
		}
	}
	
	private function __permissionList($aroTree, $acoTree) {
		$RoleCore = $RolePlugin = $RoleController = $RoleTree = $UserCore = $UserPlugin = $UserController = $UserTree = null;
		if(!empty($acoTree['acoChild']['childAcoTree'])) {
			foreach($acoTree['acoChild']['childAcoTree'] as $acoChildTree) {
				if(!empty($acoChildTree['Aco']['id'])) {
					if(!empty($aroTree['roleAro'])) {
						$RoleTree[$acoChildTree['Aco']['id']] = $this->permissionClass->find('first', array('conditions' => array('Permission.aro_id' => $aroTree['roleAro']['Aro']['id'], 'Permission.aco_id' => $acoChildTree['Aco']['id']), 'contain' => false));
					}
					if(!empty($aroTree['userAro'])) {
						$UserTree[$acoChildTree['Aco']['id']] = $this->permissionClass->find('first', array('conditions' => array('Permission.aro_id' => $aroTree['userAro']['Aro']['id'], 'Permission.aco_id' => $acoChildTree['Aco']['id']), 'contain' => false));
					}
				}
			}
		}
		if(!empty($aroTree['roleAro'])) {
			if(!empty($acoTree['coreAco']))
				$RoleCore = $this->permissionClass->find('first', array('conditions' => array('Permission.aro_id' => $aroTree['roleAro']['Aro']['id'], 'Permission.aco_id' => $acoTree['coreAco']['Aco']['id']), 'contain' => false));
			if(!empty($acoTree['pluginAco']))
				$RolePlugin = $this->permissionClass->find('first', array('conditions' => array('Permission.aro_id' => $aroTree['roleAro']['Aro']['id'], 'Permission.aco_id' => $acoTree['pluginAco']['Aco']['id']), 'contain' => false));
			if(!empty($acoTree['controllerAco']))
				$RoleController = $this->permissionClass->find('first', array('conditions' => array('Permission.aro_id' => $aroTree['roleAro']['Aro']['id'], 'Permission.aco_id' => $acoTree['controllerAco']['Aco']['id']), 'contain' => false));
		}
		if(!empty($aroTree['userAro'])) {
			if(!empty($acoTree['coreAco']))
				$UserCore = $this->permissionClass->find('first', array('conditions' => array('Permission.aro_id' => $aroTree['userAro']['Aro']['id'], 'Permission.aco_id' => $acoTree['coreAco']['Aco']['id']), 'contain' => false));
			if(!empty($acoTree['pluginAco']))
				$UserPlugin = $this->permissionClass->find('first', array('conditions' => array('Permission.aro_id' => $aroTree['userAro']['Aro']['id'], 'Permission.aco_id' => $acoTree['pluginAco']['Aco']['id']), 'contain' => false));
			if(!empty($acoTree['controllerAco']))
				$UserController = $this->permissionClass->find('first', array('conditions' => array('Permission.aro_id' => $aroTree['userAro']['Aro']['id'], 'Permission.aco_id' => $acoTree['controllerAco']['Aco']['id']), 'contain' => false));
		}
		return array('RoleCore' => $RoleCore, 'RolePlugin' => $RolePlugin, 'RoleController' => $RoleController, 'RoleTree' => $RoleTree, 'UserCore' => $UserCore, 'UserPlugin' => $UserPlugin, 'UserController' => $UserController, 'UserTree' => $UserTree);
	}

	private function __aroTreeList($userRole = null, $user = null) {
		$roleAro = $userAro = null;
		if(!empty($userRole)) {
			$roleAro = $this->aroClass->find('first', array('conditions' => array('Aro.alias' => $this->cpanelOption['rolePrefix'].$userRole, 'Aro.model' => $this->cpanelOption['roleModel'], 'Aro.parent_id' => NULL), 'contain' => array(false)));
			if(!empty($roleAro['Aro']['foreign_key'])) {
				$roleAro['name'] = $this->{$this->cpanelOption['roleModel']}->field($this->cpanelOption['aroRoleName'], array($this->cpanelOption['roleModel'].'.id' => $roleAro['Aro']['foreign_key']));
				if(!empty($user)) {
					$userAro = $this->aroClass->find('first', array('conditions' => array('Aro.alias' => $this->cpanelOption['rolePrefix'].$user, 'Aro.model' => $this->cpanelOption['userModel'], 'Aro.parent_id' => $roleAro['Aro']['id']), 'contain' => false));
					if(!empty($userAro['Aro']['foreign_key'])) {
						$userAro['name'] = $this->{$this->cpanelOption['userModel']}->field($this->cpanelOption['aroUserName'], array($this->cpanelOption['userModel'].'.id' => $roleAro['Aro']['foreign_key']));
					}
				}
			}
		}
		$this->set(compact('roleAro', 'userAro'));
		return array('roleAro' => $roleAro, 'userAro' => $userAro);
	}
	
	private function __acoTreeList($plugin = null, $controller = null) {
		$coreAco = $pluginAco = $controllerAco = $acoParent = $acoTree = null;
		$coreAco = $this->acoClass->find('first', array('conditions' => array('Aco.alias' => $this->cpanelOption['coreController'], 'Aco.model' => 'APP', 'Aco.parent_id' => NULL), 'contain' => false));
		if(empty($coreAco)) $coreAco = $this->__emptyAco('APP');
		if($plugin == 'APP') {
			$acoParent = $coreAco;
			if(!empty($controller)) {
				$controllerAco = $this->acoClass->find('first', array('conditions' => array('Aco.alias' => $controller, 'Aco.model' => 'Controller', 'Aco.parent_id' => $coreAco['Aco']['id']), 'contain' => false));
				if(empty($controllerAco)) $controllerAco = $this->__emptyAco('Controller', $plugin, $controller, null, $coreAco);
				$acoParent = $controllerAco;
			}
		} elseif($plugin != 'APP') {
			$pluginAco = $this->acoClass->find('first', array('conditions' => array('Aco.alias' => $plugin, 'Aco.model' => 'Plugin', 'Aco.parent_id' => $coreAco['Aco']['id']), 'contain' => false));
			if(empty($pluginAco)) $pluginAco = $this->__emptyAco('Plugin', $plugin, $controller, null, $coreAco);
			$acoParent = $pluginAco;
				
			if(!empty($controller)) {
				if(!empty($pluginAco['Aco']['id'])) $controllerAco = $this->acoClass->find('first', array('conditions' => array('Aco.alias' => $controller, 'Aco.model' => 'Controller', 'Aco.parent_id' => $pluginAco['Aco']['id']), 'contain' => false));
				if(empty($controllerAco)) $controllerAco = $this->__emptyAco('Controller', $plugin, $controller, null, $pluginAco);
				$acoParent = $controllerAco;
			}
		}
		$acoChild = $this->__childAco($acoParent, $plugin, $controller);
		return array('coreAco' => $coreAco, 'pluginAco' => $pluginAco, 'controllerAco' => $controllerAco, 'acoParent' => $acoParent, 'acoChild' => $acoChild);
	}
	
	private function __emptyAco($model = null, $plugin = null, $controller = null, $action = null, $parentNode = array()) {
		$emptyAco = array();
		$parentId = (!empty($parentNode['Aco']['id'])) ? $parentNode['Aco']['id'] : null;
		if($model == 'APP') {
			$emptyAco = array('Aco' => array('id' => null, 'model' => 'APP', 'alias' => $this->cpanelOption['coreController'], 'parent_id' => $parentId));
		} elseif($model == 'Plugin') {
			$pluginList = $this->__getPluginLists();
			if(in_array($plugin, $pluginList)) {
				$emptyAco = array('Aco' => array('id' => null, 'model' => 'Plugin', 'alias' => $plugin, 'parent_id' => $parentId));
			}
		} elseif($model == 'Controller') {
			if($plugin == 'APP' || CakePlugin::loaded($plugin)) $controllerList = $this->__getControllerLists($plugin);
			if(in_array($controller.'Controller', $controllerList)) {
				$emptyAco = array('Aco' => array('id' => null, 'model' => 'Controller', 'alias' => $controller, 'parent_id' => $parentId));
			}
		} elseif($model == 'Action') {
			if($plugin == 'APP' || CakePlugin::loaded($plugin)) $methodList = $this->__getMethodLists($controller, $plugin);
			if(in_array($action, $methodList)) {
				$emptyAco = array('Aco' => array('id' => null, 'model' => 'Action', 'alias' => $action, 'parent_id' => $parentId));
			}
		}
		return $emptyAco;
	}
	
	private function __childAco($parentAco = null, $plugin = null, $controller = null) {
		$childModel = $acoChild = $childList = $acoFlatList = $missingChild = $childAcoTree = array();
		if($parentAco['Aco']['model'] == 'Plugin' || $parentAco['Aco']['model'] == 'APP') {
			if($plugin == 'APP' || CakePlugin::loaded($plugin)) {
				$childModel = 'Controller';
				$childList = $this->__getControllerLists($plugin);
				$childList = array_keys($childList);
			}
		} elseif($parentAco['Aco']['model'] == 'Controller') {
			$childModel = 'Action';
			if($plugin == 'APP' || CakePlugin::loaded($plugin)) $childList = $this->__getMethodLists($controller, $plugin);
		}
		if(!empty($parentAco['Aco']['id'])) {
			$acoChild = $this->acoClass->find('all', array('conditions' => array('Aco.parent_id' => $parentAco['Aco']['id'], 'Aco.model' => $childModel), 'contain' => false, 'order' => array('FIELD(Aco.model, "APP", "Plugin", "Controller", "Action")', 'Aco.alias' => 'ASC')));
			if(!empty($acoChild)) {
				$acoFlatList = Set::classicExtract($acoChild, '{n}.Aco.alias');
				foreach($acoChild as $child) {
					if(!in_array($child['Aco']['alias'], $childList)) {
						$missingChild[] = $child;
					} elseif(in_array($child['Aco']['alias'], $childList)) {
						$childAcoTree[] = $child;
					}
				}
			}
		}
		$diffAcoList = array_diff($childList, $acoFlatList);
		if($parentAco['Aco']['model'] == 'Plugin' || $parentAco['Aco']['model'] == 'APP') {
			foreach($diffAcoList as $controllerName) {
				$childAcoTree[] = array('Aco' => array('id' => null, 'model' => 'Controller', 'alias' => $controllerName));
			}
		} elseif($parentAco['Aco']['model'] == 'Controller') {
			foreach($diffAcoList as $method) {
				$childAcoTree[] = array('Aco' => array('id' => null, 'model' => 'Action', 'alias' => $method));
			}
		}
		return array('childAcoTree' => Set::sort($childAcoTree, '{n}.Aco.alias', 'asc'),
			'missingAco' => Set::sort($missingChild, '{n}.Aco.alias', 'asc'));
	}
	
	public function security() {
		$this->autoRender = false;
		$return['status'] = false;
		if(($this->RequestHandler->isAjax())) {
			$userRole = $this->request->data['role'];
			$user = $this->request->data['user'];
			$plugin = $this->request->data['plugin'];
			$controller = $this->request->data['controller'];
			$acoModel = $this->request->data['acoModel'];
			$acoAlias = $this->request->data['acoAlias'];
			$acoAction = $this->request->data['acoAction'];
			if(empty($userRole) || empty($plugin) || empty($acoAlias) || empty($acoModel) || empty($acoAction)) {
				$return['status'] = false;
			} else {
				$parentAlias = array();
				$currentNode = $parentNode = false;
				$nodeString = '';
				$nodeData = $this->acoClass->find('first', array('conditions' => array('Aco.model' => 'APP', 'Aco.alias' => $this->cpanelOption['coreController'], 'parent_id' => null), 'contain' => false));
				if(empty($nodeData)) {
					$nodeData = $this->__acoAction($acoAction, 'APP');
				}
				$parentNode = $nodeData;
				$parentAlias[] = $nodeData['Aco']['alias'];
				if(!empty($parentNode) && $acoModel == 'APP' && $acoAlias == $this->cpanelOption['coreController']) {
					$currentNode = $parentNode;
				}
				if(!$currentNode && !empty($parentNode) && $plugin != 'APP') {
					if(empty($plugin) && $acoModel == 'Plugin') $plugin = $acoAlias;
					$nodeData = $this->acoClass->find('first', array('conditions' => array('Aco.model' => 'Plugin', 'Aco.alias' => $plugin, 'parent_id' => $parentNode['Aco']['id']), 'contain' => false));
					if(empty($nodeData)) {
						$nodeData = $this->__acoAction($acoAction, 'Plugin', $plugin, $controller, null, $parentNode);
					}
					$parentNode = $nodeData;
					$parentAlias[] = $nodeData['Aco']['alias'];
					if($acoModel == 'Plugin') $currentNode = $nodeData;
				}
				if(!$currentNode && !empty($parentNode)) {
					if(empty($controller) && $acoModel == 'Controller') $controller = $acoAlias;
					$nodeData = $this->acoClass->find('first', array('conditions' => array('Aco.model' => 'Controller', 'Aco.alias' => $controller, 'parent_id' => $parentNode['Aco']['id']), 'contain' => false));
					if(empty($nodeData)) $nodeData = $this->__acoAction($acoAction, 'Controller', $plugin, $controller, null, $parentNode);
					$parentNode = $nodeData;
					$parentAlias[] = $nodeData['Aco']['alias'];
					if($acoModel == 'Controller') $currentNode = $nodeData;
				}
				if(!$currentNode && !empty($parentNode)) {
					$nodeData = $this->acoClass->find('first', array('conditions' => array('Aco.model' => $acoModel, 'Aco.alias' => $acoAlias, 'parent_id' => $parentNode['Aco']['id']), 'contain' => false));
					if(empty($nodeData)) $nodeData = $this->__acoAction($acoAction, $acoModel, $plugin, $controller, $acoAlias, $parentNode);
					$parentAlias[] = $nodeData['Aco']['alias'];
					if($acoModel == 'Action') $currentNode = $nodeData;
				}
				if(!empty($currentNode)) {
					if($acoAction == 'delete') {
						$return['status'] = $this->acoClass->delete($currentNode['Aco']['id']);
					} elseif($acoAction == 'add') {
						$return['status'] = true;
					} else {
						$aroNode = $this->aroClass->find('first', array('conditions' => array('Aro.alias' => $this->cpanelOption['rolePrefix'].$userRole, 'Aro.model' => $this->cpanelOption['roleModel'], 'Aro.parent_id' => NULL), 'contain' => array(false)));
						if(!empty($user)) {
							$aroNode = $this->aroClass->find('first', array('conditions' => array('Aro.alias' => $this->cpanelOption['userPrefix'].$user, 'Aro.model' => $this->cpanelOption['userModel'], 'Aro.parent_id' => $aroNode['Aro']['id']), 'contain' => array(false)));
						}
						if ($acoAction == 'allow') {
							$return['status'] = $this->Acl->allow($aroNode['Aro'], implode('/', $parentAlias));
						} elseif ($acoAction == 'deny') {
							$return['status'] = $this->Acl->deny($aroNode['Aro'], implode('/', $parentAlias));
						}
					}
				}
			}
			if($return['status']) {
				if(in_array($acoAction, array('add', 'delete'))) {
					$return['permAlt'] = 'permission';
					$return['permValue'] = '';
					if($acoAction == 'add') $return['acoAlt'] = 'delete';
					else $return['acoAlt'] = 'add';
				} else {
					$return['permAlt'] = $acoAction;
					$return['permValue'] = $acoAction;
					$return['acoAlt'] = 'delete';
				}
				$return['permImage'] = $this->cpanelOption['images'][$return['permAlt']];
				$return['acoImage'] = $this->cpanelOption['images'][$return['acoAlt']];
			}
			return json_encode($return);
		}
	}
	
	private function __acoAction($addDel = 'delete', $model = null, $plugin = null, $controller = null, $action = null, $parentNode = array()) {
		$nodeData = array();
		if($addDel != 'delete') {
			$nodeData = $this->__emptyAco($model, $plugin, $controller, $action, $parentNode);
			$this->acoClass->save($nodeData);
			$nodeData['Aco']['id'] = $this->acoClass->id;
		}
		return $nodeData;
	}
	
	
	private function is_allowed() {
		$mainCpanelAcoNode = $this->cpanelOption['coreController'].'/'.implode('/', array_filter($this->cpanelOption['mainAco']));
		if(!$this->acoClass->node($mainCpanelAcoNode)) {
			$allowedAro[$this->cpanelOption['roleModel']] = $allowedAro[$this->cpanelOption['userModel']] = array();
			if(!empty($this->cpanelOption['perm'])) {
				foreach($this->cpanelOption['perm'] as $perm) {
					if($perm['model'] == $this->cpanelOption['roleModel']) {
						$allowedAro[$perm['model']][] = $this->cpanelOption['rolePrefix'].$perm['alias'];
					} elseif($perm['model'] == $this->cpanelOption['userModel']) {
						$allowedAro[$perm['model']][] = $this->cpanelOption['userPrefix'].$perm['alias'];
					}
				}
			}
			$authNode = $this->{$this->cpanelOption['userModel']}->node(array($this->cpanelOption['userModel'] => array('id' => $this->Auth->user('id'))));
			foreach($authNode as $auth_node) {
				if(empty($this->cpanelOption['perm']) || in_array($auth_node['Aro']['alias'], $allowedAro[$auth_node['Aro']['model']])) {
					//$this->Auth->allowedActions = array('index', 'getControllerLists', 'getControllerPermissions', 'getControllerMethods', 'security');
					$this->Auth->allow();
				}
			}
		}
	}

	public function acoSync() {
		$acoNodeIds = array();
		$nodeData = $this->acoClass->find('first', array('conditions' => array('Aco.model' => 'APP', 'Aco.alias' => $this->cpanelOption['coreController'], 'parent_id' => null), 'contain' => false));
		if(empty($nodeData)) {
			$nodeData = $this->__acoAction('add', 'APP');
		}
		$nodeCore = $nodeData;
		//echo $this->cpanelOption['coreController'].'(Core) : Success<br/>';
		if(!empty($nodeCore)) {
			$acoNodeIds[] = $nodeData['Aco']['id'];
			$pluginList = $this->__getPluginLists();
			foreach($pluginList as $plugin) {
				if($plugin == 'APP') {
					$nodePlugin = $nodeCore;
				} elseif($plugin != 'APP') {
					$nodeData = $this->acoClass->find('first', array('conditions' => array('Aco.model' => 'Plugin', 'Aco.alias' => $plugin, 'parent_id' => $nodeCore['Aco']['id']), 'contain' => false));
					if(empty($nodeData)) {
						$nodeData = $this->__acoAction('add', 'Plugin', $plugin, null, null, $nodeCore);
					}
					$nodePlugin = $nodeData;
					//echo $this->cpanelOption['coreController'].'(Core) > '.$plugin.'(Plugin) : Success<br/>';
				}
				if(!empty($nodePlugin)) {
					$acoNodeIds[] = $nodeData['Aco']['id'];
					$controllerList = $this->__getControllerLists($plugin);
					foreach($controllerList as $key => $controller) {
						$nodeData = $this->acoClass->find('first', array('conditions' => array('Aco.model' => 'Controller', 'Aco.alias' => $key, 'parent_id' => $nodePlugin['Aco']['id']), 'contain' => false));
						if(empty($nodeData)) {
							$nodeData = $this->__acoAction('add', 'Controller', $plugin, $key, null, $nodePlugin);
						}
						//echo $this->cpanelOption['coreController'].' > '.$plugin.' > '.$controller.' : Success<br/>';
						$nodeController = $nodeData;
						if(!empty($nodeController)) {
							$acoNodeIds[] = $nodeData['Aco']['id'];
							$methodList = $this->__getMethodLists($key, $plugin);
							foreach($methodList as $method) {
								$nodeData = $this->acoClass->find('first', array('conditions' => array('Aco.model' => 'Action', 'Aco.alias' => $method, 'parent_id' => $nodeController['Aco']['id']), 'contain' => false));
								if(empty($nodeData)) {
									$nodeData = $this->__acoAction('add', 'Action', $plugin, $key, $method, $nodeController);
								}
								if(!empty($nodeData))
									$acoNodeIds[] = $nodeData['Aco']['id'];
							}
							//echo $this->cpanelOption['coreController'].'(Core) > '.$plugin.'(Plugin) > '.$controller.' > Methods : Success<br/>';
						}
					}
				}
			}
		}
		$this->acoClass->deleteAll(array('id NOT' => $acoNodeIds), true);
		//echo 'Delete all missing nodes: Success<br/>';
		$this->redirect($this->referer());
	}
	
	public function cleanPermission() {
		$this->acoClass->deleteAll();
		$this->permissionClass->deleteAll();
		$this->redirect($this->referer());
	}
}
?>