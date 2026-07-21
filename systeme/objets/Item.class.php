<?php
namespace systeme\objets;

use PDOStatement;
use systeme\validateur\Validateur;


/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 17/12/2018
 * Time: 06:00
 * version : 3alpha
 * 
 * 
 * erreur a coriger:
 *  - integrezr message flash
 * 
 * 
 */
class Item extends Collection
{

    /**
     * 
     * @var DataDictionary definition des données
     */
    public static $_dictionaire;    
    /**
     * 
     * @return DataDictionary
     */
    public static function getDictionaire():DataDictionary
    {
        if(is_null(self::$_dictionaire))
            self::$_dictionaire = new DataDictionary();
            
            return self::$_dictionaire;
    }
    
    /**
     * retourne l'id de l'item
     * 
     * @return mixed
     */
    public function getID()
	{
		return $this->donnees['id'];
	}

	/**
	 * 
	 * retourne la liste des clés
	 * 
	 * @return array
	 */	
	public function getCle()
	{
	    return array_keys($this->donnees);
	}
	
	/**
	 *retourne la valeur qui corespond a la clé
	 *
	 * @param string $clee
	 * @return mixed/false
	 */
	public function get(string $cle)
	{
	    if($this->cleeExiste($cle))
	    {
	        return $this->donnees[$cle];
	    }
	    
	    return false;
	}
	
	/**
	 * ajoute une entrée aux données
	 * si la clée existe, sa valeur est ecrasé
	 *
	 * @param string $clee
	 * @param mixed $valeur
	 * @return bool true si la valeur est valide si non false
	 */
	public function set(string $cle, $valeur):bool
	{
	    
	    $this->donnees[$cle]=$valeur;
	    return true;
	    /*
        // si il y a une définition de la donner existe, verifier si la valeur et valide celon cette definition.
	    if(!empty(self::getDictionaire()->getDonnees()))
	    {
	       if($this->validation($cle,$valeur) === true)
	       {
	           $this->donnees[$cle]=$valeur;
	           return true;
	       }
	       return false;
	    }
	    else
	    {
	        $this->donnees[$cle]=$valeur;
	    }
	    return true;
	    */
	}
	
    public function __get(string $name)
    {        
        foreach ($this->donnees as $clée => $valeur)
        {
            if($name == $clée)
                return $valeur;
        }

        $fonction = 'get' . ucfirst($name);
        $this->$name = $this->$fonction();
        return $this->$name;

    }

    /**
     * retourne le nom de la table correspondant a l'objet Item
     * 
     * @return mixed
     */
    public static function getNomTable()
    {
        $tab = explode("\\", get_called_class());
        return $tab[count($tab)-1];
    }
    
    use Paginer;
    
    /**
     * 
     * @param int $id
     * @return \systeme\objets\Item
     */
    public function __construct(int $id = null)
    {
       
        foreach ($this->dictionaire as $definition)
        {
           
            $this->donnees[$definition['nom']]= $definition['defaut'];
        }

        $this->position = 0;
        if($id !== null)
        {
            $this->SELECT_ID($id);
        }
        
        return $this;
           
    }    
    
    
	/**
	 * Crée une entrée dans la table correspondant a une classe fille
	 * de la classe Item
	 *
	 * @param void
	 * @return void
	 */
	public function INSERT()
	{
	    debug("je passe insert()");	    
	    $verification = $this->verifier();	    
	    
	    if($verification == true)
	    {
	        Persistance::getInstance()->INSERT(self::getNomTable(),$this->getDonnees());
	        return true;
	    }
	    else
	    {
	        return $verification;
	    }
	    
	}
	
	/**
	 * Modifie une entrée dans la table correspondant a une classe fille
	 * de la classe Item
	 *
	 * @param void
	 * @return void
	 */
	public function UPDATE()
	{
	    if($this->verifier())
	    {
	        Persistance::getInstance()->UPDATE(self::getNomTable(),$this->getDonnees());
	        return true;
	    }
	    else 
	    {
	        return false;
	    }
	}
	
	/**
	 * Supprime une entrée dans la table correspondant a une classe fille
	 * de la classe Item
	 *
	 * @param void
	 * @return void
	 */
	public function DELETE()
	{
	    Persistance::getInstance()->DELETE(self::getNomTable(), $this->getID());
	}
	
