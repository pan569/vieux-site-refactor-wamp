<?php
namespace systeme\controleur;

/**
 * Trait de redirection vers une route de l'application courante.
 *
 * Phase 6 : plus de domaine hardcodé (http://site01/).
 * Utilise une URL relative pour fonctionner sur n'importe quel hôte WAMP.
 */
trait Rediriger
{
    /**
     * Redirige vers une route de l'application.
     *
     * @param array $variables Doit contenir :
     *   - 'Callback'         : nom de la méthode / route cible
     *   - 'variableCallback' : tableau des variables de route (optionnel)
     */
    public function redirigerRoute(array $variables = []): void
    {
        $callback = $variables['Callback'] ?? 'index';
        $params   = $variables['variableCallback'] ?? [];

        $route = $this->routeur->getRoute($callback);

        if ($route === null) {
            // Fallback sûr : retour à l'index de l'application
            $uri = 'index.php?application=' . urlencode($this->nomApplication) . '&fonction=index';
        } else {
            $uri = $route->generateUri($params);
        }

        // URL relative → fonctionne quel que soit le nom d'hôte / virtual host
        header('Location: ' . $uri);
        exit;
    }
}
