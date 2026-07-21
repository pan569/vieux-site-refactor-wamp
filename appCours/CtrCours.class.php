<?php
namespace appCours;

use systeme\controleur\Controleur;
use systeme\routeur\Route;
use motif\modele\Motif;

/**
 *
 * @author ulysse
 *        
 */
class CtrCours extends Controleur
{

    /**
     */
    public function __construct(Motif $motif)
    {
        $s=DIRECTORY_SEPARATOR;
        
        $this->nomApplication = str_replace( "app" , "" , __NAMESPACE__ );
        
        $motif->ajoutFichierCSS("{$s}appCours{$s}vue{$s}resources");
        $motif->ajoutFichierJS("{$s}appCours{$s}vue{$s}resources");
        parent::__construct($motif);
                
        $this->routeur->addRoute(new Route($this->nomApplication, "index", "", "", __DIR__."{$s}vue{$s}index.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "afficheurCode", "{fichier:[\w]+}", "", __DIR__."{$s}vue{$s}afficheurCode.php"));
        //$this->routeur->addRoute(new Route($this->nomApplication, "JQcours", "{fichier:[\w]+}", "", __DIR__."{$s}vue{$s}resources{$s}données{$s}JQcours04.html"));


    }
    
    public function afficherPage($main)
    {
        
        $t = [];
        $t['index'] =array( 'lien' => $this->routeur->getRoute('index')->generateUri() , 'count' => 0 );
        $t['afficheurCode'] =array( 'lien' => $this->routeur->getRoute('afficheurCode')->generateUri(['fichier' => 'JQcours04']) , 'count' => 0 );
        
        $this->motif['aside'] = $t;        
        $body = $this->renduPage("body",compact('main'));        
        echo $this->renduPage("page",compact('body'));
        
    }
    
    public function index(array $variables = [])
    {        
        $model = null;
        $main = $this->renduPage("index",compact('model'));
        $this->afficherPage($main);        
    }
    
    public function afficheurCode(array $variables = [])
    {
        $model = $variables;
        $main = $this->renduPage("afficheurCode",compact('model'));
        $this->afficherPage($main);
    }

    public function JQcours(array $variables = [])
    {
        $s=DIRECTORY_SEPARATOR;        
        echo file_get_contents( __DIR__."{$s}vue{$s}resources{$s}données{$s}{$variables['fichier']}.html");// systeme\objets\Persistance::getInstance()->LireTxt($fichier);
        
    }
    
}

