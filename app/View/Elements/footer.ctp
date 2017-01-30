<div class="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 padding-top-10"><?php 
				echo date('Y') . ' &copy; ' . $this->Session->read('Company.name') . '. All Rights Reserved.&nbsp;';
			?></div>
			<div class="col-md-6 col-sm-6 padding-top-10 text-right"><?php 
				echo $this->Html->link('Privacy Policy', $this->Session->read('Company.link') . '/privacy-policy', array('target' => '_blank'))." | ";
				echo $this->Html->link('Terms of Service', $this->Session->read('Company.link') . '/terms-of-service/', array('target' => '_blank'))." | ";
				echo $this->Html->link('About Us', $this->Session->read('Company.link'), array('target' => '_blank'))." | ";
				//echo $this->Html->link('Blog', $this->Session->read('Company.link') . '/blog', array('target' => '_blank'))." | ";
				//echo $this->Html->link('Advisory Board', $this->Session->read('Company.link') . '/advisors/', array('target' => '_blank'));
			?></div>
			<div class="col-md-6 col-sm-6 padding-top-10 hidden-md hidden-sm hidden-xs">
			<?php
			$list[] = $this->Html->link(
						$this->Html->image('my-settings.png', array('height' => '25px', 'title' => 'My Settings')) . ' Settings', 
						array('controller' => 'users', 'action' => 'profile'), 
						array('escape' => false, 'id' => 'tour-step-05'));
			
			if($this->request->controller == 'games' || $this->request->action == 'index') {
				$list[] = $this->Html->link(
					$this->Html->image('my-tour.png', array('height' => '25px', 'title' => 'Start Tour', 'id' => 'tour-step-11')) . ' Start Tour', 
					'#', array('escape' => false, 'id' => 'game-tour'));
			}
			
			$list[] = $this->Html->link(
						$this->Html->image('support-icon.png', array('height' => '25px', 'title' => 'Support')) . ' Support', 
						array('controller' => 'users', 'action' => 'support'), array('escape' => false, 'class' => 'game-support'));

			$admin = $this->Session->read('Auth.User.role_id');
			if($admin == 1) {
				$list[] = $this->Html->link('Admin', array('controller' => 'users', 'action' => 'index', 'admin' => true),
											array('target' => '_blank'));				
			}
			
			$isFacebook = $this->Session->read('Facebook');
			if($isFacebook) {
				$list[] = $this->Facebook->logout(array('label' => 'Logout', 
												   'redirect' => array('controller' => 'users', 'action' => 'logout'))); 
			} else {
				$list[] = $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout'));
			}
			if($this->Session->read('Auth.User')) {
				echo $this->Html->nestedList($list, array('class' => 'list-unstyled list-inline pull-right'));
			}
			?>
			</div>
		</div>
	</div>
</div>