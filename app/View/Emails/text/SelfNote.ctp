<?php 
echo "Note To Self\n";
if(isset($SelfNote['SelfNote']['things_to_do'])){echo "Things To Do : ".$SelfNote['SelfNote']['things_to_do']; }
if(isset($SelfNote['SelfNote']['people_to_see'])){echo "\nPeople To See : ".$SelfNote['SelfNote']['people_to_see'];}
if(isset($SelfNote['SelfNote']['note_to_take'])){echo "\nNote To Take : ".$SelfNote['SelfNote']['note_to_take'];}
?>