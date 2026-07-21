$(document).ready(function(){
	
	$('#prenom').focus(function(){
		$(this).css('background-color','blue');
	});
	
	$('#prenom').blur(function(){
		$(this).css('background-color','orange');
	});

	$('#fld').focusin(function(){
		$(this).css('background-color','green');
	});

	$('#fld').focusout(function(){
		$(this).css('background-color','red');
	});	
	
	$('#liste').change(function(){
		alert('nouvelle option sélectionnée');
	});	

	$('#formulaire').submit(function(){
		alert('formulaire envoyé');
	});
	
})