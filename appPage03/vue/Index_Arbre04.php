<?php

use appPage03\modele\DonneesTrigo;
use appPage03\modele\icone;




$width=1000;// $model['width'];
$height=600;//$model['height'];
//## ELEMENTS POUR DESSINER LES ICONES ##\\
$nbrIconEspece = 5;
$widthIcon = 100;

$bordureEspece= ($width - ($nbrIconEspece*$widthIcon) ) / (2*$nbrIconEspece);
$milieuxIcon = $bordureEspece + $widthIcon/2;

$pasEspece= $widthIcon + 2*$bordureEspece;
$longueurBranche = $height/3;
$xFin = $width/2;
$yFin = $height -100 ;

$icone = new icone($widthIcon,$bordureEspece);

/*
debug($nbrIcon,"nbrIcon");
debug($widthIcon,"widthIcon");
debug($pas,"pas");
debug($xFin,"xFin");
debug($yFin,"yFin");
/**/
?>

<h1> jouer avec les svg </h1>

<svg width="<?= $width;?>" height="<?= $height;?>" xml:lang="fr" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	<title>Test</title>
	<desc>travail sur les fichiers SVG</desc>
	<style type="text/css">
    <![CDATA[
       
   .forme
   {
        fill:white;
        stroke:black;
        stroke-width:1px;
   }
   
   ]]>
   </style>
   
   <rect x="0" y="0" width="<?= $width;?>" height="<?= $height;?>" class="forme" />
   
	<defs>	
		<g id="point" transform="translate(-5,-5)">
			<image xlink:href="/appPage03/vue/point.svg"  />		
		</g>
		<g id="icon" >					
			<rect width="<?= $icone['cote'] ;?>" height="<?= $icone['cote'] ;?>" x="<?= $icone['bordure'] ;?>" class="forme" />
			<image xlink:href="<?= $icone['href'] ;?>" x="<?= $icone['bordure'] ;?>"  width="<?= $icone['cote'] ;?>" height="<?= $icone['cote'] ;?>" />
			<text x="<?=  $icone['xMilieux'] ;?>" y="<?= $icone['cote'] ;?>" style="text-anchor:middle;"><?= $icone['texte'] ;?></text>			
		</g>
	</defs>
	
	<!-- dessin des icons -->
	<?php for ($i = 0 ; $i < $nbrIconEspece ; $i++): ?>		
		<use xlink:href="#icon" transform="translate(<?= $i * $pasEspece ;?>,<?= 25 ;?>)"/>
		<line x1="<?= $icone['xMilieux'] + ($i * $pasEspece);?>" y1="<?=  $icone['yMilieux'] + $icone['cote']/2 + 25  ;?>" x2="<?= $icone['xMilieux'] + ($i * $pasEspece) ;?>" y2="<?= $icone['yBranche'] + 25 ;?>" class="forme" />
		<line x1="<?= $icone['xMilieux'] + ($i * $pasEspece) ;?>" y1="<?= $icone['yBranche'] + 25 ;?>" x2="<?= $xFin ;?>" y2="<?= $yFin ;?>" class="forme" />		
	<?php endfor;?>
		<use xlink:href="#icon" transform="translate(<?= $xFin-$icone['xMilieux'] ;?>,<?= $yFin -$icone['yMilieux'] ;?>)"/>
</svg>	

