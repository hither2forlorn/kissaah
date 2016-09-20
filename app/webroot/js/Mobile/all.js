$(document).ready(function(){
	//To show the webapp in safari in full page mode by default
	window.addEventListener("load",function() {
	    setTimeout(function(){
	        // Hide the address bar!
	        window.scrollTo(0, 1);
	    }, 0);
	});
	//To adjust the position of menu to the bottom 
	menu_bottom();
	$(window).resize(function(){
		menu_bottom();
	});
});

function menu_bottom(){
	/*console.log($(window).height);
	$('#footer').css('background','red');
	$('#footer').stop().animate({bottom: 10}, 'slow');*/
	   var docHeight = $(window).height();
	   var footerHeight = $('#footer').height();
	   var footerTop = $('#footer').position().top + footerHeight;
	 //  console.log("footerTop : "+$('#footer').offset().top);
	   if (footerTop < docHeight) {
	    $("body").find('#footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
	   }
	 // $("#footer").delegate(".footer-links").find("p").fitText(1.1, { minFontSize: '10px', maxFontSize: '75px' });
};