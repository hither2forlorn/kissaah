var Profile = function() {
	return {
		
		Save: function() {
			$('form#UserEditForm').submit(function(event) {
				event.preventDefault();
        		var request = $.ajax({
					type 		: 'POST',
					url 		: $(this).attr('action'),
					data 		: $('form#UserEditForm :input').serializeArray(),
				});
            	request.done(function( msg ) {
            		var object = $.parseJSON(msg)
					var success = object.Success;
            		if(success == 1) {
            			$.fancybox.close();
            			Profile.UpdateUserInfo(object);
            		} else {
            			$('.fancybox-inner').html(msg);
            		}
            	});
            	request.fail(function( jqXHR, textStatus ) {
            		alert( 'Request failed');
            	});
			});
		},
		
		SettingsFancyBox: function(){
			$('.open-fancybox').fancybox({
				'type'			: 'ajax',
			    'autoSize'		: false,
			    'width'			: 400,
				'height'        : 'auto'
			});
			$('.collage-fancybox').fancybox({
				'type'			: 'ajax',
			    'autoSize'		: false,
			    'width'			: 600,
				'height'        : 'auto',
				'wrapCSS'		: 'collage-box text-center',
			});
		},
		
		ProfileImageHover: function(){
			$('.profileimage').hover(function(){
				if($(this).find('.thumbnail').attr('src') == 'http://placehold.it/220x220&text=No Image'){
					$('.profile-image-caption').html('upload profile picture');
					$('.profileimagelabel').show();
				}
			}).mouseleave(function(){
				$('.profileimagelabel').hide();
			});
			
			$('div.header-logo').find('img.img-responsive').hover(function(){
				if($(this).attr('src') == '/kissaah/img/profilecover.jpg'){
					$('.small-profile-image-caption').html('upload profile picture');
					$('.small-profileimagelabel').show();
				}
			}).mouseleave(function(){
				$('.small-profileimagelabel').hide();
			});
		},
		
		NotificationPreferences: function() {
			$('.notification_preferences').live('click', function(){
				var val = 0;
        		if($(this).is(':checked')){
        			val = 1;
        		}
				$.ajax({
    				type		: 'POST',
    				data		: {chk_notify:val,id:$(this).attr('id')},
    				url			: host_url + '/users/edit_notification_preferences',
    				success		: function(data){
    				}
    			});
			});
		},
		
		DeactivateAccount : function(){
			$('#deactivate-account').click(function(eve){
				
				var r = confirm("Are you sure you want to deactivate your account?\n" +
						"Deactivating your account will disable your profile and remove all of your data" +
						" from Kissaah.\n " +
						"Some information may still be visible to others, " +
						"such as your feedback in your allies list.");
				if ( r == true){
					$.ajax({
	    				type		: 'POST',
	    				url			: host_url + '/users/deactivate_account',
	    				success		: function(data){
	    				}
	    			});
				} else {
					eve.preventDefault();
				}
			});
		},

		//This function is to updates data after user makes changes to their profile
		UpdateUserInfo : function (object){
			if(object.ScreenName){
				$('.ScreenName').text(object.ScreenName);
			}
			if(object.Email){
				$('#Email').text(object.Email);
			}
		}
	}
}();

//For Create Your Own Avatar

$('.avatar').click(function(){
	//alert("Ok");
	$.fancybox({
		href : 'http://gamer2.researchthroughgaming.com/?g=act-new',
		type : 'iframe',
		padding : 0,
		width :720,
		height :480
		//auto-dimensions : false
	})	;
});