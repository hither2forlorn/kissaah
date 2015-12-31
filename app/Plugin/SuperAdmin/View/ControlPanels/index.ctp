<div id="content-full-screen" style="background: #fff; color: #000;">
	<ul id="sort-box" class="sorts">
		<li><?php
			$this->request->data = array();
			echo $this->Form->create('ControlPanel',array('url'=> array('controller'  => 'control_panels', 'admin' => false, 'plugin' => 'super_admin')));
			echo '<div id="content-panel">';
				echo '<div class="cpanel-wrapper">';
					echo '<div id="content-cpanel-roles">';
						echo $this->Html->tag('h3', Inflector::pluralize($cpanelOption['roleModel']), array('class' => 'header'));
						echo $this->Form->select('Roles', $roleList, array('empty' => false, 'size' => '4'));
					echo '</div>';
					echo '<div id="content-cpanel-plugins">';
						echo $this->Html->tag('h3', 'APP/Plugins', array('class' => 'header'));
						if(!empty($pluginList)) {
							echo $this->Form->select('Plugins', $pluginList, array('empty' => false, 'size' => '4'));
						}
					echo '</div>';
					echo '<div id="content-cpanel-users">';
					echo $this->Html->tag('h3', Inflector::pluralize($cpanelOption['userModel']), array('class' => 'header'));
					echo $this->Form->select('Users', $userList, array('empty' => false, 'size' => '10'));
					echo '</div>';
					echo '<div id="content-cpanel-controllers">';
						echo $this->Html->tag('h3', 'Controllers', array('class' => 'header'));
						echo $this->Form->select('Controllers', $controllerList, array('empty' => false, 'size' => '10'));
					echo '</div>';
				echo '</div>';
				echo '<div class="cpanel-wrapper">';
					echo $this->Html->link('Sync Aco', array('controller' => 'control_panels', 'action' => 'acoSync', 'admin' => false, 'plugin' => 'super_admin'), array('class' => 'btn-70'));
					echo $this->Html->link('Clean Permission', array('controller' => 'control_panels', 'action' => 'cleanPermission', 'admin' => false, 'plugin' => 'super_admin'), array('class' => 'btn-140'));
				echo '</div>';
				echo '<div id="content-cpanel-methods">';
					echo '<h3 class="header">Methods</h3>';
					echo '<h4>Choose User->Controller->Methods to allow or deny</h4>';
				echo '</div>';
			echo '</div>';
		?></li>
	</ul>
</div>