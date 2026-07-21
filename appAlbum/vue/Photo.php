<?php



use appAlbum\modele\iptc;
use appAlbum\modele\Photo;

$item = $model->getPhoto($nomPhoto);
$fontSize = "33px";

/*
 * Lien de navigatio
 * determine lesindexdes liens
 * avant et apres la photo courante 
 */

//debug($item,"index");
//debug($model->index($nomPhoto),"index");


$i=$model->index($nomPhoto); // index de la photo courante
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

/**/

?>
<h1>Album</h1>
<div style="background-color:black;">
	<div>
		<a href="<?= null //$this->routeur->getRoute('visualiserPhoto')->generateUri(['fichier' => $model[$i_moin] ]);?> ">avant</a>
		<a href="<?= null //$this->routeur->getRoute('visualiserPhoto')->generateUri(['fichier' => $model[$i_plus] ]);?> ">apres</a>
	</div>
	<div style="display: flex;justify-content: center;">
				<svg width="<?= $item->getAffichageLargeur();?>" height="<?= $item->getAffichageHauteur() ;?>" xml:lang="fr" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<title><?= $item->getimageNomPhoto() ;?></title>
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

					
					
					<image xlink:href="<?= $item->getImageUrl()  ;?>" transform="scale(<?= $item->getAffichageEchelle() ;?>) "/>
					
					<text x="<?= $item->getAffichageLargeur()/2 + 5;?>"  y=<?= 50 + 5;?> style="font-family: Impact ;font-size:<?= $fontSize ?>;fill:black;text-anchor:middle;" ><?= $item['Description'];?></text>
					<text x="<?= $item->getAffichageLargeur()/2;    ?>"  y="50"          style="font-family: Impact ;font-size:<?= $fontSize ?>;fill:white;text-anchor:middle;" ><?= $item['Description'] ?></text>
					<?php if ($item->getpng() !== null): ?>
					<g style="opacity: 0.5;" />				
						<image xlink:href="/appAlbum/vue/resources/img/png/<?= $item->getpng()['image'] ;?>"  transform="translate(<?= $item->getpng()['translate'] ;?>) scale(<?= $item->getpng()['scale'] ;?>)" />
						<text x="95" y="80" class="bulle"  transform="translate(<?= $item->getpng()['translate'] ;?>) scale(<?= $item->getpng()['scale'] ;?>)"  ><?= $item->getpng()['texte'] ?></text>
					</g>
					<?php endif ?>
					
				</svg>            
	</div>
	
</div>




	

