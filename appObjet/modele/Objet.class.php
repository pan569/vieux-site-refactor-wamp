<?php
namespace appObjet\modele;

use systeme\objets\Item;
use systeme\objets\DataDictionary;
use systeme\utilitaire\MyDateTime;

/**
 *
 * @author Ulysse1976
 * 12/022019 06:07       
 */
class Objet extends Item
{

    public function __construct($id = null)
    {
        
        //string $nom, string $type, array $taille, bool $nullable, string $commentaires, $defaut,string $validation, array $optionType = []
        
        self::getDictionaire()->addDefinition('id',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'CLE PRIMAIRE',null,'');
        self::getDictionaire()->addDefinition('titre',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],false,"Titre",null,'.+');
        self::getDictionaire()->addDefinition('slug',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 150],false,"Slug",null,'([a-z0-9]+-?)+');
        self::getDictionaire()->addDefinition('contenu',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],false,"Contenue",null,'.+');
        self::getDictionaire()->addDefinition('image',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,"Image",null,'.+');
        self::getDictionaire()->addDefinition('dateCreation',DataDictionary::TYPE_DATE,['min'=> 0,'max'=> 0],false,"Date de création",null,'.+',['TYPE_DATE' =>'Chaîne']);
        self::getDictionaire()->addDefinition('dateModification',DataDictionary::TYPE_DATE,[],false,"Date de modification",null,'.+',['TYPE_DATE' =>'Chaîne']);
        self::getDictionaire()->addDefinition('idCategorie',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,"id de la categorie",null,'.+');
        
        parent::__construct($id);
        
        return $this;
    }
    
    public function dateCreation()
    {                
       
        if($this->dateCreation === null )
            $this->dateCreation = "now";
       
        return MyDateTime::getInstance()->setDateTime($this->dateCreation)->getDateTimeFrLitér();
    }
    
    public function dateModification()
    {
        if($this->dateModification === null )
            $this->dateModification = "now";
        
        return MyDateTime::getInstance()->setDateTime($this->dateModification)->getDateTimeFrLitér();
    }
    
    public function getExtrai() 
    {
        return substr( $this->contenu,0,100).' ...' ;
    }
    

    
}

