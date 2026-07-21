$(document).ready(function(){
	//modifie la couleur de fond de l'input d'id premon quand une touche est pressé
	//keydown: gére l''evenement touche pressé 
	//css : modifie le css de l'evenement'
	$('#prenom').keydown(function(){
		$(this).css('background-color','red');			
	});
	
	//modifie la couleur de fond de l'input d'id premon quand une touche est relaché
	//keydown: gére l''evenement touche relaché 
	//css : modifie le css de l'evenement'
	$('#prenom').keyup(function(){
		$(this).css('background-color','blue');
	});
		
	//affiche dans le span d' 'id 'ascii' le caractere saisie dans l'input d'id premon 
	//keypress: capture le caractere quand une touche de caracter est apuyé 
	$('#prenom').keypress(function(e){
		var touche= String.fromCharCode(e.which); 
		$('#ascii').text(touche);			
	});
		
})