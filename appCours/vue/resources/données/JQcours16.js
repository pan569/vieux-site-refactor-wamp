$(document).ready(function(){

	var v01 = $('p').css('font-size');
	
	$('#msg').text(v01);

	$('#b1').click(function(){
		$('#d01').show('slow',
			function(){
				$('#msg').html('fonction show utilisé');	
			}
		);			
	})
		
	$('#b2').click(function(){
		$('#d01').hide('slow',
				function(){
					$('#msg').html('fonction hide utilisé');	
				}
		);			
	})
		
	$('#b3').click(function(){
		$('#d01').toggle('slow',
				function(){
					$('#msg').html('fonction toggle utilisé');	
				}
		);						
	})
		
})