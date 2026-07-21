<?php
namespace appPage03\modele;

use systeme\objets\DataDictionary;
use systeme\objets\Item;


/**
 *
 * @author Ulysse1976
 * 12/022019 06:07       
 */
class Page03 extends Item
{

    public function __construct()
    {
        self::getDictionaire()->clearDefinition();
        
        $this->donnees['width']= null ;
        $this->donnees['height']= null ;
        /*
        //## ELEMENTS POUR DESSINER LES ICONES ##\\
        $this->donnees['nbrIcon'] = 5;
        $this->donnees['widthIcon'] = 100;
        
        $this->donnees['$bordure']= ($this->donnees['width'] - ($this->donnees['nbrIcon']*$this->donnees['widthIcon']) ) / (2*$this->donnees['nbrIcon']);
        $this->donnees['$milieuxIcon'] = $this->donnees['bordure'] + $this->donnees['widthIcon']/2;
        
        $this->donnees['pas']= $this->donnees['$widthIcon'] + 2*$this->donnees['bordure'];
        $this->donnees['longueurBranche'] = $this->donnees['height']/3;
        $this->donnees['xFin'] = $this->donnees['width']/2;
        $this->donnees['yFin'] = $this->donnees['height'] ;
        /**/
        
        
        parent::__construct();
        
        return $this;
    }
    
}

