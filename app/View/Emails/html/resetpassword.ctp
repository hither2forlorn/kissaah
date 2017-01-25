<?php 
	echo "Password has been reset\n";
	echo '<br />';
	echo "Username : ".$data['User']['email']; 
	echo '<br />';
	echo "\nNew Password : ".$data['User']['password'];
	
	echo '<br />';
	echo '<div style="width:600px;text-align:justify">';
	echo '---------------------------------------------------------------------------------------------------';
	echo '<p style="text-align: center;"><strong>' . $this->Session->read('Company.name') . '(n): </strong>- Life story; tale (Sanskrit).</p>
							    <p> We all have a story to tell..</p>
								<p style="text-align: center;">Our stories describe our hopes, dreams, and ideas. Studies show our personal narratives guide our decisions and help us achieve our goals. In short, telling our life stories can help us figure out who we are and where we want to be.</p>
								<p style="text-align: center;">What Is ' . $this->Session->read('Company.name') . '?</p>
								<p style="text-align: center;">' . $this->Session->read('Company.name') . ' is research-based framework for storytelling that fosters insight, inspires self-reflection, and generates an individualized action plan that can be shared with others. ' . $this->Session->read('Company.name') . ' combines words and images to help you identify your values and hone your goals.
										Share your story, and let ' . $this->Session->read('Company.name') . ' help get you where you want to be.</p>';
	echo '<br />';
	//echo 'Please <a href="http://kissaah.org">Click Here</a> to get started .<br />';
	echo 'Please ' . $this->Html->link('Click Here', array('controller' => 'users', 'action' => 'login', 'full_base' => true)) . ' to get started .<br />';
	echo '---------------------------------------------------------------------------------------------------';
	echo '</div>';
	echo '<br />';
	echo "Thank you";
	echo '<br />';
	echo $this->Session->read('Company.name') . " Team";
	echo '<br />';
	echo '<br />';
	echo 'Please do not reply to this email as your message will not be read. If you need help from a ' . $this->Session->read('Company.name') . ' team member, please email support@kissaah.com';
?>