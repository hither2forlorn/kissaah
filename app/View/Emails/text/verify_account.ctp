<?php 
/*echo "To validate your account, you must visit the URL below within 24 hours";
echo "\n";*/
echo "Click to validate your account ";
echo Router::url(array('admin' => false, 'controller' => 'users', 'action' => 'verify', '?'=>array('f'=>'register_validate','token_key'=> $user['User']['email_token'])), true);
?>