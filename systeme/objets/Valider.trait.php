<?php
namespace systeme\objets;



use systeme\validateur\Erreurs;

trait Valider
{
    
    protected $erreurs = [];
    
    public function tester(array $definition)
    {
        
        $cles = ['nom','type','tailleMin','tailleMax','null','vide','defaut','commentaires','validationRegEx','option','valeur'];
        
        foreach ($cles as $nomCle)
        {
            if(!array_key_exists($nomCle, $definition))
            {
                throw new \Exception(" '{$nomCle}' n'existe pas dans la definition ");
            }
        }
        
       /*
        const TYPE_ENTIER ='INT';
        const TYPE_DECIMAL ='FLOAT';
        const TYPE_DATE ='DATE';
        const TYPE_CHAINE ='STRING';
        const TYPE_BINAIRE ='BINAIRE';
        const TYPE_ENUMERATION ='ENUMERATION';
        const TYPE_BOOLEEN ='BOOL';
        /**/
        
        $this->testerNullable($definition);
        
        if($definition['type'] == DataDictionary::TYPE_CHAINE)
        {
            $this->testerLongueurCaractere($definition);
        }
        
        if($definition['type'] == DataDictionary::TYPE_DATE)
        {
            $this->testerDate($definition);
        }
        
        $this->testerExpReg($definition);
        
    }
    
    public function testerNullable($definition):self
    {        
        if(is_null($definition['valeur']) && $definition['null']==false )
        {
            $this->ajoutErreur($definition['nom'], 'testerNullable');
        }
        
        return $this;
    }
    
    public function testerExpReg($definition):self
    {
        if(is_null($definition['valeur']))
        {
            return $this;
        }
        
        $patern = "/^{$definition['validationRegEx']}$/";
        
        if(!preg_match($patern, $this->parametres['valeur']))
        {
            $this->ajoutErreur($definition['nom'], 'testerExpReg');
        }
        
        return $this;
    }
    
    public function testerLongueurCaractere($definition):self
    {
        $taille = mb_strlen($definition['valeur']);
        
        if(
            !is_null($definition['tailleMin']) &&
            !is_null($definition['tailleMax']) &&
            ($taille < $definition['tailleMin'] || $taille > $definition['tailleMax'])
            )
        {
            $this->ajoutErreur($definition['nom'], 'testerLongueurCaractereEntre', [$definition['tailleMin'],$definition['tailleMax']]);
            return $this;
        }
        
        if(
            !is_null($definition['tailleMin']) &&
            $taille < $definition['tailleMin']
            )
        {
            $this->ajoutErreur($definition['nom'], 'testerLongueurCaractereMinimal', [$definition['tailleMin']]);
            return $this;
        }
        
        if(
            !is_null($definition['tailleMax']) &&
            $taille > $definition['tailleMax']
            )
        {
            $this->ajoutErreur($definition['nom'], 'testerLongueurCaractereMaximal', [$definition['tailleMax']]);
            return $this;
        }
        
        return $this;
        
    }
    
    public function testerDate($definition,string $format = 'Y-m-d H:i:s' ):self
    {
       
        $d = \DateTime::createFromFormat($format, $definition['valeur']);
        
        $erreurDateTime = \DateTime::getLastErrors();
        
        if($erreurDateTime['error_count']> 0 || $erreurDateTime['warning_count']> 0 || $d === false)
        {
            $this->ajoutErreur($definition['nom'], 'date',[$format]);
        }
        
        return $this;
    }
    
    public function isErreur():bool
    {
        return empty($this->erreurs);
    }
    
    protected function ajoutErreur(string $cle, string $regle, array $options =[])
    {
        $this->erreurs[$cle] = new Erreurs($cle, $regle, $options);
    }
    
    
}

