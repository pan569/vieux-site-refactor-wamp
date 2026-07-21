<?php 

    ini_set('highlight.html', "#A4A4A4");
    $s=DIRECTORY_SEPARATOR;
    
    
    $pathHTML="C:{$s}wamp64{$s}www{$s}site01{$s}appCours{$s}vue{$s}resources{$s}données{$s}{$model['fichier']}.html";           
    $fichierHTML = highlight_file($pathHTML,true);
    
    $pathCSS ="C:{$s}wamp64{$s}www{$s}site01{$s}appCours{$s}vue{$s}resources{$s}données{$s}{$model['fichier']}.css";
    $fichierCSS = highlight_file($pathCSS,true);
    
    $pathJS = "C:{$s}wamp64{$s}www{$s}site01{$s}appCours{$s}vue{$s}resources{$s}données{$s}{$model['fichier']}.js";
    $fichierJS = highlight_file($pathJS,true);
    
    $affichage="index.php?application=Cours&fonction=JQcours&variables=fichier:{$model['fichier']}";
    

?>
<div>

	<div style="padding-bottom: 5px;">
		<div id='boutonHTML' class='boutonAff'>code HTML</div>
		<div id='boutonCSS' class='boutonAff'>code CSS</div>
		<div id='boutonJS' class='boutonAff'>code JS</div>
	</div>
	<div >
		<div id='codeHTML' class='visible'>
			<?= $fichierHTML ?> 
		</div>
		<div id='codeCSS' class='visible'>
			<?= $fichierCSS ?> 
		</div>
		<div id='codeJS' class='visible'>
			<?= $fichierJS ?> 
		</div>		
		<iframe
  			id="inlineFrameExample"
  			title="Inline Frame Example"
  			width="49%"
  			height="500"
  			src=<?=$affichage ?>>
		</iframe>
	</div>
</div>
