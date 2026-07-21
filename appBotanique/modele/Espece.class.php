<?php
namespace appBotanique\modele;

use systeme\objets\Item;
use systeme\objets\DataDictionary;
use systeme;

/**
 *
 * @author Ulysse1976
 * 12/022019 06:07       
 */
class Espece extends Item
{
    public $icone = [];
    
    public function __construct($id = null)
    {
        
        self::getDictionaire()->clearDefinition();
        
        self::getDictionaire()->addDefinition('id',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'CLE PRIMAIRE',null,'');
        self::getDictionaire()->addDefinition('ID_GENRE',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'id genre',null,'');
        self::getDictionaire()->addDefinition('LATIN',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 150],false,'Nom de la famille en latin',null,'');
        self::getDictionaire()->addDefinition('FRANCAIS',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 150],false,'Nom de la famille en francais',null,'');
        self::getDictionaire()->addDefinition('ENSEMBLE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de l\'ensemble de la plante',null,'');
        self::getDictionaire()->addDefinition('FEUILLE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de la feuille',null,'');
        self::getDictionaire()->addDefinition('FLEUR',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de la fleur',null,'');
        self::getDictionaire()->addDefinition('FRUIT',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image du fruit',null,'');
        self::getDictionaire()->addDefinition('TIGE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de la tige',null,'');
        self::getDictionaire()->addDefinition('RACINE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de la racine',null,'');
        self::getDictionaire()->addDefinition('ECORSE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de l\'ecorce',null,'');
                        
        /*
        - [V] faire l'objet famille
        - [V] faire l'objet genre
        - [V] faire l'objet espece
        - [V] faire les table de la base de donné
        - [V] faire les formulaires
        - [V] faire le controleur
        - [V] tester les formulaires
        - [V] modifier la structure des formulaires
        - [\] Travailler le graphisme des formulaires
        
        /**/
        parent::__construct($id);

        return $this;
    }
    
    public function getGenre()
    {   
        $requettePrépare="SELECT genre.Latin AS Genre FROM genre WHERE genre.id = {$this['ID_GENRE']}";
        $resultataRequette = systeme\objets\Persistance::getInstance()->requettePersoFetch($requettePrépare);
        return $resultataRequette[0];
    }
    
    public static function listeTrié()
    {
        $requette =  'SELECT * FROM espece ORDER BY espece.LATIN ASC';
        return self::parametrable($requette);
        
    }
    
    public static function listeEspecesDuGenre($idGenre)
    {
        $requette =  'SELECT * FROM espece WHERE ID_GENRE = '.$idGenre.' ORDER BY espece.LATIN ASC';
        return self::parametrable($requette);        
    }
    
    public static function liste()
    {
        
        $requettePrépare="
            SELECT espece.id, genre.Latin AS Genre, espece.Latin AS Espece, espece.FRANCAIS AS Francais
            FROM espece
            LEFT OUTER JOIN genre ON genre.id = espece.ID_GENRE
            ORDER BY espece.FRANCAIS ASC
        ";
        
        $listeEspece = systeme\objets\Persistance::getInstance()->requettePerso($requettePrépare);        
        
        $resultat = [];
        
        foreach ($listeEspece as $i)
        {            
            $resultat[$i['id']]=$i['Francais']." (". $i['Genre']." ".$i['Espece'].")";
        }
        
        return $resultat;
        
    }
            
    public static function listeParFamille()
    {
       
        /*        
        [Famille]
            [Genre]
                [Espece]
        */ 
                
        
        $requette01 =  'SELECT * FROM famille ORDER BY famille.LATIN ASC';        
        $familles = systeme\objets\Persistance::getInstance()->requettePerso($requette01);
       
        $tabfamilles = [];
        foreach ($familles as $famille)
        {
            $tabfamille = []; 
            
            $tabfamille['id'] = $famille['id'];
            $tabfamille['LATIN'] = $famille['LATIN'];
            $tabfamille['FRANCAIS'] = $famille['FRANCAIS'];
            
            $requette02 =  "SELECT * FROM genre WHERE genre.ID_FAMILLE = {$famille['id']} ORDER BY genre.LATIN ASC";
            $genres = systeme\objets\Persistance::getInstance()->requettePerso($requette02);
            
            $tabgenres =[];
            foreach ($genres as $genre)
            {
                $tabgenre = [];
                
                $tabgenre['id'] = $genre['id'];
                $tabgenre['LATIN'] = $genre['LATIN'];
                $tabgenre['FRANCAIS'] = $genre['FRANCAIS'];
                
                $requette03 =  "SELECT * FROM espece WHERE espece.ID_GENRE = {$genre['id']} ORDER BY espece.LATIN ASC";
                $especes = systeme\objets\Persistance::getInstance()->requettePerso($requette03);
                
                $tabespeces = [];
                foreach ($especes as $espece)
                {
                    
                    $tabespece = [];
                    
                    $tabespece['id'] = $espece['id'];
                    $tabespece['LATIN'] = $espece['LATIN'];
                    $tabespece['FRANCAIS'] = $espece['FRANCAIS'];
                    
                    $tabespeces[] = $tabespece;
                }
                $tabgenre['ESPECE'] = $tabespeces;
                
                $tabgenres[] = $tabgenre;
            }
            $tabfamille['GENRE'] = $tabgenres;
            
            $tabfamilles[] = $tabfamille;
        }
        
        return $tabfamilles;
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
        //$resultat .="\t"."\t"."\t".'<rect width="'.$this->cote.'" height="'.$this->cote.'" x=" '.$this->bordure.' " class="forme" />'."\n";
        $resultat .="\t"."\t"."\t".'<image xlink:href="'.$this->icone['href'].'" x="'.$this->icone['bordure'].'"  width="'.$this->icone['cote'].'" height="'.$this->icone['cote'].'" />'."\n";
        $resultat .="\t"."\t"."\t".'<text x="'.$this->icone['xMilieux'].'" y="'.($this->icone['cote'] - 4)  .'" style="text-anchor:middle;">'.$this->icone['texte'].'</text>'."\n";
        $resultat .="\t"."\t".'</g>'."\n";
        
        return $resultat;
    }
    
    
}

