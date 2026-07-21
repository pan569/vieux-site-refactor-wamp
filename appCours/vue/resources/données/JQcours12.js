$(document).ready(function(){


	$('#b1').click(function(){
		$('#p1').append(': blablabla');	
	})
		
	$('#b2').click(function(){
		$('#p2').prepend('blablabla: ');	
	})


	$('#b3').click(function(){
		avecAppend();	
	})
		
	$('#b4').click(function(){
		avecPrepend();	
	})
		
	var t1 ='<p>Paragraphe créer par HTML</p>';
	var t2 =$('<p></p>').text('Paragraphe créer par JQ');
	var t3 =document.createElement('p');
	t3.innerHTML ='Paragraphe créer par JS';
		
	function avecAppend()
	{
		$('#d1a').append(t1,t2,t3);
	}
		
	function avecPrepend()
	{	
		$('#d1a').prepend(t1,t2,t3);
	}

	$('#bd31').click(function(){
		avecAppend();	
	})
		
	$('#bd32').click(function(){
		avecAfter();	
	})
		
	$('#bd33').click(function(){
		avecBefore();	
	})
		
	function avecAppend()
	{
		$('#d1a').append(t1,t2,t3);
	}

	function avecAfter()
	{
		$('#d1a').after(t1,t2,t3);
	}

	function avecBefore()
	{	
		$('#d1a').before(t1,t2,t3);
	}


	$('#bd41').click(function(){
		$('div').remove('#d1a');	
	})
		
	$('#bd42').click(function(){
		$('#d1b').empty();	
	})

	$('#bouton01').click(function(){
		$('#lien01').removeAttr('href');	
	})

})