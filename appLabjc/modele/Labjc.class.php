<?php
namespace appLabjc\modele;

use systeme\objets\Item;

/**
 *
 * @author Ulysse1976
 * 12/022019 06:07       
 */
class Labjc extends Item
{

    public function __construct($id = null)
    {
        //string $nom, string $type, array $taille, bool $nullable, string $commentaires, $defaut,string $validation, array $optionType = []
        
        self::getDictionaire()->clearDefinition();
        
        parent::__construct($id);
        
        return $this;
    }
    
}

