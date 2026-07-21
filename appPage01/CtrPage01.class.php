<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/06/2021
 * Time: 06:24
 */

namespace appPage01;

use systeme\routeur\Route;
use systeme\controleur\Controleur;
use motif\modele\Motif;


class CtrPage01 extends Controleur
{
        
    
    public function __construct(Motif $motif)
    {
        
        $this->nomApplication = str_replace( "app" , "" , __NAMESPACE__ );
        
        parent::__construct($motif);
        
        $s=DIRECTORY_SEPARATOR;                
        $this->routeur->addRoute(new Route($this->nomApplication, "index", "", "", __DIR__."{$s}vue{$s}index.php"));
                
    }

    public function index(array $variables = [])
    {   
       
        $s=DIRECTORY_SEPARATOR;        
        $fichier = __DIR__."{$s}vue{$s}"."articles.html";        
        $model = file_get_contents($fichier);// systeme\objets\Persistance::getInstance()->LireTxt($fichier);
        
        ///$page = $this->motif;
        echo $this->renduPage("index",compact('model'));
        /**/
    }    

    
}