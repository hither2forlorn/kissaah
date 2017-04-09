var tourActive 		= 0;
var game_step 		= 0; 
var configuration_id 	= 0;

var Game = function () {

	var narration_box = function(narration, user_info, facebook_warning, consent_for_collage, road_map, thriving_scale) {
		if(narration == 0 && road_map == ''){
	    	$.fancybox.open({
				src	 : host_url + 'posts/view/60',
				type : 'ajax',
				opts : {
					afterClose	: function() {
						user_info_box(user_info, facebook_warning, consent_for_collage, road_map, thriving_scale);
					},
	    		    closeBtn : false,
					closeClickOutside : false
				}
			});
		} else {
			user_info_box(user_info, facebook_warning, consent_for_collage, road_map, thriving_scale);
		}
	}
	
	var user_info_box = function(user_info, facebook_warning, consent_for_collage, road_map, thriving_scale) {
		if(user_info == 0) {
			$.fancybox.open({
    			src	: host_url + 'users/profile',
				type : 'ajax',
				opts : {
					afterClose	: function() {
	    				facebook_warining_box(facebook_warning, consent_for_collage, road_map, thriving_scale);
	    				//first_time_survey(facebook_warning, consent_for_collage, road_map, thriving_scale);
					},
	    		    closeBtn : false,
					closeClickOutside : false
				}
    		}); 
		} else {
			facebook_warining_box(facebook_warning, consent_for_collage, road_map, thriving_scale);
		}
	}
	
	var first_time_survey = function(facebook_warning, consent_for_collage, road_map, thriving_scale) {
		$.fancybox.open({
			src	: 'https://docs.google.com/forms/d/1XDZyawtEEudu9Etx3ntXDauDiZXHoW0aucxBPiTTYE0/viewform?embedded=true',
			type : 'iframe',
			opts : {
				afterClose	: function() {
					facebook_warining_box(facebook_warning, consent_for_collage, road_map, thriving_scale);
				},
    		    closeBtn : false,
				closeClickOutside : false
			}
		}); 
	}
	
	var facebook_warining_box = function(facebook_warning, consent_for_collage, road_map, thriving_scale) {
		if(facebook_warning == 0) {
			$.fancybox.open({
    			src	: host_url + 'users/facebook_login',
				type : 'ajax',
				opts : {
					afterClose	: function() {
	    				consent_for_collage_box(consent_for_collage, road_map, thriving_scale);
					},
	    		    closeBtn : false,
					closeClickOutside : false
				}
    		}); 
		} else {
			consent_for_collage_box(consent_for_collage, road_map, thriving_scale);
		}
	}
	
	var consent_for_collage_box = function(consent_for_collage, road_map, thriving_scale) {
		if(consent_for_collage == -1) {
			$.fancybox.open({
    			src	: host_url + 'games/collage_signup',
				type : 'ajax',
				opts : {
					afterClose	: function() {
	    				road_map_box(road_map, thriving_scale);
					},
	    		    closeBtn : false,
					closeClickOutside : false
				}
    		});            				
		} else {
			road_map_box(road_map, thriving_scale);
		}
	}

	var road_map_box = function(road_map, thriving_scale) {
		if(road_map == 0) {
			$.fancybox.open({
    			src	: host_url + 'users/roadmaps',
				type : 'ajax',
				opts : {
					afterClose	: function() {
	    				thriving_scale_box(thriving_scale);
					},
	    		    closeBtn : false,
					closeClickOutside : false
				}
    		});            				
		} else {
			thriving_scale_box(thriving_scale);
		}
	}

	var thriving_scale_box = function(thriving_scale) {
		if(thriving_scale != 2) {
			$.fancybox.open({
    			src	: host_url + 'games/game_step?st=192',
				type : 'ajax',
				opts : {
					afterClose	: function() {},
	    		    closeBtn : false,
					closeClickOutside : false
				}
    		});            				
		}
	}
	
	return {
        init: function (narration, user_info, facebook_warning, consent_for_collage, road_map, thriving_scale) {
        	$.ajaxSetup({
        		cache: false
        	});
       		narration_box(narration, user_info, facebook_warning, consent_for_collage, road_map, thriving_scale);
        },
        
        FacebookSession: function(){
        	$('a.btn-facebook').click(function(e) {
        		e.preventDefault();
        		$.ajax({
					cache		: false,
    				type		: 'POST',
    				url			: $(this).attr('href'),
    				data		: $('input[type=checkbox]').serializeArray(),
    				success		: function(msg){
                		var object = $.parseJSON(msg)
    					var success = object.Success;
                		if(success == 1) {
                			$.fancybox.close();
                		} else {
                			$('.fancybox-inner').html(msg);
                		}
    				}
    			});
        	});
        },
        
        CollageSignUp: function(){
        	$('a.btn-collage').click(function(e){
        		e.preventDefault();
        		$.ajax({
					cache		: false,
    				type		: 'POST',
    				url			: $(this).attr('href'),
    				data		: {data: { User : {'collage_status':$(this).attr('data')}}},
    				success		: function(msg){
                		var object = $.parseJSON(msg)
    					var success = object.Success;
                		if(success == 1) {
                			$.fancybox.close();
                		} else {
                			$('.fancybox-inner').html(msg);
                		}
    				}
    			});
        	})
        },

        GamePosts: function() {
        	$('.fancybox-popup').delegate('a.game-posts', 'click', function(ev) {
        		ev.preventDefault();
        		$.fancybox.close();
        	});
        },
        
        ToolBoxLoadLink: function() {
        	$('.icon-wrapper').hover(function() {
        		$(this).find('.tool-box-info:first').css({'display':'block'});
			}, function() {
        		$(this).find('.tool-box-info:first').css({'display':'none'});
			});

    		$('a.fbox-toolbox').fancybox({
    			beforeLoad	: function() {
			    	$('.tool-box-click').prev($('.notification-allies')).remove();
			    },
			});
    		
    		$('a.fbox-challenges').fancybox({});
        },
        
        TourGame: function() {
    	    $('#tourbus').tourbus({
    	    	onLegStart	: function( leg, bus ) {
    	    		
    	    		currentStep = leg.index + 1;
    	    		if(currentStep == 4) {
    	    			$('a[data=btn-' + game_step + ']').trigger('click');
    	    		}
    	    		if(currentStep == 5) {
    			    	$('.fancybox-inner').scrollTo(2000, 800);
    			    	$('#' + leg.elId).css('top', '68%');
    			    	$('#' + leg.elId).css('left', '34%');
    	    		}
    	    		if(currentStep == 6) {
    	    			$.fancybox.close();

						btnimage = $('img.level-' + game_step).attr('src');
						btnimage = btnimage.replace('level-start', 'level-finished');
						btnimage = btnimage.replace('level-in-progress', 'level-finished');

						$('img.level-1').attr('src', btnimage);
    	    			$('a[data=btn-1]').attr('class', 'col-md-12 col-sm-12 btn btn-step btn-finished');
    	    		}
    	    		if(currentStep == 7) {
						btnimage = $('img.level-' + game_step).attr('src');
						btnimage = btnimage.replace('level-in-progress', 'level-start');
						btnimage = btnimage.replace('level-finished', 'level-start');

						$('img.level-1').attr('src', btnimage);
						$('a[data=btn-' + game_step + ']').attr('class', 'col-md-12 col-sm-12 btn btn-step btn-start');
    	    		}
    	    	},
				onLegEnd	: function(leg) {},
				onDepart	: function() {},
				onStop		: function() {}
    	    });

    	    $('#game-tour').click(function(eve) {
    	    	$('#tourbus').trigger('depart.tourbus');
    	    });
        },
        
        Support: function(){
        	var files_added = 1;
    		$('.fbox-support').fancybox({
				'helpers' 		: {
					'overlay'	: {
						'closeClick' : false
					}
				},
			    beforeLoad	: function() {},
				'padding'		: [10, 0, 10, 0],
				'href'			: $(this).attr('href'),
				'type'			: 'ajax',
			    'autoSize'		: false,
				'height'        : 'auto',
				'width'			: 450,
			});
        	
        	$('.support-image-add').click(function(event) {
        		event.preventDefault();
        		files_added = files_added + 1;
        		$('<input type="file" id="UserImage' + files_added + '" name="data[User][image' + files_added + ']">').insertBefore($(this));
        		if(files_added == 3){
        			$('.support-image-add').hide();
        		}
        	});
        	
        	$('.send-to-support').click(function(eve){
        		eve.preventDefault();
        		if(!( ($('#UserSubject').val()== '') && ($('#UserIssue').val() == ''))){
        			FileUpload.startFileLoading($('.ticket-number'), 'In Progress');
            		$('.send-to-support').attr('disabled','true');
            		 $('#UserSupportForm').ajaxForm({
     					cache		: false,
    					url 	: host_url + 'users/send_to_support',
    					type 	: 'POST',
    					success : function(response) {
        					var object  = $.parseJSON(response)
        					var flash 	= object.flash;
    						$('.ticket-number').html(flash);
    						$('.send-to-support').remove();
    					}
    				}).submit();
        		} else {
        			alert('Please enter Subject and Issue');
        		}
        		
        	});
        },
        
        RenderSpider : function(){
        	$.ajax({
				cache		: false,
				type		: 'POST',
				url			: host_url +'games/render_spider',
				success		: function(data){
					$('.active-spider').html(data);
				},
				error		: function(){},
				complete	: function(){}
			});
        },
        
        TakeSurvey: function() {
        	$('.take-survey').fancybox({
				'helpers' 		: {
					'overlay'	: {
						'closeClick' : false
					}
				},
				afterClose	: function() {
					$('a[data=btn-' + game_step + ']').trigger('click');
				},
        	});
        },
        
        StartGame: function() {
			$('.btn-step').fancybox({
			    'helpers'		:  {
			        'overlay' 	: {
			            'closeClick' : false
			        }
			    },
				'type'			: 'ajax',
			    'autoSize'		: false,
				'width'         : 700,
				'height'        : 'auto',
			    beforeLoad	: function() {},
			    afterLoad		: function(current, previous) {
			    	str = (current.href).lastIndexOf('=') + 1;
			    	game_step = (current.href).substr(str);
			    },
			    afterClose	: function() {
			    	if($.isNumeric(game_step)) {
	        			$.ajax({
	    					cache		: false,
	        				type		: 'POST',
	        				data		: {data: game_step},
	        				url			: host_url +'games/step_complete',
	        				success		: function(data){
	        					if(data == 2) {
	        						btnclass = 'col-md-12 col-sm-12 col-xs-12 btn btn-step btn-finished';
	        						btnimage = $('img.level-' + game_step).attr('src');
	        						btnimage = btnimage.replace('level-start', 'level-finished');
	        						btnimage = btnimage.replace('level-in-progress', 'level-finished');
	        						
	        					} else if(data == 1) {
	        						btnclass = 'col-md-12 col-sm-12 col-xs-12 btn btn-step btn-in-progress';
		        					btnimage = $('img.level-' + game_step).attr('src');
	        						btnimage = btnimage.replace('level-start', 'level-in-progress');
	        						btnimage = btnimage.replace('level-finished', 'level-in-progress');
	        						
	        					} else {
	        						btnclass = 'col-md-12 col-sm-12 col-xs-12 btn btn-step btn-start';
	        						btnimage = $('img.level-' + game_step).attr('src');
	        						btnimage = btnimage.replace('level-in-progress', 'level-start');
	        						btnimage = btnimage.replace('level-finished', 'level-start');
	        						
	        					}
        						$('a[data=btn-' + game_step + ']').attr('class', btnclass);
        						$('img.level-' + game_step).attr('src', btnimage);

        						if($('.status-true').length >= 5) {
	        						//$('a#81').attr('class', 'btn-step');
	        					}
	        					if(game_step == 191) {
	        						//Game.RenderSpider();
	        					}
	        				},
	        				error		: function(){},
	        				complete	: function(){}
	        			});
			    	}
			    },
			});
        },
        
        OpenGame: function(step, cid) {
        	if(step > 0) {
            	game_step = step;
            	$('a[data=btn-' + game_step + ']').trigger('click');
            	
            	if(cid > 0) {
            		setTimeout(function() {
              			$('img#ins[data="' + cid + '"]').trigger('click');
            		}, 1000);
            	}
        	}
        },
        
        SaveGame: function() {
    		$('.save-answer').on('focusout', 'input[type=text], textarea, select', function(evt) {
    			var DOM_Element = $(this);
    			var data 		= $(this).serializeArray();
    			var challenge 	= $(this).closest('.save-challenge').length;

    			if(DOM_Element.attr('data-save') !== undefined && DOM_Element.attr('class').search('date-picker') == -1) {
    				if(challenge > 0) {
    					depen_id = $(this).attr('data-depn');
    		    		data 	 = $(this).closest('.save-challenge').find(':input').serializeArray();
    				} 
    				$.ajax({
    					type		: 'POST',
    					data		: data,
    					url			: $(this).attr('data-save'),
    					success		: function(data) {
    	        			var object = $.parseJSON(data);
    	        			if(object.success) {
    	        				if(challenge > 0) {
	    	        				$('input[data=challenge-' + depen_id + ']').attr('value', object.id);
	    	        				completeby = $('.date-picker-future[data-depn=' + depen_id + ']').attr('value');
	    	        				description = $('.description[data-depn=' + depen_id + ']').attr('value');
					            	$('a[data=addto-' + depen_id + ']').children('._start').text(completeby);
					            	$('a[data=addto-' + depen_id + ']').children('._end').text(completeby);
					            	$('a[data=addto-' + depen_id + ']').children('._description').text(description);
					            	$('a[data=addto-' + depen_id + ']').removeClass('hidden');
						            addthisevent.refresh();
					            	
					            	$('a[data=ally-' + depen_id + ']').removeClass('hidden');
					            	var href = $('a[data=ally-' + depen_id + ']').attr('href');
					            	href = href + object.id;
					            	$('a[data=ally-' + depen_id + ']').attr('href', href);
						            
    	        				} else {
        	        				var attr_name 	= DOM_Element.attr('name');
        	        				attr_name 		= attr_name.replace('[0]', '[' + object.id + ']');

        	        				if(DOM_Element.attr('data-child') == 'true') {
        	        					DOM_Element.parents('div.form-group').children('div:first-child').children('input').attr('name', attr_name); 
        	        					DOM_Element.parents('div.form-group').children('div:last-child').children('input').attr('name', attr_name);
        	        					
        	        				} else {
        	        					DOM_Element.attr('name', attr_name);
        	        				}
        	        				
        	        				$('label[data="' + object.cid + '"]').html(DOM_Element.attr('value'));
    	        					
    	        				}
    	        			}
    					}
    				});
    			}
    		});
    		
			$('.save-ally').on('typeahead:selected', 'input', function(evt, item) {
				conf_id = $(this).attr('data-conf');
				$('img[data=medium-' + conf_id + ']').attr('src', item.img);
				$('input[data=input-' + conf_id + ']').attr('value', item.id);
				
				var DOM_Element = $('input[data=input-' + conf_id + ']');
				
    			if(DOM_Element.attr('data-save') !== undefined) {
    				$.ajax({
    					type		: 'POST',
    					data		: $('input[data=input-' + conf_id + ']').serializeArray(),
    					url			: $('input[data=input-' + conf_id + ']').attr('data-save'),
    					success		: function(data){
    	        			var object = $.parseJSON(data);
    	        			if(object.success) {
    	        				var attr_name 	= DOM_Element.attr('name');
    	        				attr_name 		= attr_name.replace('[0]', '[' + object.id + ']');
    	        				DOM_Element.attr('name', attr_name);
    	        				
    	        			}
    					}
    				});
    			}
			});
        },
        
        SaveAndCloseGame: function() {
        	$('.fancybox-inner').on('click', '.btn-save', function() {
    			$.fancybox.close();
    			if(game_step == 81){
    				alert(game_step);
    				$.fancybox.open({
    					'helpers' 		: {
    						'overlay'	: {
    							'closeClick' : false
    						}
    					},
    					afterClose	: function() {},
    					'href'			: host_url + 'games/collage_roadmap_completed/completed',
    					'type'			: 'ajax',
    				    'autoSize'		: false,
    				    'width'			: 400,
    					'height'        : 'auto',
    					closeBtn		: false
    				});
    			}
        	});
        },
        
        GameToolBar: function() {
			$('.fancybox-game-popup').delegate('.fuwords-view', 'click', function(){
				$('.fuwords').toggle('slow', function() {});
				if ($('.help-text').is(":visible")) {
					$('.help-text').toggle('slow', function() {});
				} 
			});
			
			$('.fancybox-game-popup').delegate('.help-view', 'click', function(){
				$('.help-text').toggle('slow', function() {});
				if ($('.fuwords').is(":visible")) {
					$('.fuwords').toggle('slow', function() {});
				} 
			});
        },
        
        HashTag: function() {
        	$('.fancybox-game-popup').delegate('.label-tag', 'click', function(event){
        		event.preventDefault();
        		DOM_Element = $(this);
        		$.ajax({
    				cache		: false,
        			url		: $(this).attr('href'),
        			success : function(data) {
        				$(data).insertAfter(DOM_Element);
        			}
        		});
        	});
        },
        HashTagClose: function(){
        	$('.fancybox-game-popup').delegate('.close-ht-displayUsers', 'click', function(event){
        		$(".hashtags-diaplayUsers").remove();
        	});
        },
        
        RoadMap: function(){
        	$('.roadmaps').on('focusout', 'input[type=text], select', function(evt){
				var DOM_Element = $(this);
    			if(DOM_Element.attr('data-save') !== undefined) {
    				$.ajax({
    					type		: 'POST',
    					data		: $(this).parents('.roadmap-block').find(':input').serializeArray(),
    					url			: $(this).attr('data-save'),
    					success		: function(data) {
    	        			var object = $.parseJSON(data);
    						
    	        			if(object.success) {
    	        				if(object.update == 0) {
    	        					DOM_Element.parents('.roadmap-block').find('.roadmap-id').attr('value', object.id);
    	        					DOM_Element.parents('.roadmap-block').find('.active-roadmap').html(
    	        							'<a href="' + object.active + '"><i class="fa fa-map fa-2x"></i></a>');

    	        					if(object.delete != '') {
        	        					DOM_Element.parents('.roadmap-block').find('.delete-roadmap').html(
        	        							'<a href="' + object.delete + '"><i class="fa fa-trash fa-2x"></i></a>');
    	        					}

    	        					var duplicate = $('.roadmaps').find('.roadmap-block.hidden');
    	        					$('.roadmaps').append(duplicate.clone());
    	        					duplicate.toggleClass('hidden');
    	        				}
    	        			}
    					}
    				});
    			}
        	});
        	
        	$('.roadmap-save').click(function(event){
        		road_map_name = $('.roadmap-input').val();
        		if(road_map_name === '') {
            		event.preventDefault();
        			$('h5.error-message').html('Please enter the roadmap');
        		} else {
            		location.reload();
        		}
        	});
        },
        
	    handleDatePicker: function() {
	    	if (jQuery().datepicker) {
	    	    $('.date-picker').datepicker({
					format		: 'mm/dd/yyyy',
	    	        autoclose	: true
	    	    });
	    	    
	    	    $('.date-picker-mm-yyyy').datepicker({
	    	        autoclose	: true,
					startDate	: '-0m' ,
					endDate		: '+20y',
	    	        minViewMode	: 'months',
	    	        format		: 'M, yyyy'
	    	    }).on('changeDate', function(e) {
	    	    	
	    			var DOM_Element = $(this);
	    			if(DOM_Element.attr('data-save') !== undefined) {
	    				$.ajax({
	    					type		: 'POST',
	    					data		: $(this).serializeArray(),
	    					url			: $(this).attr('data-save'),
	    					success		: function(data){
	    	        			var object = $.parseJSON(data);
	    	        			if(object.success) {
	    	        				var attr_name 	= DOM_Element.attr('name');
	    	        				attr_name 		= attr_name.replace('[0]', '[' + object.id + ']');
	    	        			}
	    					}
	    				});
	    			}
	    	    });

				$('.date-picker-past').datepicker({
					startDate	: '-80y' ,
					endDate		: '+0m',
					format		: 'mm/dd/yyyy',
					autoclose	: true
				});
				
				$('.date-picker-future').datepicker({
					startDate	: '-0m' ,
					endDate		: '+20y',
					format		: 'mm/dd/yyyy',
					autoclose	: true
	    	    }).on('changeDate', function(e) {
					var DOM_Element = $(this);
					depen_id = $(this).attr('data-depn');
	    			if(DOM_Element.attr('data-save') !== undefined) {
	    				$.ajax({
	    					type		: 'POST',
	    					data		: $(this).parents('.save-challenge').find(':input').serializeArray(),
	    					url			: $(this).attr('data-save'),
	    					success		: function(data) {
	    	        			var object = $.parseJSON(data);
	    	        			if(object.success) {
	    	        				$('input[data=challenge-' + depen_id + ']').attr('value', object.id);
	    	        				$('img[data-depn=' + depen_id + ']').attr('data-challenge', object.id);
	    	        				
	    	        				completeby = $('.date-picker-future[data-depn=' + depen_id + ']').attr('value');
	    	        				description = $('.description[data-depn=' + depen_id + ']').attr('value');
					            	
	    	        				$('a[data=addto-' + depen_id + ']').children('._start').text(completeby);
					            	$('a[data=addto-' + depen_id + ']').children('._end').text(completeby);
					            	$('a[data=addto-' + depen_id + ']').children('._description').text(description);
					            	$('a[data=addto-' + depen_id + ']').removeClass('hidden');
	    	        				addthisevent.refresh();

	    	        				$('img[data-depn=' + depen_id + ']').parents('div').removeClass('hidden');

	    	        				$('a[data=ally-' + depen_id + ']').removeClass('hidden');
					            	var href = $('a[data=ally-' + depen_id + ']').attr('href');
					            	href = href + object.id;
					            	$('a[data=ally-' + depen_id + ']').attr('href', href);
	    	        			}
	    					}
	    				});
	    			}
				});
	    	}
	    },
	    
	    ChallengeAlly: function() {
			$('a.ally-selection').on('click', function(evt) {
				evt.preventDefault();
				DOM_Element = $(this);

    			$.ajax({
					url	: $(this).attr('href'),
					success		: function(data) {
						if(data !== 0) {
							var object = $.parseJSON(data)
							console.log(DOM_Element.parents('.row').children('.' + object.class).attr('class'));
							DOM_Element.attr('href', object.url);
							DOM_Element.appendTo(DOM_Element.parents('.row').children('.' + object.class));
						}
					}
				});
	    	});
	    },
	    
	    handleRating: function() {
	    	$('.rating').raty({
	    	    starHalf    : '../plugins/raty/lib/images/star-half.png',
	    	    starOff     : '../plugins/raty/lib/images/star-off.png',
	    	    starOn      : '../plugins/raty/lib/images/star-on.png',
	    	    score		: function() {
	    		    return $(this).attr('data-score');
	      		},
	      		click: function(score, evt) {
	    			if($(this).attr('data-save') !== undefined) {
	    				$.ajax({
	    					url	: $(this).attr('data-save') + '/' + score,
	    					success : function(data) {
	    						console.log(data);
	    						window.location.href = data;
	    					}
	    				});
	    			} else {
		      			//alert('ID: ' + this.data + "\nscore: " + score + "\nevent: " + evt);
						depen_id = $(this).attr('data-depn');
						var DOM_Element = $('input[data=rating-' + depen_id + ']');
						DOM_Element.attr('value', score);
	    			}
	      		}
	    	});
	    	
	    	$('.modal').on('click', 'button.btn', function(evt) {
    			if($(this).attr('data-save') !== undefined) {
    				id = $(this).attr('data');
    				$.ajax({
    					type		: 'POST',
    					data		: $(this).parents('.modal-challenge').find(':input').serializeArray(),
    					url			: $(this).attr('data-save'),
    					success		: function(data) {
    						DOM_Element = $('a[data=goal-' + id + ']');
    						
    						$('<div class="btn-finished pull-right">Challenge Completed</div>').insertAfter(DOM_Element);
    						DOM_Element.remove();
    					}
    				});
    			}
	    	});
	    },
	    
	    initAddToCalendar: function() {
			$.getScript('https://addthisevent.com/libs/ate-latest.min.js').success(
					function(script, textStatus) {
						console.log(textStatus);
					}).fail(function(jqxhr, settings, exception) {
			});
	    },
	    
		AddMore: function() {
			$('a.add-more').on('click', function(evt) {
				evt.preventDefault();
				data = $(this).attr('data-add');
				clone = $('div.form-group[data-add=' + data + ']').children('input:first-child').clone();
				clone.attr('value', '');
				clone.attr('name', $(this).attr('data'));
				$('div.form-group[data-add=' + data + ']').append(clone);
				//clone.insertBefore($(this));
			});
		},
    
		StartVision: function() {
			$('a.btn-start-vision').on('click', function(evt) {
				evt.preventDefault();
    			$.ajax({
					cache		: false,
    				type		: 'POST',
    				url			: $(this).attr('href'),
    				success		: function(data) {
    		            var object = $.parseJSON(data)
				        if(object.success) {
				        	//var t = object.flash.split(/[- :]/);
				        	//var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
	    		            var d = new Date(object.flash);
	    		            $('#defaultCountdown').countdown({until: d});
						}
    				}
				});
			});
		},
    
		SelectAlly: function() {
			var setHelper = new Bloodhound({
				datumTokenizer: function(d) { return d.tokens; },
	            queryTokenizer: Bloodhound.tokenizers.whitespace,
	            remote: host_url + 'challenges/typeahead_allies?query=%QUERY'
			});
			setHelper.initialize();

			$('.live-search-ally').typeahead(null, {
				displayKey	: 'name',
				source		: setHelper.ttAdapter(),
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
			
			var setChallenger = new Bloodhound({
				datumTokenizer: function(d) { return d.tokens; },
	            queryTokenizer: Bloodhound.tokenizers.whitespace,
	            remote: host_url + 'games/typeahead_allies?query=%QUERY'
			});
			setChallenger.initialize();

			$('.live-search-goal').typeahead(null, {
				displayKey	: 'name',
				source		: setChallenger.ttAdapter(),
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

			$('input.live-search-goal').on('typeahead:selected', function(evt, item) {
				depn_id = $(this).attr('data-depn');
				$('input[data=from-' + depn_id + ']').attr('value', item.id);
				$('img[data=medium-' + depn_id + ']').attr('src', item.img);
				$('div[data=label-' + depn_id + ']').html(item.goal);
			});
		},
		
		UpdateNotification: function() {
    		$('#notification').on('click', 'a.noti', function(evt) {
    			var DOM_Element = $(this);
    			evt.preventDefault();
    			$.ajax({
					cache		: false,
    				type		: 'POST',
    				url			: $(this).attr('href'),
    				success		: function() {
    	    			alert_count = $('#notification').find('span.bold').text();
    	    			alert_count = alert_count - 1;
    	    			$('#notification').find('span.bold').text(alert_count);
    	    			$('#notification').find('span.badge').text(alert_count);
    	    			if(alert_count == 0) {
    	    				$('#notification').find('span.badge').remove();
    	    			}
    					DOM_Element.remove();
    				}
				});
    		});
		}
	};
}();

var DreamPathGauge = function () {
	return {
		Init: function() {
			var block;
			$('.selected').css({'box-shadow':'0 4px 10px #B0D29F'});
			
			for(j = 0; j < 24; j++){
				for(i = 1; i <=10; i++){
					block = $("<div />",{
					"class"		: "numberbox",
					"id"		: "tblock-"+ j + "-" + i}).css({"position":"absolute", 
																'color':'#FF0000', 
																"top" : 12, 
																"left" : 49 + ((i - 1) * 16)});
					$(block).appendTo("#temperature-" + j);
				}
			}
		},
		
		FillData: function() {
			$(".oppgaugebox").each(function(ev){
			 	answer = $(this).attr('data-answer');
			 	//alert(answer);
			 	var ctx = document.getElementById("temp-" + $(this).find('.temperature').attr('id').split('-')[1]).getContext("2d");
				ctx.fillStyle = "#808080";
				if(answer){
					ctx.clearRect(0, 0, 300, 150);
					tempid = $(this).find('.temperature').attr('id').split('-')[1];
					ctx.fillRect(45, 80, (5 + (answer * 18)), 7);
				}
				answer = '';
			});
		},
		
		SaveData: function() {
			$("div.temperature").delegate("div.numberbox", "click", function(ev){
				ev.preventDefault();
				var ctx = document.getElementById("temp-"+$(this).closest('.temperature').attr('id').split('-')[1]).getContext("2d");
				
				ctx.fillStyle = "#808080";
				ctx.clearRect(0, 0, 500, 200);
				
				answer 		= $(this).attr('id').split('-')[2];
				confid 		= $(this).closest('.oppgaugebox').attr('id');

				var object = {}; 
				object[confid] = answer;
				ctx.fillRect(45, 80, (5 + (answer * 18)), 7);
				key2 		= {'Game': {'configuration_id': object}};
				
				$.ajax({
					beforeSend	: function(){},
					url			: host_url + 'games/save',
					type		: 'POST',
					data 		: {data : key2},
					success		: function(data){
						var object = $.parseJSON(data)
				        if(object.flash){
							$('.cMessageBlock').html(object.flash);
							showMessageBlock();
						}
					}
				});
			});
		}
	}
}();

var FileUpload = function () {
	return {
        startFileLoading: function(container, message) {
            $('.page-loading').remove();
            container.append('<div class="page-loading"><img src="' + 
            		host_url + 'img/loading-spinner-blue.gif" />&nbsp;&nbsp;<span>' + 
            		(message ? message : 'Loading...') + '</span></div>');
        },

        stopFileLoading: function() {
            $('.page-loading').remove();
        },

		UploadFileImage: function() {
			var upload_DOM, formElement;
			var ReqHan = new Array();
			$('.fileupload').change(function(ev) {
				FileUpload.startFileLoading($(this).closest('.image-box'), 'Uploading');
				upload_DOM = $(this).find('input[type=file]');
				upload_URL = $(this).attr('data-save');
				formElement = upload_DOM.parents('form').attr('id');
				if(typeof(ReqHan[formElement]) == 'undefined') {
					ReqHan[formElement] = false;
				}
				if(!ReqHan[formElement]) {
					ReqHan[formElement] = $('#' + formElement).ajaxForm({
						beforeSend		: function(){},
						data			: {},
						url				: upload_URL,
						uploadProgress	: function(ev, position, total, percentComplete){},
						success			: function(data) {
							var object = $.parseJSON(data);
							var success = object.success;
							if(success) {
								$('img[data="medium-' + object.cid + '"]').attr('src', host_url + 'files/img/medium/' + object.filename);
								$('img[data="small-' + object.cid + '"]').attr('src', host_url + 'files/img/small/' + object.filename);
								$('#' + formElement).siblings('.remove-upload').toggleClass('hidden');
								if($('#' + formElement).closest('.col-md-12').prev('.uploadMultipleDiv').length){
									$('#' + formElement).closest('.col-md-12').prev('.uploadMultipleDiv').remove();
								}
							} else {
								console.log(object.flash);
							}
							FileUpload.stopFileLoading();
							ReqHan[formElement] = false;
						},
						error		: function(data) {},
						complete	: function(){
							ReqHan[formElement] = false;
						}
					}).submit();
				}
			}); 
		},
		
		UploadMultipleImages: function() {
			$('.multi-upload').click(function(eve) {
				eve.preventDefault();
				DOM_element = $(this);
				var parentID = DOM_element.attr('id');
				parentID = parentID.substr(6,2);
				FileUpload.startFileLoading(DOM_element.closest('div.uploadMultipleDiv').next('div').find('.image-box'), 'Uploading');
				
				$('#Model' + parentID + 'GameStepForm').ajaxForm({
					beforeSend		: function(){},
					data			: {},
					url				: host_url + 'games/uploadAll',
					uploadProgress	: function(ev, position, total, percentComplete) {},
					success			: function(data) {
						var object = $.parseJSON(data);
						$.each(object, function(key, val){
							if(val.success) {
								$('.row-multi-upload').hide();
								$('img[data="medium-' + val.cid + '"]').attr('src', host_url + 'files/img/medium/' + val.filename);
								$('img[data="small-' + val.cid + '"]').attr('src', host_url + 'files/img/small/' + val.filename);
								$('.image-icon').append('<a href="/kissaah/games/remove_image/' + object.cid + '"><i class="fa fa-trash fa-2x" title="Remove Image"></i></a>');
							} else {
								alert(val.flash);
							}
							FileUpload.stopFileLoading();
						});
					},
					error			: function(data){
						DOM_element.show();
					},
					complete		: function(){
						FileUpload.stopFileLoading();
					}
				}).submit();
			});
		},
		
		//For the image  icons below Activity Images 
		ImageActions: function(){
			$('.image-icon').delegate('a', 'click', function(ev) {
				ev.preventDefault();
				element = $(this);
				url  = $(this).attr('href');
				icon = $(this).children('i').attr('class');
				if(url != '') {
					if(icon == 'fa fa-trash fa-2x') {
						var r = confirm("Are You Sure You want to remove this image ?\n This will all delete dependent data as well");
						if(r == true) {
							$.ajax({
								beforeSend 	: function() {},
								type 		: 'POST',
								url			: url,
								dataType	: 'json',
								success 	: function(data) {
									message = data.message;
									success = data.success;
									cid		= data.cid;
									if(success == 0 ) {
										alert('Cannot remove image. Please try again later.');
									} else if(success == 1) {
										element.toggleClass('hidden');
										$('img[data="medium-' + cid + '"]').attr('src', 'http://placehold.it/198x198&text=X');
										$('img[data="small-' + cid + '"]').attr('src', 'http://placehold.it/198x198&text=X');
										$('textarea[data="' + cid + '"]').attr('value', '');
										$('input[data="' + cid + '"]').attr('value', '');
										$('div[data="' + cid + '"]').html('');
									}
								},
								error 		: function() {},
								complete 	: function() {}
							});
						}
					} else {
						$.fancybox.close();
						setTimeout(function(){
		        			$.fancybox.open({
		        				'helpers' 		: {
		        					'overlay'	: {'closeClick' : false}
		        				},
		        				afterClose	: function() {
		        					$('a[data=btn-' + game_step + ']').trigger('click');
		        				},
		        				'href'			: url,
		        				'type'			: 'ajax',
		        			    'autoSize'		: false,
		        				'width'         : 700,
		        				'height'        : 'auto',
		        			});
						}, 500);
					}
				}
			});
			
		},
		
		UploadPinterestImage: function() {
			$('.fancybox-pinterest').delegate('#pinterest-username', 'click', function(eve) {
				eve.preventDefault();
				$.ajax({
					url 	: host_url + 'games/pinterest_getimages/' + $('#pinterest_user').val() + '?cid=' + $('#configuration_id').val(),
					type 	: 'POST',
					success : function(response) {
						$('.fancybox-inner').html(response);
					}
				});
			});

			$('.fancybox-pinterest').delegate('.pinterest-upload', 'click', function(eve) {
				$('.UploadingPinterest').css('display', 'block');
				var formData = {};
				var src = $(this).parent().find('img').attr('src');
				formData['src'] = src;
				formData['cid'] = $(this).attr('data');
				
				$.ajax({
					beforeSend:function(){},
					type	:'POST',
					data	: {
						data: JSON.stringify(formData)
					},
					url		: host_url + 'games/upload_image_pinterest',
					success	: function(data){
						var object = $.parseJSON(data);
						var success = object.success;

						$('img[data="medium-' + object.cid + '"]').attr('src', host_url + 'files/img/medium/' + object.filename);
						$('img[data="small-' + object.cid + '"]').attr('src', host_url + 'files/img/small/' + object.filename);

						if(success == 1){
        					$.fancybox.close();
        					setTimeout(function() {
        						$('a[data=btn-' + game_step + ']').trigger('click');
        					}, 500);
						}
						if(success == 0){
							alert('Cannot Upload Image,Try later');
						}
					},
					error: function(){},
					complete: function(){}
				});
			});

		},
	}
}();

var SortingValues = function () {
	return {
		DragAndDrop: function() {
			var finalconfid;
			$(document).on('mouseenter', '.draggable-list', function(e) {
				var item = $(this); 
				item.draggable({
					helper		: 'clone',
					snap		: true,
					//revert	: 'invalid',
					//cursor	: 'move',
					//scroll	: false,
					//zIndex	: 500,
					start	: function(ev, ui) {
						finalconfid = undefined;
					},
					stop	: function(ev, ui) {
						confid 	= item.parent('div').attr('data-conf');
						id 		= item.parent('div').attr('data-id');
						list_class = item.attr('class');
						
						if(confid != undefined && finalconfid != undefined && list_class.search('draggable-fixed') == -1) {
							var data = { };
							data['data[Game][' + confid + '][' + id + ']'] = '';
							
							$.ajax({
								url			: host_url + 'games/save',
								type		: 'POST',
								data 		: data,
								success		: function(data) {
		        					var object = $.parseJSON(data);
		        					if(object.success) {
		        						if($('div[data-conf="' + object.cid + '"]').hasClass('droppable-answer-xs')) {
		        							$('div[data-conf="' + object.cid + '"]').html('<li class="draggable-drop-here">Drop Here</li>');	
		        						} else {
		        							$('div[data-conf="' + object.cid + '"]').html('<li class="draggable-drop-here">Drop <br>Here</li>');
		        						}
		    							
		        					}
								}
							});
						} else {
							$('.add-wild-card li').hide();
							$('.add-wild-card li').html('');
							$('.add-wild-card a').css('display', 'inline-block');
							
						}
						
					}
				 });
			});
			
			$(document).on('touchstart', '.draggable-list', function(e) {
				var item = $(this); 
				item.draggable({
					helper		: 'clone',
					snap		: true,
					//revert	: 'invalid',
					//cursor	: 'move',
					//scroll	: false,
					//zIndex	: 500,
					start	: function(ev, ui) {
						finalconfid = undefined;
					},
					stop	: function(ev, ui) {
						confid 	= item.parent('div').attr('data-conf');
						id 		= item.parent('div').attr('data-id');
						list_class = item.attr('class');
						
						if(confid != undefined && finalconfid != undefined && list_class.search('draggable-fixed') == -1) {
							var data = { };
							data['data[Game][' + confid + '][' + id + ']'] = '';
							
							$.ajax({
								url			: host_url + 'games/save',
								type		: 'POST',
								data 		: data,
								success		: function(data) {
		        					var object = $.parseJSON(data);
		        					if(object.success) {
		        						if($('div[data-conf="' + object.cid + '"]').hasClass('droppable-answer-xs')) {
		        							$('div[data-conf="' + object.cid + '"]').html('<li class="draggable-drop-here">Drop Here</li>');	
		        						} else {
		        							$('div[data-conf="' + object.cid + '"]').html('<li class="draggable-drop-here">Drop <br>Here</li>');		        							
		        						}
		        					}
								}
							});
						} else {
							$('.add-wild-card li').hide();
							$('.add-wild-card li').html('');
							$('.add-wild-card a').css('display', 'inline-block');
							
						}
						
					}
				 });
			});
			
			$('.droppable-answer').droppable({
				accept 		: '.draggable-list',
				activeClass	: 'ui-draggable',
				drop		: function( event, ui ) {
					confid 	= $(this).attr('data-conf');
					id 		= $(this).attr('data-id');
					finalconfid = confid;
					
					if(confid != undefined) {
						$(this).html($(ui.draggable).clone());
						
						dropelement = $(ui.draggable).clone();
						dropelement.attr('class', 'draggable-fixed');
						$('div[data="drop-' + confid + '"]').html(dropelement);
						
						dropelement = ui.draggable.text();
						$('div[data="dropsummary-' + confid + '"]').html(dropelement);
						$('div[data="dropsummary-' + confid + '"]').attr('class', 'btn-in-progress btn-featured');
						
						var data = { };
						data['data[Game][' + confid + '][' + id + ']'] = ui.draggable.text();

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
			
			$('.droppable-answer-xs').droppable({
				accept 		: '.draggable-list',
				activeClass	: 'ui-draggable',
				drop		: function( event, ui ) {
					confid 	= $(this).attr('data-conf');
					id 		= $(this).attr('data-id');
					finalconfid = confid;
					
					if(confid != undefined) {
						$(this).html($(ui.draggable).clone());
						
						dropelement = $(ui.draggable).clone();
						dropelement.attr('class', 'draggable-fixed');
						$('div[data="drop-' + confid + '"]').html(dropelement);
						
						dropelement = ui.draggable.text();
						$('div[data="dropsummary-' + confid + '"]').html(dropelement);
						$('div[data="dropsummary-' + confid + '"]').attr('class', 'btn-in-progress btn-featured');
						
						var data = { };
						data['data[Game][' + confid + '][' + id + ']'] = ui.draggable.text();

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
			
			$('.droppable-discard').droppable({
				accept 		: '.draggable-list',
				drop		: function( event, ui ) {
					finalconfid = 0;
					ui.draggable.hide();
				}
			});

			$('.add-wild-card').on('click', 'a', function(ev) {
				ev.preventDefault();
				$(this).parent('.add-wild-card').find('li').hide();
				$(this).parent('.add-wild-card').find('input').show();
				$(this).parent('.add-wild-card').find('input').attr('value', '');
				$(this).hide();
				
			});
			
			$('.add-wild-card').on('click keypress', 'input', function(ev) {
				if(ev.which == 1 || ev.which == 13){
					ev.preventDefault();
					if($.trim($(this).val()).length != 0) {
						$(this).parent('.add-wild-card').find('li').css('display', 'inline-block');
						$(this).parent('.add-wild-card').find('li').html($(this).val());
						$(this).parent('.add-wild-card').find('input').hide();
					}
				}
			});
		},
	}
}();

var OrganizationMap = function() {
	return {
		init : function(data_map) {
			$('#chart-container').orgchart({
				'data' 		 	: data_map,
				'nodeID' 	 	: 'id',
				'verticalDepth' : 3,
				'depth'			: 4,
				'createNode' 	: function($node, data) {
					var organizationDesc = $('<i>', {
						'class' : 'fa fa-info-circle org-desc',
						click : function() {
							$(this).siblings('.description').toggle();
						}
					});
					$node.append(organizationDesc).append('<div class="description">' + data.title + '</div>');
				}
			});
		},
	}
}();