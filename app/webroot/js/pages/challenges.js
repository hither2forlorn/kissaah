var Challenges = function(){
	$.ajaxSetup({
		cache: false
	});
	
	return {
		Challenge : function() {
    		$('.challenge-link').fancybox({
			    'beforeShow'	: function() {},
				'href' 			: $(this).attr('href'),
				'type'			: 'ajax',
			    'autoSize'		: false,
				'width'         : 750,
				'height'        : 'auto',
				'padding'		: [0, 0, 15, 0],
				'wrapCSS'		: 'fancybox-challenges'
			});
    		$('.challenge-link-small').fancybox({
			    'beforeShow'	: function() {},
				'href' 			: $(this).attr('href'),
				'type'			: 'ajax',
			    'autoSize'		: false,
				'width'         : 500,
				'height'        : 'auto',
				'padding'		: [0, 0, 15, 0],
				'wrapCSS'		: 'fancybox-challenges'
			});
    		$('.challenge-link-xsmall').fancybox({
			    'beforeShow'	: function() {},
				'href' 			: $(this).attr('href'),
				'type'			: 'ajax',
			    'autoSize'		: false,
				'width'         : 400,
				'height'        : 'auto',
				'padding'		: [0, 0, 15, 0],
				'wrapCSS'		: 'fancybox-challenges'
			});
		},
		
		PreviewChallenge: function() {
			$('.form-field').delegate('.action-button', 'click', function(event) {
				$('.form-field').addClass('hidden');
				$('.preview-field').removeClass('hidden');
				
				todayDate 		= new Date();
				challengeDate 	= $.datepicker.parseDate('mm/dd/yy', $('#ChallengeCompleteBy').val());
				datediff 		= Math.ceil((challengeDate.getTime() - todayDate.getTime())/(24*60*60*1000));

				$('.challenge-ally').html('Ally:<br />' + $('#ChallengeAssigned').val());
				$('.challenge-complete-by').html($.datepicker.formatDate('D dd M yy', challengeDate));
				$('.challenge-description').html($('#ChallengeDescription').val());
				$('.challenge-title').html($('#ChallengeName').val() + '<br />Challenge');
				$('.date-diff').html(datediff + '&nbsp;&nbsp;&nbsp;&nbsp;00<br />DAYs&nbsp;&nbsp;HRs');
			});

			$('.preview-field').delegate('.action-button', 'click', function(event) {
				$('.form-field').removeClass('hidden');
				$('.preview-field').addClass('hidden');
			});
		},
		
		SaveChallenge : function() {
			$('form').submit(function(event) {
				event.preventDefault();
        		var request = $.ajax({
					type 	: 'POST',
					url 	: $(this).attr('action'),
					data 	: $(this).serialize(),
				});
            	request.done(function(msg) {
            		var object = $.parseJSON(msg)
					var success = object.success;
            		if(success == 1) {
            			$.fancybox.close();
            			$.fancybox({
            			    'beforeShow'	: function() {},
            				'href' 			: object.link,
            				'type'			: 'ajax',
            			    'autoSize'		: false,
            				'width'         : 750,
            				'height'        : 'auto',
            				'padding'		: [0, 0, 15, 0],
            				'wrapCSS'		: 'fancybox-challenges'
            			});
            		} else {
            			$('.fancybox-inner').html(msg);
            		}
            	});
            	request.fail(function( jqXHR, textStatus ) {
            		alert( 'Request failed');
            	});
			});
		},
		
		SelectRoadMap: function() {
			$('div.road-map-list').delegate('.road-map input[type="checkbox"]', 'change', function(event) {
				img = $(this).siblings('img').attr('src');
				if($(this).is(':checked')) {
					//$(this).toggleClass('checked')
					img = img.replace('road-map-grey.png', 'road-map-selected.png');
				} else {
					//$(this).toggleClass('checked')
					img = img.replace('road-map-selected.png', 'road-map-grey.png');
				}
				$(this).siblings('img').attr('src', img);
			});
		},
		
		SelectAlly: function() {
			var custom = new Bloodhound({
				datumTokenizer: function(d) { return d.tokens; },
	            queryTokenizer: Bloodhound.tokenizers.whitespace,
	            //remote: 'http://localhost/kissaah/game/challenges/typeahead_allies?query=%QUERY'
	            remote: 'http://kissaah.com/game/challenges/typeahead_allies?query=%QUERY'
			});
			
			custom.initialize();

			$('#ChallengeAssigned').typeahead(null, {
				name		: 'ChallengeAssigned',
				displayKey	: 'name',
				source		: custom.ttAdapter(),
				hint		: true,
				templates	: {
					suggestion: Handlebars.compile([
		                '<div class="media">',
		                      '<div class="pull-left">',
		                          '<div class="media-object">',
		                              '<img src="{{img}}" width="50" height="50"/>',
		                          '</div>',
		                      '</div>',
		                      '<div class="media-body">',
		                          '<h4 class="media-heading">{{name}}</h4>',
		                          '<p>{{email}}</p>',
		                      '</div>',
		                '</div>',
		            ].join(''))
				}
			});
			
			$('input[id=ChallengeAssigned]').on('typeahead:selected', function(evt, item) {
				if($('div.select-ally').length) {
					$('img.ally-image').attr('src', item.img);
					$('#ChallengeChallengeFromId').val(item.id);
					$('#ChallengeNotification').val('2');
					//$('p.ally-name').append(item.name);
					
				} else {
					$('img.profile-image').attr('src', item.img);
					$('#ChallengeUserId').val(item.id);
					$('p.ally-name').append(item.name);
					$('div.road-map-list').html('');
					$.each(item.usergamestatus, function(index, value) {
						$('div.road-map-list').append(
							'<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding road-map">' +
								//'<img alt="" class="margin-bottom-10" src="/kissaah/game/img/ch/road-map-grey.png">' +
								'<img alt="" class="margin-bottom-10" src="/game/img/ch/road-map-grey.png">' +
								'<input type="hidden" value="0" id="UserGameStatus' + value.id + '_" name="data[UserGameStatus][' + value.id + ']">' +
								'<input type="checkbox" id="UserGameStatus' + value.id + '" value="1" class="form-control" name="data[UserGameStatus][' + value.id + ']">' +
								'<label for="UserGameStatus' + value.id + '"><span class="light-blue-small">' + value.roadmap + '</span></label>' +
							'</div>'
						);
					});
					
					$('div.road-map-list').append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 greyed-xsmall">(Pick the relevant RoadMap(s))</div>');
				}
			});
		},
		
		RejectChallenge: function() {
			$('.reject-status').delegate('.action-button', 'click', function(event) {
				event.preventDefault();
				$('.action-button').removeClass('selected');
				$('#ChallengeActionStatus').val($(this).html());
				$(this).addClass('selected');
			});
		},

		Calendar: function (cal_url) {
            if (!jQuery().fullCalendar) {
                return;
            }

    		$('#calendar').fullCalendar({
    			height: 500,
    			header: {
    				left: 'prev,next today',
    				center: 'title',
    				right: 'month,agendaWeek,agendaDay'
    			},
    			editable: false,
    			eventLimit: true, // allow "more" link when too many events
    			events: {
    				//url: $(this).attr('data-url'),
    				url: cal_url,
    				cache: true,
    				error: function() {
    					$('#script-warning').show();
    				}
    			},
    			loading: function(bool) {
    				$('#loading').toggle(bool);
    			},
    			windowResize: function(view) {
    				alert('The calendar has adjusted to a window resize');
    		    }
    		});
    		
        },
	}
}();