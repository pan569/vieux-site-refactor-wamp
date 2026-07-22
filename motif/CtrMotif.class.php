<?php
/**
 * Contrôleur de l'application Motif (administration du site).
 *
 * Phase onglets : une interface unique avec navigation par onglets
 * (Vue d'ensemble / Configuration / Crédits / En-tête / Menus / Pied).
 * Les formulaires POST restent séparés pour simplicité et robustesse.
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
        // Plus d'aside complexe pour l'admin : les onglets suffisent
        $this->motif['aside'] = [];

        $dossier = "/appBotanique/vue/resources"; // historique, conservé pour compatibilité
        $this->motif->ajoutFichier($dossier);

        $body = $this->renduPage("body", compact('main'));
        echo $this->renduPage("page", compact('body'));
    }

    /**
     * Page principale avec système d'onglets.
     * Paramètre GET 'onglet' pour ouvrir directement le bon panneau après un enregistrement.
     */
    public function index(array $variables = [])
    {
        $model  = $this->motif;
        $onglet = $variables['onglet'] ?? ($_GET['onglet'] ?? 'apercu');

        // Onglets autorisés
        $ongletsValides = ['apercu', 'configuration', 'credits', 'entete', 'menus', 'pied'];
        if (!in_array($onglet, $ongletsValides, true)) {
            $onglet = 'apercu';
        }

        $main = $this->renduPage("index", compact('model', 'onglet'));
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
            $this->redirigerVersOnglet('configuration');
            return;
        }

        // Affichage direct du formulaire (lien depuis un onglet ou favori)
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
            $this->redirigerVersOnglet('credits');
            return;
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
            $this->redirigerVersOnglet('entete');
            return;
        }

        $main = $this->renduPage("modifEntete", compact('model'));
        $this->afficherPage($main);
    }

    public function modifMenu(array $variables = [])
    {
        $AdministrationSite = $this->motif;
        $model = $AdministrationSite['Menus'][$variables['menu']] ?? null;

        if ($model === null) {
            $this->flashErreur('Menu introuvable.');
            $this->redirigerVersOnglet('menus');
            return;
        }

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
            $this->redirigerVersOnglet('menus');
            return;
        }

        $main = $this->renduPage("modifMenu", compact('model'));
        $this->afficherPage($main);
    }

    public function modifPied(array $variables = [])
    {
        $AdministrationSite = $this->motif;
        $model = $AdministrationSite['Pied'][$variables['menu']] ?? null;

        if ($model === null) {
            $this->flashErreur('Élément de pied de page introuvable.');
            $this->redirigerVersOnglet('pied');
            return;
        }

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
            $this->redirigerVersOnglet('pied');
            return;
        }

        $main = $this->renduPage("modifMenu", compact('model'));
        $this->afficherPage($main);
    }

    /**
     * Redirige vers la page index avec l'onglet souhaité.
     */
    private function redirigerVersOnglet(string $onglet): void
    {
        $Callback = 'index';
        $variableCallback = ['onglet' => $onglet];
        $this->redirigerRoute(compact('Callback', 'variableCallback'));
    }
}
