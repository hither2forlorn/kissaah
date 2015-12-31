<?php
echo $this->Html->tag('h3', 'Controllers', array('class' => 'header'));
echo $this->Form->select('ControlPanel.Controllers', $controllerList, array('empty' => false, 'multiple' => true, 'size' => '10'));
?>