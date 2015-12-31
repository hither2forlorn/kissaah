<?php
App::uses('AppHelper', 'View/Helper');

class TreeListHelper extends AppHelper {
	var $helpers = array ('Html','Form');
	var $model = null;
	function generate($data){
		$return = '';
		foreach($this->request->params['models'] as $model=> $list){
			$this->model = $model;
			break;
		}
		if ($this->model === null) {
			$this->model = Inflector::classify($this->model);
		}
		$i = 0;
		foreach($data as $l => $result):
			$hasChildren = false;
			$countChildren = 0;
			if ($result['children']) {
				$hasChildren = true;
				$countChildren = count($result['children']);
			}
			if($result[$this->model]['status']==1){
				$status = '<span>visible</span>';
			}else{
				$status = '<span style="color:#FF0000">hidden</span>';
			}
			$return .= '<li>';
			$return .= $result[$this->model]['title'] . $status;
			//if($result[$this->model]['title'] != 'Default Game'){
				$return .= '<span>'.$this->Html->link('Delete',array('action'=>'delete','admin'=>true,$result[$this->model]['id']),array('class'=>'delete', 'title'=>'Delete', 'rel'=>'delete')).'</span>';
			//}
			$return .= '<span>'.$this->Html->link('Edit',array('action'=>'edit','admin'=>true,$result[$this->model]['id']),array('class'=>'edit', 'title'=>'Edit')).'</span>';
			$return .= '<span>'.$this->Html->link('Add Child',array('action'=>'add','admin'=>true,$result[$this->model]['id']),array('class'=>'edit', 'title'=>'Add')).'</span>';
			//if($result[$this->model]['title'] != 'Default Game'){
			$return .= '<span>'.$this->Html->link('Move Up',array('action'=>'moveup','admin'=>false,$result[$this->model]['id'], 1),array('class'=>'edit', 'title'=>'Move Up')).'</span>';
			$return .= '<span>'.$this->Html->link('Move Down',array('action'=>'movedown','admin'=>false,$result[$this->model]['id'], 1),array('class'=>'edit', 'title'=>'Move Down')).'</span>';
			//}
			//	$return .= '<span>'.$this->Html->link('Create Activity',array('action'=>'add_activity','admin'=>true,$result[$this->model]['id']),array('class'=>'add', 'title'=>'Create Activity')).'</span>';
			if ($hasChildren) {
				$return .='<ul  class="childlist">';
				$return .= $this->generate($result['children']);
				$return .='</ul>';
			}
			$return .='</li>';
		endforeach;
		
		return $return;
	}
}