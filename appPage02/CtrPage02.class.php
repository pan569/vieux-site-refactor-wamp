<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 12/06/2021
 * Time: 06:24
 */

namespace appPage02;

use systeme\routeur\Route;
use systeme\controleur\Controleur;
use appPage02\modele\Page02;
use motif\modele\Motif;


class CtrPage02 extends Controleur
{
    public function __construct(Motif $motif)
    {
        // nomApplication est maintenant déduit automatiquement par le parent
        parent::__construct($motif);

        $s = DIRECTORY_SEPARATOR;
        $this->routeur->addRoute(new Route($this->nomApplication, "Objet", "", "", __DIR__."{$s}vue{$s}unObjet.php"));
    }

    public function afficherPage($main)
    {
        $t = [];
        $t['High-Tech'] = array('lien' => $this->routeur->getRoute('Objet')->generateUri(), 'count' => 5);
        $t['Concentré du Web'] = array('lien' => $this->routeur->getRoute('Objet')->generateUri(), 'count' => 3);
        $t['A propos'] = array('lien' => $this->routeur->getRoute('Objet')->generateUri(), 'count' => 10);
        $t['Astuces pour développeurs'] = array('lien' => $this->routeur->getRoute('Objet')->generateUri(), 'count' => 5);
        $t['Ressources'] = array('lien' => $this->routeur->getRoute('Objet')->generateUri(), 'count' => 0);
        $t['Bonnes pratiques'] = array('lien' => $this->routeur->getRoute('Objet')->generateUri(), 'count' => 0);
        $this->motif['aside'] = $t;

        $body = $this->renduPage("body", compact('main'));
        echo $this->renduPage("page", compact('body'));
    }

    public function index(array $variables = [])
    {
        $model = Page02::ListeX();
        $main = $this->renduPage("Objet", compact('model'));
        $this->afficherPage($main);
    }
}
