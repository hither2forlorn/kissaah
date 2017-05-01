var Allies = function(){
	$.ajaxSetup({
		cache: false
	});
	
	return {
		OpenPopup : function() {
			$('a.btn-invite').on('click', function(event) {
				var email = $('input[id="Email"]').val() + '/email';
				var link = $(this).attr('href');
				link = link.replace('slug', email);
				$(this).attr('href', link);
			});
			
			$('a.btn-ally').on('click', function() {
				var email = $('input[id="Email"]').val() + '/email';
				var link = $(this).attr('href');
				link = link.replace('slug', email);
				$(this).attr('href', link);

				$.fancybox.close();
			});
    		
			$('a.btn-ally').fancybox({});
		},
		
		Search : function(){
			$('.allies').on('keyup', '#SearchText', function(event) {
				var code = event.keyCode || event.which;
				if (code == 13) {
					$.ajax({
						cache		: false,
						type 		: 'POST',
						url 		: $('#search-allies').attr('href'),
						data 		: { data: { search: $('input[id="SearchText"]').val()} },
						success		:function(data){
							$('.allies-list').html(data);
						}
					});
				}
			});	
			$('.allies').on('click', '#search-allies', function(event) {
				event.preventDefault();
				$.ajax({
					cache		: false,
					type 		: 'POST',
					url 		: $('#search-allies').attr('href'),
					data 		: { data: { search: $('input[id="SearchText"]').val()} },
					success		:function(data){
						$('.allies-list').html(data);
					}
				});
			});	
		},
		
        SaveFeedback: function() {
    		$('.feedback-block').on('focusout', 'input[type=radio], textarea', function(evt) {
    			data = $(this).serializeArray();
    			data.push({name: $('input#FeedbackUserGameStatusId').attr('name'), value: $('input#FeedbackUserGameStatusId').val()});
    			$.ajax({
					cache		: false,
    				beforeSend	: function(){},
    				type		: 'POST',
    				data		: data,
    				url			: host_url + 'feedbacks/save',
    				success		: function(data){},
    				error		: function(){},
    				complete	: function(){}
    			});
    		});
        	$('.fancybox-game-popup').delegate('.saveclose', 'click', function() {
    			$.fancybox.close();
        	});
        },
        
        AllyFunctions: function(){
        	$('.allies').on('click', '.btn-ally-status', function(eve) {
        		eve.preventDefault();
        		$.ajax({
        			cache		: false,
        			beforeSend	: function(){},
        			type		: 'POST',
        			url			: $(this).attr('href'),
        			success		: function(msg){
        				var obj = $.parseJSON(msg);
        				var success = obj.success;
        				if(success == 1){
        					var condition 	= obj.condition;
        					var id 			= obj.id;
        					if(condition == 'delete' || condition == 'block') {
        						$('div[data="' + id + '"]').remove();
   							
        					} else if(condition == 'accept') {
        						$('div[data="' + id + '"]').switchClass('color-grey', 'color-finished');
        						$('div[data="' + id + '"]').find('a').removeClass('hidden');
        						$('div[data="' + id + '"]').find('i.fa-check-square').parent('a').remove();
        					}
        				}
        			},
        			error		: function(){},
        			complete	: function(){}
        		});
			});
        	
			$('.allies').on('click', '.ally-invite', function(event) {
				event.preventDefault();
				var valid_request = true;
				/*
		        $('#AllyRequestForm input[type=text]').each(function() {
		        	if(this.value.length < 32 && valid_request) {
		        		valid_request = false;
		        		alert('Please enter at least 10 characters to each field');
		        	};
		        });
		        */
				$('#AllyRoadmap').attr('value', $('#AllyUserGameStatusId option:selected').text());
		        if(valid_request) {
					var request = $.ajax({
						cache	: false,
						type 	: 'POST',
						url 	: $(this).attr('href'),
						data 	: $('form#AllyRequestForm :input').serializeArray(),
					});
	            	request.done(function(data) {
        				var object = $.parseJSON(data);
        				var success = object.success;
        				if(success == 1) {
	            			$.fancybox.close();
	            		}
	            	});
	            	request.fail(function( jqXHR, textStatus ) {
	            		alert( 'Request failed');
	            	});
		        }
			});
        },
        
        NotifyAlly: function(){
        	$('.save-answer').on('click', '.btn-notify-ally', function(eve) {
        		eve.preventDefault();
        		DOM_Element = $(this);
        		$.ajax({
        			cache		: false,
        			beforeSend	: function(){},
        			type		: 'POST',
        			url			: $(this).attr('href'),
        			success		: function(data){
        				var object = $.parseJSON(data);
        				var success = object.success;
        				if(success == 1) {
        					$('.btn-notify-ally').text('Notified');
        				} else {
        					$('.btn-notify-ally').text('Failed');
        				}
        			},
        			error		: function(){},
        			complete	: function(){}
        		});
			});
        }
	}
}();