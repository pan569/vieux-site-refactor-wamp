<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/12/2018
 * Time: 05:59
 */

namespace motif;

use systeme\routeur\Route;
use systeme\controleur\Controleur;
use motif\modele\Motif;


class CtrMotif extends Controleur
{
        
    
    public function __construct(Motif $motif)
    {
        $this->nomApplication = str_replace( "app" , "" , __NAMESPACE__ );
                
        parent::__construct($motif);
        
        $s=DIRECTORY_SEPARATOR;        
        $this->routeur->addRoute(new Route($this->nomApplication, "index", "", "", __DIR__."{$s}vue{$s}index.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "modifConfiguration", "", "", __DIR__."{$s}vue{$s}configuration.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "modifCredit", "", "", __DIR__."{$s}vue{$s}credit.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "modifEntete", "", "", __DIR__."{$s}vue{$s}entete.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "modifMenu", "{menu:[\w0-9]+}", "", __DIR__."{$s}vue{$s}menu.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "modifPied", "{menu:[\w0-9]+}", "", __DIR__."{$s}vue{$s}menu.php"));
        
        
        
                
    }
    
    public function afficherPage($main)
    {   
        $t = [];
        $t['Index'] = array( 'lien' => $this->routeur->getRoute('index')->generateUri() , 'count' => '');
        $t['configuration'] = array( 'lien' => $this->routeur->getRoute('modifConfiguration')->generateUri() , 'count' => '');
        $t['Credit'] = array( 'lien' => $this->routeur->getRoute('modifCredit')->generateUri() , 'count' => '');
        $t['Entete'] = array( 'lien' => $this->routeur->getRoute('modifEntete')->generateUri() , 'count' => '');
        
        $this->motif['aside'] = $t;
        
        //\resources\themes/theme.monBog/
        $dossier = "/appBotanique/vue/resources";
        $this->motif->ajoutFichier($dossier);
        /**/
                
        $body = $this->renduPage("body",compact('main'));        
        echo $this->renduPage("page",compact('body'));
        
    }
    
    
    public function index(array $variables = [])
    {   
        $model = $this->motif;
        
        $main = $this->renduPage("index",compact('model'));
        $this->afficherPage($main);
        
    }
    
    public function modifConfiguration(array $variables = [])
    {
        //debug($variables,"CtrMotif->modifConfiguration() variables");
        
        $model = $this->motif;
        
                
        if(array_key_exists('form',$variables))
        {
            
            
            //debug($model['Configuration'],"CtrMotif->modifConfiguration() model['Configuration']");
                    
            //Traitement des autres variables
            /*
            foreach ($model['Configuration']->getCle() as $clé)
            {                            
                //enregistrement de la donnée dans $model
                $model['Configuration']->set($clé,$variables[$clé]);        
            }
            */
            
            $t=[];           
            foreach (array_keys($model['Configuration']) as $clé)
            {
                //enregistrement de la donnée dans $model                
                $t[$clé]= $variables[$clé];                
            }            
            $model['Configuration'] = $t;
            
            //sauvegarde des données
            /*$model['Configuration']->SauvegardeElement();*/
            $model->SauvegardeElement('Configuration');
                        
            //redirection (vers la page index)            
            $Callback ='index';
            $variableCallback = [];
            $this->redirigerRoute(compact('routeur','Callback','variableCallback'));
            /**/            
        }
        
        $main = $this->renduPage("modifConfiguration",compact('routeur','model'));
        $this->afficherPage($main);
        
    }
    
    public function modifCredit(array $variables = [])
    {   
        //debug($variables,"CtrMotif->modifCredit() variables");
        
        $model = $this->motif;
        
        if(array_key_exists('form',$variables))
        {
            
            $t=[];
            foreach (array_keys($model['Proprietaire']) as $clé)
            {
                //enregistrement de la donnée dans $model
                $t[$clé]= $variables["Proprietaire_$clé"];
            }
            debug($t,"t - Proprietaire");
            $model['Proprietaire'] = $t;
            $model->SauvegardeElementAttribut('Credits','Proprietaire');
            
            
            $t=[];
            foreach (array_keys($model['Developpeur']) as $clé)
            {
                //enregistrement de la donnée dans $model
                $t[$clé]= $variables["Developpeur_$clé"];
            }
            debug($t,"t - Developpeur");
            $model['Developpeur'] = $t;
            $model->SauvegardeElementAttribut('Credits','Developpeur');
            
            
            $t=[];
            foreach (array_keys($model['Hebergeur']) as $clé)
            {
                //enregistrement de la donnée dans $model
                $t[$clé]= $variables["Hebergeur_$clé"];
            }
            debug($t,"t - Hebergeur");
            $model['Hebergeur'] = $t;
            $model->SauvegardeElementAttribut('Credits','Hebergeur');
            
            //redirection (vers la page index)            
            $Callback ='index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback','variableCallback'));
            /**/
        }
        
        
        $main = $this->renduPage("modifCredit",compact('model'));
        $this->afficherPage($main);
        /**/
    }
    
