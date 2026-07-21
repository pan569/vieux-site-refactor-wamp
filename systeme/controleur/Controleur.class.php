<?php
namespace systeme\controleur;

use systeme\routeur\Routeur;
use motif\modele\Motif;
use systeme\routeur\Route;

/**
 * Classe de base de tous les contrôleurs d'application.
 *
 * - Déduit automatiquement $nomApplication à partir du namespace
 *   (appBlog → Blog, motif → motif, etc.)
 * - Plus besoin de la ligne str_replace(...) dans les contrôleurs enfants.
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
        $variables['nomDeVue'] = $nomDeVue;
        extract($variables); // rend les variables visibles dans la vue
        ob_start();

        require($this->routeur->getRoute($nomDeVue)->getVue());

        return ob_get_clean();
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
