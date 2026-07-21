<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/12/2018
 * Time: 05:59
 */

namespace appObjet;


use systeme\routeur\Route;
use systeme\controleur\Controleur;
use systeme\exceptions\myException;
use appObjet\modele\MyIptc;
use appObjet\modele\MyPhoto;
use systeme\objets\Valider;
use appBlog;
use motif\modele\Motif;


class CtrObjet extends Controleur
{
        
    
    public function __construct(Motif $motif)
    {
        $this->nomApplication = str_replace( "app" , "" , __NAMESPACE__ );
        
        parent::__construct($motif);
        
        $s=DIRECTORY_SEPARATOR;
        
        $this->routeur->addRoute(new Route($this->nomApplication, "index", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}index.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "editerPhoto", "", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}editePhoto.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "montrerPhoto", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}montrePhoto.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "script", "", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}script.php"));
        
                
    }
    
    public function afficherPage($main)
    {
        $t = [];
        $t['index'] =array( 'lien' => $this->routeur->getRoute('index')->generateUri() , 'count' => 0 );
        $t['image'] =array( 'lien' => $this->routeur->getRoute('editerPhoto')->generateUri() , 'count' =>  0 );
        $t['script'] =array( 'lien' => $this->routeur->getRoute('script')->generateUri() , 'count' => 0 );        
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
        
        public function editerPhoto(array $variables = [])
        {
            
            debug($variables,'variable');
            //$filename = "C:\wamp64\www\site01\appObjet\vue\resource\img\X\C_Fanny.jpg";
            
            $model = new MyPhoto();
            
            if(array_key_exists('Description',$variables)|| array_key_exists('texteBulle',$variables))
            {
                
                debug($_FILES,'_FILES');
                /*
                $model->imagetelecharge($_FILES ['Photo']);
                $model->__set("Description", $variables['description']);
                $model->bulleTelecharge($_FILES ['Bulle']);
                $model->__set("Instructions", $variables['texteBulle']);
            
                
                debug($model,"model");
                
                foreach ($model->dictionnaire as $clé => $valeur)
                {
                    debug($model->listTags[$valeur],"{$clé} ({$valeur})");
                }
                /*
                foreach (array_keys($model->dictionnaire) as $cle)
                {
                    
                    
                    
                    $donnée= null;
                    if(!empty ( $model->__get($cle) ))
                    {
                        if(trim($donnée)!="")
                            echo $cle.": ".$donnée."</br>";
                    }
                }
                */
                
                $model->Dessinateur();
                $main = $this->renduPage("montrerPhoto",compact('model'));
                $this->afficherPage($main);
            }
            
            
            
            $main = $this->renduPage("editerPhoto",compact('model'));
            $this->afficherPage($main);
            
        }
        
        public function montrerPhoto(array $variables = [])
        {
            echo "rwlkdignlgdg";
            $model = new MyPhoto();
            
            $main = $this->renduPage("index",compact('model'));
            $this->afficherPage($main);
            
        }

        public function script(array $variables = [])
        {
                        
            $model = null;
            $main = $this->renduPage("script",compact('model'));
            $this->afficherPage($main);
            
        }
        
}