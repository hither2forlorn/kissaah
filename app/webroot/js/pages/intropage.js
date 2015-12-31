var IntroPage = function () {

    return {

    	init: function (account_active) {
        	$('.service-box-image-over').hide();
        	if(account_active != '') {
        		$(account_active).trigger('click');
        	}
        },
        
        AccountManagement: function() {
        	$('body').delegate('.link-sign-in', 'click', function(ev) {
        		ev.preventDefault();
        		$('.sign-in').show();
            	$('.forgot-password').hide();
            	$('.create-an-account').hide();
        	});
        	$('body').delegate('.link-create-an-account', 'click', function(ev) {
        		ev.preventDefault();
            	$('.sign-in').hide();
            	$('.forgot-password').hide();
            	$('.create-an-account').show();
        	});
        	$('body').delegate('.link-forget-password', 'click', function(ev) {
        		ev.preventDefault();
            	$('.sign-in').hide();
            	$('.forgot-password').show();
            	$('.create-an-account').hide();
        	});
        }
    };
}();