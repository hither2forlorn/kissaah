$(document).ready(function(){
	var $cbImgViewerCnt;
	
	var settings = {
		'viewportWidth' : '100%',
		'viewportHeight' : '100%',
		'fitToViewportShortSide' : true,  
		'contentSizeOver100' : false,
		'loadingBgColor' : '#ffffff',
		'startScale' : 1,
		'startX' : 500,
		'startY' : 500,
		'animTime' : 500,
		'draggInertia' : 10,
		'zoomLevel' : 1,
		'zoomStep' : 0.1,
		'contentUrl' : '',
		'intNavEnable' : true,
		'intNavPos' : 'R',
		'intNavAutoHide' : true,
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
		'mapThumb' : '',
		'mapPos' : 'BL',
		'popupShowAction' : 'click',
		'testMode' : false
	};
	
	$(".group1").colorbox({innerWidth : '600px', innerHeight : '400px', rel : 'group1'});
	$(".group1").colorbox({
		onComplete : function() {
			if($cbImgViewerCnt) {
				$cbImgViewerCnt.lhpMegaImgViewer('destroy');
			}
			$cbImgViewerCnt = $('<div/>').css({'width' : '100%', 'height' : '100%', 'overflow' : 'hidden'});
			$('#cboxLoadedContent').empty().append($cbImgViewerCnt);
			settings.contentUrl = $(this).attr('href');
			settings.mapThumb = $(this).find('img').attr('src');
			$cbImgViewerCnt.lhpMegaImgViewer(settings);
		},
		onClosed : function() {
			if($cbImgViewerCnt) {
				$cbImgViewerCnt.lhpMegaImgViewer('destroy');
			}
		}
	});
	$('.sample img').each(function(index){
		$(this).hover(function(){
			$(this).stop(true, true).animate({'opacity':.4});
		},
		function () {
			$(this).stop(true, true).animate({'opacity':1});
		});
	});
});