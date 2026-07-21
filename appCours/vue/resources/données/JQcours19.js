$(document).ready(function(){

	$('#b1').click(function(){
		$('#d01')
			.animate({width:'-=10%'},1000)
			.animate({fontSize:'20px'},1000)
			.fadeTo(2000,0.5);			
	});
	
	function enAttente(){
		var n = $('#d01').queue('fx');
		$('#msg').text(n.length);
		setTimeout(enAttente, 10);
	}
	enAttente();
	
		
	$('#b2').click(function(){
		$('#d03')
			.animate({left:'+=200px'},1000)
			.animate({top:'+=50px'},1000)
			.queue(function(){
					$(this).toggleClass('rouge').dequeue();
				}
			)
		.animate({left:'+=200px'},1000)
		.animate({top:'+=50px'},1000);			
	});		
		
	$('#b3').click(function(){
		$('#d03').clearQueue();		
	});	
		
	$('#b4').click(function(){
		$('#d03').stop(true);		
	});
	
	$('#b4').click(function(){
		$('#d03').stop(true);		
	});
		
	$('#b5').click(function(){
		$('#d03').finish();		
	});		
		
})