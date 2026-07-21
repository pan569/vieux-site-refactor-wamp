<?php
namespace appBotanique\modele;

use systeme\objets\Item;
use systeme\objets\DataDictionary;
use appBotanique;

/**
 *
 * @author Ulysse1976
 * 12/022019 06:07       
 */
class Famille extends Item
{
    public $icone = [];
    
    use iconeFamille;
    
    public function __construct($id = null)
    {
        
        self::getDictionaire()->clearDefinition();
        
        self::getDictionaire()->addDefinition('id',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'CLE PRIMAIRE',null,'');        
        self::getDictionaire()->addDefinition('LATIN',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 150],false,'Nom de la famille en latin',null,'');
        self::getDictionaire()->addDefinition('FRANCAIS',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 150],false,'Nom de la famille en francais',null,'');
        
        /*
        - faire l'objet famille
        - faire l'objet genre
        - faire l'objet espece
        - faire les table de la base de donné
        - faire les formulaires
        - faire le controleur
        - tester les formulaires
        - modifier la structure des formulaires
        - Travailler le graphisme des formulaires
        
        /**/
        
        
        parent::__construct($id);
        
        return $this;
    }
    
    public static function listeTrié()
    {                        
        $requette =  'SELECT * FROM famille ORDER BY famille.LATIN ASC';        
        return self::parametrable($requette);        
        
    }
    
    public static function liste()
    {
        
        
        $listeFamille = self::listeTrié();
        
        $resultat = [];
        
        foreach ($listeFamille as $i)
        {
            $resultat[$i->get('id')]=$i->get('LATIN');
        }
        
       
        return $resultat;
        
    }
    
    public function listeGenre()
    {
        return appBotanique\modele\Genre::listeGenreDeFamille($this['id']);
    }
    
    public function calcul($coté,$texte)
    {
        $this->icone['cote'] = $coté;
        //$this->icone['bordure'] = $bordure;
        //$this->icone['width'] = $this->icone['cote']+ 2 * $this->icone['bordure'];
        
        $this->icone['xMilieux'] = $this->icone['cote'] / 2;
        $this->icone['yMilieux'] = $this->icone['cote'] / 2;
        
        $this->icone['yBranche'] = 250;
        $this->icone['texte'] = $texte ;
        $this->icone['href'] = "/appBotanique/vue/img_09.png" ;
    }
    
    public function g()
    {
        $resultat = null;
        $resultat .='<g id="'.$this->icone['texte'].'" >'."\n";
        $resultat .="\t"."\t"."\t".'<circle  r="'. $this->icone['cote']/2 .'" class="forme" />'."\n";
        
        //$resultat .="\t"."\t"."\t".'<image xlink:href="'.self::$href.'" x="'.self::$bordure.'"  width="'.self::$cote.'" height="'.self::$cote.'" />'."\n";
        $resultat .="\t"."\t"."\t".'<text x="'.$this->icone['xMilieux'].'" y="'.$this->icone['yMilieux'].'" style="text-anchor:middle;">'.$this->icone['texte'].'</text>'."\n";
        $resultat .="\t"."\t".'</g>'."\n";
        
        return $resultat;
    }
}

