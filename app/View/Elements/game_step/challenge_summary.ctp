<?php
echo $this->Html->div('col-md-12 btn-finished margin-bottom-5', $selfdata['Configuration']['title']);

foreach($selfdata['children'] as $child) {
	$options['data-conf'] 	= $child['Configuration']['id'];
	$optionsid['data-conf'] = $child['Configuration']['id'];

	if(isset($child['Dependent'])) {
		foreach($child['Dependent'] as $dependent) {
			
			$goal = $this->requestAction(array('controller' => 'challenges', 'action' => 'goal', $dependent['id']));
			//debug($goal);
			if(!empty($goal) && $goal['Challenge']['status'] == 'Completed') {
				
				$optionsid['type'] 		= 'hidden';
				$optionsid['data-depn'] = $dependent['id'];
				$optionsid['value'] 	= $goal['Challenge']['id'];
				$optionsid['data'] 		= 'challenge-' . $dependent['id'];
				$optionsid['data-save'] = $this->Html->url(array('controller' => 'challenges', 'action' => 'set_challenge'));
				$challenge_id = $this->Form->input('Challenge.id', $optionsid);
				
				$challenge = $this->Html->div('col-md-4 no-padding', $this->Html->div('btn-label light-blue', $goal['Challenge']['name']));
				$complete_by = $this->Html->div('col-md-3 no-padding', 
												$this->Html->div('btn-label dark-blue', 
																 'Complete by ' . date('m-d-Y', strtotime($goal['Challenge']['complete_by']))));
				$username = $this->Html->div('col-md-3 no-padding', $this->Html->div('btn-label dark-blue', $goal['ChallengeFrom']['name']));
		
				$options['class'] 		= 'form-control';
				$options['label'] 		= false;
				$options['div'] 		= 'col-md-12 no-padding margin-top-5';
				$options['type'] 		= 'textarea';
				$options['rows']  		= '3';
				$options['readonly']  	= 'readonly';
				$options['placeholder'] = $selfdata['Configuration']['title'];
				$options['data-save'] 	= $this->Html->url(array('controller' => 'challenges', 'action' => 'set_challenge'));
				$options['value'] 		= $goal['Challenge']['feedback'];
				$description = $this->Form->input('Challenge.feedback', $options);
				
				$optionsid['value'] 	= $goal['Challenge']['rating'];
				$optionsid['data'] 		= 'rating-' . $dependent['id'];
				$rating = $this->Form->input('Challenge.rating', $optionsid);
				$rating = $this->Html->div('rating', '', array('data-score' => $optionsid['value'], 'data-depn' => $dependent['id'])) . $rating;
				$rating = $this->Html->div('col-md-2 no-padding', $this->Html->div('btn-label dark-blue', $rating));
				
				$left_block = $this->Html->div('col-md-12 no-padding', $challenge_id . $challenge . $complete_by . $username . $rating . $description);
		
				echo $this->Html->div('row no-margin margin-bottom-10', $left_block);
			}
		}
	}
}
?>
