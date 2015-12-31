$(document).ready(function(){
	var pluginMethods;
	
	var settings = {
		'viewportWidth' : '100%',
		'viewportHeight' : '100%',
		'fitToViewportShortSide' : false,  
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
	
	$('#myDiv').lhpMegaImgViewer(settings);
	
	pluginMethods = [];
	pluginMethods[0] = function(){ $('#myDiv').lhpMegaImgViewer( settings ); };
	pluginMethods[1] = function(){ $('#myDiv').lhpMegaImgViewer( 'setPosition', 1300, 700, 0.8, false ); };
	pluginMethods[2] = function(){ $('#myDiv').lhpMegaImgViewer( 'moveUp' ); };
	pluginMethods[3] = function(){ $('#myDiv').lhpMegaImgViewer( 'moveDown' ); };
	pluginMethods[4] = function(){ $('#myDiv').lhpMegaImgViewer( 'moveLeft' ); };
	pluginMethods[5] = function(){ $('#myDiv').lhpMegaImgViewer( 'moveRight' ); };
	pluginMethods[6] = function(){ $('#myDiv').lhpMegaImgViewer( 'moveStop' ); };
	pluginMethods[7] = function(){ $('#myDiv').lhpMegaImgViewer( 'zoom' ); };
	pluginMethods[8] = function(){ $('#myDiv').lhpMegaImgViewer( 'unzoom' ); };
	pluginMethods[9] = function(){ $('#myDiv').lhpMegaImgViewer( 'zoomStop' ); };
	pluginMethods[10] = function(){ $('#myDiv').lhpMegaImgViewer( 'fitToViewport' ); };
	pluginMethods[11] = function(){ $('#myDiv').lhpMegaImgViewer( 'fullSize' ); };
	pluginMethods[12] = function(){ $('#myDiv').lhpMegaImgViewer( 'adaptsToContainer' ); };
	pluginMethods[13] = function(){ $('#myDiv').lhpMegaImgViewer( 'destroy' ); };
	pluginMethods[14] = function(){ return $('#myDiv').lhpMegaImgViewer( 'getCurrentState' ); };
	
	$('#myDiv').lhpMegaImgViewer(settings);
	
	$('#publicMethods a').each(function(index){
		
		$(this).click(function(index) {
				return function(e) {
					e.preventDefault();	
					if(index == 14) {
						displayCurrentState(pluginMethods[index]());
					} else {
						pluginMethods[index]();
					}
				}
			}(index));

	});
	
	function displayCurrentState(currentState) {
		var res = '';
		
		res += 'scale : ' + currentState.scale; 
		res += '<br/>xPosInCenter : ' + currentState.xPosInCenter; 
		res += '<br/>yPosInCenter : ' + currentState.yPosInCenter;
		res += '<br/>allowDown : ' + currentState.allowDown; 
		res += '<br/>allowUp : ' + currentState.allowUp; 
		res += '<br/>allowLeft : ' + currentState.allowLeft; 
		res += '<br/>allowRight : ' + currentState.allowRight; 
		res += '<br/>allowZoom : ' + currentState.allowZoom; 
		res += '<br/>allowUnzoom : ' + currentState.allowUnzoom; 
		res += '<br/>hPropViewpContent : ' + currentState.hPropViewpContent; 
		res += '<br/>wPropViewpContent : ' + currentState.wPropViewpContent; 
		res += '<br/>isScaled : ' + currentState.isScaled; 
		
		$('#currentStates').html(res);
	}
});