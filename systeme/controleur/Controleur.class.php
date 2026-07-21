<?php
namespace systeme\controleur;

use systeme\routeur\Routeur;
use motif\modele\Motif;
use systeme\routeur\Route;
use systeme\securite\Csrf;
use systeme\message\MessageFlash;

/**
 * Classe de base de tous les contrôleurs d'application.
 *
 * - Déduit automatiquement $nomApplication à partir du namespace
 * - Helpers CSRF (Phase 6)
 * - Helpers messages flash (Phase 7)
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
        $ns = (new \ReflectionClass($this))->getNamespaceName();

        if ($ns === 'motif') {
            $this->nomApplication = 'motif';
        } else {
            $this->nomApplication = str_replace('app', '', $ns);
        }

        $this->routeur = new Routeur();
        $this->motif   = $motif;

        $s = DIRECTORY_SEPARATOR;
        $x = $_SERVER["DOCUMENT_ROOT"] . "{$s}motif{$s}vue{$s}";

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
        extract($variables);
        ob_start();

        require $fichierVue;

        return ob_get_clean();
    }

    /* ========== CSRF (Phase 6) ========== */

    protected function verifierCsrf(): bool
    {
        return Csrf::valider();
    }

    public function champCsrf(): string
    {
        return Csrf::champ();
    }

    /* ========== Messages flash (Phase 7) ========== */

    protected function flashSucces(string $message): void
    {
        MessageFlash::succes($message);
    }

    protected function flashErreur(string $message): void
    {
        MessageFlash::erreur($message);
    }

    protected function flashInfo(string $message): void
    {
        MessageFlash::info($message);
    }

    /**
     * HTML des messages flash (pour usage manuel dans une vue).
     * En pratique body.php les affiche déjà automatiquement.
     */
    public function afficherFlash(): string
    {
        return MessageFlash::html();
    }

    /**
     * Refuse une action POST si le token CSRF est invalide.
     * Pose un message flash et retourne true si refus.
     */
    protected function refuserSiCsrfInvalide(): bool
    {
        if ($this->verifierCsrf()) {
            return false;
        }

        $this->flashErreur('Action refusée : jeton de sécurité invalide ou expiré. Veuillez réessayer.');
        return true;
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
