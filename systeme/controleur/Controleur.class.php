<?php
namespace systeme\controleur;

use systeme\routeur\Routeur;
use motif\modele\Motif;
use systeme\routeur\Route;
use systeme\securite\Csrf;

/**
 * Classe de base de tous les contrôleurs d'application.
 *
 * - Déduit automatiquement $nomApplication à partir du namespace
 *   (appBlog → Blog, motif → motif, etc.)
 * - Plus besoin de la ligne str_replace(...) dans les contrôleurs enfants.
 *
 * Phase 6 : renduPage robuste + helpers CSRF.
 *
 * @author Ulysse1976
 */
class Controleur
{
    const DEFCONTAINER = __DIR__.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.'Config.php';

    protected $nomApplication;

    public function getNomApplication()
    {
        return $this->nomApplication;
    }

    protected $routeur;

    public function getRouteur()
    {
        return $this->routeur;
    }

    protected $motif;

    use Rediriger;

    public function __construct(Motif $motif)
    {
        // ===== Déduction automatique du nom d'application =====
        // Permet d'ajouter une application sans avoir à écrire
        // $this->nomApplication = str_replace("app", "", __NAMESPACE__);
        $ns = (new \ReflectionClass($this))->getNamespaceName();

        if ($ns === 'motif') {
            $this->nomApplication = 'motif';
        } else {
            // appBlog → Blog, appPage02 → Page02, appAnnuaire → Annuaire, etc.
            $this->nomApplication = str_replace('app', '', $ns);
        }

        $this->routeur = new Routeur();
        $this->motif   = $motif;

        $s = DIRECTORY_SEPARATOR;
        $x = $_SERVER["DOCUMENT_ROOT"] . "{$s}motif{$s}vue{$s}";

        // Routes communes fournies par le motif (aside / body / page)
        $this->routeur->addRoute(new Route($this->nomApplication, "aside", "", "", "{$x}aside.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "body",  "", "", "{$x}body.php"));
        $this->routeur->addRoute(new Route($this->nomApplication, "page",  "", "", "{$x}page.php"));
    }

    public function ExecCallable(string $callback, array $variables = [])
    {
        $variablesCallable[] = $variables;
        $controleur = $this;
        $callable = array($controleur, $callback);

        return call_user_func_array($callable, $variablesCallable);
    }

    /**
     * Fait un rendu de la vue.
     *
     * @param string $nomDeVue nom de la vue sous la forme "nomDeLaVue"
     * @return string
     */
    public function renduPage(string $nomDeVue, array $variables = []): string
    {
        $route = $this->routeur->getRoute($nomDeVue);

        if ($route === null) {
            return '<!-- Vue « ' . htmlspecialchars($nomDeVue, ENT_QUOTES, 'UTF-8') . ' » introuvable -->';
        }

        $fichierVue = $route->getVue();

        if (!is_file($fichierVue)) {
            return '<!-- Fichier de vue introuvable : ' . htmlspecialchars($fichierVue, ENT_QUOTES, 'UTF-8') . ' -->';
        }

        $variables['nomDeVue'] = $nomDeVue;
        extract($variables); // rend les variables visibles dans la vue
        ob_start();

        require $fichierVue;

        return ob_get_clean();
    }

    /**
     * Vérifie le token CSRF (à appeler avant tout traitement POST sensible).
     *
     * @return bool true si le token est valide
     */
    protected function verifierCsrf(): bool
    {
        return Csrf::valider();
    }

    /**
     * Génère le champ HTML CSRF (raccourci pour les vues via le contrôleur).
     */
    public function champCsrf(): string
    {
        return Csrf::champ();
    }

    public function dataCheckboxList(array $nomVariables, string $etiquetteRecherché)
    {
        $resultat = [];
        foreach ($nomVariables as $etiquette) {
            $recherche = strstr($etiquette, $etiquetteRecherché);

            if ($recherche !== false) {
                $resultat[] = str_replace($etiquetteRecherché, '', $recherche);
            }
        }

        return implode(';', $resultat);
    }
}
