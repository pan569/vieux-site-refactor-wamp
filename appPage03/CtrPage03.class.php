<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/06/2021
 * Time: 06:24
 */

namespace appPage03;

use systeme\routeur\Route;
use systeme\controleur\Controleur;
use appPage03\modele\Page03;
use motif\modele\Motif;


class CtrPage03 extends Controleur
{
        
    
    public function __construct(Motif $motif)
    {
        $this->nomApplication = str_replace( "app" , "" , __NAMESPACE__ );
        
        parent::__construct($motif);
        
        $s=DIRECTORY_SEPARATOR;
        
        $this->routeur->addRoute(new Route($this->nomApplication, "index", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}index.php"));
        
                
    }
    
    public function afficherPage($main)
    {
        
        $t = [];
        $t['vide'] =array( 'lien' => $this->routeur->getRoute('index')->generateUri() , 'count' => 0);
        $this->motif['aside'] = $t;
        
        $body = $this->renduPage("body",compact('main'));
        
        echo $this->renduPage("page",compact('body'));
        
    }
    

    public function index(array $variables = [])
    {   
        
        $model = new Page03();
        $main = $this->renduPage("index",compact('model'));                
        $this->afficherPage($main);
        
    }    

    
}