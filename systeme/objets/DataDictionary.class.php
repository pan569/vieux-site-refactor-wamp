<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 16/12/2018
 * Time: 06:41
 */

namespace systeme\objets;



class DataDictionary extends collection
{

    const TYPE_DONNEES = ['ENTIER','DECIMAL','DATE','CHAINE','BINAIRE','ENUMERATION'];
    const TYPE_ENTIER ='integer';
    const TYPE_DECIMAL ='double';
    const TYPE_DATE ='DateTime';
    const TYPE_CHAINE ='string';
    const TYPE_BINAIRE ='binaire';
    const TYPE_ENUMERATION ='array';
    const TYPE_BOOLEAN ='boolean';
    
    
    const PROPRIETE_NULL ="NULL";
    const PROPRIETE_NOT_NULL ="NOT NULL";
    
    const OPTIONS = ['chaîne','numerique','inclusif','exclusif'];
    const OPTION_TYPE_DATE_CHAINE ='chaîne';
    const OPTION_TYPE_DATE_NUMERIQUE ='numerique';
    const OPTION_TYPE_ENUMERATION_INCLUSIF ='inclusif';
    const OPTION_TYPE_ENUMERATION_EXCUSIF ='exclusif';
        

    
    public function ExtraireDefinition(string $clee,$valeur)
    {
       

        foreach ($this->donnees as $donnee)
        {

            if($donnee[$clee]==$valeur)
            {                
                return $donnee;
            }
        }

    }
    
    
    public function __construct()
    {
        $clear =[];
        parent::__construct($clear);
    }

    /**
     * 
     * @param string $nom nom
     * @param string $type
     * @param array $taille
     * @param bool $vide
     * @param bool $nullable
     * @param string $commentaires
     * @param mixed $defaut
     * @param string $validation
     * @param array $optionType
     * @return \systeme\objets\DataDictionary
     */
    public function addDefinition(string $nom, string $type, array $taille, bool $nullable, string $commentaires, $defaut,string $validation=null , array $optionType = []):self
    {
        $definition = [];

        $definition['nom'] =$nom;
        $definition['type'] =$type;
        
        if(array_key_exists('min', $taille))
        {
            $definition['tailleMin']= $taille['min'];
        }
        else 
        {
            $definition['tailleMin']=0;
        }
        
        if(array_key_exists('max', $taille))
        {
            $definition['tailleMax']= $taille['max'];
        }
        
        
        
        $definition['null']= $nullable;
        $definition['defaut'] =$defaut;
        $definition['commentaires'] =$commentaires;      
        $definition['validationRegEx'] = $validation;
        $definition['option'] =$optionType;
        $definition['valeur'] =null;        
        
        $this->set($definition['nom'], $definition) ;      
        
        return $this;

    }

    public function clearDefinition()
    {
        $this->donnees = [];
    }
    
    public function modifDef($definition,$propriete,$valeur)
    {
        debug($definition,'definition');
        debug($propriete,'propriete');
        debug($valeur,'valeur');
        
        if($propriete != 'nom')
        {
            $this->donnees[$definition][$propriete] = $valeur;
        }
    }
    
    
   /**
    * Ecrit la ligne en MySQL pour creer une colonne de table Mysql a partir de la definition de la propriété
    * 
    * @param string $nomPropriete nom de la propriété dans le dictionaire
    * @return string code MySQL
    */
    public function CodeMySQL(string $nomPropriete):string 
    {
        
        $definition = $this->ExtraireDefinition('nom', $nomPropriete);        
        $colonne = (new ColonneTableBD($definition))->ecritureMySQL() ;

        return $colonne;
    }
    
    /**
     * Ecrit la ligne en MySQL pour creer les colonnes de table Mysql a partir tout le dictionaire de propriété
     * 
     * @return string code MySQL
     */
    public function CodeMySQLTotal():string
    {
        
        $resultat = null;
        $cp = count($this->donnees) -1;
        
        debug($this->donnees,"DataDirectory_Données");
        
        foreach ($this->donnees as $definition)
        {
            //$colonne = new colonneTableBD() ;           
            $resultat .=  (new ColonneTableBD($definition))->ecritureMySQL() ;

            if($cp != 0)
            {
                $resultat .=", ";
            }
            $cp--;
            
            $resultat .= "\r" ;
        }
        
        debug($resultat,"DataDirectory_CodeMySQLTotal_Resultat");
        
        return $resultat;
    }

}