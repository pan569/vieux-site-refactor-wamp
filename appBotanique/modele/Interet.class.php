<?php
namespace appBotanique\modele;

use systeme\objets\DataDictionary;
use systeme\objets\Item;

class Interet  extends Item
{
    
    public function __construct()
    {
        
        self::getDictionaire()->clearDefinition();
        
        self::getDictionaire()->addDefinition('COMESTIBLE',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Intérêts culinaires',null,'');
        self::getDictionaire()->addDefinition('P_COMESTIBLE',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Liste des partie de la plante qui est comestible',null,'');
       
        self::getDictionaire()->addDefinition('MEDICINAL',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Intérêts medicinaux',null,'');
        self::getDictionaire()->addDefinition('P_MEDICINAL',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Liste des partie de la plante qui comporte des Intérêts medicinaux',null,'');
        
        self::getDictionaire()->addDefinition('ENVIRONNEMENTAL',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Intérêts environementaux',null,'');
        self::getDictionaire()->addDefinition('P_ENVIRONNEMENTAL',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Liste des partie de la plante qui comporte des Intérêts environementaux',null,'');
        
        self::getDictionaire()->addDefinition('TOXICITE',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Toxicité',null,'');
        self::getDictionaire()->addDefinition('P_COMESTIBLE',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Liste des partie de la plante qui comporte des elements toxique',null,'');
       
        self::getDictionaire()->addDefinition('AUTRES',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Autres',null,'');
        
        parent::__construct();
        
        return $this;
    }
    
}

