<?php

namespace systeme;


use systeme\objets\Collection;
use motif\modele\Motif;


/**
 *
 * @author Ulysse1976
 * 
 * Ce fichier est le neud du systeme (du site)
 * 
 *  son role est :
 *  - [ ] De charger l'autoloader
 *  - [ ] De charger le systeme de session
 *  - [x] De centraliser toute les données utile au bon fonctionnement du systeme
 *  - [X] Gerere le controleur
 *  - [ ] Gere le rendorer
 *  
 *  systeme interne :
 *  - [X]systeme de singleton
 *  - [ ]Conteneur de dépendance 
 *  
 */

class Noyau
{
    
    const FICHIER_INI = "";
    
    private static $_instance;
    /*
     * singleton de la classe
     */
    public static function getInstance():Noyau
    {
        if(is_null(self::$_instance))
            self::$_instance = new Noyau();
            
            return self::$_instance;
    }
    
    protected $motif;
    
    public $données;
    /**
     *
     *
     * @param string $clee
     * @return unknown/false
     */
    public function getDonnées(string $clee)
    {
        return $this->données->get($clee);
    }
    
    /**
     * liste des controleurs d'application.
     * @var array
     */    
    protected $controleurs = [];    
    public function getControleurs()
    {
        return $this->controleurs;
    }
    
    public function getControleur(string $NomControleur)
    {
        //debug($this->controleurs,"liste des controleurs");
        //debug($NomControleur,"non du controleur cherché");
        
        
        foreach ($this->controleurs as $controleur)
        {                       
            if($controleur->getNomApplication() == $NomControleur)
            {
                
                //debug($controleur,"controleur trouvé");
                return $controleur;
            }
        }
    }
    
    protected $routes = [];
    
    public function __construct()
    {
        $this->données = new Collection();
        
        $this->motif = new Motif('ini_monBlog.xml');
                
        $this->données['#DataBaseServeur']=$this->motif['Configuration']['DataBaseServeur'];// "localhost";
        $this->données['#DatabasePort']="3307";
        $this->données['#DataBaseNon']=$this->motif['Configuration']['DataBaseNon'];// "mytest";
        $this->données['#DatabaseCharset']="utf8";
        $this->données['#DataBaseUtilisateur']=$this->motif['Configuration']['DataBaseUtilisateur'];// "root";
        $this->données['#DataBaseMdP']=$this->motif['Configuration']['DataBaseMdP'];// "";

        /**/
        
        //- [ ] Gerere le controleur
        //## initialisation des controleurs d'application ##
        
        ////////**************** NE PAs CONSTRUIRE LES CONTROLEURS ICI ****************\\\\\\\\\
        
        $this->controleurs[] = new \motif\CtrMotif($this->motif);
        $this->controleurs[] = new \appPage01\CtrPage01($this->motif);
        $this->controleurs[] = new \appPage02\CtrPage02($this->motif);
        $this->controleurs[] = new \appPage03\CtrPage03($this->motif);
        $this->controleurs[] = new \appLabjc\CtrLabjc($this->motif);
        $this->controleurs[] = new \appObjet\CtrObjet($this->motif);
        $this->controleurs[] = new \appBlog\CtrBlog($this->motif);
        $this->controleurs[] = new \appAlbum\CtrAlbum($this->motif);
        $this->controleurs[] = new \appBotanique\CtrBotanique($this->motif);
        $this->controleurs[] = new \appAnnuaire\CtrlAnnuaire($this->motif);
        $this->controleurs[] = new \appCours\CtrCours($this->motif);
        //$this->controleurs[] = new \appObjet3\CtrObjet3();                
        
        //$this->memRoutes();
        
        

    }
   
    public function navig()
    {
        //regarder si 'appication' existe dans  le tableau _GET
        if(array_key_exists ( 'application' , $_GET) )
        {
            $application=$_GET['application'];
            
            $fonction=null;
            //regarde si 'fonction' existe dans le tableau _GET
            if(array_key_exists ( 'fonction' , $_GET) )
                $fonction=$_GET['fonction'];
            
                
            $tabVariables = [];
            //regarde si 'variables' existe dans le tableau _GET
            if(array_key_exists ( 'variables' , $_GET) )
            {
                $variables=$_GET['variables'];
                //debug($variables,"Noyau ligne 144 variables");
                $variableCallback =$this->getControleur($application)->getRouteur()->getRoute($fonction)->getVariableCallback();
                //debug($variableCallback,"Noyau ligne 147 variableCallback");
               
                $match=null;
                $patern="%[\w\s]+:[\w\s-]+%";        
                preg_match_all($patern, $variables,$match);                       
                //debug($match,"Noyau ligne 152 match");
               

                
                foreach ($match as $var)
                {            
                    foreach ($var as $variableCallback)
                    {                
                        $t2=explode ( ":" , $variableCallback );
                        //debug($t2,"Noyau ligne 161 t2");
                        $tabVariables[$t2[0]]=$t2[1];
                    }
                }
                //debug($tabVariables,"Noyau ligne 165 tabVariables");
                /**/
            }
            
            if(count($_POST) != 0)
            {
                //debug($_POST);
                
                foreach ($_POST as $var => $val)
                {
                    $tabVariables[$var]=$val;
                }
            }
        }
        else 
        {
            $application="Page02";
            $fonction="index";
            $tabVariables = [];                
        }
        
        $this->getControleur($application)->ExecCallable($fonction,$tabVariables);
        /*
        $controleur = $this->getControleur($application);
        $controleur->ExecCallable($fonction,$tabVariables);//->getRoute($fonction)->ExecCallable($variables);
        /**/
    }

    
    /* FONCTION POUR DEBEUGAGE */
    /* ####################### */
    public function memRoutes()
    {
        foreach ($this->controleurs as $controleur)
        {
            foreach ($controleur->getRouteur()->getRoutes() as $route)
            {
                $this->routes[] = $route;//recupere les routes du routeur du controleur.
            }
        }           
    }
    
    public function memAllUrl()
    {
        
        foreach ($this->routes as $route)
        {
           
            $var=[];
            echo "- ".$route->generateUri($var)."<br>";
        }
        
        
    }
}

