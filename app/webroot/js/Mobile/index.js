
$(document).ready(function(){
	
	
	//$("#instructions").fitText(1.1, { minFontSize: '10px', maxFontSize: '20px' });
	
	//For Index-Page Instructions
	$("#index-instr-2").hide();
	$("#index-instr-3").hide();
	$("#index-instr-4").hide();
	$(".arrow").click(function(){
		var id= $(this).attr('id');
		var id_num=id.substr(5,1);
		id_num=parseInt(id_num);
		var newId_num=id_num+1;
		$(this).attr('id',"arrow"+newId_num);
		$("#index-instr-"+id_num).hide();
		$("#index-instr-"+newId_num).show();
		if(id_num ==3){
			$(".arrow").hide();
			add_vertical_line();
		}
		
	});
	
	//Adding Lines between dots in Quadrants
	addLines();
	$(window).resize(function(){
		$('.path').remove();
		addLines();
		if($(".point-eudamonia").length){
			add_vertical_line();
			}
	});
		
});


function addLines(){
	var point1x=$('.point-1').offset().left;
	$('.point-1').append("<div class='path path-horizontal path-line-1'></div>");
	var point2x=$('.point-2-1').offset().left;
	$('.point-2-1').append("<div class='path path-horizontal path-line-2-1'></div>");
	$('.path-line-1').css('width',point2x-point1x+'px');
	$('.path-line-2-1').css('width',point21x-point2x+'px');
	var point21x=$(".point-2-2").offset().left;
	$('.path-line-2-1').css('width',point21x-point2x+'px');
	var point21y=$(".point-2-2").offset().top;
	var point3y=$(".point-3").offset().top;
	$(".point-2-2").append("<div class='path path-vertical'></div>");
	$('.path-vertical').css('height',point3y-point21y-17+'px');
	var point3x=$('.point-3').offset().left;
	var point4x=$('.point-4').offset().left;
	$('.point-3').append("<div class='path path-horizontal path-line-4'></div>");
	$(".path-line-4").css('width',point4x-point3x+'px');
}
function  add_vertical_line(){
		var window_width=$(window).width();
		var top= $(".path-line-4").offset().top;
		
		var texteudamoniay=$("#eudamonia").offset().top;
		
		$(".point-eudamonia").append("<div class='path path-vertical eudamonia'></div>");
		var pointeudamoniay=$(".eudamonia").offset().top;
		$(".eudamonia").css('top',top+"px");
		$(".eudamonia").css('height',(texteudamoniay-top)+"px");
		$(".eudamonia").css('margin-top',"-"+(pointeudamoniay-top-25)+"px");
		
	}