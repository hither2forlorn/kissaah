  <script>
	$( function() {
		$( "ul.competencies-list" ).sortable({
			connectWith: "ul",
			receive : function( event, ui ) {
				confid 	= $(this).attr('data-conf');
				id 		= ui.item.attr('data-id');

				console.log(ui.item.text());
				console.log(confid);
				console.log(id);

				if(confid != undefined) {
				
					var data = { };
					data['data[Game][' + confid + '][' + id + ']'] = ui.item.text();

					$.ajax({
						url			: host_url + 'games/save',
						type		: 'POST',
						data 		: data,
						success		: function(data){
        					var object = $.parseJSON(data);
        					console.log(object);
        					if(object.success) {
    							$('div[data-conf="' + object.cid + '"]').attr('data-id', object.id);
    							ui.item.attr('data-id', object.id);
        					}
						}
					});
				}
			}
		});
 
    $('ul.competencies-list').disableSelection();
  } );
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
						'data-id' 		=> $answer['Game']['id'],
						'data-save'		=> $this->Html->url(array('controller' => 'games', 'action' => 'save_rating', $answer['Game']['id']))));
				$r_li  .= $this->Html->div('col-md-12 no-padding margin-top-5 margin-bottom-10', $rating);
			}
		}
		
		$ul = $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 competencies-list', 'data-conf' => $selfdata['Configuration']['id']));
		echo $this->Html->div('col-md-8 col-sm-12 col-xs-12 no-padding padding-left-10 hidden-xs' . $offset, $heading . $ul);
	}

} else {
	$data = $this->requestAction(array('controller' => 'games', 'action' => 'get_sortlist'));
	$li = '';
	foreach($data as $key => $list) {
		$li .= $this->Html->tag('li', $list, array('class' => 'col-xs-4', 'data-id' => 0));
	
	}
	
	$ul 		= $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 competencies-list'));
	$ulxs 		= $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 value-list-xs'));
	$heading 	= $this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10', 'All Competencies');
	echo $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding padding-left-10 hidden-xs', $heading . $ul);
	
	foreach($selfdata['children'] as $key => $value) {
	
		$heading = $this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10', $value['Configuration']['title']);
	
		$li = '';
		if(empty($value['Game'])) {
	
		} else {
			foreach($value['Game'] as $answer) {
				$li .= $this->Html->tag('li', $answer['Game']['answer'], array(
						'class' 	=> 'col-xs-4',
						'data-id' 	=> $answer['Game']['id'],
						'name' 		=> 'data[Game][' . $value['Configuration']['id'] . '][' . $answer['Game']['id'] . ']'
				));
			}
		}
	
		$ul = $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 competencies-list', 'data-conf' => $value['Configuration']['id']));
		echo $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding padding-left-10 hidden-xs', $heading . $ul);
	}
}
?>
<script>
$(document).ready(function(){
	Game.handleRating();
});
</script>