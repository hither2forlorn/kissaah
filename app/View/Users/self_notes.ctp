<?php 
echo $this->Html->script(array('pages/notes'));
?>
<div class="no-margin row self-notes">
	<?php
	echo $this->Html->div('col-md-12 col-sm-12', 
						  $this->Html->tag('h1', 
								$this->Html->image('my-notes.png', array('classs' => 'img-responsive', 'height' => 40)) . ' Quick Tasks', 
								array('class' => 'activitytitle')));

	echo $this->Html->div('col-md-12 col-sm-12', 
						  $this->Html->tag('h5', 
								'The content you place here will automatically save', 
								array('class' => 'activitytitle')));

	echo $this->Html->div('col-md-12 col-sm-12', 
						  $this->Html->tag('h3', 
								'Set yourself targets and notes to yourself here', 
								array('class' => 'activitytitle margin-bottom-30')));

	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php
		$types = array('Notes to take', 'People to see', 'Things to do');

		echo $this->Form->create('UserGameStatus', array('url' => array('controller' => 'users', 'action' => 'self_notes'),
										'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control')));
		foreach($types as $type) {
			$add = $this->Html->link($this->Html->tag('i', ' ', array('class' => 'fa fa-plus')), 
									 array('action' => 'self_notes', 'new', $type), 
									 array('class' => 'new-note', 'escape' => false));
			echo $this->Html->div('row row-new-note', 
								  $this->Html->div('col-md-6 col-sm-6', $type . ' ' . $add) .
								  $this->Html->div('col-md-3 col-sm-3', 'Complete By') .
								  $this->Html->div('col-md-3 col-sm-3', ''));
			
			foreach($self_notes as $self_note) {
				if($type == $self_note['SelfNote']['type']) {
					$idInput = $this->Form->input('SelfNote.id',   array('type' => 'hidden', 'value' => $self_note['SelfNote']['id']));
					$typeInput = $this->Form->input('SelfNote.type', array('type' => 'hidden', 'value' => $self_note['SelfNote']['type']));
					
					$note = $this->Html->div('form-group margin-bottom-5', $this->Form->input('SelfNote.text', array('value' => $self_note['SelfNote']['text'],
																									 'data-save' => $self_note['SelfNote']['id'])));
					$complete = $this->Html->div('form-group margin-bottom-5', 
						$this->Form->input('SelfNote.complete_by', array('value' => $self_note['SelfNote']['complete_by'],
																		 'data-save' => $self_note['SelfNote']['id'], 'class' => 'form-control date-picker')));
		
					/*
					$add = $this->Html->div('col-md-2', $this->Html->div('form-group',
								$this->Form->input('SelfNote.' . $i . '.add_challenge', 
									array('type' => 'checkbox', 'checked' => $add_challenge))));
					*/
					$calendar  = $this->Html->tag('span', $self_note['SelfNote']['complete_by'], array('class' => '_start'));
					$calendar .= $this->Html->tag('span', $self_note['SelfNote']['complete_by'], array('class' => '_end'));
					$calendar .= $this->Html->tag('span', $self_note['SelfNote']['text'], array('class' => '_summary'));
					$calendar .= $this->Html->tag('span', 'true', array('class' => '_all_day_event'));
		
					$add = $this->Html->link('Add to Calendar' . $calendar, '#', array('class'  => 'addthisevent event' . $self_note['SelfNote']['id'], 
																					   'title'  => 'Add to Calendar',
																					   'escape' => false));
					
					echo $this->Html->div('row note-' . $self_note['SelfNote']['id'], $idInput . $typeInput .
							$this->Html->div('col-md-6', $note) . 
							$this->Html->div('col-md-3', $complete) . 
							$this->Html->div('col-md-3', $add));
				}
				
			}
	
		}

		echo $this->Form->end();
		?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id ="ButtonsDiv">
		<?php
		echo $this->Html->link('Email', array('controller' => 'users', 'action' => 'self_note_email_me'),
						   array('id'=>'EmailMe','class' => 'btn btn-primary collapsed margin-right-10'));
		echo $this->Html->link('Export to Word', array('controller' => 'users', 'action' => 'export_to_word'),
						   array('id' => 'ExportToWord', 'class' => 'btn btn-primary collapsed margin-right-10'));
		?>
	</div>
	<div id="message-notes" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 highlighted"></div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		NoteToSelf.init();
		NoteToSelf.NewNote();
		Metronic.DateOnlyFuture();
		NoteToSelf.SaveNote();
		NoteToSelf.Email();

		Game.initAddToCalendar();
		addthisevent.refresh();
	});
</script>