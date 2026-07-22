<?php
/**
 * Contrôleur de l'application Motif (administration du site).
 *
 * Interface unique à onglets : tous les formulaires sont dans index.php.
 * Les méthodes modif* ne gèrent plus que les POST (enregistrement).
 * En cas d'accès GET ou d'erreur CSRF → retour vers l'onglet concerné.
 *
 * @author Ulysse1976
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

    /**
     * Affiche le layout Motif (page + body).
     * L'aside est volontairement simplifié : les onglets remplacent la navigation latérale.
     */
    public function afficherPage($main)
    {
        $this->motif['aside'] = [];

        $dossier = "/appBotanique/vue/resources"; // historique, conservé pour compatibilité
        $this->motif->ajoutFichier($dossier);

        $body = $this->renduPage("body", compact('main'));
        echo $this->renduPage("page", compact('body'));
    }

    /**
     * Page principale avec système d'onglets + formulaires intégrés.
     */
    public function index(array $variables = [])
    {
        $model  = $this->motif;
        $onglet = $variables['onglet'] ?? ($_GET['onglet'] ?? 'apercu');

        $ongletsValides = ['apercu', 'configuration', 'credits', 'entete', 'menus', 'pied'];
        if (!in_array($onglet, $ongletsValides, true)) {
            $onglet = 'apercu';
        }

        $main = $this->renduPage("index", compact('model', 'onglet'));
        $this->afficherPage($main);
    }

    public function modifConfiguration(array $variables = [])
    {
        // Seuls les POST sont traités ici ; le reste renvoie vers l'onglet
        if (!array_key_exists('form', $variables)) {
            $this->redirigerVersOnglet('configuration');
            return;
        }

        if ($this->refuserSiCsrfInvalide()) {
            $this->redirigerVersOnglet('configuration');
            return;
        }

        $model = $this->motif;
        $t = [];
        foreach (array_keys($model['Configuration']) as $clé) {
            $t[$clé] = $variables[$clé] ?? $model['Configuration'][$clé];
        }
        $model['Configuration'] = $t;
        $model->SauvegardeElement('Configuration');

        $this->flashSucces('Configuration enregistrée.');
        $this->redirigerVersOnglet('configuration');
    }

    public function modifCredit(array $variables = [])
    {
        if (!array_key_exists('form', $variables)) {
            $this->redirigerVersOnglet('credits');
            return;
        }

        if ($this->refuserSiCsrfInvalide()) {
            $this->redirigerVersOnglet('credits');
            return;
        }

        $model = $this->motif;

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
        $this->redirigerVersOnglet('credits');
    }

    public function modifEntete(array $variables = [])
    {
        if (!array_key_exists('form', $variables)) {
            $this->redirigerVersOnglet('entete');
            return;
        }

        if ($this->refuserSiCsrfInvalide()) {
            $this->redirigerVersOnglet('entete');
            return;
        }

        $model = $this->motif;
        $t = [];
        foreach (array_keys($model['Entete']) as $clé) {
            $t[$clé] = $variables[$clé] ?? $model['Entete'][$clé];
        }
        $model['Entete'] = $t;
        $model->SauvegardeElement('Entete');

        $this->flashSucces('En-tête enregistré.');
        $this->redirigerVersOnglet('entete');
    }

    public function modifMenu(array $variables = [])
    {
        if (!array_key_exists('form', $variables)) {
            $this->redirigerVersOnglet('menus');
            return;
        }

        $AdministrationSite = $this->motif;
        $menuKey = $variables['menu'] ?? '';

        if (!isset($AdministrationSite['Menus'][$menuKey])) {
            $this->flashErreur('Menu introuvable.');
            $this->redirigerVersOnglet('menus');
            return;
        }

        if ($this->refuserSiCsrfInvalide()) {
            $this->redirigerVersOnglet('menus');
            return;
        }

        if (array_key_exists('description', $variables)) {
            $AdministrationSite['Menus'][$menuKey]->set('description', $variables['description']);
        }
        if (array_key_exists('image', $variables)) {
            $AdministrationSite['Menus'][$menuKey]->set('image', $variables['image']);
        }
        if (array_key_exists('css', $variables)) {
            $AdministrationSite['Menus'][$menuKey]->set('css', $variables['css']);
        }
        if (array_key_exists('cible', $variables)) {
            $AdministrationSite['Menus'][$menuKey]->set('cible', $variables['cible']);
        }

        $AdministrationSite['Menus'][$menuKey]->SauvegardeElement();

        $this->flashSucces('Menu enregistré.');
        $this->redirigerVersOnglet('menus');
    }

    public function modifPied(array $variables = [])
    {
        if (!array_key_exists('form', $variables)) {
            $this->redirigerVersOnglet('pied');
            return;
        }

        $AdministrationSite = $this->motif;
        $menuKey = $variables['menu'] ?? '';

        if (!isset($AdministrationSite['Pied'][$menuKey])) {
            $this->flashErreur('Élément de pied de page introuvable.');
            $this->redirigerVersOnglet('pied');
            return;
        }

        if ($this->refuserSiCsrfInvalide()) {
            $this->redirigerVersOnglet('pied');
            return;
        }

        if (array_key_exists('description', $variables)) {
            $AdministrationSite['Pied'][$menuKey]->set('description', $variables['description']);
        }
        if (array_key_exists('image', $variables)) {
            $AdministrationSite['Pied'][$menuKey]->set('image', $variables['image']);
        }
        if (array_key_exists('css', $variables)) {
            $AdministrationSite['Pied'][$menuKey]->set('css', $variables['css']);
        }
        if (array_key_exists('cible', $variables)) {
            $AdministrationSite['Pied'][$menuKey]->set('cible', $variables['cible']);
        }

        $AdministrationSite['Pied'][$menuKey]->SauvegardeElement();

        $this->flashSucces('Pied de page enregistré.');
        $this->redirigerVersOnglet('pied');
    }

    /**
     * Redirige vers la page index avec l'onglet souhaité.
     */
    private function redirigerVersOnglet(string $onglet): void
    {
        $uri = 'index.php?application=' . urlencode($this->nomApplication)
             . '&fonction=index'
             . '&onglet=' . urlencode($onglet);

        header('Location: ' . $uri);
        exit;
    }
}
