<?php

namespace systeme;

use systeme\objets\Collection;
use motif\modele\Motif;

/**
 * Noyau du système
 *
 * - Singleton
 * - Centralise les données
 * - Découvre automatiquement les applications (dossiers app* + motif)
 * - Gère le routage vers le bon contrôleur
 *
 * Objectif : ajouter ou supprimer une application = ajouter ou supprimer uniquement le dossier.
 */
class Noyau
{
    const FICHIER_INI = "";

    private static $_instance;

    public static function getInstance(): Noyau
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Noyau();
        }
        return self::$_instance;
    }

    protected $motif;
    public $données;

    /** @var array Liste des contrôleurs d'application */
    protected $controleurs = [];

    protected $routes = [];

    public function getDonnées(string $clee)
    {
        return $this->données->get($clee);
    }

    public function getControleurs()
    {
        return $this->controleurs;
    }

    public function getControleur(string $NomControleur)
    {
        foreach ($this->controleurs as $controleur) {
            if ($controleur->getNomApplication() == $NomControleur) {
                return $controleur;
            }
        }
        return null;
    }

    public function __construct()
    {
        $this->données = new Collection();

        // Chargement de la configuration via Motif
        $this->motif = new Motif('ini_monBlog.xml');

        $this->données['#DataBaseServeur']     = $this->motif['Configuration']['DataBaseServeur'];
        $this->données['#DatabasePort']        = "3307";
        $this->données['#DataBaseNon']         = $this->motif['Configuration']['DataBaseNon'];
        $this->données['#DatabaseCharset']     = "utf8";
        $this->données['#DataBaseUtilisateur'] = $this->motif['Configuration']['DataBaseUtilisateur'];
        $this->données['#DataBaseMdP']         = $this->motif['Configuration']['DataBaseMdP'];

        // ===== DÉCOUVERTE AUTOMATIQUE DES APPLICATIONS =====
        $this->decouvrirApplications();
    }

    /**
     * Découvre et instancie automatiquement tous les contrôleurs
     * présents dans les dossiers "app*" et "motif".
     *
     * Convention :
     *   - dossier "appAlbum"     → classe \appAlbum\CtrAlbum
     *   - dossier "appAnnuaire"  → classe \appAnnuaire\CtrlAnnuaire (gère Ctr/Ctrl)
     *   - dossier "motif"        → classe \motif\CtrMotif
     */
    protected function decouvrirApplications(): void
    {
        $racine = $_SERVER["DOCUMENT_ROOT"];
        $dossiers = array_filter(glob($racine . DIRECTORY_SEPARATOR . '*'), 'is_dir');

        foreach ($dossiers as $cheminDossier) {
            $nomDossier = basename($cheminDossier);

            // On ne prend que "motif" et les dossiers qui commencent par "app"
            if ($nomDossier !== 'motif' && strpos($nomDossier, 'app') !== 0) {
                continue;
            }

            $classe = $this->trouverClasseControleur($nomDossier);

            if ($classe !== null && class_exists($classe)) {
                $this->controleurs[] = new $classe($this->motif);
            }
        }
    }

    /**
     * Détermine le nom complet de la classe contrôleur à partir du nom du dossier.
     */
    protected function trouverClasseControleur(string $nomDossier): ?string
    {
        if ($nomDossier === 'motif') {
            return '\\motif\\CtrMotif';
        }

        // Enlève le préfixe "app" → Album, Page01, Annuaire, etc.
        $nomCourt = ucfirst(substr($nomDossier, 3));

        // Essai Ctr... puis Ctrl... (pour gérer l'ancienne incohérence Annuaire)
        $candidats = [
            '\\' . $nomDossier . '\\Ctr'  . $nomCourt,
            '\\' . $nomDossier . '\\Ctrl' . $nomCourt,
        ];

        foreach ($candidats as $classe) {
            if (class_exists($classe)) {
                return $classe;
            }
        }

        // Aucune classe trouvée → on ignore ce dossier
        return null;
    }

    public function navig()
    {
        if (array_key_exists('application', $_GET)) {
            $application = $_GET['application'];

            $fonction = null;
            if (array_key_exists('fonction', $_GET)) {
                $fonction = $_GET['fonction'];
            }

            $tabVariables = [];

            if (array_key_exists('variables', $_GET)) {
                $variables = $_GET['variables'];
                $variableCallback = $this->getControleur($application)
                    ->getRouteur()
                    ->getRoute($fonction)
                    ->getVariableCallback();

                $match = null;
                $patern = "%[\\w\\s]+:[\\w\\s-]+%";
                preg_match_all($patern, $variables, $match);

                foreach ($match as $var) {
                    foreach ($var as $variableCallback) {
                        $t2 = explode(":", $variableCallback);
                        $tabVariables[$t2[0]] = $t2[1];
                    }
                }
            }

            if (count($_POST) != 0) {
                foreach ($_POST as $var => $val) {
                    $tabVariables[$var] = $val;
                }
            }
        } else {
            // Application par défaut
            $application = "Page02";
            $fonction = "index";
            $tabVariables = [];
        }

        $controleur = $this->getControleur($application);

        if ($controleur === null) {
            // Sécurité : application inconnue
            die("Application « {$application} » introuvable.");
        }

        $controleur->ExecCallable($fonction, $tabVariables);
    }

    /* ========== Fonctions de débogage ========== */

    public function memRoutes()
    {
        foreach ($this->controleurs as $controleur) {
            foreach ($controleur->getRouteur()->getRoutes() as $route) {
                $this->routes[] = $route;
            }
        }
    }

    public function memAllUrl()
    {
        foreach ($this->routes as $route) {
            $var = [];
            echo "- " . $route->generateUri($var) . "<br>";
        }
    }
}
