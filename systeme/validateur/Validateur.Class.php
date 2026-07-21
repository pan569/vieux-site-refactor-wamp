<?php
namespace systeme\validateur;

use systeme\objets\DataDictionary;


class Validateur
{
    /**
     * 
     * @var array
     */
    protected $definition;
    
    
    /**
     * 
     * @var Erreurs[]
     */
    protected $erreurs = [];
    
    /**
     * 
     * @return \systeme\Validateur\Erreurs[]
     */
    public function getErreurs()
    {
        return $this->erreurs;
    }
    
    public function __construct()
    {
        return $this;
    }
    
    public function tester(array $definition)
    {

        $this->definition = $definition;
        
        //debug($this->definition,'$this->definition');
        
        $verifierType = [DataDictionary::TYPE_BOOLEAN,DataDictionary::TYPE_CHAINE,DataDictionary::TYPE_DECIMAL,DataDictionary::TYPE_ENTIER];
        
        
        if(in_array ( $definition['type'] , $verifierType))
        {
            $this->testerTypeVariable();
        }
                
        $this->testerNullable();
        
        if($definition['type'] == DataDictionary::TYPE_CHAINE)
        {
            $this->testerLongueurCaractere();
        }
        
        if($definition['type'] == DataDictionary::TYPE_DATE)
        {
            $this->testerDate();
        }
        
        $this->testerExpReg();
        
        unset($this->definition);
        /**/
        return $this;
    }
       
    public function testerTypeVariable():self
    {
        
        
        $type = gettype($this->definition['valeur']);
        
        //debug($type,'type de la valeur stocké' );
        //debug($this->definition['type'],'type que la variable devrais etre' );
        
        if( $type != $this->definition['type'] )
        {
            $this->ajoutErreur($this->definition['nom'], 'type',[$type,$this->definition['type']]);
        }
        
        return $this;
    }
    
    public function testerNullable():self
    {
        if(is_null($this->definition['valeur']) && $this->definition['null']==false )
        {
            $this->ajoutErreur($this->definition['nom'], 'testerNullable');
        }
        
        return $this;
    }
    
    public function testerExpReg():self
    {
        if(is_null( $this->definition['valeur']))
        {
            return $this;
        }

        $patern = "%".$this->definition['validationRegEx']."%";
        
        //debug($patern,"patern");
        //debug($this->definition['valeur'],"valeur");
        
        
        if(!preg_match($patern, $this->definition['valeur']))
        {
            $this->ajoutErreur( $this->definition['nom'], 'testerExpReg',[$this->definition['valeur'], $this->definition['validationRegEx']]);
        }
        
        return $this;
    }
    
    public function testerLongueurCaractere():self
    {
        $taille = mb_strlen( $this->definition['valeur']);
        
        if(
            !is_null( $this->definition['tailleMin']) &&
            !is_null( $this->definition['tailleMax']) &&
            ($taille <  $this->definition['tailleMin'] || $taille >  $this->definition['tailleMax'])
            )
        {
            $this->ajoutErreur( $this->definition['nom'], 'tailleEntre', [$taille, $this->definition['tailleMin'], $this->definition['tailleMax']]);
            return $this;
        }
        
        if(
            !is_null( $this->definition['tailleMin']) &&
            $taille <  $this->definition['tailleMin']
            )
        {
            $this->ajoutErreur( $this->definition['nom'], 'tailleMinimal', [ $this->definition['tailleMin']]);
            return $this;
        }
        
        if(
            !is_null( $this->definition['tailleMax']) &&
            $taille >  $this->definition['tailleMax']
            )
        {
            $this->ajoutErreur( $this->definition['nom'], 'tailleMaximal', [ $this->definition['tailleMax']]);
            return $this;
        }
        
        return $this;
        
    }
    //1985-08-27 07:39:03
    public function testerDate(string $format = 'Y-m-d H:i:s' ):self
    {
       
        $d = \DateTime::createFromFormat($format,  $this->definition['valeur']);
        
        $erreurDateTime = \DateTime::getLastErrors();
        
        if($erreurDateTime['error_count']> 0 || $erreurDateTime['warning_count']> 0 || $d === false)
        {
            $this->ajoutErreur( $this->definition['nom'], 'date',[$this->definition['valeur'], $format]);
        }
        
        return $this;
    }
    
    public function isErreur():bool
    {
        if(count($this->erreurs) > 0)
        {
            return true;
        }
        
        return false;
    }
    
    protected function ajoutErreur(string $cle, string $regle, array $options =[])
    {
        $this->erreurs[] = new Erreurs($cle, $regle, $options);
    }
    
    
}

