var Profile = function() {
	
	return {
		Save: function() {
			$('form#UserEditForm').on('focusout', 'input[type=text], textarea, select', function(event) {
        		var request = $.ajax({
					type 		: 'POST',
					url 		: $('form#UserEditForm').attr('action'),
					data 		: $('form#UserEditForm :input').serializeArray(),
				});
            	request.done(function( msg ) {
            		var object = $.parseJSON(msg)
					var success = object.Success;
            		if(success == 1) {
            		} else {
            			$('form#UserEditForm').html(msg);
            		}
            	});
            	request.fail(function( jqXHR, textStatus ) {
            		alert( 'Request failed');
            		
            		//{"Success":1,"ScreenName":"Eric Alana Cooper","Email":"liebcpt@himalayantechies.com"}
            	});
			});
		},
		
		DeactivateAccount : function(){
			$('#deactivate-account').click(function(eve){
				
				var r = confirm('Are you sure you want to deactivate your account?\n' +
						'Deactivating your account will disable your profile and remove all of your data from Kissaah.\n' +
						'Some information may still be visible to others, such as your feedback in your allies list.');
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
	}
}();