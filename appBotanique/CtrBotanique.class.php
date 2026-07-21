<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/12/2018
 * Time: 05:59
 */

namespace appBotanique;


use systeme\objets\Persistance;
use systeme\routeur\Route;
use systeme\controleur\Controleur;
use appBotanique\modele\Famille;
use appBotanique\modele\Genre;
use appBotanique\modele\Espece;
use appBotanique\modele\Plante;
use appBotanique\modele\Interet;
use motif\modele\Motif;


class CtrBotanique extends Controleur
{
    
    protected $dossierVue;
    
    public function __construct(Motif $motif)
    {
        // nomApplication est maintenant déduit automatiquement par le parent
        parent::__construct($motif);
               
        $s=DIRECTORY_SEPARATOR;        
        $this->dossierVue = __DIR__."{$s}vue{$s}";
        
        $this->routeur->addRoute(new Route($this->nomApplication, "index", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", $this->dossierVue."index.php"));
        
        $this->routeur->addRoute(new Route($this->nomApplication, "indexFamille", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", $this->dossierVue."ListeFamille.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "montrerFamille", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."montreFamille.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "ajouterFamille", "", "", $this->dossierVue."editeFamille.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "editerFamille", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."editeFamille.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "supprimerFamille", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."editeFamille.php"));
        
        $this->routeur->addRoute(new Route($this->nomApplication, "indexGenre", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", $this->dossierVue."ListeGenre.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "montrerGenre", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."montreGenre.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "ajouterGenre", "", "", $this->dossierVue."editeGenre.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "editerGenre", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."editeGenre.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "supprimerGenre", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."editeGenre.php"));
        
        $this->routeur->addRoute(new Route($this->nomApplication, "indexEspece", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", $this->dossierVue."ListeEspece.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "montrerEspece", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."montreEspece.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "ajouterEspece", "", "", $this->dossierVue."editeEspece.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "editerEspece", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."editeEspece.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "supprimerEspece", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."editeEspece.php"));
        
        $this->routeur->addRoute(new Route($this->nomApplication, "indexPlante", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", $this->dossierVue."ListePlante.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "montrerPlante", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."montrePlante.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "ajouterPlante", "", "", $this->dossierVue."editePlante.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "editerPlante", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."editePlante.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "supprimerPlante", "{id:[0-9]+}", "%([\w]+)\.([\w]+)\?([\w]+=[\w]+)&([\w]+=[\w]+)%", $this->dossierVue."editePlante.php"));
        
        $this->routeur->addRoute(new Route($this->nomApplication, "especeParFamille", "", "", $this->dossierVue."montreEspeceFamille.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "arbre", "{page:[0-9]+}", "%([\w]+)\.([\w]+)\%", $this->dossierVue."arbre.php"));
        
    }

    public function afficherVue($main)
    {
        $t = [];
        $t['Liste des familles'] =array( 'lien' => $this->routeur->getRoute('indexFamille')->generateUri() , 'count' => Persistance::getInstance()->COUNT('famille')['Nbr']);        
        $t['Liste des genres'] =array( 'lien' => $this->routeur->getRoute('indexGenre')->generateUri() , 'count' => Persistance::getInstance()->COUNT('genre')['Nbr']);        
        $t['Liste des especes'] =array( 'lien' => $this->routeur->getRoute('indexEspece')->generateUri() , 'count' => Persistance::getInstance()->COUNT('espece')['Nbr']);        
        $t['Especes par familles'] =array( 'lien' => $this->routeur->getRoute('especeParFamille')->generateUri() , 'count' => Persistance::getInstance()->COUNT('espece')['Nbr']);        
        $t['Liste des plantes'] =array( 'lien' => $this->routeur->getRoute('indexPlante')->generateUri() , 'count' => Persistance::getInstance()->COUNT('plante')['Nbr']);        
        $t['arbre'] =array( 'lien' => $this->routeur->getRoute('arbre')->generateUri(), 'count' => 0);
        $this->motif['aside'] = $t;
         
        $dossier = "/appBotanique/vue/resources";
        $this->motif->ajoutFichier($dossier);
        
        $body = $this->renduPage("body",compact('main'));
        
        echo $this->renduPage("page",compact('body'));
        
    }
    
    public function index(array $variables = [])
    {
        $vue = $this->renduPage("index",compact(''));        
        $this->afficherVue($vue);
    }
    
    
    public function indexFamille(array $variables = [])
    {
        if(array_key_exists ( "page" , $variables ))
        {
            $model = Famille::SELECT_PAGE($variables["page"]);
        }
        else
        {
            $model = Famille::listeTrié();
        }             
        
        $vue = $this->renduPage("indexFamille",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function montrerFamille (array $variables)
    {
        $model = new Plante($variables['id']);
        $vue = $this->renduPage("montrer",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function ajouterFamille (array $variables)
    {
        $model = new Famille();
        
        if(array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
        {            
            $model->set('LATIN', $variables['LATIN']);
            $model->set('FRANCAIS', $variables['FRANCAIS']);
            
            if($model->INSERT())
            {
                $model = Famille::SELECT();
                $Callback ='indexFamille';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
        }
        
        $vue = $this->renduPage("ajouterFamille",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function editerFamille (array $variables)
    {
        $model = new Famille();
        $model->SELECT_id($variables['id']);
        
        if(array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
        {
            $model->set('LATIN', $variables['LATIN']);
            $model->set('FRANCAIS', $variables['FRANCAIS']);
            
            if($model->UPDATE())
            {
                $model = Famille::SELECT();
                $Callback ='indexFamille';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
        }
        
        $vue =  $this->renduPage("editerFamille",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function supprimerFamille (array $variables)
    {
        $model = new Famille();
        $model->SELECT_id($variables['id']);
        
        if(array_key_exists('method',$variables))
        {
            $model->DELETE();
            $Callback ='indexFamille';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback','variableCallback'));
        }
        
        $vue = $this->renduPage("supprimerFamille",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function indexGenre(array $variables = [])
    {
        if(array_key_exists ( "page" , $variables ))
        {
            $model = Genre::SELECT_PAGE($variables["page"]);
        }
        else
        {
            $model = Genre::listeTrié();
        }
        
        $vue = $this->renduPage("indexGenre",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function montrerGenre (array $variables)
    {
        $model = new Plante($variables['id']);
        $vue = $this->renduPage("montrer",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function ajouterGenre (array $variables)
    {
        $listeFamille = Famille::liste();        
        $model = new Genre();
        
        if(array_key_exists('ID_FAMILLE',$variables)|| array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
        {
            $model->set('ID_FAMILLE',  (int)$variables['ID_FAMILLE']);
            $model->set('LATIN', $variables['LATIN']);
            $model->set('FRANCAIS', $variables['FRANCAIS']);
            
            if($model->INSERT())
            {
                $model = Genre::SELECT();
                $Callback ='indexGenre';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
        }
        
        $vue = $this->renduPage("ajouterGenre",compact('model','listeFamille'));
        $this->afficherVue($vue);
    }
    
    public function editerGenre (array $variables)
    {
        $listeFamille = Famille::liste();
        $model = new Genre();
        $model->SELECT_id($variables['id']);
        
        if(array_key_exists('ID_FAMILLE',$variables)|| array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
        {
            $model->set('ID_FAMILLE',  (int)$variables['ID_FAMILLE']);
            $model->set('LATIN', $variables['LATIN']);
            $model->set('FRANCAIS', $variables['FRANCAIS']);
            
            if($model->UPDATE())
            {
                $model = Genre::SELECT();
                $Callback ='indexGenre';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
        }
        
        $vue = $this->renduPage("editerGenre",compact('model','listeFamille'));
        $this->afficherVue($vue);
    }
    
    public function supprimerGenre (array $variables)
    {
        $model = new Genre();
        $model->SELECT_id($variables['id']);
        
        if(array_key_exists('method',$variables))
        {
            $model->DELETE();
            $Callback ='indexGenre';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback','variableCallback'));
        }
        
        $vue = $this->renduPage("supprimerGenre",compact('model'));
        $this->afficherVue($vue);
    }
        
    public function indexEspece(array $variables = [])
    {
        if(array_key_exists ( "page" , $variables ))
        {
            $model = Espece::SELECT_PAGE($variables["page"]);
        }
        else
        {
            $model = Espece::listeTrié();
        }
        
        $vue = $this->renduPage("indexEspece",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function montrerEspece (array $variables)
    {
        $model = new Espece();
        $model->SELECT_id($variables['id']);
        $vue = $this->renduPage("montrerEspece",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function ajouterEspece (array $variables)
    {
        $listeGenre = Genre::liste();
        $model = new Espece();
        
        if(array_key_exists('ID_GENRE',$variables)|| array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
        {
            $model->set('ID_GENRE',  (int)$variables['ID_GENRE']);
            $model->set('LATIN', $variables['LATIN']);
            $model->set('FRANCAIS', $variables['FRANCAIS']);
                        
            if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
            {
                if($_FILES['FEUILLE']['size'] <= 500000)
                {
                    $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                }
            }
            if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
            {
                if($_FILES['FLEUR']['size'] <= 500000)
                {
                    $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
            {
                if($_FILES['FRUIT']['size'] <= 500000)
                {
                    $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
            {
                if($_FILES['TIGE']['size'] <= 500000)
                {
                    $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
            {
                if($_FILES['RACINE']['size'] <= 500000)
                {
                    $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                }
            }
            
            if($model->INSERT())
            {
                $model = Espece::SELECT();
                $Callback ='indexEspece';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
        }
        $vue = $this->renduPage("ajouterEspece",compact('model','listeGenre'));
        $this->afficherVue($vue);
    }
    
    public function editerEspece (array $variables)
    {
        $listeGenre = Genre::liste();
        $model = new Espece();
        $model->SELECT_id($variables['id']);
        
        if(array_key_exists('ID_GENRE',$variables)|| array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
        {
            $model->set('ID_GENRE',  (int)$variables['ID_GENRE']);
            $model->set('LATIN', $variables['LATIN']);
            $model->set('FRANCAIS', $variables['FRANCAIS']);
            
            if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
            {
                if($_FILES['FEUILLE']['size'] <= 500000)
                {
                    $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                }
            }
            if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
            {
                if($_FILES['FLEUR']['size'] <= 500000)
                {
                    $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
            {
                if($_FILES['FRUIT']['size'] <= 500000)
                {
                    $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
            {
                if($_FILES['TIGE']['size'] <= 500000)
                {
                    $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
            {
                if($_FILES['RACINE']['size'] <= 500000)
                {
                    $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                }
            }
            
            if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                }
            }

            if($model->UPDATE())
            {
                $model = Espece::SELECT();
                $Callback ='indexEspece';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
        }
        
        $vue = $this->renduPage("editerEspece",compact('model','listeGenre'));
        $this->afficherVue($vue);
    }
    
    public function supprimerEspece (array $variables)
    {        
        $model = new Espece();
        $model->SELECT_id($variables['id']);
        
        if(array_key_exists('method',$variables))
        {
            $model->DELETE();
            $Callback ='indexEspece';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback','variableCallback'));
        }
        
        $vue = $this->renduPage("supprimerEspece",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function indexPlante(array $variables = [])
    {
        if(array_key_exists ( "page" , $variables ))
        {
            $model = Plante::SELECT_PAGE($variables["page"]);
        }
        else
        {
            $model = Plante::listeTrié();
        }
        
        $vue = $this->renduPage("indexPlante",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function montrerPlante (array $variables)
    {
        $model = new Plante($variables['id']);
        $model->FGE();
        $vue = $this->renduPage("montrerPlante",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function ajouterPlante (array $variables)
    {
        $listeEspece = Espece::liste();
        $interetPlante = new Interet();
        $model = new Plante();                
        
        if(array_key_exists('ID_ESPECE',$variables))
        {            
            $espece = new Espece();
            $espece->SELECT_ID($variables['ID_ESPECE']);            
            $model->set('NOM',$espece['FRANCAIS']);           
            
            foreach (array_keys($model->getDonnees()) as $clé)
            {            
                if(array_key_exists($clé,$variables))
                {
                    $resultat = null;                    
                    if(is_array($variables[$clé]))
                        $resultat = implode ( ';' , array_filter($variables[$clé]) ) ;
                    else 
                        $resultat = $variables[$clé];
                        
                    $model->set($clé,$resultat);
                }
                
                if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
                {
                    if($_FILES['ENSEMBLE']['size'] <= 500000)
                    {
                        $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
                {
                    if($_FILES['FEUILLE']['size'] <= 500000)
                    {
                        $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                    }
                }
                if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
                {
                    if($_FILES['FLEUR']['size'] <= 500000)
                    {
                        $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
                {
                    if($_FILES['FRUIT']['size'] <= 500000)
                    {
                        $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
                {
                    if($_FILES['TIGE']['size'] <= 500000)
                    {
                        $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
                {
                    if($_FILES['RACINE']['size'] <= 500000)
                    {
                        $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
                {
                    if($_FILES['ENSEMBLE']['size'] <= 500000)
                    {
                        $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                    }
                }
            }
            
            if($model->INSERT())
            {
                $model = Espece::SELECT();
                $Callback ='indexPlante';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
        }
        
        $vue = $this->renduPage("ajouterPlante",compact('model','interetPlante','listeEspece'));
        $this->afficherVue($vue);
    }
    
    public function editerPlante (array $variables)
    {           
        $listeEspece = Espece::liste();        
        $interetPlante = new Interet();
        $model = new Plante();
        $model->SELECT_id($variables['id']);
        
         if(array_key_exists('ID_GENRE',$variables)|| array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
         {
            foreach (array_keys($model->getDonnees()) as $clé)
            {
                if(array_key_exists($clé,$variables))
                {
                    $resultat = null;
                    if(is_array($variables[$clé]))
                        $resultat = implode ( ';' , array_filter($variables[$clé]) ) ;
                        else
                            $resultat = $variables[$clé];
                            
                            $model->set($clé,$resultat);
                }
                
                if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
                {
                    if($_FILES['ENSEMBLE']['size'] <= 500000)
                    {
                        $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
                {
                    if($_FILES['FEUILLE']['size'] <= 500000)
                    {
                        $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                    }
                }
                if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
                {
                    if($_FILES['FLEUR']['size'] <= 500000)
                    {
                        $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
                {
                    if($_FILES['FRUIT']['size'] <= 500000)
                    {
                        $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
                {
                    if($_FILES['TIGE']['size'] <= 500000)
                    {
                        $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
                {
                    if($_FILES['RACINE']['size'] <= 500000)
                    {
                        $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                    }
                }
                
                if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
                {
                    if($_FILES['ENSEMBLE']['size'] <= 500000)
                    {
                        $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                    }
                }
            }
         }
        
        $vue = $this->renduPage("editerPlante",compact('model','interetPlante','listeEspece'));
        $this->afficherVue($vue);
    }
    
    public function TraitementFormulaireEditPlant(Plante $model, Interet $interetPlante, array $variables)
    {
        $nomVariables = array_keys($variables);
        
        $espece = new Espece();
        $espece->SELECT_ID($variables['ID_ESPECE']);
        
        foreach (array_keys($model->getDonnees()) as $clé)
        {
            switch ($clé)
            {
                case 'NOM':
                    $model->set('NOM',$espece['FRANCAIS']);
                    break;
                case 'FLEURESON':
                case 'FRUCTIFICATION':
                case 'MULTIPLICATION':
                case 'SEMIS_INTERIEUR':
                case 'SEMIS_EXTERIEUR':
                case 'PLANTATION':
                case 'SENSIBILITE':
                    $model->set($clé,$this->dataCheckboxList($nomVariables, $clé."_"));
                    break;
                case 'ENSEMBLE':
                case 'FEUILLE':
                case 'FLEUR':                
                case 'FRUIT':
                case 'TIGE':
                case 'RACINE':
                case 'ECORSE':
                    $model->set($clé, $this->fichierTelecharge($clé));
                    break;
                default:
                    if(array_key_exists($clé,$variables))
                    {
                        $model->set($clé,$variables[$clé]);
                    }
            }
        }
        
        foreach (array_keys($interetPlante->getDonnees()) as $clé)
        {
            switch ($clé)
            {               
                case 'P_COMESTIBLE':
                case 'P_MEDICINAL':
                case 'P_ENVIRONNEMENTAL':
                    $interetPlante->set($clé,$this->dataCheckboxList($nomVariables, $clé."_"));
                    break;
                default:
                    if(array_key_exists($clé,$variables))
                    {
                        $interetPlante->set($clé,$variables[$clé]);
                    }
            }
        }
    }
   
    public function fichierTelecharge(string $nomEtiquette)
    {
        if(is_uploaded_file($_FILES[$nomEtiquette]['tmp_name']))
        {
            if($_FILES[$nomEtiquette]['size'] <= 500000)
            {
                return file_get_contents ($_FILES['$nomEtiquette']['tmp_name']);
            }
        }
        
        return false;       
    }
    
    public function supprimerPlante (array $variables)
    {
        $model = new Plante();
        $model->SELECT_id($variables['id']);
        
        if(array_key_exists('method',$variables))
        {
            $model->DELETE();
            $Callback ='indexPlante';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback','variableCallback'));
        }
        
        $vue = $this->renduPage("supprimerPlante",compact('model'));
        $this->afficherVue($vue);
    }
   
    public function especeParFamille (array $variables)
    {
        $model = Espece::listeParFamille(); 
        $vue = $this->renduPage("especeParFamille",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function arbre (array $variables)
    {
        $model = null;
        $vue = $this->renduPage("arbre",compact('model'));
        $this->afficherVue($vue);
    }
}
