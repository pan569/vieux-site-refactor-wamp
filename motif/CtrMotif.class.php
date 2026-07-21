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
        parent::__construct($motif);

        $s = DIRECTORY_SEPARATOR;
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
        $t['Index'] = array('lien' => $this->routeur->getRoute('index')->generateUri(), 'count' => '');
        $t['configuration'] = array('lien' => $this->routeur->getRoute('modifConfiguration')->generateUri(), 'count' => '');
        $t['Credit'] = array('lien' => $this->routeur->getRoute('modifCredit')->generateUri(), 'count' => '');
        $t['Entete'] = array('lien' => $this->routeur->getRoute('modifEntete')->generateUri(), 'count' => '');

        $this->motif['aside'] = $t;

        $dossier = "/appBotanique/vue/resources";
        $this->motif->ajoutFichier($dossier);

        $body = $this->renduPage("body", compact('main'));
        echo $this->renduPage("page", compact('body'));
    }

    public function index(array $variables = [])
    {
        $model = $this->motif;
        $main = $this->renduPage("index", compact('model'));
        $this->afficherPage($main);
    }

    public function modifConfiguration(array $variables = [])
    {
        $model = $this->motif;

        if (array_key_exists('form', $variables)) {

            if ($this->refuserSiCsrfInvalide()) {
                $main = $this->renduPage("modifConfiguration", compact('model'));
                $this->afficherPage($main);
                return;
            }

            $t = [];
            foreach (array_keys($model['Configuration']) as $clé) {
                $t[$clé] = $variables[$clé] ?? $model['Configuration'][$clé];
            }
            $model['Configuration'] = $t;
            $model->SauvegardeElement('Configuration');

            $this->flashSucces('Configuration enregistrée.');
            $Callback = 'index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback', 'variableCallback'));
        }

        $main = $this->renduPage("modifConfiguration", compact('model'));
        $this->afficherPage($main);
    }

    public function modifCredit(array $variables = [])
    {
        $model = $this->motif;

        if (array_key_exists('form', $variables)) {

            if ($this->refuserSiCsrfInvalide()) {
                $main = $this->renduPage("modifCredit", compact('model'));
                $this->afficherPage($main);
                return;
            }

            $t = [];
            foreach (array_keys($model['Proprietaire']) as $clé) {
                $t[$clé] = $variables["Proprietaire_$clé"] ?? $model['Proprietaire'][$clé];
            }
            $model['Proprietaire'] = $t;
            $model->SauvegardeElementAttribut('Credits', 'Proprietaire');

            $t = [];
            foreach (array_keys($model['Developpeur']) as $clé) {
                $t[$clé] = $variables["Developpeur_$clé"] ?? $model['Developpeur'][$clé];
            }
            $model['Developpeur'] = $t;
            $model->SauvegardeElementAttribut('Credits', 'Developpeur');

            $t = [];
            foreach (array_keys($model['Hebergeur']) as $clé) {
                $t[$clé] = $variables["Hebergeur_$clé"] ?? $model['Hebergeur'][$clé];
            }
            $model['Hebergeur'] = $t;
            $model->SauvegardeElementAttribut('Credits', 'Hebergeur');

            $this->flashSucces('Crédits enregistrés.');
            $Callback = 'index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback', 'variableCallback'));
        }

        $main = $this->renduPage("modifCredit", compact('model'));
        $this->afficherPage($main);
    }

    public function modifEntete(array $variables = [])
    {
        $model = $this->motif;

        if (array_key_exists('form', $variables)) {

            if ($this->refuserSiCsrfInvalide()) {
                $main = $this->renduPage("modifEntete", compact('model'));
                $this->afficherPage($main);
                return;
            }

            $t = [];
            foreach (array_keys($model['Entete']) as $clé) {
                $t[$clé] = $variables[$clé] ?? $model['Entete'][$clé];
            }
            $model['Entete'] = $t;
            $model->SauvegardeElement('Entete');

            $this->flashSucces('En-tête enregistré.');
            $Callback = 'index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback', 'variableCallback'));
        }

        $main = $this->renduPage("modifEntete", compact('model'));
        $this->afficherPage($main);
    }

    public function modifMenu(array $variables = [])
    {
        $AdministrationSite = $this->motif;
        $model = $AdministrationSite['Menus'][$variables['menu']];

        if (array_key_exists('form', $variables)) {

            if ($this->refuserSiCsrfInvalide()) {
                $main = $this->renduPage("modifMenu", compact('model'));
                $this->afficherPage($main);
                return;
            }

            if (array_key_exists('description', $variables))
                $AdministrationSite['Menus'][$variables['menu']]->set('description', $variables['description']);

            if (array_key_exists('image', $variables))
                $AdministrationSite['Menus'][$variables['menu']]->set('image', $variables['image']);

            if (array_key_exists('css', $variables))
                $AdministrationSite['Menus'][$variables['menu']]->set('css', $variables['css']);

            if (array_key_exists('cible', $variables))
                $AdministrationSite['Menus'][$variables['menu']]->set('cible', $variables['cible']);

            $AdministrationSite['Menus'][$variables['menu']]->SauvegardeElement();

            $this->flashSucces('Menu enregistré.');
            $Callback = 'index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback', 'variableCallback'));
        }

        $main = $this->renduPage("modifMenu", compact('model'));
        $this->afficherPage($main);
    }

    public function modifPied(array $variables = [])
    {
        $AdministrationSite = $this->motif;
        $model = $AdministrationSite['Pied'][$variables['menu']];

        if (array_key_exists('form', $variables)) {

            if ($this->refuserSiCsrfInvalide()) {
                $main = $this->renduPage("modifMenu", compact('model'));
                $this->afficherPage($main);
                return;
            }

            if (array_key_exists('description', $variables))
                $AdministrationSite['Pied'][$variables['menu']]->set('description', $variables['description']);

            if (array_key_exists('image', $variables))
                $AdministrationSite['Pied'][$variables['menu']]->set('image', $variables['image']);

            if (array_key_exists('css', $variables))
                $AdministrationSite['Pied'][$variables['menu']]->set('css', $variables['css']);

            if (array_key_exists('cible', $variables))
                $AdministrationSite['Pied'][$variables['menu']]->set('cible', $variables['cible']);

            $AdministrationSite['Pied'][$variables['menu']]->SauvegardeElement();

            $this->flashSucces('Pied de page enregistré.');
            $Callback = 'index';
            $variableCallback = [];
            $this->redirigerRoute(compact('Callback', 'variableCallback'));
        }

        $main = $this->renduPage("modifMenu", compact('model'));
        $this->afficherPage($main);
    }
}
