<?php
echo $this->Html->tag('h4', $acoTree['coreAco']['Aco']['model'].' Permission', array('class' => 'methodHeader'));
echo '<table class="cpanel">';
	echo $this->Cpanel->tableHeaders();
	echo $this->Cpanel->tableCells($acoTree['coreAco']['Aco'], $permissionTree['RoleCore'], $permissionTree['UserCore']);
echo '</table>';

if(!empty($acoTree['pluginAco'])) {
	echo $this->Html->tag('h4', $acoTree['pluginAco']['Aco']['model'].' Permission', array('class' => 'methodHeader'));
	echo '<table class="cpanel">';
	echo $this->Cpanel->tableHeaders();
	echo $this->Cpanel->tableCells($acoTree['pluginAco']['Aco'], $permissionTree['RolePlugin'], $permissionTree['UserPlugin']);
	echo '</table>';
}

if(!empty($acoTree['controllerAco']['Aco'])) {
	echo $this->Html->tag('h4', $acoTree['controllerAco']['Aco']['model'].' Permission', array('class' => 'methodHeader'));
	echo '<table class="cpanel">';
		echo $this->Cpanel->tableHeaders();
		echo $this->Cpanel->tableCells($acoTree['controllerAco']['Aco'], $permissionTree['RoleController'], $permissionTree['UserController']);
	echo '</table>';
}

$model = '';
$tableOpen = false;
foreach($acoTree['acoChild']['missingAco'] as $cnt => $child) {
	if($model != $child['Aco']['model']) {
		if($tableOpen) {
			echo '</table>';
			$tableOpen = false;
		}
		$model = $child['Aco']['model'];
		echo $this->Html->tag('h4', $model.' missing in '.$acoTree['acoParent']['Aco']['alias'].' ('.$acoTree['acoParent']['Aco']['model'].')', array('class' => 'methodHeader'));
		$tableOpen = true;
		echo '<table class="cpanel">';
			echo $this->Cpanel->tableHeaders('missing');
	}
			echo $this->Cpanel->missingTableCells($child['Aco']);
	if($tableOpen && (($cnt+1) == count($acoTree['acoChild']['missingAco']))) echo '</table>';
}

$model = '';
$tableOpen = false;
foreach($acoTree['acoChild']['childAcoTree'] as $cnt => $child) {
	if($model != $child['Aco']['model']) {
		if($tableOpen) {
			echo '</table>';
			$tableOpen = false;
		}
		$model = $child['Aco']['model'];
		echo $this->Html->tag('h4', $model.' available in '.$acoTree['acoParent']['Aco']['alias'].' ('.$acoTree['acoParent']['Aco']['model'].')', array('class' => 'methodHeader'));
		$tableOpen = true;
		echo '<table class="cpanel">';
			echo $this->Cpanel->tableHeaders();
	}
			echo $this->Cpanel->tableCells($child['Aco'], $permissionTree['RoleTree'], $permissionTree['UserTree']);
	if($tableOpen && (($cnt+1) == count($acoTree['acoChild']['childAcoTree']))) echo '</table>';
}

exit;
//$coreAco $pluginAco $controllerAco $acoParent $acoChild


$methodNum = 0;
$acoMethods = array();
$acoActs = array();

	//Generate the aco tree with permissions
	foreach ( $acoTree as $item ) {
        // id
        $aco_id = $item['Aco']['id'];
        //$aco_id = str_replace( "_", "", $item );
        
        // record details
        $acoRecord = array();
        $selected = '';
        foreach ( $acoRecords as $aco ) {
		        if($aco['Aco']['model'] == $controller){  //IF controller name matches the model name
				
		            if ( $aco['Aco']['id'] == $aco_id ) {
		                $acoRecord = $aco;
		                $acoActs[] = $aco['Aco']['alias'];
		                // check whether its been selected
		                $aroRecords = $aco['Aro'];
		                
						//check if it is in aco table or not
		                foreach ( $aroRecords as $aro ) {
		                    if ( $aro[ 'alias' ] == $current_alias ) {
		                        if (    ( $aro[ 'Permission' ][ '_create' ] == 1 ) &&
		                                ( $aro[ 'Permission' ][ '_read' ] == 1 ) &&
		                                ( $aro[ 'Permission' ][ '_update' ] == 1 ) &&
		                                ( $aro[ 'Permission' ][ '_delete' ] == 1 )
		                            ) {
		                            $selected = 'allow';
									$acoMethods[$methodNum]['name'] = $aco['Aco'][ 'alias' ];
									$acoMethods[$methodNum]['permission'] = $selected;
									$methodNum++;
		                            break;
		                        }
		                        else {
		                            $selected = 'deny';
									$acoMethods[$methodNum]['name'] = $aco['Aco'][ 'alias' ];
									$acoMethods[$methodNum]['permission'] = $selected;
									$methodNum++;
		                            break;
		                        }
								
		                    }
							}
		                }
		         }
		}
	 }
	 
	//get all methods with the controller itself
	$methods = array();
	foreach($actions as $controlMethods){
		$method = str_replace( 'function ', '', $controlMethods );
		$method = str_replace( '(', '', $method );
		if($method[0] != '_')
			$methods[] = $method;
	}


sort($methods);

