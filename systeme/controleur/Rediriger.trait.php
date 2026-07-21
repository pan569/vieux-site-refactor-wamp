<?php
namespace systeme\controleur;



/**
 *
 * @author Ulysse1976
 *        
 */
trait Rediriger
{
    /**
     * @param string $path
     * @param array $paramettres
     */
    public function redirigerRoute(array $variables = [])
    {
        //debug($variables,"rediriger->redirigerRoute variables ");
        
        $uri = $this->routeur->getRoute($variables['Callback'])->generateUri($variables['variableCallback']);
        
        //debug($uri,"rediriger->redirigerRoute uri ");
        
        header("Location: http://site01/{$uri}");
        exit();
        
    }
}

