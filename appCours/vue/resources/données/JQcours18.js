$(document).ready(function(){

	$('#b1').click(function(){
		$('#d01').animate({width:'-=10%'},1000);			
	})
		
	$('#b2').click(function(){
		$('#d01').animate({fontSize:'20px'},1000);			
	})
		
	$('#b3').click(function(){
		$('#d01').animate({left:'100px'},1000);						
	})
	
	$('#b4').click(function(){
		$('#d03').animate(
			{
				width:'-=10%',
				fontSize:'20px',
				left:'100px'
			},1000
		);			
	})
		
})