<?php



use appAlbum\modele\iptc;

//debug($model,"liste des fichiers JPEG");



$width=1000;// $model['width'];
$height=600;

//$nomImage= "lili.jpg";
$fontSize = "40px";

if($nomImage === null)
{
    
    $texte = "pas d'image selectionée";
    $hrefImage="/appAlbum/vue/resource/img/09.jpg";
    $chemin = "C:\\wamp64\\www\\site01\\appAlbum\\vue\\resource\\img\\09.jpg";
    $scaleImage = 1;
    $xImage = ($width - 600)/2;
}
else 
{
    /*
    $chemin = "C:\\wamp64\\www\\site01\\appAlbum\\vue\\resource\\img\\X\\".$nomImage;
    
    $exif01 = exif_read_data($chemin,'FILE',true);
    
    //debug($exif01);
    if(array_key_exists('COMMENT',$exif01))
    {
        
        
        $texte = $exif01['COMMENT'][0];
    }
    else
    {
        $texte = "";
    }
    
    $hrefImage="/appAlbum/vue/resource/img/X/{$nomImage}";
    $scaleImage = $width/$exif01['COMPUTED']['Width'];
    $height=$exif01['COMPUTED']['Height']*$scaleImage;
    $xImage = ($width  - ($exif01['COMPUTED']['Width']*$scaleImage)) /2;
    
    
    /**/
    
}



/**/    
?>
<table>
    <thead>
        <tr>
            <th colspan="3">Album Photo</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>			
				<ul>
<?php foreach ( $model as $item): ?>
    				<li>
    					<a href="<?= $this->routeur->getRoute('index')->generateUri(['fichier' => $item ]);?> "> <?= $item ;?> </a>    	
    				</li>
<?php endforeach;?>    
				</ul>			
			</td>
            <td>
				<svg width="<?= $width;?>" height="<?= $height;?>" xml:lang="fr" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<title><?= $nomImage ;?></title>
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
	
					<image xlink:href="<?= $hrefImage ;?>" transform="translate(<?= $xImage ;?>,0) scale(<?= $scaleImage ;?>)"/> />
					<text x="<?= $width/2 + 5;?>"  y=<?= 50 + 5;?> style="font-family: Impact ;font-size:<?= $fontSize ?>;fill:black;text-anchor:middle;" ><?= $texte ?></text>
					<text x="<?= $width/2;?>"  y="50" style="font-family: Impact ;font-size:<?= $fontSize ?>;fill:white;text-anchor:middle;" ><?= $texte ?></text>
					<!-- <image xlink:href="/appPage03/vue/resource/img/X/odeur.png"  style="opacity: 0.5;" transform="translate(160,220) scale(0.8)"/> />  -->
				</svg>            
            </td>
            <td>            	
            	<?= "";//debug($iptc->iptc); ?>
            </td>
        </tr>
    </tbody>
</table>



	

