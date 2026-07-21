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
        // nomApplication est maintenant déduit automatiquement par le parent
        parent::__construct($motif);

        $s = DIRECTORY_SEPARATOR;
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
        $body = $this->renduPage("body",compact('main'));
        echo $this->renduPage("page",compact('body'));
    }

    public function listerAlbums()
    {
        $fichiers = scandir($this->_direction);

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
        $model = new Album($this->_direction, $variables["nomAlbum"]);
        $main = $this->renduPage("visualiserAlbum",compact('model'));
        $this->afficherPage($main);
    }

    public function visualiserPhoto(array $variables = [])
    {
        $fichiers = scandir($this->_direction.$variables['nomAlbum']);

        $FichiersJPEG = [];
        foreach ($fichiers as $fichier)
        {
            if(stristr($fichier, '.jpg') !== FALSE)
            {
                $FichiersJPEG[] = str_replace( '.jpg' , '' , $fichier ) ;
            }
        }

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
    }

    public function tester()
    {
        $objet = new systeme\utilitaire\GestionaireFichiers($this->_direction);

        $objet->CreerDissier("NSTDS");

        $objet = new systeme\utilitaire\GestionaireFichiers($this->_direction."NSTDS");
        $objet->getListeFichiersFiltrés([".jpg"]);

        $objet->copierFichier($this->_direction."test/test.zip",$objet->getNonDossier());

        $objet->deziperFichiersDossier();
    }

    public function editeur(array $variables = [])
    {
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
