$(document).ready(function(){
	//To adjust the position of menu-with images(discover,design....) to the bottom 
	menuImages_bottom();
	$(window).resize(function(){
		menuImages_bottom();
	});
});

function menuImages_bottom(){
	/*console.log($(window).height);
	$('#footer').css('background','red');
	$('#footer').stop().animate({bottom: 10}, 'slow');*/
	   var docHeight = $(window).height();
	  // console.log(docHeight);
	   var footerHeight = $('.footer-images').height();
	   var footerTop = $('.footer-images').position().top + footerHeight;
	   
	   if (footerTop < docHeight) {
	    $('.footer-images').css('margin-top', 10 + (docHeight - footerTop) + 'px');
	    $("#footer").css('margin-top','0px');
	   }
	 // $(".footer-images").delegate(".footer-links").find("span").fitText(1.1, { minFontSize: '10px', maxFontSize: '75px' });
};