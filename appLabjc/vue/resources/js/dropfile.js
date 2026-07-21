(function($){
	
	var options = {
		message : 'Déposer un fichier ici',
		script : '/appLabjc/vue/upload.php',
		cible : ''
	}
	//C:\wamp64\www\site01\appLabjc\vue
	$.fn.dropfile = function(opt)
	{
		if(options) $.extend(options,opt);
		
		//console.log("bonjour ");
		
		this.each(function(){
			$('<span>').addClass('instructions').append(options.message).appendTo(this);
			$('<span>').addClass('progress').appendTo(this);
			$(this).bind({
				dragenter : function(e){
					e.preventDefault();					
					//console.log('dragenter !!!');
				},
				dragover : function(e){
					e.preventDefault();
					$(this).addClass('hover');
					//console.log('dragover !!!');
				},
				dragleave : function(e){
					e.preventDefault();
					$(this).removeClass('hover');
					//console.log('dragleave !!!');
				}
			});
			this.addEventListener('drop', 
			function(e){
				e.preventDefault();
				var files = e.dataTransfer.files;					
				upload(files,$(this),0);
			},
			false);
		});
		
		function upload(files,area,index)
		{
			//console.log(options.script);
			//console.log(files);
			//console.log(area);
			//console.log(index);
			
			var file = files[index];
			//console.log(file);
			
			var progress = area.find('progress');
			var xhr = new XMLHttpRequest();
			/******* REONSE *******/
			xhr.addEventListener('load',function(e){
				
				area.removeClass('hover');
				progress.css({height:0});
				var reponse = jQuery.parseJSON(e.target.responseText);
		
				if(reponse.error)
				{
					alert(reponse.error);
					return false;
				}
				else
				{
					
				}
				
				area.append(reponse.imgHTML);
				/**/ 
			}),false;
			
			/******* PROGRESSION *******/
			
			xhr.upload.addEventListener('progress',function(e){
				if(e.lengthComputable)
				{
					var pourcentTelecharge = (Math.round(e.loaded/e.total)*100)+'%' ;
					progress.css({height:pourcentTelecharge}).html(pourcentTelecharge);
				}
			}),false;
			
			/******* ENVOIE *******/
			
			
			xhr.open('POST',options.script,true);
			xhr.setRequestHeader('content-type','multipart/form-data');
			xhr.setRequestHeader('x-file-type',file.type);
			xhr.setRequestHeader('x-file-size',file.size);
			xhr.setRequestHeader('x-file-name',file.name);
			//xhr.setRequestHeader('test',options.cible);
			xhr.send(file);
			
			/*
			// 4. Ceci sera appelé après la réception de la réponse
			xhr.onload = function() {
  				if (xhr.status != 200) { 
					// analyse l'état HTTP de la réponse
    				alert(`Error ${xhr.status}: ${xhr.statusText}`); // e.g. 404: Not Found
  				} 
				else { 
					// show the result
    				alert(`Done, got ${xhr.response.length} bytes`); // response est la réponse du serveur
  				}
			};
			/**/ 

		}
	}
	
})(jQuery)