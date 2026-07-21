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

    /** Application affichée quand aucune n'est demandée dans l'URL */
    protected $applicationParDefaut = 'Page02';

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

        // Application par défaut (configurable dans resources/ini_monBlog.xml)
        if (isset($this->motif['Configuration']['ApplicationParDefaut'])
            && $this->motif['Configuration']['ApplicationParDefaut'] !== '') {
            $this->applicationParDefaut = $this->motif['Configuration']['ApplicationParDefaut'];
        }

        // ===== DÉCOUVERTE AUTOMATIQUE DES APPLICATIONS =====
        $this->decouvrirApplications();
    }

    /**
     * Découvre et instancie automatiquement tous les contrôleurs
     * présents dans les dossiers "app*" et "motif".
     *
     * Convention unique :
     *   - dossier "appAlbum"  → classe \appAlbum\CtrAlbum
     *   - dossier "motif"     → classe \motif\CtrMotif
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
     * Convention unique : Ctr + NomCourt
     */
    protected function trouverClasseControleur(string $nomDossier): ?string
    {
        if ($nomDossier === 'motif') {
            return '\\motif\\CtrMotif';
        }

        // Enlève le préfixe "app" → Album, Page01, Annuaire, etc.
        $nomCourt = ucfirst(substr($nomDossier, 3));
        $classe   = '\\' . $nomDossier . '\\Ctr' . $nomCourt;

        if (class_exists($classe)) {
            return $classe;
        }

        // Aucune classe trouvée → on ignore ce dossier
        return null;
    }

    public function navig()
    {
        // --- Récupération des paramètres d'URL ---
        $application = $_GET['application'] ?? $this->applicationParDefaut;
        $fonction    = $_GET['fonction']    ?? 'index';
        $tabVariables = [];

        // Variables passées dans l'URL (?variables=id:12|p:2)
        if (!empty($_GET['variables'])) {
            $controleur = $this->getControleur($application);

            if ($controleur === null) {
                $this->erreur("Application « {$application} » introuvable.");
                return;
            }

            $route = $controleur->getRouteur()->getRoute($fonction);
            if ($route === null) {
                $this->erreur("Fonction « {$fonction} » introuvable dans l'application « {$application} ».");
                return;
            }

            $match = null;
            $patern = "%[\\w\\s]+:[\\w\\s-]+%";
            preg_match_all($patern, $_GET['variables'], $match);

            foreach ($match as $var) {
                foreach ($var as $paire) {
                    $t2 = explode(":", $paire);
                    if (count($t2) === 2) {
                        $tabVariables[$t2[0]] = $t2[1];
                    }
                }
            }
        }

        // Variables POST (formulaires)
        if (!empty($_POST)) {
            foreach ($_POST as $var => $val) {
                $tabVariables[$var] = $val;
            }
        }

        // --- Exécution ---
        $controleur = $this->getControleur($application);

        if ($controleur === null) {
            $this->erreur("Application « {$application} » introuvable.");
            return;
        }

        // Vérifie que la méthode existe bien dans le contrôleur
        if (!method_exists($controleur, $fonction)) {
            $this->erreur("La méthode « {$fonction} » n'existe pas dans le contrôleur de « {$application} ».");
            return;
        }

        $controleur->ExecCallable($fonction, $tabVariables);
    }

    /**
     * Affiche une erreur simple et arrête l'exécution.
     * (Peut être amélioré plus tard avec une vraie page d'erreur du motif)
     */
    protected function erreur(string $message): void
    {
        http_response_code(404);
        echo "<h1>Erreur</h1>";
        echo "<p>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><a href=\"index.php\">Retour à l'accueil</a></p>";
        exit;
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
