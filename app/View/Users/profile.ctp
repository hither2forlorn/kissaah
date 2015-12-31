<div class="row margin-bottom-40 padding-top-30">
	<div class="col-sm-2"><?php
	
		$image = $this->Session->read('Profile.Game.answer');
		$id = $this->Session->read('Profile.Game.id');
		$configure = $this->Session->read('Profile.Game.configure_id');
		if(empty($id)) {
			$id = 0; 
		}
		if(empty($image)) {
			$image = 'http://placehold.it/220x220&text=No Image';
		} else {
			$image = '/files/img/medium/' . $image;
		}
		
		echo $this->Html->image($image, array('alt' => $this->Session->read('Auth.User.name'), 
											  'class' => 'img-responsive',
											  'data' => 'medium-' . $configure));

		echo $this->Html->div('margin-top-10',
				$this->Html->link(
					$this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o')) . ' Language', 
								   '#', array('escape' => false, 'class' => '')) .
				$this->Html->div('margin-left-20', 'English(US)'));
				
	?></div>
	<div class="col-md-4 col-sm-4 profile-general-settings">
		<h2>General Settings</h2>
		<?php 
		echo $this->Form->create('Game' . $id . 'upload', array('class' => 'btn-file fileupload'));
		echo $this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o', 'id' => 'upl' . $configure));
		echo $this->Html->tag('span', ' Profile Picture', array('class' => ''));
		echo $this->Form->input($configure, array(
											'type' 		=> 'file', 
											'label' 	=> false, 
											'class'		=> 'default', 
											'div' 		=> false));
		echo $this->Form->end();

		echo $this->Html->div('margin-bottom-10',
				$this->Html->link(
					$this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o')) . ' Screen Name', 
								   array('controller' => 'users', 'action' => 'edit/profile'), 
								   array('escape' => false, 'class' => 'open-fancybox ')) . 
				$this->Html->div('margin-left-25 ScreenName', $userdetail['User']['name'] . ''));

		echo $this->Html->div('margin-bottom-10',
			$this->Html->link(
				$this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o')) . ' Log In Password', 
								   array('controller' => 'users', 'action' => 'edit/password'), 
								   array('escape' => false, 'class' => 'open-fancybox ')));

		echo $this->Html->div('margin-bottom-10',
				$this->Html->link(
					$this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o')) . ' Email', 
								   array('controller' => 'users', 'action' => 'edit/profile'), 
								   array('escape' => false, 'class' => 'open-fancybox ')) .
				$this->Html->div('margin-left-25', $this->Session->read('Auth.User.email'),array('id'=>'Email')));

		echo $this->Html->div('margin-bottom-10',
				$this->Html->link(
					$this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o')) . 
						' Give consent to make a collage of my RoadMap for public use', 
								   array('controller' => 'games', 'action' => 'collage_signup'), 
								   array('escape' => false, 'class' => 'collage-fancybox ')) .
				$this->Html->div('margin-left-25', 'Consent Given&nbsp;&nbsp;' .
						$this->Html->tag('i', '', array('class' => 'fa fa-question-circle '))));
		
		echo $this->Html->div('margin-bottom-10',
			$this->Html->link(
				$this->Html->tag('i', '', array('class' => 'fa fa-lg fa-pencil-square-o')) . ' Terms of Service', 
								   'http://www.kissaah.com/terms-of-service/', 
								   array('escape' => false, 'target' => '_blank', 'class' => '')));
		?>
	</div>
	<div class="col-md-3 col-sm-3 profile-accounts">
	<?php
		echo $this->Html->div('col-md-12', $this->Html->tag('h3', 'Feedback'));
		 
		echo $this->Html->div('col-md-12', $this->Html->para(null, 'Got an idea about Kissaah you\'d like to share, or 
																	some feedback about your experience? Fill out this survey'));
																	
		echo $this->Html->div('col-md-12 margin-bottom-10', $this->Html->link('Start Survey', 
					'https://docs.google.com/forms/d/1ECrPJKbh1j2d-nZeHznomnRmgxCSWgW10jpc9bhN840/viewform?embedded=true',
					array('class' => 'btn btn-primary collapsed take-survey fancybox.iframe')));
		
		echo $this->Html->div('col-md-12 margin-bottom-10', $this->Html->link('Reset Current Roadmap', 
									array('controller' => 'games', 'action' => 'reset', true), 
									array('class' => 'btn btn-primary open-fancybox')));
									
		echo $this->Html->div('col-md-12 margin-bottom-10', $this->Html->link('Deactivate Account', 
									array('controller' =>'users', 'action' => 'deactivate_account'), 
									array('class' => 'btn btn-primary', 'id' =>'deactivate-account')));
	?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		Game.TakeSurvey();
		Game.Support();
		Game.ToolBoxLoadLink();

		FileUpload.UploadFileImage();

		Profile.SettingsFancyBox();
		Profile.ProfileImageHover();
		Profile.NotificationPreferences();
		Profile.DeactivateAccount();
	});
</script>