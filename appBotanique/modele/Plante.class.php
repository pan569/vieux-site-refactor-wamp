<?php
namespace appBotanique\modele;

use systeme\objets\Item;
use systeme\objets\DataDictionary;

/**
 *
 * @author Ulysse1976
 * 12/022019 06:07       
 */
class Plante extends Item
{
    const _SEXUALITE = ['','Autogame','Allogame'];
    const _CYCLE_DE_VIE = ['','Vivace','Annuelle'];
    const _EXPOSITION = ['','soleil','mi-ombre','ombre','lumiere tamisé','lumiere vive'];
    const _AERATION = ['','Trés drainant','drainant','frais','lourd'];
    const _PH = ['','indiferant','acide','neutre','basic'];
    const _RICHESSE = ['','pauvre','correct','riche'];
    const _MULTIPLICATION = ['','semi','marcottage','bouturage','greffe'];
    const _SENSIBILITE = ['','resistante','oïdium','Limaces','pucerons','rouille','araignées rouge','chancre bactérien','maladies cryptogamiques','mouche des fruits'];
    const _STRATE = ['','Sous-sol','couvre-sol','basse','Taillis','Arbuste','Lianes','canopée'];
    const _LIBELLE = ['','arbre','potagé','production','bioindicateur'];
    const _PERIODE = ['','Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
    const _PARTIE_PLANTE = ['Racine','Bulbe','Tige','Ecorce','Feuille','Fleur','Fruit'];

    
    /**
     * ...
     *
     * @Famille
     * @access private
     */
    protected $famille;
    
    /**
     * ...
     *
     * @param void
     * @return $Famille
     */
    public function getFamille()
    {
        return $this->famille;
    }
    
    
   /**
    * ...
    *
    * @Genre
    * @access private
    */
    protected $genre;
    
    /**
     * ...
     *
     * @param void
     * @return $genre
     */
    public function getGenre()
    {
        return $this->genre;
    }
    
   /**
    * ... 
    * 
    * @Espece
    * @access private
    */
    protected $espece;
    
    /**
     * ...
     *
     * @param void
     * @return $espece
     */
    public function getEspece()
    {
        return $this->espece;
    }
    
    
    public function __construct($id = null)
    {
        
        self::getDictionaire()->clearDefinition();
        
        self::getDictionaire()->addDefinition('id',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'CLE PRIMAIRE',null,'');                
        self::getDictionaire()->addDefinition('ID_ESPECE',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],false,'Nom de l’espece en latin',null,'');
        self::getDictionaire()->addDefinition('VARIETEE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Nom de la varietée en latin',null,'');
        self::getDictionaire()->addDefinition('NOM',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],false,'Nom du genre en francais',null,'');
        self::getDictionaire()->addDefinition('SYNONYME',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Liste des synonyme',null,'');        
        self::getDictionaire()->addDefinition('DESCRIPTION',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Description de la plante',null,'');
        self::getDictionaire()->addDefinition('ENSEMBLE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de l\'ensemble de la plante',null,'');
        self::getDictionaire()->addDefinition('FEUILLE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de la feuille',null,'');
        self::getDictionaire()->addDefinition('FLEUR',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de la fleur',null,'');
        self::getDictionaire()->addDefinition('FRUIT',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image du fruit',null,'');
        self::getDictionaire()->addDefinition('TIGE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de la tige',null,'');
        self::getDictionaire()->addDefinition('RACINE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de la racine',null,'');
        self::getDictionaire()->addDefinition('ECORSE',DataDictionary::TYPE_BINAIRE,['min'=> 0,'max'=> 16000000],true,'Image de l\'ecorce',null,'');
        self::getDictionaire()->addDefinition('SEXUALITE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Type de reproduction',null,'');
        self::getDictionaire()->addDefinition('FLEURESON',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Periode de fleuraison de la plante',null,'.+');
        self::getDictionaire()->addDefinition('FRUCTIFICATION',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Age ou la plante commance a donner des fruits',null,'');
        self::getDictionaire()->addDefinition('HAUTEUR_MIN',DataDictionary::TYPE_DECIMAL,['min'=> 0,'max'=> 10],true,'Hauteur minimum de la plante en cm',null,'');
        self::getDictionaire()->addDefinition('HAUTEUR_MAX',DataDictionary::TYPE_DECIMAL,['min'=> 0,'max'=> 10],true,'Hauteur maximal de la plante en cm',null,'');        
        self::getDictionaire()->addDefinition('LARGEUR',DataDictionary::TYPE_DECIMAL,['min'=> 0,'max'=> 10],true,'Largeur de la plante en cm',null,'');
        self::getDictionaire()->addDefinition('CROISSANCE',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],true,'Croissance en cm / an',null,'');
        self::getDictionaire()->addDefinition('DUREE_DE_VIE',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],true,'Duré de vie moyenne de la plante en année',null,'');
        self::getDictionaire()->addDefinition('CYCLE_DE_VIE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Periode de vie',null,'');
        self::getDictionaire()->addDefinition('RUCTICITE',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],true,'Temperature negatif maximum a laquel la plante peut suporter en °C',null,'');
        self::getDictionaire()->addDefinition('EXPOSITION',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'type d’exposition solaire que la plante suport',null,'');
        self::getDictionaire()->addDefinition('AERATION',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'drainage de l eau dans la terre',null,'');
        self::getDictionaire()->addDefinition('PH',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'PH de la sol',null,'');
        self::getDictionaire()->addDefinition('RICHESSE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'richesse du sol en ???',null,'');
        self::getDictionaire()->addDefinition('HUMIDITE',DataDictionary::TYPE_ENTIER,['min'=> 0,'max'=> 5],true,'Taux d’humiditée de le sol en %',null,'');
        self::getDictionaire()->addDefinition('MULTIPLICATION',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Facon dont peut multiplier les plantes',null,'');
        self::getDictionaire()->addDefinition('PLANTATION',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Periode de plantation/repicage de la plante',null,'');
        self::getDictionaire()->addDefinition('SEMIS_INTERIEUR',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Periode de semence de la plante en interieur',null,'');
        self::getDictionaire()->addDefinition('SEMIS_EXTERIEUR',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Periode de semence de la plante en exterieur',null,'');
        self::getDictionaire()->addDefinition('GREFFE',DataDictionary::TYPE_CHAINE,['min'=> 0,'max'=> 8000],true,'Type de greffe',null,'');
        self::getDictionaire()->addDefinition('BOUTURE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Renseigne si la plante est bouturable',null,'');
        self::getDictionaire()->addDefinition('STRATE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'Place que la plante occupe dans une foret',null,'');
        self::getDictionaire()->addDefinition('SENSIBILITE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>8000],true,'maladie insecte etc',null,'');
        self::getDictionaire()->addDefinition('UTILITAIRE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>8000],true,'',null,'');
        self::getDictionaire()->addDefinition('LIBELLE',DataDictionary::TYPE_CHAINE, ['min'=> 0,'max'=>150],true,'groupe tout a fait personnel ',null,'');
        
        
        
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
        $requette =  'SELECT * FROM plante ORDER BY plante.nom ASC';                
        
        return self::parametrable($requette);
        
    }
    
    public function FGE()
    {
        $this->espece = new Espece();
        $this->espece->SELECT_id($this['ID_ESPECE']);
        
        $this->genre = new Genre();
        $this->genre->SELECT_id($this->espece['ID_GENRE']);
        
        $this->famille = new Famille();
        $this->famille->SELECT_id($this->genre['ID_FAMILLE']);
        
    }
    
    public function separateur (string $etiquette)
    {
        return str_replace( ";", ", ", $this[$etiquette]);
    }
    
    
}

