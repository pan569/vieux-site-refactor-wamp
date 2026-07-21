<?php

use appPage03\modele\DonneesTrigo;
use appPage03\modele\icone;




$width=1000;// $model['width'];
$height=600;//$model['height'];

$nomImage= "manon.jpg";
$fontSize = "40px";
$chemin = "C:\\wamp64\\www\\site01\\appPage03\\vue\\resources\\img\\X\\".$nomImage;
/*
$fp = fopen("C:\\wamp64\\www\\site01\\appPage03\\vue\\resource\\img\\X\\".$nomImage, 'r');
$exif =null;
if($fp)
{
    $exif = exif_read_data($fp,0,true);
}
/**/
$exif01 = exif_read_data($chemin,'FILE',true);

//$exif02 = exif_read_data($chemin,'COMPTER',true);
//$exif03 = exif_read_data($chemin,'ANY_TAG',true);
//$exif04 = exif_read_data($chemin,'IFD0',true);
//$exif05 = exif_read_data($chemin,'THUMBNAIL',true);
//$exif06 = exif_read_data($chemin,'COMMENT',true);
//$exif07 = exif_read_data($chemin,'EXIF',true);
//debug($exif01);
/*
debug($exif02);
debug($exif03);
debug($exif04);
debug($exif05);
debug($exif06);
debug($exif07);
/**/
$texte = $exif01['COMMENT'][0];
if($exif01['COMPUTED']['Width'] > $width)
{
    $scale = $width/$exif01['COMPUTED']['Width'];// 0.5;
}
else 
{
    $scale = 1;
}
$xPhoto = ($width  - ($exif01['COMPUTED']['Width']*$scale)) /2;//(540*$scale))

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
	</defs>
	
	<image xlink:href="/appPage03/vue/resources/img/X/<?= $nomImage ;?>" transform="translate(<?= $xPhoto ;?>,0) scale(<?= $scale ;?>)"/> />
	<text x="<?= $width/2 + 5;?>"  y=<?= 50 + 5;?> style="font-family: Impact ;font-size:<?= $fontSize ?>;fill:black;text-anchor:middle;" ><?= $texte ?></text>
	<text x="<?= $width/2;?>"  y="50" style="font-family: Impact ;font-size:<?= $fontSize ?>;fill:white;text-anchor:middle;" ><?= $texte ?></text>
	<image xlink:href="/appPage03/vue/resources/img/X/odeur.png"  style="opacity: 0.5;" transform="translate(160,220) scale(0.8)"/> />
</svg>	

