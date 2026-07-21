<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/06/2021
 * Time: 06:24
 */

namespace appBlog;

use systeme\routeur\Route;
use systeme\utilitaire\MyDateTime;
use systeme\controleur\Controleur;
use appBlog\modele\Blog;
use motif\modele\Motif;


class CtrBlog extends Controleur
{
        
    
    public function __construct(Motif $motif)
    {
        $this->nomApplication = str_replace( "app" , "" , __NAMESPACE__ );
        
        parent::__construct($motif);
        
        $s=DIRECTORY_SEPARATOR;
        
        $this->routeur->addRoute(new Route($this->nomApplication, "index", "{p:[0-9]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}index.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "montrer", "{id:[\w]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}montre.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "ajouter", "{id:[\w]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}edit.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "editer", "{id:[\w]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}edit.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "supprimer", "{id:[\w]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}edit.php"));
        
        
    }
    
    public function afficherPage($main)
    {
        
        $t = [];        
        $t['vide'] = array( 'lien' => $this->routeur->getRoute('index')->generateUri(), 'count' => 0);
        $this->motif['aside'] = $t;
        
        $body = $this->renduPage("body",compact('main'));
        
        echo $this->renduPage("page",compact('body'));
        
    }

    public function index(array $variables = [])
    {   
        
        //debug($this->motif['fichiersCss'],"liste des fichier css");
        
        $model = Blog::PageResultat(isset($variables['p']) ? $variables['p'] : 1,12);
        $main = $this->renduPage("index",compact('model'));                
        $this->afficherPage($main);
        
    }
    
    public function montrer(array $variables = [])
    {        
        $model = new Blog($variables['id']);
        $main = $this->renduPage("montrer",compact('model'));
        $this->afficherPage($main);
        
    }
    
    public function ajouter (array $variables)
    {        
        $model = new Blog();
        
        if(array_key_exists('titre',$variables)|| array_key_exists('slug',$variables)|| array_key_exists('contenu',$variables))
        {
            
            $model->set('auteur', 'ulysse1976');
            $model->set('titre', $variables['titre']);
            $model->set('slug', $variables['slug']);
            $model->set('contenu', $variables['contenu']);
            $model->set('dateCreation', MyDateTime::getInstance()->getDateTime());
            $model->set('dateModification', MyDateTime::getInstance()->getDateTime());
            
            
            if($model->INSERT())
            {
                $model = Blog::SELECT();
                
                $Callback ='index';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
            
        }
        
        $main = $this->renduPage("ajouter",compact('model'));
        $this->afficherPage($main);
    }
    
    public function editer (array $variables)
    {     
        $model = new Blog($variables['id']);;
        
        if(array_key_exists('titre',$variables)|| array_key_exists('slug',$variables)|| array_key_exists('contenu',$variables))
        {
            
            //debug($model,"CtrBog->editer:model");
            
            $model->set('auteur', $model['auteur']);
            $model->set('titre', $variables['titre']);
            $model->set('slug', $variables['slug']);
            $model->set('contenu', $variables['contenu']);
            $model->set('dateCreation', $model['dateCreation']);
            $model->set('dateModification', MyDateTime::getInstance()->getDateTime());
            
            
            if($model->UPDATE())
            {
                $model = Blog::SELECT();
                
                $Callback ='index';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
            
        }
        
        $main = $this->renduPage("editer",compact('model'));
        $this->afficherPage($main);
        
        
        
    }
    
    public function supprimer (array $variables)
    {
        $model = new Blog();
        $model->SELECT_id($variables['id']);
        
        if(array_key_exists('method',$variables))
        {
            debug('je suis ici');
            
            $model->DELETE();
            
            //$this->messageFlash->ajoutMessageSucces("L'article as bien été supprimé");
            
            $Callback ='index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback','variableCallback'));
        }
        
        $main = $this->renduPage("supprimer",compact('model'));
        $this->afficherPage($main);
        
    }

    
}