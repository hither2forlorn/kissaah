var NoteToSelf = function() {
	req 	= false;
	return {
		init: function () {
			addthisevent.settings({
				mouse		: false,
				css			: false,
				outlook		: {show:true, text:"Outlook Calendar"},
				google		: {show:true, text:"Google Calendar"},
				yahoo		: {show:true, text:"Yahoo Calendar"},
				ical		: {show:true, text:"iCal Calendar"},
				hotmail		: {show:true, text:"Hotmail Calendar"},
				facebook	: {show:true, text:"Facebook Calendar"}
			});
		},	
		
		NewNote: function() {
			$('#UserGameStatusSelfNotesForm').on('click', 'a.new-note', function(evt){
				evt.preventDefault();
				element = $(this);
				$.ajax({
					url		: $(this).attr('href'),
					success	: function(result) {
						$(result).insertAfter(element.parents('div.row-new-note'));
			            addthisevent.refresh();
					},
					error		: function(){},
					complete	: function(){}
				});
			});
		},
		
		SaveNote: function() {
    	    $('.date-picker').datepicker().on('changeDate', function(evt) {
    	    	console.log('date changed');
				var save_id = $(this).attr('data-save');
				console.log($('div.note-' + save_id + ' :input').serialize());
				if(!req) {
					req = $.ajax({
						url		: $('#UserGameStatusSelfNotesForm').attr('action'),
						data	: $('div.note-' + save_id + ' :input').serialize(),
						type	: 'POST',
						success	: function(result) {
							if(typeof($('#UserGameStatusId').val() == 'undefined')) {
								var data = jQuery.parseJSON(result);
								if(data.success == 1) {
					            	$('.event' + save_id).children('._start').text($('#SelfNoteCompleteBy[data-save=' + save_id + ']').val());
					            	$('.event' + save_id).children('._end').text($('#SelfNoteCompleteBy[data-save=' + save_id + ']').val());
					            	$('.event' + save_id).children('._summary').text($('#SelfNoteText[data-save=' + save_id + ']').val());
						            addthisevent.refresh();
									
								}
							}
							req = false;
						}
					});
				}
    	    });

			$('#UserGameStatusSelfNotesForm').on('focusout', 'input[type=text], textarea', function(evt) {
				var save_id = $(this).attr('data-save');
				if(!req) {
					req = $.ajax({
						url		: $('#UserGameStatusSelfNotesForm').attr('action'),
						data	: $('div.note-' + save_id + ' :input').serialize(),
						type	: 'POST',
						success	: function(result) {
							if(typeof($('#UserGameStatusId').val() == 'undefined')) {
								var data = jQuery.parseJSON(result);
								if(data.success == 1) {
					            	$('.event' + save_id).children('._start').text($('#SelfNoteCompleteBy[data-save=' + save_id + ']').val());
					            	$('.event' + save_id).children('._end').text($('#SelfNoteCompleteBy[data-save=' + save_id + ']').val());
					            	$('.event' + save_id).children('._summary').text($('#SelfNoteText[data-save=' + save_id + ']').val());
						            addthisevent.refresh();
									
								}
							}
							req = false;
						}
					});
				}
			});
		},
		
		Email: function() {
			$('.self-notes').delegate('#EmailMe', 'click', function(event) {
				event.preventDefault();
				$.ajax({
					url 	: host_url + 'users/self_note_email_me',
					type 	: 'POST',
					data 	: '',
					success : function(response) {
						var obj = $.parseJSON(response);
						if (obj.success == 1){
							if($('#message-notes').find("span").length <= 0){
								$('#message-notes').append('<span>Email Sent</span>');
							}
						}
					}
				});
			});
		},
		
	}
}();