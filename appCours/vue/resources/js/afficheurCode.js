$(document).ready(function(){
	//var tailleH1 = $('#t1a').css('font-size');
	
	$('#boutonHTML').show();
	$('#codeCSS').hide();
	$('#codeJS').hide();
	
	
	$('.boutonAff').click(function(){
		var idSelec = $(this).prop("id");				
		affichage(idSelec);				
	})
	

	function affichage (id)
	{
		
		switch(id) {
  			case 'boutonCSS':
    			$('#codeHTML').hide();
				$('#codeCSS').show('slow');
				$('#codeJS').hide();
    		break;
  			case 'boutonJS':
    			$('#codeHTML').hide();
				$('#codeCSS').hide();
				$('#codeJS').show('slow');;
    		break;
  			case 'boutonHTML':
    			$('#codeHTML').show('slow');
				$('#codeCSS').hide();
				$('#codeJS').hide();
    		break;
				
		}

	}
	
	
})