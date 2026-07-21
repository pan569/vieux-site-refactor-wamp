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
class Genre extends Item
{
    public $icone = [];
    
    use iconeGenre;

    public function __construct($id = null)
    {
        
        self::getDictionaire()->clearDefinition();
        
        self::getDictionaire()->addDefinition('id',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'CLE PRIMAIRE',null,'');
        self::getDictionaire()->addDefinition('ID_FAMILLE',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'ID FAMILLE',null,'');
        self::getDictionaire()->addDefinition('LATIN',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 150],false,'Nom du Genre en latin',null,'');
        self::getDictionaire()->addDefinition('FRANCAIS',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 150],false,'Nom du Genre en francais',null,'');
        
        
        
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
        $requette =  'SELECT * FROM genre ORDER BY genre.LATIN ASC';
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
    
    public function listeEspece()
    {        
        return appBotanique\modele\Espece::listeEspecesDuGenre($this['id']);
    }
    
    public static function listeGenreDeFamille($idFamille)
    {
        $requette =  'SELECT * FROM genre WHERE ID_FAMILLE = '.$idFamille.' ORDER BY genre.LATIN ASC';
        return self::parametrable($requette);
    }
     
    public function calcul($coté,$bordure)
    {
        $this->icone['cote'] = $coté;
        $this->icone['bordure'] = $bordure;
        $this->icone['width'] = $this->icone['cote'] + 2 * $this->icone['bordure'];
        
        $this->icone['xMilieux'] = $this->icone['width'] / 2;
        $this->icone['yMilieux'] = $this->icone['cote'] / 2;
        
        $this->icone['yBranche'] = 250;
        $this->icone['texte'] = "icone" ;
        $this->icone['href'] = "/appBotanique/vue/img_09.png" ;
    }
    
    public function g()
    {
        $resultat = null;
        $resultat .='<g id="'.$this->icone['texte'].'" >'."\n";
        $resultat .="\t"."\t"."\t".'<circle  r="'. $this->icone['cote']/2 .'"  x="'.$this->icone['xMilieux'].'"   class="forme" />'."\n";
        //$resultat .="\t"."\t"."\t".'<rect width="'.$this->cote.'" height="'.$this->cote.'" x=" '.$this->bordure.' " class="forme" />'."\n";
        //$resultat .="\t"."\t"."\t".'<image xlink:href="'.$this->icone['href'].'" x="'.$this->icone['bordure'].'"  width="'.$this->icone['cote'].'" height="'.$this->icone['cote'].'" />'."\n";
        $resultat .="\t"."\t"."\t".'<text x="'. 0 .'" y="'. 0 .'" style="text-anchor:middle;">'.$this->icone['texte'].'</text>'."\n";
        $resultat .="\t"."\t".'</g>'."\n";
        
        return $resultat;
    }
    
    
}

