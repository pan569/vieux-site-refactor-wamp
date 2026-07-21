<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/06/2021
 * Time: 06:24
 */

namespace appAlbum;

use systeme\routeur\Route;
use systeme\controleur\Controleur;
use motif\modele\Motif;
use appAlbum\modele\Album;
use systeme;


class CtrAlbum extends Controleur
{
    
    public $_direction = null;
    
    public function __construct(Motif $motif)
    {
        $this->nomApplication = str_replace( "app" , "" , __NAMESPACE__ );        
        parent::__construct($motif);
        
        $s=DIRECTORY_SEPARATOR;
        $this->routeur->addRoute(new Route($this->nomApplication, "listerAlbums", "{}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}Albums.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "visualiserAlbum", "{nomAlbum:[\w]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}Album.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "visualiserPhoto", "{nomAlbum:[\w]+}{nomPhoto:[\w]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}Photo.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "editeur", "", "",                                 __DIR__."{$s}vue{$s}Editeur.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "exifToIptc", "{fichier:[\w]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}visioneuseIPTC.php"));
        
        $this->routeur->addRoute(new Route($this->nomApplication, "tester", "","", __DIR__."{$s}vue{$s}Album.php"));
        
        $this->_direction =  __DIR__."{$s}vue{$s}resources{$s}data{$s}";
        
    }   
    
    public function afficherPage($main)
    {
        /*
        $t = [];
        $t['Liste des familles'] =array( 'lien' => $this->routeur->getRoute('indexFamille')->generateUri() , 'count' => Persistance::getInstance()->COUNT('famille')['Nbr']);
        $t['Liste des genres'] =array( 'lien' => $this->routeur->getRoute('indexGenre')->generateUri() , 'count' => Persistance::getInstance()->COUNT('genre')['Nbr']);
        $t['Liste des especes'] =array( 'lien' => $this->routeur->getRoute('indexEspece')->generateUri() , 'count' => Persistance::getInstance()->COUNT('espece')['Nbr']);
        $t['Especes par familles'] =array( 'lien' => $this->routeur->getRoute('especeParFamille')->generateUri() , 'count' => Persistance::getInstance()->COUNT('espece')['Nbr']);
        $t['Liste des plantes'] =array( 'lien' => $this->routeur->getRoute('indexPlante')->generateUri() , 'count' => Persistance::getInstance()->COUNT('plante')['Nbr']);
        $t['arbre'] =array( 'lien' => $this->routeur->getRoute('arbre')->generateUri(), 'count' => 0);
        $this->motif['aside'] = $t;
        */
        
        $body = $this->renduPage("body",compact('main'));
        
        echo $this->renduPage("page",compact('body'));
        
    }

    public function listerAlbums()
    {

        
        //1) lister les fichiers. </br>";
        $fichiers = scandir($this->_direction);       
        
        //2) trier fichiers, recuperer que les fichiers jpeg  </br>";
        $Albums = [];
        foreach ($fichiers as $fichier)
        {
            if(is_dir($this->_direction.$fichier) && !in_array($fichier, array('.','..')))
                $Albums[] = $fichier;                
        }
        
        $model = $Albums;
        
        $main = $this->renduPage("listerAlbums",compact('model'));
        $this->afficherPage($main);
        
    }
    
    public function visualiserAlbum(array $variables = [])
    {   
       
        //debug($variables,"variables");//$variables["album"] 
        $model = new Album($this->_direction, $variables["nomAlbum"]);        
        $main = $this->renduPage("visualiserAlbum",compact('model'));                
        $this->afficherPage($main);
        /**/
    }
    
    public function visualiserPhoto(array $variables = [])
    {

        //debug($variables,"CtrlAlbum ligne 95 variables");
        //debug($this->routeur->getRoutes(),"CtrlAlbum ligne 96 routes");
        /**/
        //1) lister les fichiers. </br>";
        $fichiers = scandir($this->_direction.$variables['nomAlbum']);
        //debug($fichiers,"liste des fichiers dans le dossier d'album");
        
        //2) trier fichiers, recuperer que les fichiers jpeg  </br>";
        $FichiersJPEG = [];
        foreach ($fichiers as $fichier)
        {
            if(stristr($fichier, '.jpg') !== FALSE)
            {
                $FichiersJPEG[] = str_replace( '.jpg' , '' , $fichier ) ;
            }
        }
        
        //debug($FichiersJPEG,"liste des fichiers JPEG");
        //debug($variables,"les variables");
        
        if(array_key_exists('fichier',$variables) )
        {
            $nomImage = $variables["fichier"].'.jpg';
        }
        else
        {
            $nomImage = null;
        }
        
        
        $nomPhoto = $variables["nomPhoto"];
        $model = new Album($this->_direction, $variables["nomAlbum"]);
        $main = $this->renduPage("visualiserPhoto",compact('model','nomPhoto'));
        $this->afficherPage($main);
        /**/
    }
    
    public function tester()
    {
        // pointer la racine sur direction
        $objet = new systeme\utilitaire\GestionaireFichiers($this->_direction);
        
        //debug($objet);
        
        //supprimer "NSTDS" siil existe
        //$objet->supprimerDossier("NSTDS");
        
        
        //crrerledossier (nouvel album) "NSTDS" 
        $objet->CreerDissier("NSTDS");
        
        // pointer la racine sur "NSTDS"
        $objet = new systeme\utilitaire\GestionaireFichiers($this->_direction."NSTDS");
        $objet->getListeFichiersFiltrés([".jpg"]);
        
        $objet->copierFichier($this->_direction."test/test.zip",$objet->getNonDossier());//$this->_racine.$this->getNonDossier()
        
        $objet->deziperFichiersDossier();
        
        
        
        //debug($objet);
            
        
        /*
        
        $cheminAlbum = $this->_direction.$nomAlbum;
        
        debug($cheminAlbum,"chemin");
        
        
        
        //mkdir( $this->_directionemin , $permissions = 0777 );
        /**/
        
    }
    
    
    
    public function editeur(array $variables = [])
    {
        //echo "1) lister les fichiers. </br>";
        
        $fichiers = scandir("D:\\Documents\\Developpement\\php\\wamp64\\www\\site01\\appAlbum\\vue\\resources\\data\\X\\");
        
        if(array_key_exists('fichier',$variables) )
        {
            $nomImage = $variables["fichier"].'.jpg';
        }
        else
        {
            $nomImage = null;
        }
        
        $model = null;
        
        debug($model,"model");
        
        $main = $this->renduPage("editeur",compact('model','nomImage'));
        $this->afficherPage($main);
        
    }
        
    

    
}