$(document).ready(function(){
	var settings = {
		'viewportWidth' : '100%',
		'viewportHeight' : '100%',
		'fitToViewportShortSide' : false,  
		'contentSizeOver100' : false,
		'loadingBgColor' : '#ffffff',
		'startScale' : 1,
		'startX' : 0,
		'startY' : 0,
		'animTime' : 500,
		'draggInertia' : 10,
		'zoomLevel' : 1,
		'zoomStep' : 0.1,
		'contentUrl' : 'img/1.jpg',
		'intNavEnable' : true,
		'intNavPos' : 'B',
		'intNavAutoHide' : false,
		'intNavMoveDownBtt' : true,
		'intNavMoveUpBtt' : true,
		'intNavMoveRightBtt' : true,
		'intNavMoveLeftBtt' : true,
		'intNavZoomBtt' : true,
		'intNavUnzoomBtt' : true,
		'intNavFitToViewportBtt' : true,
		'intNavFullSizeBtt' : true,
		'intNavBttSizeRation' : 1,
		'mapEnable' : true,
		'mapThumb' : 'img/thumb-1.jpg',
		'mapPos' : 'BL',
		'popupShowAction' : 'click',
		'testMode' : false
	};
	
	$('#myDiv').lhpMegaImgViewer(settings);
	
	$('#galleryThumbImg a').each(function(index){
		$(this).click(function(e) {
			e.preventDefault();
			settings.contentUrl = $(this).attr('href');
			settings.mapThumb = $(this).find('img').attr('src');
			$('#myDiv').lhpMegaImgViewer('destroy');
			$('#myDiv').lhpMegaImgViewer(settings);
		});
	});
	$('#galleryThumbImg img').each(function(index){
		$(this).hover(function(){
			$(this).stop(true, true).animate({'opacity':.4});
		},
		function () {
			$(this).stop(true, true).animate({'opacity':1});
		});
	});
});