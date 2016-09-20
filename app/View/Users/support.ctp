<div class="no-margin row">
<?php
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-10',
				$this->Html->tag('h3', 'Customer Support', array('class' => 'activitytitle'))); 
?>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-10'>
	<?php 
		echo $this->Html->tag('h4', 'Open a ticket here');
	?>
	</div>
	<?php 
	echo $this->Form->create();
	echo $this->Html->div('col-xs-12 col-sm-6 col-md-6 col-lg-6 margin-bottom-10', 
				$this->Form->input('email', array(
							'label' 	=> 'Your email address', 'div' => false,
							'readonly'	=> true, 'placeholder' => $user_email)));
	
	echo $this->Html->div('col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-10', 
			$this->Form->input('department', array(	
							'type'	 	=> 'select',
							'options'  	=> array('Support' => 'Support', 'Billing' => 'Billing', 'General' => 'General'),
							'div'		=> false, 'label' => 'Department')));
	
	echo $this->Html->div('col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-10', 
			$this->Form->input('priority', array(
							'type'	 	=> 'select',
							'options'  	=> array('High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low'),
							'div'		=> false, 'label' => 'Priority')));
	
	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-10', 
			$this->Form->input('subject', array(
							'div' 		  => false, 'label'	=> false, 'class' => 'form-control',
							'placeholder' => 'Subject: (Please write a brief subject heading)')));

	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-10', 
			$this->Form->input('issue', array(
							'div' 		  => false, 'label'	=> false, 
							'type'		  => 'textarea', 'class' => 'form-control',
							'placeholder' => 'Please let us know your issue here and how we can help. Let us ' .
											 'know where the issue exists and if you have a screen shot of the issue, ' .
											 'please use the attachment browser below to add this to your message.')));

	echo $this->Html->div('col-xs-12 col-sm-8 col-md-8 col-lg-8 support-image', 
			$this->Form->input('image1', array('div' => false, 'label'	=> false, 'type' => 'file')) . 
			$this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus-circle')) . ' Add more', '#',
							  array('class' => 'margin-top-10 support-image-add', 'escape' => false)));

	echo $this->Html->div('col-xs-12 col-sm-4 col-md-4 col-lg-4', 
			$this->Html->link('Send to Support',
							  array('controller' => 'users', 'action' => 'send_to_support'),
							  array('class' => 'btn btn-primary send-to-support', 'escape' => false)));
	echo $this->Form->end();

	echo $this->Html->div('col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top-10',
				$this->Html->tag('h4', '', array('class' => 'activitytitle ticket-number'))); 
	?>
</div>
<script>
	$(document).ready(function(){
		Game.Support();
	});
</script>