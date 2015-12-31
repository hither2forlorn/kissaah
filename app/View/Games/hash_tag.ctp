<div class='hashtags-diaplayUsers'>
	<div class='pull-right close-ht-displayUsers'>
		<i class='fa fa-times '></i>
	</div>
	
	<br/>
<?php
	if(count($users_with_tag) > 0){
		
		foreach($users_with_tag as $user)	{
			echo '<span class="tag-title">User Email : </span>'.$user['User']['email'];
			echo '<br/>';
			echo '<span class="tag-title">Current City : </span>';
			echo isset($user['User']['city'])?$user['User']['city']:'N/A';
			echo '<hr/>';
		}
	}else{
		echo "No one else using this tag.";
	}
?>
</div>
<script>
	$(document).ready(function(){
		Game.HashTagClose();
	});
</script>