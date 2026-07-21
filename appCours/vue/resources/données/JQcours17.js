$(document).ready(function(){

	$('#b1').click(function(){
		$('#d01').fadeOut('slow',
			function(){
				$('#msg01').html('fonction fadeOut utilisé');	
			}
		);			
	})
		
	$('#b2').click(function(){
		$('#d01').fadeIn('slow',
				function(){
					$('#msg01').html('fonction fadeIn utilisé');	
				}
		);			
	})
		
	$('#b3').click(function(){
		$('#d01').fadeToggle('slow',
				function(){
					$('#msg01').html('fonction fadeToggle utilisé');	
				}
		);						
	})
		
	$('#b4').click(function(){
		$('#d01').fadeTo('slow',0.5,
				function(){
					$('#msg01').html('fonction fadeTo utilisé');	
				}
		);						
	})
	
	$('#b5').click(function(){
		$('#d03').slideUp('slow',
			function(){
				$('#msg02').html('fonction slideUp utilisé');	
			}
		);			
	})
		
	$('#b6').click(function(){
		$('#d03').slideDown('slow',
				function(){
					$('#msg02').html('fonction slideDown utilisé');	
				}
		);			
	})
		
	$('#b7').click(function(){
		$('#d03').slideToggle('slow',
				function(){
					$('#msg02').html('fonction slideToggle utilisé');	
				}
		);						
	})	
		
})