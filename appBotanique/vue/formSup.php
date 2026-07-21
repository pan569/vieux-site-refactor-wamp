<?php
namespace appBotanique\vue;

use systeme\vue\form;

class formSup extends form
{
    
    private static $_instance;
    /*
     * singleton de la classe
     */
    public static function getInstance(string $classe = null)
    {
        if(is_null(self::$_instance))
            self::$_instance = new formSup();
            
            return self::$_instance;
    }
    
    public function test01 (/*$titre, $nom, $valeur*/)
    {
        
        $list= array('Jr','Fr','Ms','Al','Mi','Jn','Jt','At','Se','Oe','Ne','De');
        
        $resultat = NULL;
        foreach ($list as $mois)
        {
            $resultat .= $this->ConstructeurChamp($mois, $mois, false , 'checkbox',);
        }
    
        
             //
         
         return $resultat;
         
    }
    
    
}


