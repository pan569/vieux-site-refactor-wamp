<?php
namespace systeme\routeur;

/**
 * Conteneur de routes d'une application.
 *
 * Phase 6 : getRoute() retourne null si la route n'existe pas
 * (évite les notices / erreurs fatales).
 */
class Routeur
{
    /** @var Route[] */
    protected $routes = [];

    /**
     * Retourne la route demandée, ou null si absente.
     */
    public function getRoute(string $nomRoute): ?Route
    {
        return $this->routes[$nomRoute] ?? null;
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function __construct()
    {
    }

    public function addRoute(Route $route): void
    {
        $this->routes[$route->getCallback()] = $route;
    }

    /**
     * Indique si une route existe.
     */
    public function hasRoute(string $nomRoute): bool
    {
        return isset($this->routes[$nomRoute]);
    }
}
