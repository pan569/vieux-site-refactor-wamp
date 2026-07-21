<?php
namespace appBotanique\modele;

use systeme\objets\Item;

class IconeBotanique extends Item
{
    
    
    
    public function __construct($coté,$bordure)
    {
        self::getDictionaire()->clearDefinition();
        $this->donnees['cote'] = $coté;
        $this->donnees['bordure']= $bordure;
        $this->donnees['width']= $this->donnees['cote'] + 2*$this->donnees['bordure'];
                
        $this->donnees['xMilieux'] = $this->donnees['width']/2;
        $this->donnees['yMilieux'] = $this->donnees['cote']/2;
        
        $this->donnees['yBranche'] = 250;    
    
        //$this->donnees['xFin'] = 0;
        //$this->donnees['yFin'] = 0 ;
        
        $this->donnees['texte'] = 'icone' ;
        $this->donnees['href']="/appBotanique/vue/img_09.png" ;
    
        parent::__construct();
    
        return $this;
    }
    
    public function dessin()
    {
        /*
        <g id="icon" width="<?= $pas ;?>" height="150">					
			<rect width="<?= $widthIcon ;?>" height="<?= $widthIcon ;?>" x="<?= $bordure ;?>" class="forme" />
			<image xlink:href="/appPage03/vue/point.svg" x="<?= $milieuxIcon ;?>" y="<?= $widthIcon/2 ;?>" transform="translate(-5,-5)" />
			<text x="<?=  $milieuxIcon ;?>" y="<?= $widthIcon ;?>"><?= "icon" ;?></text>
			<line x1="<?= $milieuxIcon ;?>" y1="<?= $widthIcon ;?>" x2="<?= $milieuxIcon ;?>" y2="<?= $longueurBranche ;?>" class="forme" />
		</g>
         */
    }
}



