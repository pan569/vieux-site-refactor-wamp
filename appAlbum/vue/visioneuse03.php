<?php



use appAlbum\modele\iptc;
use appAlbum\modele\Photo;

//debug($model,"liste des fichiers JPEG");
//debug($nomImage,"nomImage");

/*
 * Lien de navigatio
 * determine lesindexdes liens
 * avant et apres la photo courante 
 */

$i=array_search(str_replace(".jpg","",$nomImage),$model); // index de la photo courante
$cp= count($model); // taille du tableau (autrement ditnombre de photos dansl'album )

// determinel'indexdu lien de la photo precedente
if($i==0)
{
    $i_moin= $cp -1;    
}
else 
{
    $i_moin= $i-1;
}

// determinel'index delaphoto suivante 
if($i == $cp -1)
{
    $i_plus= 0;
}
else 
{
    $i_plus=$i+1;
}

/*****************************************************************************/
/*********************  ZONE TEST OBJET   ************************************/
/*****************************************************************************/

$photo =new Photo("",$nomImage);

debug($photo,"photo");

/*****************************************************************************/
/*****************************************************************************/
/*****************************************************************************/

//Lien et emplacementdel'image
$chemin = "C:\\wamp64\\www\\site01\\appAlbum\\vue\\resources\\img\\X\\".$nomImage;
$hrefImage="/appAlbum/vue/resources/img/X/{$nomImage}";

//dimentionnement de l'image
$width=1000;// $model['width'];
$height=600;
$dimImage = getimagesize($chemin); // recupereles dimensions de l'image. index 0 -> Width index 1 -> Height
$scaleImage = $height/$dimImage[1]    ;//
$height = $dimImage[1]*$scaleImage ;//
$xImage = ($width  - ($dimImage[0] * $scaleImage)) /2 ;//

//Traitementdes metadonnées
$iptc = new \appAlbum\modele\iptc($chemin);
$texte = $iptc['Description'];
$fontSize = "33px";

$png=null;
if($iptc->offsetExists('Instructions'))
{
    $png = json_decode($iptc['Instructions'], true);
}
 
?>
<h1>Album</h1>
<div style="background-color:black;">
	<div>
		<a href="<?= $this->routeur->getRoute('voir')->generateUri(['fichier' => $model[$i_moin] ]);?> ">avant</a>
		<a href="<?= $this->routeur->getRoute('voir')->generateUri(['fichier' => $model[$i_plus] ]);?> ">apres</a>
	</div>
	<div>
				<svg width="<?= $width;?>" height="<?= $height;?>" xml:lang="fr" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<title><?= $nomImage ;?></title>
					<desc>travail sur les fichiers SVG</desc>
					<style type="text/css">
                    <![CDATA[
                    
                    @font-face 
                    {
                        font-family: 'coeur';
                        src: url('../appAlbum/vue/resources/fonts//coeur.ttf');   
                    }
                    
                    @font-face 
                    {
                        font-family: 'N_COM';
                        src: url('../appAlbum/vue/resources/fonts/NON-COMMERCIAL_Blockography.ttf');   
                    }
                    

                    .bulle
                    {
                        font-family: 'N_COM' ;
                        font-size:18px;
                        fill:pink;
                        text-anchor:middle;
                    }
                    
                    /*style="font-family:Calibri ;font-size:25;fill:black;text-anchor:middle;"*/
                    
                    .forme
                    {
                        fill:white;
                        stroke:black;
                        stroke-width:1px;
                    }
   
                    ]]>
                    </style>

					
					<image xlink:href="<?= $hrefImage ;?>" transform="translate(<?= $xImage ;?>,0) scale(<?= $scaleImage ;?>)"/>
					
					
					<text x="<?= $width/2 + 5;?>"  y=<?= 50 + 5;?> style="font-family: Impact ;font-size:<?= $fontSize ?>;fill:black;text-anchor:middle;" ><?= $texte ?></text>
					<text x="<?= $width/2;?>"  y="50" style="font-family: Impact ;font-size:<?= $fontSize ?>;fill:white;text-anchor:middle;" ><?= $texte ?></text>
					<?php if ($png !== null): ?>
					<g style="opacity: 0.5;" />				
						<image xlink:href="/appAlbum/vue/resources/img/png/<?= $png['image'] ;?>"  transform="translate(<?= $png['translate'] ;?>) scale(<?= $png['scale'] ;?>)" />
						<text x="95" y="80" class="bulle"  transform="translate(<?= $png['translate'] ;?>) scale(<?= $png['scale'] ;?>)"  ><?= $png['texte'] ?></text>
					</g>
					<?php endif ?>
					
				</svg>            
	</div>
	
</div>




	