	/**
	 * returne une entrée dans la table correspondant a une classe fille
	 * de la classe Item
	 *
	 * @param int
	 * @return void
	 */
	public function SELECT_ID($id)
	{	  
	    $this->InsertDonnées(Persistance::getInstance()->SELECT_ID(self::getNomTable(),$id));
	}

	/**
	 */
    public static function SELECT()
    {
        return self::TableauItem(Persistance::getInstance()->SELECT(self::getNomTable()));
    }
    
    public static function SELECT_PAGE(int $page = 10)
    {
        return self::TableauItem(Persistance::getInstance()->SELECT_PAGE(self::getNomTable(),$page));
    }
    
    public static function parametrable(string $requette)
    {
        return self::TableauItem(Persistance::getInstance()->requettePerso($requette));
    }
    
    /**
     * 
     * @param array $DataDonnées
     * @return item[]
     */
    public static function TableauItem(array $DataDonnées) 
    {
        $resultat = [];
        
        foreach ($DataDonnées as $DataDonnée)
        {

            $itemNom = get_called_class();
            $item = new $itemNom;            
            
            $item->InsertDonnées($DataDonnée);
            
            $resultat[] = $item;
        }
        
        return $resultat;
    }
    
    /**
     * crée une table dans la base de donnée courante grace a la datadefinition de l'objet (fille) "Item"
     * 
     * @return PDOStatement
     */
    public static function CREATE_TABLE() 
    {
        return Persistance::getInstance()->CREATE_TABLE(self::getNomTable(), self::getDictionaire()->CodeMySQLTotal());
    }
    
    /**
     * 
     * @param string $cle
     * @param mixed $valeur
     * @return bool
     */
    public function validation(string $cle,$valeur)
    {
        $validation = new Validateur();
        
        $definition = self::getDictionaire()[$cle];
        $definition['valeur'] =  $valeur;                
        $validation->tester($definition);
        
        
        
        if($validation->isErreur())
        {
            //debug($valeur,"contenue : ");
            
            //debug($validation->getErreurs(),"liste des erreurs");
            
            debug("je passe validation() et il y au moins 1 erreur");
            
            $resultat =[];
            
            $resultat['clé'] = $cle;
            $resultat['valeur'] = $valeur;
            $resultat['definition'] = $definition;
            $resultat['erreur']=$validation->getErreurs();           
            
            return $resultat;
        }
        
        return true;
        
    }
    
    public function verifier()
    {
        foreach ($this->donnees as $cle => $valeur)
        {                        
            if(!empty(self::getDictionaire()->getDonnees()[$cle]))
            {
                //debug(self::getDictionaire()->getDonnees()[$cle]['commentaires'],"getDonnees");
                if(self::getDictionaire()->getDonnees()[$cle]['commentaires']!="CLE PRIMAIRE")
                {
                    
                    
                    
                    if(self::getDictionaire()->getDonnees()[$cle]['null']=== true && $valeur === null)
                    {
                        return true;
                    }
                    
                    debug("je passe verifier() et il y validation");
                    
                    return  $this->validation($cle,$valeur);
                    
                }
            }
        }
        
        return true;
    }

    public static function clear()
    {
        //self:: $this->donnees = [];
    }


    public function LireXmlElement($fichier, $element )
    {        
        $this->donnees = Persistance::getInstance()->LireXmlElement($fichier, $element, $this->donnees);
    }
    
    public function LireXmlElementAttribut($fichier, $element, $attribut  )
    {
        //$this->LireXmlElementAttribut($this->fichierIni, 'Credits', $this->personne);
        $this->donnees = Persistance::getInstance()->LireXmlElementAttribut($fichier, $element, $attribut, $this->donnees);
    }
    
    public function EcrireXmlElement($fichier, $element )
    {
        Persistance::getInstance()->EcrireXmlElement($fichier, $element, $this->donnees);
    }
    
    public function EcrireXmlElementAttribut($fichier, $element, $attribut )
    {
        Persistance::getInstance()->EcrireXmlElementAttribut($fichier, $element, $attribut, $this->donnees);
    }
    
}
