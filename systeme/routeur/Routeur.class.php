<?php
namespace systeme\routeur;

/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 19/12/2018
 * Time: 06:40
 */

class Routeur 
{
    protected $routes = [];
    
    public function getRoute(string $nomRoute):Route
    {
        /*
        debug($nomRoute,"route recherché");
        debug(array_keys($this->routes),"liste des routes");
        
        debug($this->routes[$nomRoute],"la route {$nomRoute}");
        /**/
        
        return $this->routes[$nomRoute];
    }
    
    public function getRoutes()
    {
        return  $this->routes;
    }

    public function __construct()
    {
        
    }
    
    public function  addRoute(Route $route)
    {
        
        $this->routes["{$route->getCallback()}"]=$route;
    }

   
}
