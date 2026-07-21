$(document).ready(function(){

//https://www.youtube.com/watch?v=p9vaQbOXoGQ&list=PLwLsbqvBlImGxO-ge8D2J7_zNedld8w4T&index=10

	$('#span01').parent().css('color','red');
		

	$('#span02').parents().css({
			'color':'red',
			'border':'2px solid orange'
	});


	$('#span03').parentsUntil('#L3li1').css({
		'color':'red',
		'border':'2px solid blue'			
	});


	$('#L4').children().css({
		'color':'green'
	});


	$('#L5').children('#L5li1').css({
		'color':'purple'
	});
	
	$('#L6').find('*').css({
		'color':'purple'
	});

/*
	$('.l1').find('*').css({
		'color':'red'
	});
*/

})