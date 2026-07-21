$(document).ready(function(){
	
	//cache les elements de type "p" en double-cliquant dessus
	//dblclick : evenement double clique
	//hide : fonction cacher
	$('p').dblclick(function(){
		$(this).hide();
	});
	
	
	/*********/
	
	//affiche l'elements d'id "p2" en entrant le curseur de la souris sur l'element d'id "p1".
	//mouseenter : evenement entrer
	//show : fonction afficher
	$('#p1').mouseenter(function(){
		$('#p2').show();
	});
	
	//cache l'elements d'id "p2" en entrant le curseur de la souris sur l'element d'id "p1".
	//mouseenter : evenement entrer
	//hide : fonction cacher
	$('#p1').mouseleave(function(){
		$('#p2').hide();
	});
	
	
	/*********/
	
	$('#p4').hide();
	
	//affiche l'elements d'id "p4" en entrant le curseur de la souris entre dans l'element d'id "p3".
	//et cache l'elements d'id "p4" en entrant le curseur de la souris sort de l'element d'id "p3".	
	$('#p3').hover(
		function(){$('#p4').show();},
		function(){$('#p4').hide();}
	);

	/*********/
	
	$('#p6').hide();
		
	$('#p5').mousedown(function(){
		$('#p6').show();
	});
	
	$('#p5').mouseup(function(){
		$('#p6').hide();
	});

})