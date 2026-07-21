$(document).ready(function(){

	$('#b1').click(function(){
		$('#d01').addClass('bordure epaisTexte alignement');			
	})
		
	$('#b2').click(function(){
		$('#d01').removeClass('bordure epaisTexte alignement');			
	})
		
	$('#b3').click(function(){
		$('#d03').toggleClass('bordure epaisTexte alignement');			
	})

})