<?php
Configure::load('SuperAdmin.cpanel');
if (file_exists(APP . 'Config' . DS . 'cpanel.php')) {
	Configure::load('cpanel');
}
class CpanelBehavior extends ModelBehavior {

	var $options = array();
	
	public function pNode(&$Model) {
		if($Model->alias == $this->options['roleModel']) {
			return null;
		} elseif($Model->alias == $this->options['userModel']) {
			if (!$Model->id && empty($Model->data)) {
				return null;
			}
			$data = $Model->data;
			if (empty($data[$this->options['userModel']][$this->options['roleKey']])) {
				$data = $Model->read();
			}
			if (empty($data[$this->options['userModel']][$this->options['roleKey']])) {
				return null;
			} else {
				return array($this->options['roleModel'] => array('id' => $data[$this->options['userModel']][$this->options['roleKey']]));
			}
		}
	}
	
	function setUp(Model $Model, $options = array()){
		$CpanelSettings = Configure::read('Cpanel');
		if(!is_array($options)){
			$options = array();
		}
		$this->options = array_merge($CpanelSettings, $options);
		if($Model->alias == $this->options['userModel'] || $Model->alias == $this->options['roleModel'])
			$Model->Behaviors->load('Acl', array('type' => 'requester'));
	}
	
	function afterSave(Model $Model, $created,$options=array()) {
		if($created && ($Model->alias == $this->options['roleModel'] || $Model->alias == $this->options['userModel'])) {
			$data = $Model->data[$Model->alias];
			$data['id'] = $Model->id;
			$node = $Model->node();
			$node = $node[0];
			if($Model->alias == $this->options['roleModel']) {
				$node['Aro']['alias'] = $this->options['rolePrefix'].$data[$this->options['aroRoleKey']];
			} elseif($Model->alias == $this->options['userModel']) {
				$node['Aro']['alias'] = $this->options['userPrefix'].$data[$this->options['aroUserKey']];
			}
			$Model->Aro->save($node);
		}
		return true;
	}
	
}
?>
