$(document).ready(function(){
	var settings = {
		'viewportWidth' : '100%',
		'viewportHeight' : '100%',
		'fitToViewportShortSide' : true,  
		'contentSizeOver100' : false,
		'loadingBgColor' : '#ffffff',
		'startScale' : .5,
		'startX' : 1100,
		'startY' : 1700,
		'animTime' : 500,
		'draggInertia' : 10,
		'zoomLevel' : 1,
		'zoomStep' : 0.1,
		'contentUrl' : 'img/0.jpg',
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
		'mapThumb' : 'img/thumb-0.jpg',
		'mapPos' : 'BL',
		'popupShowAction' : 'click',
		'testMode' : false
	};
	
	$('#myDiv').lhpMegaImgViewer(settings, 'MyHotspots');
	
	$("#myDiv").resizable({
		resize: function(event, ui) {
			$('#resizeIco').hide();
			$(this).lhpMegaImgViewer('adaptsToContainer');
		}
	});
});