    public function modifEntete(array $variables = [])
    {        
        $model = $this->motif;
        
        if(array_key_exists('form',$variables))
        {
            /*
            //Traitement des autres variables
            foreach ($model['Entete']->getCle() as $clé)
            {
                //enregistrement de la donnée dans $model
                $model['Entete']->set($clé,$variables[$clé]);        
            }
            
            
            //sauvegarde des données
            $model['Entete']->SauvegardeElement();
            /**/
            
            $t=[];
            foreach (array_keys($model['Entete']) as $clé)
            {
                //enregistrement de la donnée dans $model
                $t[$clé]= $variables[$clé];
            }
            $model['Entete'] = $t;
            
            //sauvegarde des données            
            $model->SauvegardeElement('Entete');
            
            
            //redirection (vers la page index)            
            $Callback ='index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback','variableCallback'));
            /**/
        }
        
        $main = $this->renduPage("modifEntete",compact('routeur','model'));
        $this->afficherPage($main);
    }

    public function modifMenu(array $variables = []) 
    {
        $AdministrationSite = $this->motif;
        $model=$AdministrationSite['Menus'][$variables['menu']];
        
        if(array_key_exists('form',$variables))
        {
            //Traitement des autres variables
            if(array_key_exists('description',$variables))
                $AdministrationSite['Menus'][$variables['menu']]->set('description',$variables['description']);
            
            if(array_key_exists('image',$variables))
                $AdministrationSite['Menus'][$variables['menu']]->set('image',$variables['image']);
                
            if(array_key_exists('css',$variables))
                $AdministrationSite['Menus'][$variables['menu']]->set('css',$variables['css']);
            
            if(array_key_exists('cible',$variables))
                $AdministrationSite['Menus'][$variables['menu']]->set('cible',$variables['cible']);
                
            debug($AdministrationSite['Menus'][$variables['menu']],"CtrAdministrationSite->modifEntete:Model postEnregistrement");
            
            
            //sauvegarde des données
            $AdministrationSite['Menus'][$variables['menu']]->SauvegardeElement();
            
            //redirection (vers la page index)
            $Callback ='index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback','variableCallback'));
            /**/
            
        }
        
        $main = $this->renduPage("modifMenu",compact('routeur','model'));
        $this->afficherPage($main);
    }
    
    public function modifPied(array $variables = [])
    {
        $AdministrationSite = $this->motif;
        $model=$AdministrationSite['Pied'][$variables['menu']];
        
        if(array_key_exists('form',$variables))
        {
            
            //Traitement des autres variables
            if(array_key_exists('description',$variables))
                $AdministrationSite['Pied'][$variables['menu']]->set('description',$variables['description']);
                
                if(array_key_exists('image',$variables))
                    $AdministrationSite['Pied'][$variables['menu']]->set('image',$variables['image']);
                    
                    if(array_key_exists('css',$variables))
                        $AdministrationSite['Pied'][$variables['menu']]->set('css',$variables['css']);
                        
                        if(array_key_exists('cible',$variables))
                            $AdministrationSite['Pied'][$variables['menu']]->set('cible',$variables['cible']);
                            
                            debug($AdministrationSite['Pied'][$variables['menu']],"CtrAdministrationSite->modifEntete:Model postEnregistrement");
                            
                            
                            //sauvegarde des données
                            $AdministrationSite['Pied'][$variables['menu']]->SauvegardeElement();
                            
                            //redirection (vers la page index)
                            $Callback ='index';
                            $variableCallback = [];
                            $this->redirigerRoute(compact('Callback','variableCallback'));
                            
                            
        }
        
        $main = $this->renduPage("modifMenu",compact('model'));
        $this->afficherPage($main);
    }

}