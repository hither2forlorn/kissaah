<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
	<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
	<div class="page-sidebar navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
		<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
		<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
		<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
			<li class="sidebar-toggler-wrapper">
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				<div class="sidebar-toggler"></div>
				<!-- END SIDEBAR TOGGLER BUTTON -->
			</li>
			<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
			<li class="sidebar-search-wrapper">
				<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
				<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
				<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
				<?php echo $this->Form->create('Account', array('action' => 'search', 'class' => 'sidebar-search')); ?>
				<a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
				<div class="input-group">
					<?php echo $this->Form-> input('search', array('label' => false, 'div' => false, 'placeholder' => 'Search...', 'class' => 'form-control')); ?>
					<span class="input-group-btn"> <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a> </span>
				</div>
				<?php echo $this->Form->end(); ?>
				<!-- END RESPONSIVE QUICK SEARCH FORM -->
			</li><?php
				$menus[] = array('name' => ' Dashboard', 'icon' => 'icon-home', 'url' => 'admin/');
				$menus[] = array('name' => ' Configure Game', 'icon' => 'icon-bar-chart', 'url' => 'admin/configurations');
				$menus[] = array('name' => ' Value/Strength', 'icon' => 'icon-bar-chart', 'url' => 'admin/value_strength_categories');
				$menus[] = array('name' => ' Users', 'icon' => 'icon-user', 'url' => 'admin/users/view/');
				$menus[] = array('name' => ' Control Panel', 'icon' => 'icon-screen-smartphone', 'url' => 'super_admin/control_panels');
				$menus[] = array('name' => ' Collage', 'icon' => 'icon-graph',
								 'child' => array(
											array('name' => ' Image Activity', 'url' => 'admin/games/collage/Image%20Activity', 'icon' => 'fa-bullhorn'),
											array('name' => ' Cartoon Upload', 'url' => 'admin/games/collage/Cartoon%20Upload', 'icon' => 'fa-bullhorn'),
											array('name' => ' Image Place', 'url' => 'admin/games/collage/Image%20Place', 'icon' => 'fa-bullhorn'),
											array('name' => ' Image Path', 'url' => 'admin/games/collage/Image%20Path', 'icon' => 'fa-bullhorn'),
						  ));
				
				
				foreach($menus as $id => $menu) {
					$class = '';
					
					if($id == 0) {
						$class .= 'start ';
					} elseif (++$id == count($menus)) {
						$class .= 'last ';
					}
					
					if(isset($menu['child'])) {
						$active_sub_menu = 0;
						$sub_menu = '';
						foreach($menu['child'] as $id => $child) {
							$active = '';
							if($this->request->url == $child['url']){
								$active = 'active ';
								$active_sub_menu = 1;
								$class .= 'active open ';
							}
							$link = $this->Html->tag('i', '', array('class' => $child['icon'])) . $this->Html->tag('span', $child['name'], array('class' => 'title'));
							$sub_menu .= $this->Html->tag('li', $this->Html->link($link, '/' . $child['url'], array('escape' => false)), array('class' => $active));
							
						}

						if($active_sub_menu) {
							$link = $this->Html->tag('span', '', array('class' => 'selected')) . $this->Html->tag('span', '', array('class' => 'arrow open'));
							
						} else {
							$link = $this->Html->tag('span', '', array('class' => 'arrow'));
							
						}
						$link = $this->Html->tag('i', '', array('class' => $menu['icon'])) . $this->Html->tag('span', $menu['name'], array('class' => 'title')) . $link;

						$link = $this->Html->link($link, 'javascript:;', array('escape' => false));

						echo '<li class="'. $class . '">';
						echo $link;
						echo '<ul class="sub-menu">' . $sub_menu . '</ul>';
						echo '</li>';
						
					} else {
						$class .= ($this->request->url == $menu['url'])? 'active ': '';
						$link = $this->Html->tag('i', '', array('class' => $menu['icon'])) . $this->Html->tag('span', $menu['name'], array('class' => 'title'));
						echo $this->Html->tag('li', $this->Html->link($link, '/' . $menu['url'], array('escape' => false)), array('class' => $class));
						
					}
				}
			?>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>
<!-- END SIDEBAR -->
