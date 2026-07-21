<?php
namespace systeme\objets;


/**
 *
 * @author Ulysse1976
 *        
 */
class ItemCollection  implements \ArrayAccess, \IteratorAggregate
{

    /**
     * Liste des Attributs de la classe enfant
     *
     * @var array
     * @access private
     */
    protected $itemCollection = [];
 
    
    /**
     *
     *
     * @param string $clee
     * @return unknown/false
     */
    public function get(string $cle)
    {
        if($this->cleeExiste($cle))
        {
            return $this->itemCollection[$cle];
        }
        else
        {
            return false;
        }
    }
    
    /**
     * ajoute une entrée aux données
     * si la clée existe, sa valeur est ecrasé
     *
     * @param string $clee
     * @param mixed $valeur
     */
    public function set(string $cle, $valeur)
    {
        $this->itemCollection[$cle]=$valeur;
    }
        
    /**
     * est ce que la clée existe ?
     *
     * @param string $clee
     * @return bool
     */
    public function cleeExiste(string $cle):bool
    {
        return array_key_exists($cle,$this->itemCollection);
    }
    
    
       
    /**
     */
    public function __construct()
    {}

    
    //Fonctions de l'interface ArrayAccess
    
    public function offsetExists($offset)
    {
        return $this->cleeExiste($offset);
    }
    
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
    
    public function offsetSet($offset, $value)
    {
        $this->set($offset,$value);
    }
    
    public function offsetUnset($offset)
    {
        if($this->cleeExiste($offset))
            unset($this->donnees[$offset]);
    }
    
    //Fonctions de l'interface IteratorAggregate
    
    public function getIterator()
    {
        return new \ArrayIterator($this->itemCollection);
    }
    
    
    //Fonctions de Persistance
    /**
     */
    public function SELECT()
    {
        $this->TableauItem(Persistance::getInstance()->SELECT(self::getNomTable()));
    }
    
    public function SELECT_PAGE(int $page = 10)
    {
        $this->TableauItem(Persistance::getInstance()->SELECT_PAGE(self::getNomTable(),$page));
    }
    
    
    /**
     *
     * @param array $DataDonnées
     * @return item[]
     */
    public function TableauItem(array $DataDonnées)
    {
        foreach ($DataDonnées as $DataDonnée)
        {
            
            $itemNom = get_called_class();
            $item = new $itemNom;
            
            $item->InsertDonnées($DataDonnée);
            
            $this->itemCollection[] = $item;
        }
        
    }
    
    
}

