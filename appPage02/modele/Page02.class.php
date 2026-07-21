<?php
namespace appPage02\modele;

use systeme\objets\DataDictionary;
use systeme\objets\Item;


/**
 *
 * @author Ulysse1976
 * 12/022019 06:07       
 */
class Page02 extends Item
{

    public function __construct()
    {
        self::getDictionaire()->clearDefinition();
        
        self::getDictionaire()->addDefinition('titre',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],false,"Titre",null,'.+');        
        self::getDictionaire()->addDefinition('contenu',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],false,"Contenue",null,'.+');
        self::getDictionaire()->addDefinition('image',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,"Image",null,'.+');
        self::getDictionaire()->addDefinition('dateCreation',DataDictionary::TYPE_DATE,['min'=> 0,'max'=> 0],false,"Date de création",null,'.+',['TYPE_DATE' =>'Chaîne']);
        
        parent::__construct();
        
        return $this;
    }
    
    
    public static function pseudoItem()
    {
        $speudoItem = new Page02();
        
        $speudoItem['titre']="Le statut de Freelance";
        $speudoItem['contenu']="Dans un précédent podcast on s'était intéressé au métier de développeur web de manière générale mais aujourd'hui je voulais me focaliser sur le statut de freelance en particulier. Plutôt que de faire une longue explication sur le statut, mon expér...
				Dans un précédent podcast on s'était intéressé au métier de développeur web de manière générale mais aujourd'hui je voulais me focaliser sur le statut de freelance en particulier. Plutôt que de faire une longue explication sur le statut, mon expér...";
        $speudoItem['image']="appPage01/vue/resources/img/article.jpg";
        $speudoItem['dateCreation']="14 juin 2018";

        return $speudoItem;
    }
    
    public static function ListeX()
    {
        $resultat = [];
        for ($i = 1; $i <= 6; $i++) {
            $resultat[] = self::pseudoItem();
        }
        
        return $resultat;
    }
    
}

