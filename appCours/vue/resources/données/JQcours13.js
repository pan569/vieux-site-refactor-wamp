$(document).ready(function(){

	$('#b1').click(function(){
		var var01 = $('#p1').replaceWith('<h2>titre h2</h2>');
		$('#msg').text(var01.text());
	})
		
	$('#b2').click(function(){
		$('<h2>titre h2</h2>').replaceAll('#p2');
		//$('#msg').text(var01.text());
	})
	
	$('#b3').click(function(){
		$('.p3').wrap("<div class='cl01' ></div");			
	})

	$('#b4').click(function(){
		$('.p4').wrapAll("<div class='cl02' ></div");			
	})

	$('#b5').click(function(){
		$('.p5').wrapInner("<div class='cl03' ></div");			
	})
	
	$('#b6').click(function(){
		$('.p6').wrapAll("<div class='cl01' ></div");			
	})

	$('#b7').click(function(){
		$('.p6').unwrap();			
	})

})