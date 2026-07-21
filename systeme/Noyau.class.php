<?php

namespace systeme;

use systeme\objets\Collection;
use systeme\securite\Securite;
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
 *
 * Phase 6 : sanitisation des paramètres URL + page d'erreur unifiée.
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
        // Session nécessaire pour CSRF et messages flash futurs
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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
        // --- Récupération et sanitisation des paramètres d'URL ---
        $application = Securite::sanitizeNom(
            $_GET['application'] ?? $this->applicationParDefaut
        );
        $fonction = Securite::sanitizeNom(
            $_GET['fonction'] ?? 'index'
        );

        if ($application === '') {
            $application = $this->applicationParDefaut;
        }
        if ($fonction === '') {
            $fonction = 'index';
        }

        $tabVariables = [];

        // Variables passées dans l'URL (?variables=id:12|p:2)
        if (!empty($_GET['variables'])) {
            $tabVariables = $this->parserVariablesUrl((string) $_GET['variables']);
        }

        // Variables POST (formulaires) — nettoyage léger des clés
        if (!empty($_POST)) {
            foreach ($_POST as $var => $val) {
                // On garde les tableaux (checkbox multiples) tels quels
                if (is_array($val)) {
                    $tabVariables[$var] = $val;
                } else {
                    $tabVariables[$var] = is_string($val) ? Securite::nettoyer($val) : $val;
                }
            }
        }

        // --- Exécution ---
        $controleur = $this->getControleur($application);

        if ($controleur === null) {
            $this->erreur("Application « {$application} » introuvable.", 404);
            return;
        }

        // Vérifie que la méthode existe bien dans le contrôleur
        if (!method_exists($controleur, $fonction)) {
            $this->erreur("La méthode « {$fonction} » n'existe pas dans le contrôleur de « {$application} ».", 404);
            return;
        }

        $controleur->ExecCallable($fonction, $tabVariables);
    }

    /**
     * Parse la chaîne variables de l'URL (format clé:valeur|clé2:valeur2).
     */
    protected function parserVariablesUrl(string $chaine): array
    {
        $resultat = [];

        // Accepte "clé:valeur" séparés par | ou ;
        $paires = preg_split('/[|;]/', $chaine);

        foreach ($paires as $paire) {
            $paire = trim($paire);
            if ($paire === '') {
                continue;
            }

            $parts = explode(':', $paire, 2);
            if (count($parts) === 2) {
                $cle = Securite::sanitizeNom($parts[0]);
                $val = Securite::nettoyer($parts[1]);
                if ($cle !== '') {
                    $resultat[$cle] = $val;
                }
            }
        }

        return $resultat;
    }

    /**
     * Affiche une page d'erreur unifiée (motif/vue/erreur.php) et arrête l'exécution.
     */
    protected function erreur(string $message, int $code = 404): void
    {
        http_response_code($code);

        $fichierErreur = $_SERVER['DOCUMENT_ROOT']
            . DIRECTORY_SEPARATOR . 'motif'
            . DIRECTORY_SEPARATOR . 'vue'
            . DIRECTORY_SEPARATOR . 'erreur.php';

        if (is_file($fichierErreur)) {
            // Variables disponibles dans la vue
            // $message, $code
            require $fichierErreur;
        } else {
            // Fallback minimal si le fichier motif est absent
            echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Erreur</title></head><body>';
            echo '<h1>Erreur ' . (int) $code . '</h1>';
            echo '<p>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<p><a href="index.php">Retour à l\'accueil</a></p>';
            echo '</body></html>';
        }

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
