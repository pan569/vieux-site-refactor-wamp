<?php
namespace systeme\utilitaire;

class Convertion
{
    
    private static $_Convertion;
    public static function getInstance()
    {
        if(is_null(self::$_Convertion))
        {
            self::$_Convertion = new Convertion();
        }
        return self::$_Convertion;
    }
    
    public function __construct()
    {
        
    }
    
    public function convTableVersTexte(array $tab, string $separateur):string
    {

        //1)supprimer les elements vides du tableau
        $tabResultat = array_filter($tab);
        
        //2)transforme le tableau en chaine de caractere
        $resultat = implode ( $separateur , $tabResultat ) ;

        return $resultat;
    }
    
    public function convTexteVersTable(string $chaine, string $separateur):array
    {
        $resultat = [];
        if(strpos($chaine, $separateur) != false)
        {
            $resultat = explode ( $separateur , $chaine);
            
            debug($resultat,"Conv convTexteVersTable $resultat");
        }
        else 
        {
            $resultat[] = $chaine;
        }
        
        return $resultat;
    }
    
}