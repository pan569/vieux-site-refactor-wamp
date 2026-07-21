<?php
namespace systeme\routeur;

/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 19/12/2018
 * Time: 06:42
 */

class Route
{
    
    //nom
    protected $nom;
    
    public function getNom():string
    {
        return $this->nom;
    }
    public function  set(string $nom):void
    {
        $this->nom = $nom;
    }
    
    //fonction de rappele
    protected $callback;
    
    public function getCallback():string
    {
        return $this->callback;
    }
    public function  setCallback(string $callback):void
    {
        $this->callback = $callback;
    }
    
    //liste des noms des variables utilisé par la fonction de rappele
    protected $variableCallback = [];
    
    public function getVariableCallback():array
    {
        return $this->variableCallback;
    }
    public function setVariableCallback(array $variableCallback):void
    {
        
        $this->variableCallback = $variableCallback;
    }
    public function addVariableCallback(string $variableCallback):void
    {
    
        //debug($variableCallback, "variableCallback de ".$this->nom." Route.class.php ligne 53");
        
        //on recherche la liste des variables avec leur paterne de controle {var:regex}
        $resPregMatch=null;
        preg_match_all('`\{([^{]+)\}`',$variableCallback,$resPregMatch);
        //debug($resPregMatch, "resPregMatch de ".$this->nom." Route.class.php ligne 53");
        
        $variablesTrouvé =$resPregMatch[1];
        
        // memorise dans le tableau de variable de la route : $this->variables[NomVariabe]=REGEXVariable;        
        foreach ($variablesTrouvé as $variable)
        {           
            $res = explode(':', $variable);
            
            $this->variableCallback[$res[0]]=$res[1];
        }
        
        
        
    }
    
    //Paterne du chemin permetant de dededuire les variables du callback
    protected $paternCheminFonction;
    
    public function getPaternCheminFonction():string
    {
        return $this->paternCheminFonction;
    }
    public function  setPaternCheminFonction(string $paternCheminFonction):void
    {
        $this->paternCheminFonction = $paternCheminFonction;
    }
    
    //chemin de la vue corespondant a la fonction de rappele.
    protected $vue;
    
    public function getVue():string
    {
        return $this->vue;
    }
    public function  setVue(string $vue):void
    {
        $this->vue = $vue;
    }
    
    
    public function __construct(string $nom, string $callback, string $variableCallback, string $paternCheminFonction, string $vue)
    {

        $this->nom = $nom;
        $this->callback = $callback;
        $this->addVariableCallback($variableCallback);        
        $this->paternCheminFonction = $paternCheminFonction;
        $this->vue = $vue;
    }
            
    public function generateUri(array $variables=[]):string
    {
        //debug($variables,"Route ligne 111 Variables");
        $url ="index.php?application={$this->nom}&fonction={$this->callback}";
               
        $var = null;
        if(count($this->variableCallback)!=0 && count($variables)!=0)
        {            
            
            //debug($url,' Route.class.php L118 url');
            //debug($variables,' Route.class.php L119 variables');
            //debug($this->variableCallback,' Route.class.php L120 variableCallback');
            
            foreach (array_keys($this->variableCallback) as $nomVariable)
            {
                //debug($nomVariable,"Route ligne 124 nomVariable");
                
                if(array_key_exists ( $nomVariable , $variables ))
                {
                    $var.= "{$nomVariable}:{$variables[$nomVariable]}|";
                }
                else 
                {
                    $var.= "{$nomVariable}:?;";
                }
                
            }
            
            //debug($var,' Route.class.php L137 var');
            
            
            $url.="&variables={$var}";
        }
        
        return $url;
    }
    
    
    


}