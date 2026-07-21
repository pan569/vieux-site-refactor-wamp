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
        $this->nomApplication = str_replace( "app" , "" , __NAMESPACE__ );
        
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
         
        
        
        //\resources\themes/theme.monBog/
        $dossier = "/appBotanique/vue/resources";
        $this->motif->ajoutFichier($dossier);
        /**/
        
        
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
            $model = Famille::SELECT_PAGE($variables["page"]); //PageResultat(isset($_GET['p']) ? $_GET['p'] : 1,12);
        }
        else
        {
            $model = Famille::listeTrié();
        }             
        
        //echo $this->renduPage("indexFamille",compact('model'));
        $vue = $this->renduPage("indexFamille",compact('model'));
        $this->afficherVue($vue);
        
    }
    
    public function montrerFamille (array $variables)
    {
        $model = new Plante($variables['id']);
        //echo $this->renduPage("montrer",compact('model'));
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
            
            debug($model,"editerFamille_model");
            
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
            debug('je suis ici');
            
            $model->DELETE();
            
            //$this->messageFlash->ajoutMessageSucces("L'article as bien été supprimé");
            
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
            $model = Genre::SELECT_PAGE($variables["page"]); //PageResultat(isset($_GET['p']) ? $_GET['p'] : 1,12);
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
            
            debug($model,"editerGenre_model");
            
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
            debug('je suis ici');
            
            $model->DELETE();
            
            //$this->messageFlash->ajoutMessageSucces("L'article as bien été supprimé");
            
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
            $model = Espece::SELECT_PAGE($variables["page"]); //PageResultat(isset($_GET['p']) ? $_GET['p'] : 1,12);
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
        //debug($variables,"CtrBotanique->montrerEspece:variables");
        
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
                        
            debug($_FILES['ENSEMBLE']);
            if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                }
            }
            
            debug($_FILES['FEUILLE']);
            if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
            {
                if($_FILES['FEUILLE']['size'] <= 500000)
                {
                    $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                }
            }
            debug($_FILES['FLEUR']);
            if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
            {
                if($_FILES['FLEUR']['size'] <= 500000)
                {
                    $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                }
            }
            
            debug($_FILES['FRUIT']);
            if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
            {
                if($_FILES['FRUIT']['size'] <= 500000)
                {
                    $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                }
            }
            
            debug($_FILES['TIGE']);
            if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
            {
                if($_FILES['TIGE']['size'] <= 500000)
                {
                    $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                }
            }
            
            debug($_FILES['RACINE']);
            if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
            {
                if($_FILES['RACINE']['size'] <= 500000)
                {
                    $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                }
            }
            
            debug($_FILES['ECORSE']);
            if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                }
            }
            /**/
            
            //debug($model->getDonnees(),"editerEspece_model");
            
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
            
            
            debug($_FILES['ENSEMBLE']);
            if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                }
            }
            
            debug($_FILES['FEUILLE']);
            if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
            {
                if($_FILES['FEUILLE']['size'] <= 500000)
                {
                    $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                }
            }
            debug($_FILES['FLEUR']);
            if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
            {
                if($_FILES['FLEUR']['size'] <= 500000)
                {
                    $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                }
            }
            
            debug($_FILES['FRUIT']);
            if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
            {
                if($_FILES['FRUIT']['size'] <= 500000)
                {
                    $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                }
            }
            
            debug($_FILES['TIGE']);
            if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
            {
                if($_FILES['TIGE']['size'] <= 500000)
                {
                    $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                }
            }
            
            debug($_FILES['RACINE']);
            if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
            {
                if($_FILES['RACINE']['size'] <= 500000)
                {
                    $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                }
            }
            
            debug($_FILES['ECORSE']);
            if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                }
            }

           
            /**/
            
            //debug($model->getDonnees(),"editerEspece_model");
            
            
            if($model->UPDATE())
            {
                $model = Espece::SELECT();
                
                $Callback ='indexEspece';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
            /**/
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
            debug('je suis ici');
            
            $model->DELETE();
            
            //$this->messageFlash->ajoutMessageSucces("L'article as bien été supprimé");
            
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
            $model = Plante::SELECT_PAGE($variables["page"]); //PageResultat(isset($_GET['p']) ? $_GET['p'] : 1,12);
        
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
        //debug($model,"CtrBotanique montrerPlante model");
        
        $vue = $this->renduPage("montrerPlante",compact('model'));
        $this->afficherVue($vue);
    }
    
    public function ajouterPlante (array $variables)
    {
        debug("je passe ici ajouterPlante");
        $listeEspece = Espece::liste();//liste des options du formulaire
        $interetPlante = new Interet();
        $model = new Plante();                
        
        
        //Si dans le tables des variable il y a la variable d'etiquette ID_ESPECE
        //cela veux dire que c'est un retour de formulaire il faut donc traiter les £variable
        //et enregister $model dans a base de donné
        if(array_key_exists('ID_ESPECE',$variables))
        {            
            
            /**/
            //recherche du nom francais de l'espece corespondant a ID_ESPECE et renseigne $model['NOM'] avec le nom francais de l'espece trouvé
            $espece = new Espece();
            $espece->SELECT_ID($variables['ID_ESPECE']);            
            $model->set('NOM',$espece['FRANCAIS']);           
            
            //Traitement des autres variables
            foreach (array_keys($model->getDonnees()) as $clé)
            {            
                // si la variable corespont a une donnée de $model
                if(array_key_exists($clé,$variables))
                {
                  
                    $resultat = null;                    
                    //si $variables[$clé] est un tableau
                    if(is_array($variables[$clé]))
                        $resultat = implode ( ';' , array_filter($variables[$clé]) ) ; // Transforme le tableau en chaine de caractere, avec chaque données séparé par un ';'
                    else 
                        $resultat = $variables[$clé];
                        
                    $model->set($clé,$resultat);

                }
                
                //debug($_FILES['ENSEMBLE']);
                if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
                {
                    if($_FILES['ENSEMBLE']['size'] <= 500000)
                    {
                        $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                    }
                }
                
                //debug($_FILES['FEUILLE']);
                if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
                {
                    if($_FILES['FEUILLE']['size'] <= 500000)
                    {
                        $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                    }
                }
                //debug($_FILES['FLEUR']);
                if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
                {
                    if($_FILES['FLEUR']['size'] <= 500000)
                    {
                        $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                    }
                }
                
                //debug($_FILES['FRUIT']);
                if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
                {
                    if($_FILES['FRUIT']['size'] <= 500000)
                    {
                        $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                    }
                }
                
                //debug($_FILES['TIGE']);
                if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
                {
                    if($_FILES['TIGE']['size'] <= 500000)
                    {
                        $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                    }
                }
                
                //debug($_FILES['RACINE']);
                if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
                {
                    if($_FILES['RACINE']['size'] <= 500000)
                    {
                        $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                    }
                }
                
                //debug($_FILES['ECORSE']);
                if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
                {
                    if($_FILES['ENSEMBLE']['size'] <= 500000)
                    {
                        $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                    }
                }
            }
            /**/
            
            if($model->INSERT())
            {
                $model = Espece::SELECT();
                
                $Callback ='indexPlante';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
            /**/
        }
        
        //ouverture du formulaire de création d'une plante
        $vue = $this->renduPage("ajouterPlante",compact('model','interetPlante','listeEspece'));
        $this->afficherVue($vue);
    }
    
    public function editerPlante (array $variables)
    {           
        //debug("je passe ici editerPlante");
        debug($variables,"CtrlBotanique.class.php ligne 703 variable");
        $listeEspece = Espece::liste();        
        $interetPlante = new Interet();
        $model = new Plante();
        $model->SELECT_id($variables['id']);
        
        // 
        
         if(array_key_exists('ID_GENRE',$variables)|| array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
         {
            //$model->set('ID_GENRE',  (int)$variables['ID_GENRE']);
            //$model->set('LATIN', $variables['LATIN']);
            //$model->set('FRANCAIS', $variables['FRANCAIS']);
         
            //Traitement des autres variables
            foreach (array_keys($model->getDonnees()) as $clé)
            {
                // si la variable corespont a une donnée de $model
                if(array_key_exists($clé,$variables))
                {
                    $resultat = null;
                    //si $variables[$clé] est un tableau
                    if(is_array($variables[$clé]))
                        $resultat = implode ( ';' , array_filter($variables[$clé]) ) ; // Transforme le tableau en chaine de caractere, avec chaque données séparé par un ';'
                        else
                            $resultat = $variables[$clé];
                            
                            $model->set($clé,$resultat);
                            
                }
                
                //debug($_FILES['ENSEMBLE']);
                if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
                {
                    if($_FILES['ENSEMBLE']['size'] <= 500000)
                    {
                        $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                    }
                }
                
                //debug($_FILES['FEUILLE']);
                if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
                {
                    if($_FILES['FEUILLE']['size'] <= 500000)
                    {
                        $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                    }
                }
                //debug($_FILES['FLEUR']);
                if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
                {
                    if($_FILES['FLEUR']['size'] <= 500000)
                    {
                        $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                    }
                }
                
                //debug($_FILES['FRUIT']);
                if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
                {
                    if($_FILES['FRUIT']['size'] <= 500000)
                    {
                        $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                    }
                }
                
                //debug($_FILES['TIGE']);
                if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
                {
                    if($_FILES['TIGE']['size'] <= 500000)
                    {
                        $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                    }
                }
                
                //debug($_FILES['RACINE']);
                if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
                {
                    if($_FILES['RACINE']['size'] <= 500000)
                    {
                        $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                    }
                }
                
                //debug($_FILES['ECORSE']);
                if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
                {
                    if($_FILES['ENSEMBLE']['size'] <= 500000)
                    {
                        $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                    }
                }
            }
            /**/
            /*
            if($model->UPDATE())
            {
                $model = Plante::SELECT();
         
                $Callback ='indexPlante';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
            /**/
         }
         /**/
        
        
        /************************************************************************/
        
        /*
        if(array_key_exists('ID_GENRE',$variables)|| array_key_exists('LATIN',$variables)|| array_key_exists('FRANCAIS',$variables))
        {
            $model->set('ID_GENRE',  (int)$variables['ID_GENRE']);
            $model->set('LATIN', $variables['LATIN']);
            $model->set('FRANCAIS', $variables['FRANCAIS']);
            
            debug($_FILES['ENSEMBLE']);
            if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                }
            }
            
            debug($_FILES['FEUILLE']);
            if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
            {
                if($_FILES['FEUILLE']['size'] <= 500000)
                {
                    $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                }
            }
            debug($_FILES['FLEUR']);
            if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
            {
                if($_FILES['FLEUR']['size'] <= 500000)
                {
                    $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                }
            }
            
            debug($_FILES['FRUIT']);
            if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
            {
                if($_FILES['FRUIT']['size'] <= 500000)
                {
                    $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                }
            }
            
            debug($_FILES['TIGE']);
            if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
            {
                if($_FILES['TIGE']['size'] <= 500000)
                {
                    $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                }
            }
            
            debug($_FILES['RACINE']);
            if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
            {
                if($_FILES['RACINE']['size'] <= 500000)
                {
                    $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                }
            }
            
            debug($_FILES['ECORSE']);
            if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                }
            }
            
            if($model->UPDATE())
            {
                $model = Plante::SELECT();
                
                $Callback ='indexPlante';
                $variableCallback = [];
                $this->redirigerRoute(compact('Callback','variableCallback'));
            }
        }
        /**/
        
        //Si dans le tables des variable il y a la variable d'etiquette ID_ESPECE
        //cela veux dire que c'est un retour de formulaire il faut donc traiter les £variable
        //et enregister $model dans a base de donné
        /*
         if(array_key_exists('ID_ESPECE',$variables))
         {
         //$model = $this->TraitementFormulaireEditPlant($model,$interetPlante,$variables);
         //debug($model,"MODEL");
         
         if($model->UPDATE())
         {
         $model = Plante::SELECT();
         
         $Callback ='indexPlante';
         $variableCallback = [];
         $this->redirigerRoute(compact('Callback','variableCallback'));
         }
         
         }
         /**/
        
        $vue = $this->renduPage("editerPlante",compact('model','interetPlante','listeEspece'));
        $this->afficherVue($vue);
    }
    
    public function TraitementFormulaireEditPlant(Plante $model, Interet $interetPlante, array $variables)
    {
        debug("je passe ici TraitementFormulaireEditPlant");
        
        //liste des clé du tableau $variables
        $nomVariables = array_keys($variables);
        
        //recherche de l'espece de la plante
        $espece = new Espece();
        $espece->SELECT_ID($variables['ID_ESPECE']);
        
        //On recupere les etiques des données de la plante et on les traite celon le type de controleur du formulaire
        foreach (array_keys($model->getDonnees()) as $clé)
        {
            switch ($clé)
            {
                //On renseingle le nom de la plante avec le nom francais de son espece
                case 'NOM':
                    $model->set('NOM',$espece['FRANCAIS']);
                    break;
                //On traite les checkboxlist
                case 'FLEURESON':
                case 'FRUCTIFICATION':
                case 'MULTIPLICATION':
                case 'SEMIS_INTERIEUR':
                case 'SEMIS_EXTERIEUR':
                case 'PLANTATION':
                case 'SENSIBILITE':
                    $model->set($clé,$this->dataCheckboxList($nomVariables, $clé."_"));
                    break;
                //On traite les "uploaded_file"
                case 'ENSEMBLE':
                case 'FEUILLE':
                case 'FLEUR':                
                case 'FRUIT':
                case 'TIGE':
                case 'RACINE':
                case 'ECORSE':
                    $model->set($clé, $this->fichierTelecharge($clé));
                    break;
                //On traite les autres types de controleurs    
                default:
                    if(array_key_exists($clé,$variables))
                    {
                        //enregistrement de la donnée dans $model
                        $model->set($clé,$variables[$clé]);
                    }
                    
            }
        }
        
        //debug($interetPlante, "interetPlante A");
        
        //On recupere les etiques des données de la plante et on les traite celon le type de controleur du formulaire
        foreach (array_keys($interetPlante->getDonnees()) as $clé)
        {
            switch ($clé)
            {               
                    //On traite les checkboxlist
                case 'P_COMESTIBLE':
                case 'P_MEDICINAL':
                case 'P_ENVIRONNEMENTAL':
                case 'P_COMESTIBLE':
                    $interetPlante->set($clé,$this->dataCheckboxList($nomVariables, $clé."_"));
                    break;
             
                    //On traite les autres types de controleurs
                default:
                    if(array_key_exists($clé,$variables))
                    {
                        //enregistrement de la donnée dans $model
                        $interetPlante->set($clé,$variables[$clé]);;
                    }
                    
            }
        }
        
        //debug($interetPlante, "interetPlante B");
        
        /*
        //debug($variables,"CtrBotanique->editerPlante variables");
        
        //recherche du nom francais de l'espece corespondant a ID_ESPECE et renseigne $model['NOM'] avec le nom francais de l'espece trouvé
        $espece = new Espece();
        $espece->SELECT_ID($variables['ID_ESPECE']);
        $model->set('NOM',$espece['FRANCAIS']);
        
        
        $model->set("FLEURESON",$this->dataCheckboxList(array_keys($variables), "FLEURESON_"));
        $model->set("FRUCTIFICATION",$this->dataCheckboxList(array_keys($variables), "FRUCTIFICATION_"));
        $model->set("MULTIPLICATION",$this->dataCheckboxList(array_keys($variables), "MULTIPLICATION_"));
        $model->set("SEMIS_INTERIEUR",$this->dataCheckboxList(array_keys($variables), "SEMIS_INTERIEUR_"));
        $model->set("SEMIS_EXTERIEUR",$this->dataCheckboxList(array_keys($variables), "SEMIS_EXTERIEUR_"));
        $model->set("PLANTATION",$this->dataCheckboxList(array_keys($variables), "PLANTATION_"));
        $model->set("SENSIBILITE",$this->dataCheckboxList(array_keys($variables), "SENSIBILITE_"));
        
        
        //Traitement des autres variables
        foreach (array_keys($model->getDonnees()) as $clé)
        {
            // si la variable corespont a une donnée de $model
            if(array_key_exists($clé,$variables))
            {
                //enregistrement de la donnée dans $model
                $model->set($clé,$variables[$clé]);
            }
        }
            
        $model->set('ENSEMBLE', $this->fichierTelecharge('ENSEMBLE'));
        $model->set('FEUILLE', $this->fichierTelecharge('FEUILLE'));
        $model->set('FLEUR', $this->fichierTelecharge('FLEUR'));
        $model->set('FRUIT', $this->fichierTelecharge('FRUIT'));
        $model->set('TIGE', $this->fichierTelecharge('TIGE'));
        $model->set('RACINE', $this->fichierTelecharge('set'));
        $model->set('ECORSE', $this->fichierTelecharge('ECORSE'));
            
        return $model;
            
            /*
              
            //Traitement des autres variables
        foreach (array_keys($model->getDonnees()) as $clé)
        {
            // si la variable corespont a une donnée de $model
            if(array_key_exists($clé,$variables))
            {
                
                if(is_array($variables[$clé]))//si la variable courante est de type tableau
                {
                    // Transforme le tableau en chaine de caractere, avec chaque données séparé par un ';'
                    //-------------------------------------------------------------
                    //1)supprimer les elements vides du tableau
                    $tab = array_filter($variables[$clé]);
                    
                    //2)transforme le tableau en chaine de caractere
                    $resultat = implode ( ';' , $tab ) ;
                    //-------------------------------------------------------------
                    
                    //enregistrement de la donnée dans $model
                    $model->set($clé,$resultat);
                    
                }
                else
                {
                    //enregistrement de la donnée dans $model
                    $model->set($clé,$variables[$clé]);
                }
                
            }  
              
            
            debug($_FILES['ENSEMBLE']);
            if(is_uploaded_file($_FILES['ENSEMBLE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ENSEMBLE',  file_get_contents ($_FILES['ENSEMBLE']['tmp_name']));
                }
            }
            
            debug($_FILES['FEUILLE']);
            if(is_uploaded_file($_FILES['FEUILLE']['tmp_name']))
            {
                if($_FILES['FEUILLE']['size'] <= 500000)
                {
                    $model->set('FEUILLE',  file_get_contents ($_FILES['FEUILLE']['tmp_name']));
                }
            }
            debug($_FILES['FLEUR']);
            if(is_uploaded_file($_FILES['FLEUR']['tmp_name']))
            {
                if($_FILES['FLEUR']['size'] <= 500000)
                {
                    $model->set('FLEUR',  file_get_contents ($_FILES['FLEUR']['tmp_name']));
                }
            }
            
            debug($_FILES['FRUIT']);
            if(is_uploaded_file($_FILES['FRUIT']['tmp_name']))
            {
                if($_FILES['FRUIT']['size'] <= 500000)
                {
                    $model->set('FRUIT',  file_get_contents ($_FILES['FRUIT']['tmp_name']));
                }
            }
            
            debug($_FILES['TIGE']);
            if(is_uploaded_file($_FILES['TIGE']['tmp_name']))
            {
                if($_FILES['TIGE']['size'] <= 500000)
                {
                    $model->set('TIGE',  file_get_contents ($_FILES['TIGE']['tmp_name']));
                }
            }
            
            debug($_FILES['RACINE']);
            if(is_uploaded_file($_FILES['RACINE']['tmp_name']))
            {
                if($_FILES['RACINE']['size'] <= 500000)
                {
                    $model->set('RACINE',  file_get_contents ($_FILES['RACINE']['tmp_name']));
                }
            }
            
            debug($_FILES['ECORSE']);
            if(is_uploaded_file($_FILES['ECORSE']['tmp_name']))
            {
                if($_FILES['ENSEMBLE']['size'] <= 500000)
                {
                    $model->set('ECORSE',  file_get_contents ($_FILES['ECORSE']['tmp_name']));
                }
            }
            /**/
        
    }
   
    public function fichierTelecharge(string $nomEtiquette)
    {
        //debug($_FILES[$nomEtiquette]);
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
            debug('je suis ici');
            
            $model->DELETE();
            
            //$this->messageFlash->ajoutMessageSucces("L'article as bien été supprimé");
            
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
        /**/
    }
    
    public function arbre (array $variables)
    {
        
        $model = null;
        $vue = $this->renduPage("arbre",compact('model'));
        $this->afficherVue($vue);
        /**/
    }
    
    
}