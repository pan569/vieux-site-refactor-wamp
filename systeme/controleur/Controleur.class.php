<?php
namespace systeme\controleur;


use systeme\routeur\Routeur;
use motif\modele\Motif;
use systeme\routeur\Route;

/**
 *
 * @author Ulysse1976
 *        
 */

class Controleur
{
    
    const DEFCONTAINER = __DIR__.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.'Config.php';
    
    
    protected $nomApplication;
    public function getNomApplication()
    {
        return $this->nomApplication ;
    }
    
    protected $routeur ;    
    public function getRouteur()
    {        
        return $this->routeur ;
    }
    
    protected $motif;
    
    
    use Rediriger;

    /**
     */
    public function __construct(Motif $motif)
    {
        
        $this->routeur = new Routeur();
       
       
       //$this->motif = new Motif('ini_monBlog.xml');
       $this->motif=$motif;
       
       $s=DIRECTORY_SEPARATOR;
       $x =$_SERVER ["DOCUMENT_ROOT"]."{$s}motif{$s}vue{$s}";
       //$x = str_replace( ["\\",'/'] , $s , $x  );
      
       $this->routeur->addRoute(new Route($this->nomApplication, "aside","", "","{$x}aside.php"));
       $this->routeur->addRoute(new Route($this->nomApplication, "body", "", "","{$x}body.php"));
       $this->routeur->addRoute(new Route($this->nomApplication, "page", "", "","{$x}page.php"));
       
    }
    
    public function ExecCallable(string $callback, array $variables = [])
    {
        
        //debug($this,"controleur_ExecCallable");
        //debug($callback,"controleur_ExecCallable_callback");
        //debug($variables,"controleur_ExecCallable_Variables");
        
        $variablesCallable[] = $variables;
        $controleur = $this;
        $callable =array($controleur ,$callback); //__NAMESPACE__ .'\Foo::test'
        
        //debug($callable,"controleur_ExecCallable_callable");
        //debug($variablesCallable,"controleur_ExecCallable_variablesCallable");
        
        return call_user_func_array($callable,$variablesCallable);
        
    }
    
    /**
     *
     * Fait un rendu de la vue
     *
     * @param string $nomDeVue nom de la vue sous la forme "nomDeLaVue" ou "EspaceDeNom#nomDeLaVue"
     * @return string
     */
    public function renduPage(string $nomDeVue, array $variables = []):string
    {
        $variables['nomDeVue']=$nomDeVue;
        extract($variables);// permet de rendre les variables visible dans la vue
        ob_start();
        
        
        //debug($nomDeVue,"controleur->renduPage() nomDeVue");
        //debug($this->routeur->getRoutes(),"controleur->renduPage() les routes");
        //debug($this->routeur->getRoute($nomDeVue),"controleur->renduPage(nomDeVue)");
        //require($_SERVER ["DOCUMENT_ROOT"]."/motif/vue/page.php");
        require($this->routeur->getRoute($nomDeVue)->getVue());
        
        return ob_get_clean();
    }
    
    Public function dataCheckboxList(array $nomVariables, string $etiquetteRecherché)
    {
        $resultat = [];
        foreach ($nomVariables as $etiquette )
        {
            
            $recherche = strstr($etiquette, $etiquetteRecherché); //'FLEURESON_'
            
            if($recherche != false )
            {
                $resultat[] = str_replace( $etiquetteRecherché , '' , $recherche );
                
            }
            
        }
        
        /*
        // Transforme le tableau en chaine de caractere, avec chaque données séparé par un ';'
        //-------------------------------------------------------------
        //1)supprimer les elements vides du tableau
        $tab = array_filter($variables[$clé]);
        
        //2)transforme le tableau en chaine de caractere
        $resultat = implode ( ';' , $tab ) ;
        //-------------------------------------------------------------
        
        //enregistrement de la donnée dans $model
        //$model->set($clé,$resultat);
        /**/
        
        return implode ( ';' , $resultat ) ;
    }
    
}

