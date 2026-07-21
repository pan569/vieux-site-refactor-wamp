<?php ?>

<h1>Drop fichier</h1>
<p>source: https://www.tutos.eu/2471 </p>

<script type="text/javascript">
	
	jQuery(function($){
		$('.dropfile').dropfile({
			//message : 'Déposer ici',
				url : '/appLabjc/vue/dropFichierTelechargement.php'
		});
	})
	/**/	
</script>

<div id="bloc_page">
	<div id="dropFichier">Drop an image from your computer</div>
</div>
