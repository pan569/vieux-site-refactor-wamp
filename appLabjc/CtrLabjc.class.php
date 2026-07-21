<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/06/2021
 * Time: 06:24
 */

namespace appLabjc;

use systeme\routeur\Route;
use systeme\controleur\Controleur;
use motif\modele\Motif;


class CtrLabjc extends Controleur
{
    public function __construct(Motif $motif)
    {
        $s = DIRECTORY_SEPARATOR;

        $motif->ajoutFichierCSS("{$s}appLabjc{$s}vue{$s}resources");
        $motif->ajoutFichierJS("{$s}appLabjc{$s}vue{$s}resources");

        // nomApplication est maintenant déduit automatiquement par le parent
        parent::__construct($motif);

        $this->routeur->addRoute(new Route($this->nomApplication, "index", "{p:[0-9]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}index.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "dropFichier", "{p:[0-9]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}dropFichier.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "test", "{p:[0-9]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}affichage.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "upload", "{p:[0-9]+}", "%([\w]+)\.([\w]+)\%", __DIR__."{$s}vue{$s}upload.php"));
    }

    public function afficherPage($main)
    {
        $t = [];
        $t['index'] = array('lien' => $this->routeur->getRoute('index')->generateUri(), 'count' => 0);
        $t['dropFichier'] = array('lien' => $this->routeur->getRoute('dropFichier')->generateUri(), 'count' => 0);
        $t['T'] = array('lien' => $this->routeur->getRoute('test')->generateUri(), 'count' => 0);

        $this->motif['aside'] = $t;

        $body = $this->renduPage("body", compact('main'));
        echo $this->renduPage("page", compact('body'));
    }

    public function index(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("index", compact('model'));
        $this->afficherPage($main);
    }

    public function Windows(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("Windows", compact('model'));
        $this->afficherPage($main);
    }

    public function Geolocation(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("Geolocation", compact('model'));
        $this->afficherPage($main);
    }

    public function History(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("History", compact('model'));
        $this->afficherPage($main);
    }

    public function DOM(array $variables = [])
    {
        extract($variables);
        ob_start();
        require($_SERVER["DOCUMENT_ROOT"] . "/appLabjc/vue/CJSPG_DOM.php");
        echo ob_get_clean();
    }

    public function CoursJQUERY01(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("CoursJQUERY01", compact('model'));
        $this->afficherPage($main);
    }

    public function CoursJQUERY02(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("CoursJQUERY02", compact('model'));
        $this->afficherPage($main);
    }

    public function CoursJQUERY03(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("CoursJQUERY03", compact('model'));
        $this->afficherPage($main);
    }

    public function CoursJQUERY04(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("CoursJQUERY04", compact('model'));
        $this->afficherPage($main);
    }

    public function CoursJQUERY05(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("CoursJQUERY05", compact('model'));
        $this->afficherPage($main);
    }

    public function CoursJQUERY06(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("CoursJQUERY06", compact('model'));
        $this->afficherPage($main);
    }

    public function ProtoAnnuaire(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("ProtoAnnuaire", compact('model'));
        $this->afficherPage($main);
    }

    public function dropFichier(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("dropFichier", compact('model'));
        $this->afficherPage($main);
    }

    public function test(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("test", compact('model'));
        $this->afficherPage($main);
    }

    public function upload(array $variables = [])
    {
        $model = null;
        $main = $this->renduPage("upload", compact('model'));
        $this->afficherPage($main);
    }
}
