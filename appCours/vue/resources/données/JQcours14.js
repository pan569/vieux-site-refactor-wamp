$(document).ready(function(){

	var v01 = $('p').css('font-size');
	
	$('#msg').text(v01);

	$('#b1').click(function(){
		$('#d01').addClass('bordure epaisTexte alignement');			
	})
		
	$('#b2').click(function(){
		$('#d01').removeClass('bordure epaisTexte alignement');			
	})

	$('#b3').click(function(){
		$('#d03').toggleClass('bordure epaisTexte alignement');			
	})
		
	$('#b4').click(function(){
		$('p').css({
			'border':'2px solid red'
		});	
	})
		
})