// Root Controller Access
	echo '<h4 class="methodHeader"> -- Controller Permission --</h3>';
		echo '<table class="cpanel">';
		?>
		<tr>
			<th><?php echo __('Controller');?></th>
		<th><?php echo __('Actions');?></th>
		<th><?php echo __('Permission');?></th>
		<th><?php echo __('Aco');?></th>
		</tr>
		<?php
		echo '<tr><td>'.$controller.'</td><td>';
		$fileName = '';
		foreach($acoMethods as $methodActions){
			if($methodActions['name'] == $controller){
					if($methodActions['permission'] == 'allow'){
						$fileName = 'allow';
						break;
					}
					else{
						$fileName = 'deny';
						break;
					}
				
			}
	  	}
		if(empty($fileName)){  //if nothing is done to methods
			$fileName = 'permissions';
		}
		
		echo $this->Form->radio(  '1-'.$controller.'-',
	                                array(  'allow' => '&nbsp;Allow',
	                                        'deny' => '&nbsp;Deny' ),
	                                array( 'value' => $fileName,
	                                        'legend' => false,'title'=>'methods', 'class' => 'allow-deny-radio')
	                                );
			echo '</td><td>';
			//show image of permission if the permission is not set
			//$fileName = 'permissions';
				$fileExtension = 'png';
				echo $this->Html->image('SuperAdmin.cpanel/'.$fileName.'.'.$fileExtension, array('id'=>'img'.$methodNum ,'alt' => $fileName,'title'=>'methods','class' => 'perImage'));
			echo '</td><td>';
			
			$acoAlt = '';
			foreach($acoActs as $acoMeths){
				if($controller == $acoMeths ){
					$acoAlt =  'delete';
					break;
				}
			}
			if($acoAlt== '')
				$acoAlt = 'add';
			
			echo $this->Html->image('SuperAdmin.cpanel/'.$acoAlt.'.'.$fileExtension, array('id'=>'1-'.$controller.'-picChange','class'=>'acoImage','title'=>'methods','alt' => $acoAlt));
			echo'</td></tr>';
			$methodNum++;
		
		
?>
</table>
<?php


	//Show if the methods are not availble in controller
	
	
	$noMethods = array();
	foreach($acoActs as $acActs){
		$flag_method = 0;
			foreach($methods as $acMethods){
				if($acActs ==  $acMethods || $controller == $acActs){
					$flag_method = 1;
				 	break;
				}
			}
		if($flag_method == 0){   //method not found
			$noMethods[] = $acActs;
		}
	}


	if(!empty($noMethods)){
		echo '<h4 class="methodHeader"> Methods Missing in the controller.</h3>';

		echo '<table class="cpanel">';
		?>
		<tr>
			<th><?php echo __('Methods');?></th>
			<th><?php echo __('Aco');?></th>
		</tr>
		<?php
		foreach($noMethods as $delMethods){
		?>
			<tr >
			
			<?php
				echo '<td>'.$delMethods.'</td><td>';
				$acoAlt = 'delete';
				$fileExtension = 'png';
		
				echo $this->Html->image('SuperAdmin.cpanel/'.$acoAlt.'.'.$fileExtension, array('id'=>'2-'.$delMethods.'-picDelete' ,'class'=>'acoImage','alt' => $acoAlt,'title'=>'methods'));
				
				
				echo'</td></tr>';
		}
		echo '</table>';
	}
?>
<?php
	
	/*
	 * get lists of methods and their permissions
	 * 	$acoMethods[]['name'] and $acoMethods[]['permission']
	 */
	 
	echo '<h4 class="methodHeader"> Methods available in controller.</h3>';
	echo '<table class="cpanel">';
	?>
	<tr>
		<th><?php echo __('Methods');?></th>
		<th><?php echo __('Actions');?></th>
		<th><?php echo __('Permission');?></th>
		<th><?php echo __('Aco');?></th>
	</tr>
	<?php
	$methodNum = 0;

	
	
	
	//debug($acoActs);
	//debug($methods);
	foreach($methods as $controlMethods){
		$method = $controlMethods;
		$fileName = '';
		foreach($acoMethods as $methodActions){
			if($methodActions['name'] == $method){
				if($methodActions['permission'] == 'allow'){
					$fileName = 'allow';
					break;
				}
				else{
					$fileName = 'deny';
					break;
				}
			}
	  }
	if(empty($fileName)){  //if nothing is done to methods
		$fileName = 'permissions';
	}
	
	
	
		?>
		<tr>
		
		<?php
			echo '<td>'.$method.'</td>';
			//echo '<td class="actions"> <input type="radio" name="permission'.$methodNum.'" method = "'.$method.'" value="1">Allow </td>';
			//echo '<td class="actions"> <input type="radio" name="permission'.$methodNum.'" method = "'.$method.'" value="0">Deny </td>';
			echo '<td>';
			echo $this->Form->radio(  '2-'.$method.'-',
	                                array(  'allow' => '&nbsp;Allow',
	                                        'deny' => '&nbsp;Deny' ),
	                                array( 'value' => $fileName,
	                                        'legend' => false,'title'=>'methods', 'methodName'=>$method, 'class' => 'allow-deny-radio')
	                                );
			echo '</td><td>';
			//show image of permission if the permission is not set
			//$fileName = 'permissions';
				$fileExtension = 'png';
				echo $this->Html->image('SuperAdmin.cpanel/'.$fileName.'.'.$fileExtension, array('id'=>'img'.$methodNum ,'alt' => $fileName,'title'=>'methods','class' => 'perImage'));
			echo '</td><td>';
			
			$acoAlt = '';
			foreach($acoActs as $acoMeths){
				if($method == $acoMeths ){
					$acoAlt =  'delete';
					break;
				}
			}
			if($acoAlt== '')
				$acoAlt = 'add';
			
			echo $this->Html->image('SuperAdmin.cpanel/'.$acoAlt.'.'.$fileExtension, array('id'=>'2-'.$method.'-picChange' ,'class'=>'acoImage','alt' => $acoAlt,'title'=>'methods'));
			echo'</td></tr>';
			$methodNum++;
		}
	echo '</table>';
?>