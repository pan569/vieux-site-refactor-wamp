$(document).ready(function(){

	
	//recupere la taille du titre h1		
	$('#t1a').css('font-size','50px');

	//modifie la taille du titre h1
	var tailleH1 = $('#t1a').css('font-size');

	//affiche la taille du titre h1
	$('#msga').text('la taille du titre est : ' + tailleH1);
	
		
	
	//recupere le texte du titre h1
	var texteH1b = $('#t1b').text();

	//modifie le texte du titre h1		
	//var tailleH1 = $('h1').css('font-size');
	$('#t1b').text('texte du titre manipulé');

	//affiche le texte du titre h1
	$('#msgb').text('le texte du titre est : ' + texteH1b);


	
	//recupere le texte du titre h1
	var texteH1c = $('#t1bc').html();

	//modifie le texte du titre h1		
	//var tailleH1 = $('h1').css('font-size');
	$('#t1bc').html('<mark>DOM</mark> du titre manipulé');
	//affiche le texte du titre h1
	$('#msgc').html('le texte du titre etait : ' + texteH1c);
	
		

	$('#prenom').keyup(function(){
		var valeurChampPrenom = $(this).val();
		$('#spPrenom').text('la valeur du champ prenom est : ' + valeurChampPrenom);
	});
		
	$('#liste').change(function(){
		var valeurChampListe = $('select').val() || [] ;
		$('#spListe').text('la valeur du champ liste est : ' + valeurChampListe.join(', '));
	});
	//https://www.youtube.com/watch?v=sJZjjt4moS0&list=PLwLsbqvBlImGxO-ge8D2J7_zNedld8w4T&index=9
		

	//on recupere la valeur de l'attribut h2
	var attH2 =$('#t2').attr('class');
	//on affiche la valeur dans le span message
	$('#msg').text('la classe de t2 est : ' + attH2);
	
	//modiffication de la valeur de l'attribut de h3
	$('#t3').attr('class','titreH3 ');
	
	//deffinition d'attributs (href et target) pour le lien
	$('a').attr({
			href:'https://zonegfx.com/',
			target:'_blank'
	});


		
	$('#check01').change(function(){
		var v = $(this);
			
		$('#spcheck01').html(
			'la valeur de l\'attribut de check01 est : ' + v.attr('checked') +' </br>'+
			'la valeur de la proprieté de check01 est : ' + v.prop('checked')			
		);
	})
	

})