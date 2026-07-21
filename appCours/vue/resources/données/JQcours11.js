$(document).ready(function(){


	$('.p1').first().css({
		'color':'red'			
	});
		
	$('.p1').last().css({
		'color':'blue'			
	});


	$('.p2').eq(1).css({
		'color':'red'			
	});
		
	$('.p2').eq(-2).css({
		'color':'blue'			
	});


	$('.li1').filter(':nth-child(even)').css({
		'color':'blue'			
	});
	
	$('.tr1').filter(':nth-child(odd)').css({
		'background-color':'blue'			
	});


	$('.li2').not(':nth-child(even)').css({
		'color':'red'			
	});
		
	$('.tr2').not(':nth-child(odd)').css({
		'background-color':'red'			
	});

	
})