  <style>
  #sortable1, #sortable2, #sortable3 { list-style-type: none; margin: 0; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 143px;}
  #sortable1 li, #sortable2 li, #sortable3 li { margin: 5px; padding: 5px; font-size: 1.2em; width: 120px; }
  </style>
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
					$('div[data="drop-' + confid + '"]').html(ui.item.text());
					$('div[data="dropsummary-' + confid + '"]').html(ui.item.text());
					$('div[data="dropsummary-' + confid + '"]').attr('class', 'btn-in-progress btn-featured');
					
					var data = { };
					data['data[Game][' + confid + '][' + id + ']'] = ui.item.text();

					$.ajax({
						url			: host_url + 'games/save',
						type		: 'POST',
						data 		: data,
						success		: function(data){
        					var object = $.parseJSON(data);
        					if(object.success) {
    							$('div[data-conf="' + object.cid + '"]').attr('data-id', object.id);
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
$data = $this->requestAction(array('controller' => 'games', 'action' => 'get_sortlist'));
$li = '';
foreach($data as $key => $list) {
	$li .= $this->Html->tag('li', $list, array('class' => 'col-xs-4', 'data-id' => 0));

}

$ul 		= $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 competencies-list'));
$ulxs 		= $this->Html->tag('ul', $li, array('class' => 'col-md-12 col-sm-12 col-xs-12 value-list-xs'));
$heading 	= $this->Html->div('col-md-12 col-xs-12 no-padding text-center margin-bottom-10', 'All Competencies');
echo $this->Html->div('col-md-4 col-sm-4 col-xs-4 no-padding padding-left-10 hidden-xs', $heading . $ul);

$drophere = 'Drop <br />Here';
$r = '';
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
?>
