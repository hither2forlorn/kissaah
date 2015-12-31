<?php

/**
 * WeatherHelper is the helper to the get weather info of weather.com
 * using api.wunderground.com
 *
 * @author: Laxman Maharjan
 * @version: 0.0.1
 * @email: email@mlaxman.com.np
 * @link: http://github.com/lmmrssa
 *
 */
Configure::load('SuperAdmin.cpanel');
if (file_exists(APP . 'Config' . DS . 'cpanel.php')) {
	Configure::load('cpanel');
}

App::uses('AppHelper','View/Helper');
class CpanelHelper extends AppHelper{
	var $helpers = array('Html', 'Form', 'Cache');
	var $columns = array('default' => array('Name', 'Actions', 'Permission', 'Aco'),
			'missing' => array('Name', 'Aco'));
	
	public $options = array(
		'images' => array(
			'permission' => 'permissions.png',
			'allow' => 'allow.png',
			'deny' => 'deny.png',
			'add' => 'add.png',
			'delete' => 'delete.png',
		)
	);
	
	function __construct(View $View, $options = array()){
		$CpanelSettings = Configure::read('Cpanel');
		$this->options = array_merge($CpanelSettings, $options);
		parent::__construct($View, $options);
	}
	
	public function tableHeaders($type = 'default') {
		return $this->Html->tableHeaders($this->columns[$type]);
	}
	
	public function misingTableHeaders($type = 'missing') {
		return $this->tableHeaders($type);
	}
	
	public function tableCells($acoData, $rolePerm = array(), $userPerm = array()) {
		$returnString = '<tr>';
			$returnString .= '<td>'.$acoData['alias'].'</td>';
			$permission = 'permission';
			$acoAction = 'add';
			if(!empty($acoData['id'])) {
				$acoAction = 'delete';
				if(!empty($userPerm['Permission'])) $permData = $userPerm['Permission'];
				elseif(!empty($rolePerm['Permission'])) $permData = $rolePerm['Permission'];
				elseif(!empty($userPerm[$acoData['id']]['Permission'])) $permData = $userPerm[$acoData['id']]['Permission'];
				elseif(!empty($rolePerm[$acoData['id']]['Permission'])) $permData = $rolePerm[$acoData['id']]['Permission'];
				if(isset($permData)) {
					if(($permData[ '_create' ]) &&
					($permData[ '_read' ] == 1 ) &&
					($permData[ '_update' ] == 1 ) &&
					($permData[ '_delete' ] == 1 )) {
						$permission = 'allow';
					} else {
						$permission = 'deny';
					}
				}
			}
			$returnString .= '<td>';
				$returnString .=  $this->Form->radio($acoData['model'].'.'.$acoData['alias'],
					array('allow' => '&nbsp;Allow', 'deny' => '&nbsp;Deny' ),
					array('value' => $permission, 'legend' => false, 'aco-model' => $acoData['model'], 'aco-alias' => $acoData['alias'], 'class' => 'allow-deny-radio')
				);
			$returnString .= '</td>';
			$returnString .= '<td>';
				$returnString .= $this->Html->image('SuperAdmin.cpanel/'.$this->options['images'][$permission], array('alt' => $permission, 'class' => 'perImage'));
			$returnString .= '</td>';
			$returnString .= '<td>';
				$returnString .= $this->Html->image('SuperAdmin.cpanel/'.$this->options['images'][$acoAction], array('class'=>'acoImage', 'alt' => $acoAction, 'aco-model' => $acoData['model'], 'aco-alias' => $acoData['alias'], 'aco-action' => $acoAction));
			$returnString .= '</td>';
		$returnString .= '</tr>';
		return $returnString;
	}
	
	public function missingTableCells($acoData) {
		$acoAction = 'delete';
		$returnString = '<tr>';
			$returnString .= '<td>'.$acoData['alias'].'</td>';
			$returnString .= '<td>';
				$returnString .= $this->Html->image('SuperAdmin.cpanel/'.$this->options['images'][$acoAction], array('class'=>'acoImage','alt' => $acoAction, 'aco-model' => $acoData['model'], 'aco-alias' => $acoData['alias'], 'aco-action' => $acoAction));
			$returnString .= '</td>';
		$returnString .= '</tr>';
		return $returnString;
	}

}
?>