<?php
namespace appAnnuaire\modele;

use systeme\objets\DataDictionary;
use systeme\objets\Item;
use systeme\utilitaire\MyDateTime;

class url extends Item
{

    public function __construct()
    {
        
        self::getDictionaire()->clearDefinition($id = null);
        
        self::getDictionaire()->addDefinition('id',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'CLE PRIMAIRE',null,'[0-9]+');
        self::getDictionaire()->addDefinition('nom',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],false,"auteur de l'article",null,'[a-zA-Z0-9\s]+');
        self::getDictionaire()->addDefinition('url',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],false,"Titre",null,'[a-zA-Z\s]+');
        self::getDictionaire()->addDefinition('contenu',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],false,"Contenue",null,'.+');
        self::getDictionaire()->addDefinition('image',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,"Image",null,'.+');
        self::getDictionaire()->addDefinition('dateCreation',DataDictionary::TYPE_DATE,['min'=> 0,'max'=> 0],true,"Date de création",null,'.+',['TYPE_DATE' =>'Chaîne']);
        self::getDictionaire()->addDefinition('dateModification',DataDictionary::TYPE_DATE,[],true,"Date de modification",null,'.+',['TYPE_DATE' =>'Chaîne']);
        self::getDictionaire()->addDefinition('idCategorie',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],true,"id de la categorie",null,'.+');
        
        parent::__construct($id);
        
        return $this;
    }
    
    
    public function dateCreation()
    {
        return MyDateTime::getInstance()->setDateTime($this->dateCreation)->getDateTimeFrLitér();
    }
    
    public function dateModification()
    {
        return MyDateTime::getInstance()->setDateTime($this->dateModification)->getDateTimeFrLitér();
    }
}

