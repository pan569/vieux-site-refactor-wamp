<?php
namespace appPage03\modele;

use systeme\objets\Item;

class DonneesTrigo extends Item
{
    
    public function __construct($angleA,$H,$ofset)
    {
        self::getDictionaire()->clearDefinition();
        
        /*
        cos ABC = AB/BC
        cos ABC * BC = AB
        cos angle * H = AB
        
        
        */
        $this->donnees['angleA']= $angleA ;
        $this->donnees['angleB']= 180 - 90 - $angleA ;
        $this->donnees['H']= $H ;
        $this->donnees['a']= ($this->donnees['H'] * cos( deg2rad($this->donnees['angleA']))) ;
        $this->donnees['b']= ($this->donnees['H'] * cos( deg2rad($this->donnees['angleB']))) ;

        
        parent::__construct();
        
        return $this;
    }
    
}

