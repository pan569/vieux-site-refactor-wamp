$(document).ready(function(){

	$('.par').on('click',function(){
		$(this).hide();
	});
	
	$('#div1').on('mouseenter mouseleave',function(){
		$('#msg').text("vous etes entré ou sorti du div1");
	});
	
	$('#div2').on({
		mouseenter:function(){$('#msg').text("vous etes entré dans div2");}, 
		mouseleave:function(){$('#msg').text("vous etes sorti du div2");}
	});
	
	
	//https://youtu.be/A7KSWtPoGVI?list=PLwLsbqvBlImGxO-ge8D2J7_zNedld8w4T&t=743
	$('#trg').click(function(){
		$('#prenom').trigger('focus');
	});
	$('#trgh').click(function(){
		$('#prenom').triggerHandler('focus');
	});
			
	$('#prenom').focus(function(){
		$('#msg').text('!!! focus !!!');
	});
	
	
	
	$('#msg02').hide();
		
	$('#b2').click(function(){
		$('#b1').on(
			'click',function(){
	   			$('#msg02').text('bouton cliqué');
				$('#msg02').show();
			;}
		);
	});
	
	$('#b3').click(function(){
		$('#msg02').hide();
		$('#b1').off('click');
	});

	
	$('.par02').on('click mouseover mouseout',
			function(e){
				$('#msg').text('l\'évenement qui a ete declenché est: '+ e.type);
			}
	);

})