<script>
$(function() {
	$('ul.competencies-list').sortable({
		connectWith: 'ul',
		receive : function( event, ui ) {
			confid 	= $(this).attr('data-conf');
			id 		= ui.item.attr('data-id');

			if(confid != undefined) {
				var data = { };
				data['data[Game][' + confid + '][' + id + ']'] = ui.item.text();
				$.ajax({
					url		: host_url + 'games/save',
					type	: 'POST',
					data 	: data,
					success	: function(data){
        				var object = $.parseJSON(data);
        				if(object.success) {
    						$('div[data-conf="' + object.cid + '"]').attr('data-id', object.id);
    						ui.item.attr('data-id', object.id);
    						$('ul[data-conf="' + object.cid + '"]').append(ui.item);
        				}
					}
				});
			}
		}
	});
    $('ul.competencies-list').disableSelection();
});
</script>
<?php
if($summary) {
	if($selfdata['Configuration']['id'] == 111) {
		$heading = $this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10', $selfdata['Configuration']['title']);
		$li = '';
		$r_li = '';
		$offset = ' col-md-offset-2';

		foreach($selfdata['Game'] as $answer) {
			$li .= $this->Html->tag('li', $answer['Game']['answer'], array(
					'class' 	=> 'col-xs-4',
					'data-id' 	=> $answer['Game']['id']));

			if($selfdata['Dependent']['feedback']) {
				$offset = '';
				$rating = $this->Html->div('rating', '', array(
						'data-score' 	=> $answer['Game']['rating'],
						'data-save'		=> $this->Html->url(array('controller' => 'games', 'action' => 'save_rating', $answer['Game']['id']))));
				$r_li  .= $this->Html->div('col-md-12 no-padding margin-top-5 margin-bottom-10', $rating);
			}
		}

		$ul = $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 competencies-list', 'data-conf' => $selfdata['Configuration']['id']));
		echo $this->Html->div('col-md-8 col-sm-12 col-xs-12 no-padding padding-left-10 hidden-xs' . $offset, $heading . $ul);

		if($selfdata['Dependent']['feedback']) {
			$r_ul = $this->Html->tag('ul', $r_li, array('class' => 'col-md-12 col-sm-12 col-xs-12 text-center'));
			echo $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding padding-left-10 hidden-xs', 
					$this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10', 'Rating') . $r_ul);
		}
	}
} else {
	$check_values = array();
	$competencies = '';

	foreach($selfdata['children'] as $key => $value) {
		$heading = $this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10 height-2l', $value['Configuration']['title']);
		$li = '';

		if(empty($value['Game'])) {
		} else {
			foreach($value['Game'] as $answer) {
				$check_values[$answer['Game']['answer']] = $answer['Game']['answer'];
				$li .= $this->Html->tag('li', $answer['Game']['answer'], array(
						'class' 	=> 'col-xs-4',
						'data-id' 	=> $answer['Game']['id'],
						'name' 		=> 'data[Game][' . $value['Configuration']['id'] . '][' . $answer['Game']['id'] . ']'
				));
			}
		}

		$ul = $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 competencies-list', 'data-conf' => $value['Configuration']['id']));
		$competencies .= $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding padding-left-10 hidden-xs', $heading . $ul);
	}

	$data = $this->requestAction(array('controller' => 'organizations', 'action' => 'get_competencies'));
	$li = '';
	
	foreach($data as $key => $list) {
		if(!isset($check_values[$list])) {
			$li .= $this->Html->tag('li', $list, array('class' => 'col-xs-4', 'data-id' => 0));
		}
	}

	$ul 		= $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 competencies-list', 'data-conf' => 0));
	$ulxs 		= $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 value-list-xs'));
	$heading 	= $this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10 height-2l', 'Organization Priorities');
	echo $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding padding-left-10 hidden-xs', $heading . $ul);
	echo $competencies;
}
?>
<script>
$(document).ready(function(){
	Game.handleRating();
});
</script>
