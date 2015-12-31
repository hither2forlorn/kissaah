<?php
echo '<div id="game-comments">';
	$this->CommentWidget->options(array('allowAnonymousComment' => true, 
										'target' 				=> '#comment',
										'ajaxAction' 			=> 'comments'));
	echo $this->CommentWidget->display();
echo '</div>';
echo $this->Js->writeBuffer();
?>