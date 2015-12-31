<?php
echo $this->Html->tag('h3', Inflector::pluralize($cpanelOption['userModel']), array('class' => 'header'));
echo $this->Form->select('ControlPanel.Users', $userList, array('empty' => false, 'multiple' => true, 'size' => '10'));
?>