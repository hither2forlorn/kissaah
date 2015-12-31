<?php
	echo 'Dear '.$data['user'];
	echo '<br />';
	echo '<div style="width:600px;text-align:justify">';
	echo '---------------------------------------------------------------------------------------------------';
	echo '<p style="text-align: center;"><strong>Kissaah(n): </strong>- Life story; tale (Sanskrit).</p>
							    <p> We all have a story to tell..</p>
								<p style="text-align: center;">Our stories describe our hopes, dreams, and ideas. Studies show our personal narratives guide our decisions and help us achieve our goals. In short, telling our life stories can help us figure out who we are and where we want to be.</p>
								<p style="text-align: center;">What Is Kissaah?</p>
								<p style="text-align: center;">Kissaah is research-based framework for storytelling that fosters insight, inspires self-reflection, and generates an individualized action plan that can be shared with others. Kissaah combines words and images to help you identify your values and hone your goals.
										Share your story, and let Kissaah help get you where you want to be.</p>';
	echo '<br />';
	echo $data['sender'].'<p style="text-align: center;"> has sent feedback.</p>';
	echo 'Please <a href="'.Router::url('/', true).'/feedbacks/feedback_view_individual/'.$data['invitationID'].'">Click Here</a> to view.<br />';
	echo '---------------------------------------------------------------------------------------------------';
	echo '</div>';
	echo '<br />';
	echo "Thank you";
	echo '<br />';
	echo "Kissaah Team";
	echo '<br />';
	echo '<br />';
	echo "Please do not reply to this email as your message will not be read. If you need help from a Kissaah team member, please email support@kissaah.com";
?>