			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->               
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN DASHBOARD STATS -->
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number"><?php echo $totalUsers; ?></div>
							<div class="desc">Users</div>
						</div>
						<?php
						echo $this->Html->link('View more <i class="m-icon-swapright m-icon-white"></i>',
															array('controller' => 'users',
																'action' => 'view',
																'full_base' => true),
															array('class'=>'more', 'escape' => false));
						?>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number"><?php echo $totalImagesUploaded; ?></div>
							<div class="desc">Images Uploaded</div>
						</div>
						<?php
						echo $this->Html->link('View more <i class="m-icon-swapright m-icon-white"></i>', 
														array('controller' => 'game_configures',
															'action' => 'collage','Image Activity',
															'full_base' => true),
														array('class'=>'more', 'escape' => false));
						?>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number"><?php  ?></div>
							<div class="desc">Comments</div>
						</div>
						<?php
						echo $this->Html->link('View more <i class="m-icon-swapright m-icon-white"></i>',
													array('controller' => 'comments',
														'action' => 'index',
														'full_base' => true),
													array('class'=>'more', 'escape' => false));
						?>                    
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat yellow">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">12,5M$</div>
							<div class="desc">Total Profit</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>                 
					</div>
				</div>
			</div>
			<!-- END DASHBOARD STATS -->
			<div class="clearfix"></div>
			<div class="row ">
				<div class="col-md-6 col-sm-6">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">Users</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
								<ul class="feeds">
									<?php foreach($UserList as $UL) { ?>
									<li>
										<div class="col1">
											<div class="cont">
												<div class="cont-col2">
													<div class="desc">
														<?php  
															if(isset($UL['name'])){
																echo $UL['name'];
															} else {
																echo $UL['email'];
															}
														?> joined Kissaah.
													</div>
												</div>
											</div>
										</div>
										<div class="col2">
											<div class="date">
												<?php echo  $UL['created'];?>
											</div>
										</div>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="portlet box green tasks-widget">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-bell-0"></i>Recent Activities</div>
						</div>
						<div class="portlet-body">
							<div class="task-content">
								<div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="1">
									<!-- START TASK LIST -->
									<ul class="task-list">
										<?php foreach($Answers as $ans){
											if($ans['type']=='image'){    ?>
										<li>
											<div class="task-title">
												<span class="task-title-sp"><?php echo isset($ans['user_name'])?$ans['user_name']:$ans['user_email'];
																				  echo '  uploaded image for  ';
																				  echo $this->Html->link(
																									    $ans["GameConfigure_title"],
																									    array(
																									        'controller' => 'configurations',
																									        'action' => 'collage',
																									        $ans['GameConfigure_title'],
																									        'full_base' => true
																									    )
																									);
																			?>
																				  	
												</span>
											</div>
										</li>
										<?php }else{ ?>
											<li>
											<div class="task-title">
												<span class="task-title-sp"><?php echo isset($ans['author_name'])?$ans['author_name']:$ans['author_email'];
																				  echo '  posted a ';
																				  echo $this->Html->link('Comment',
																									    array(
																									        'controller' => 'comments',
																									        'action' => 'comments/view',
																									        $ans['comment_id'],
																									        'full_base' => true
																									    )
																									);
																			?>
												</span>
											</div>
										</li>
										<?php } }?>
									</ul>
									<!-- END START TASK LIST -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
