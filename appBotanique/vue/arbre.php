<?php

use appPage03\modele\DonneesTrigo;
use appPage03\modele\icone;
use appBotanique\modele\Espece;
use appBotanique\modele\Genre;
use appBotanique\modele\Famille;

$width=1000;// $model['width'];
$height=600;//$model['height'];
$widthIcon = 100;

$xxxFamille= new Famille(11);
$xxxGenres= $xxxFamille->listeGenre();


//## ELEMENTS POUR DESSINER LES ICONES FAMILLE##\\
$xxxFamille->calcul(100 , $xxxFamille['LATIN']);

//## ELEMENTS POUR DESSINER LES ICONES GENRE##\\
$nbrIconGenre = count($xxxGenres);
$bordureGenre= ($width - ($nbrIconGenre*$widthIcon) ) / (2*$nbrIconGenre);
$pasGenre= $widthIcon + 2*$bordureGenre;

foreach ($xxxGenres as $xxxGenre)
{
    debug($xxxGenre['LATIN']);
    
    $xxxGenre->calcul($widthIcon, $bordureGenre);
    
    $xxxGenre->icone['texte'] = $xxxGenre['LATIN'];
    if($xxxGenre['IMAGE'] !== null)
    {
        $xxxGenre->icone['href'] = "data:image/png;base64,".base64_encode($xxxGenre['IMAGE']);
        
    }
    debug($xxxGenre->icone['cote'],"cote");
    debug($xxxGenre->icone['xMilieux'],"xMilieux");
}


//## ELEMENTS POUR DESSINER LES ICONES ESPECES##\\
$xxxGenre = new Genre(30);
$xxxEspeces = $xxxGenre->listeEspece();
$nbrIconEspece = count($xxxEspeces);
$bordureEspece= ($width - ($nbrIconEspece*$widthIcon) ) / (2*$nbrIconEspece);
$pasEspece= $widthIcon + 2*$bordureEspece;
foreach ($xxxEspeces as $xxxEspece)
{
    debug($xxxEspece['FRANCAIS']);
    
    $xxxEspece->calcul($widthIcon, $bordureEspece);
    
    $xxxEspece->icone['texte'] = $xxxEspece['FRANCAIS'];
    if($xxxEspece['IMAGE'] !== null)
    {
        $xxxEspece->icone['href'] = "data:image/png;base64,".base64_encode($xxxEspece['IMAGE']);
        
    }
    debug($xxxEspece->icone['xMilieux'],"xMilieux");
}

$xFin = $width/2;
$yFin = $height - $widthIcon ;

debug($pasEspece,"pas");

/**/
?>

<h1> Les éspeces par familles </h1>

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
   
   
   
	<defs>
		<?= $xxxFamille->g() ?>
		<?php foreach ( $xxxGenres as $xxxGenre): ?>
		<?= $xxxGenre->g() ?>
		<?php endforeach;?>
		<?php foreach ( $xxxEspeces as $xxxEspece): ?>
		<?= $xxxEspece->g() ?>
		<?php endforeach;?>
					
	</defs>
	
	<!-- dessin des icons -->
	<?php for ($i = 0 ; $i < $nbrIconGenre ; $i++): ?>				
		<line x1="<?= $xxxGenres[$i]->icone['xMilieux'] + ($i * $pasGenre);?>" y1="<?=  $xxxGenres[$i]->icone['yMilieux'] + $xxxGenres[$i]->icone['cote']/2  ;?>" x2="<?= $xxxGenres[$i]->icone['xMilieux'] + ($i * $pasGenre) ;?>" y2="<?= $xxxGenres[$i]->icone['yBranche'] ;?>" class="forme" />
		<line x1="<?= $xxxGenres[$i]->icone['xMilieux'] + ($i * $pasGenre) ;?>" y1="<?= $xxxGenres[$i]->icone['yBranche'] ;?>" x2="<?= $xFin  ;?>" y2="<?= $yFin ;?>" class="forme" />
		<use xlink:href="#<?= $xxxGenres[$i]->icone['texte'] ?>" transform="translate(<?= $xxxGenres[$i]->icone['xMilieux'] + ($i * $pasGenre) ;?>,<?=  $xxxGenres[$i]->icone['yMilieux'] + $xxxGenres[$i]->icone['cote']/2  ;?>)"/>		
	<?php endfor;?>
		<use xlink:href="#<?= $xxxFamille::$texte ?>" transform="translate(<?= $xFin ;?>,<?= $yFin ;?>)"/>
</svg>

