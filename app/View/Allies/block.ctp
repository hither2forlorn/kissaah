<?php 
	echo $this->Html->tag('h3', 'Why do you want to block this user ?', 
			array('class' => 'activitytitle')); ?>
	
	<div class="col-md-12"><?php 
		echo $this->Form->create('Ally', array('id' => 'AllyBlockForm', 'class' => 'text-left', 'url' => array('controller' => 'allies', 'action' => 'request_action','block',$id),
				'inputDefaults' => array('div' => false, 'class' => 'form-control')));
		
		echo $this->Form->input('blocked_reason', 
								array(	'type' => 'radio','legend' => false,'label' => false, 'hiddenField'=>false, 'separator' => '<br/>', 'class' => 'blocked',
										'options' => array(
										'1' => ' This user is using inappropriate images for their profile picture or RoadMaps(s)',
										'2' => ' This user is sending inappropriate feedback on my RoadMap(s)',
										'3' => ' This user is using inappropriate language',
										'4' => ' This user is bothering me ',
										)));

		echo $this->Html->div('form-group no-margin hidden bother',
				$this->Form->textarea('bother_how', 
								   		  array('label' => false,'class' => 'blockreason',
								   		  		'placeholder' => 'Please let us know how this user is bothering you...', 'required'=> false)));

		echo $this->Form->submit('Block', array('class' => 'btn btn-in-progress', 'div' => 'input-group margin-top-10'));
			
		echo $this->Form->end(); ?>
	</div>
<script>
$(".blocked").click(function() {
	if ($(this).val() == 4){
		$('.bother').removeClass('hidden');
		$(".bother textarea").attr('required', true);
	}
	else{
		$('.bother').addClass('hidden');
		$(".bother textarea").removeAttr('required');
	}
});
</script>

