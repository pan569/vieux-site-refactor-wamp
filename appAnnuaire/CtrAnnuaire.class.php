<?php
namespace appAnnuaire;

use appAnnuaire\modele\Annuaire;
use motif\modele\Motif;
use systeme\controleur\Controleur;
use systeme\routeur\Route;
use systeme\utilitaire\GestionaireFichiers;

class CtrAnnuaire extends Controleur
{
    public $_direction = null;

    public function __construct(Motif $motif)
    {
        // nomApplication est maintenant déduit automatiquement par le parent
        parent::__construct($motif);

        $s = DIRECTORY_SEPARATOR;

        $this->routeur->addRoute(new Route(
            $this->nomApplication,
            "index",
            "{Dossier:[\w]+}",
            "%([\w]+)\.([\w]+)\%",
            __DIR__ . "{$s}vue{$s}navigateur.php"
        ));

        $this->_direction = __DIR__ . "{$s}vue{$s}resources{$s}data{$s}";
    }

    private function afficherPage($main)
    {
        $body = $this->renduPage("body", compact('main'));
        echo $this->renduPage("page", compact('body'));
    }

    public function index(array $variables = [])
    {
        $direction = $this->_direction;

        if (array_key_exists("Dossier", $variables)) {
            $d = $this->_direction . str_replace("-", DIRECTORY_SEPARATOR, $variables["Dossier"]) . DIRECTORY_SEPARATOR;
            if (file_exists($d)) {
                $direction = $d;
            }
        }

        $model = new Annuaire($direction, array('.url'));
        $vue = $this->renduPage("index", compact('model'));
        $this->afficherPage($vue);
    }

    public function editeur(array $variables)
    {
    }

    public function ajouter(array $variables)
    {
    }

    public function editer(array $variables)
    {
    }

    public function supprimer(array $variables)
    {
    }
}
