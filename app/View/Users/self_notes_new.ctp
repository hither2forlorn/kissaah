<?php
	$idInput = $this->Form->input('SelfNote.id',   array('type' => 'hidden', 'value' => $self_note['SelfNote']['id']));
	$typeInput = $this->Form->input('SelfNote.type', array('type' => 'hidden', 'value' => $self_note['SelfNote']['type']));
	
	$note = $this->Html->div('form-group margin-bottom-5', $this->Form->input('SelfNote.text', array('value' => $self_note['SelfNote']['text'],
																					 'data-save' => $self_note['SelfNote']['id'],
																					 'label' => false, 'div' => false, 
																					 'class' => 'form-control')));
	$complete = $this->Html->div('form-group margin-bottom-5', $this->Form->input('SelfNote.complete_by', array('value' => $self_note['SelfNote']['complete_by'],
																								'data-save' => $self_note['SelfNote']['id'],
																					 			'label' => false, 'div' => false,  
																								'class' => 'form-control date-picker')));

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
?>
<script type="text/javascript">
	$(document).ready(function() {
		Metronic.DateOnlyFuture();
	});
</script>