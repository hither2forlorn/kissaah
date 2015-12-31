var controller;
var move = false;
var countNewRow = 0;
var colorboxHeight = 0;
var xhrRequest;

$(document).ready(function(){
	$('a[rel=add]').live('click', function(clickEvent) {
		clickEvent.preventDefault();
		table_row = '<tr id="newRow' + countNewRow + '" class="newRowAdd"></tr>';
		if($(this).attr('id') == 'addnew-place') {
			$("table#NolightIndexTable tr:first").after(table_row);
			$('#addnew-place').hide();
		} else if($(this).attr('id') == 'addnew-time') {
			$("table#NolightTimeIndexTable tr:first").after(table_row);
		} else {
			$(this).closest('li').find('.index-box').find('tr:first').after(table_row);
		}
		$(table_row).insertBefore('tr.bulkActions');
		$('#newRow' + countNewRow).load($(this).attr('href'));
		countNewRow++;
	});

	$('a[rel=edit]').live('click',function(clickEvent) {
		clickEvent.preventDefault();
		$(this).closest('tr').load($(this).attr('href'));
	});
	
	$('a[rel=move]').live('click',function(clickEvent) {
		clickEvent.preventDefault();
		$($(this).closest('tr').next('tr.move')).remove();
		$($(this).closest('tr').next('tr.upload')).remove();
		$(this).closest('tr').after('<tr id="newRow' + countNewRow + '" class="move"></tr>');
		$('#newRow' + countNewRow).load($(this).attr('href'));
		countNewRow++;
		move = true;
	});
	
	$('a[rel=upload]').live('click',function(clickEvent) {
		clickEvent.preventDefault();
		$($(this).closest('tr').next('tr.move')).remove();
		$($(this).closest('tr').next('tr.upload')).remove();
		$(this).closest('tr').after('<tr id="newRow' + countNewRow + '" class="upload"></tr>');
		$('#newRow' + countNewRow).load($(this).attr('href'));
		countNewRow++;
		move = true;
	});
	
	$('a[rel=cancel]').live('click', function(clickEvent) {
		clickEvent.preventDefault();
		$(this).closest('tr').remove();
		if($(this).attr('href').indexOf('nolights/add/Nolight') > 0) {
			$('#addnew-place').show();
		}
	});

	$('a[rel=delete]').live('click',function(clickEvent) {
		clickEvent.preventDefault();
		DOM_Element = $(this);
		if (!confirm('Please confirm. It cannot be undone.')) {
			return;
		}
		$.post($(this).attr('href'), function(result) {
			if(result.substr(0, 7) == 'Success') {
				DOM_Element.closest('tr').remove();
				if($('#content-location-left').length) {
					$('#content-location-left').load(__HOST_NAME__ + "/admin/" + controller + "/locTree");
				}
			} else if(result.substr(0, 6) == 'Failed') {
				alert('Could not delete the record. Please try again.')
			} else {
				alert(result);
			}
			return;
		});
	});

	$('a[rel=save]').live('click', function(clickEvent){
		clickEvent.preventDefault();
		var DOM_Element = $(this).closest('tr');
		$('#NolightDescription').val(function(){
			this.value = creator.showData();
			return this.value;
		});
		DOM_Element.load($(this).attr('href'), $("#" + DOM_Element.attr('id') + " :input").serializeArray(), 
			function(result) {
				if($('#content-location-left').length) {
					$('#content-location-left').load(__HOST_NAME__ + "/admin/" + controller + "/locTree");
				}
				if(move) {
					DOM_Element.closest('tr').prev().remove();
					DOM_Element.closest('tr').remove();
					move = false;
				}
				return;
			}
		);
	});
	
	$("input#searchAdmin").live("focus", function() {
		DOM_element = $(this);
		var sValue;//search string
		if(DOM_element.val()=='Start Search ...' || DOM_element.val()=='' ){
			DOM_element.val('').css({'color':'#2A3FBC'});
		}
		DOM_element.keyup(function(){
			sValue = DOM_element.val();
			if (xhrRequest != null) {
				xhrRequest.abort();
				xhrRequest = null;
			}
			$('#tabs-1').html('<img class="loading" src="' + __HOST_NAME__ + '/img/loading.gif" />');
			xhrRequest = $.ajax({
				url: __HOST_NAME__ + "/admin/" + controller + "/index",
				type: "POST",
				data: ({name: sValue}), 
				success: function(result){
					$('#tabs-1').html(result);
					xhrRequest = null;
				}
			});
		});
	}).live("blur",  function() {
		DOM_element = $(this);
		if(DOM_element.val() == ''){
			$(this).val('Start Search ...').css({'color':'#666'});	
		}
	});

	$('p.tree').live('click', function(){
		DOM_element = $(this);
		parentId = DOM_element.attr('id');
		path = '/admin/' + controller + '/treeUpdate';
		$('#tabs-1').html('<img class="loading" src="' + __HOST_NAME__ + '/img/loading.gif" />');
		$('#tabs-1').load(__HOST_NAME__ + path,{
			name: parentId
		}, function(result){
			$('#addnew').attr('href', __HOST_NAME__ + '/admin/' + controller + '/add/' + parentId);
			return;
		});
	});
	
	$('a[rel=attach]').live('click', function(clickEvent) {
		clickEvent.preventDefault();
		$('#load_attach').load($(this).attr('href'), 
				function(result) {
					return;
				}
		);
	});
	
});

function updateIndexParentId(parentId) {
	$('#tabs-1').html('<img class="loading" src="' + __HOST_NAME__ + '/img/loading.gif" />');
	$('#tabs-1').load(__HOST_NAME__ + '/admin/' + controller + '/treeUpdate',{
		name: parentId
	}, function(result){
		$('#addnew').attr('href', __HOST_NAME__ + '/admin/' + controller + '/add/' + parentId);
		return;
	});
}
function autoCompleteEmails(updateElement, updateText){
	if(updateElement == ".email #message-body"){
		$('#'+updateElement).html(updateText);
	}else{
		$('#'+updateElement).val(updateText);
	}
}