<?php
/**
 * Created by PhpStorm.
 * User: Ulysse1976
 * Date: 16/12/2018
 * Time: 07:38
 */
namespace systeme\objets;

use Traversable;


class Collection implements \ArrayAccess, \IteratorAggregate
{
    /**
     * Liste des Attributs de la classe enfant
     *
     * @var array
     * @access private
     */
    protected $donnees = [];
    
    /**
     * Retourne le tableau de données
     *
     * @param void
     * @return array $donnees
     */
    public function getDonnees()
    {
        return $this->donnees;
    }
    /**
     * Charge un tableau dans le tableau de données
     * 
     * @param array $tab
     * @return void
     */
    public function setDonnees(array $tab):void
    {
        foreach ($tab as $clée => $valeur)
        {
            $this->donnees[$clée] = $valeur;
        }
    }

    /**
     * 
     * 
     * @param string $clee
     * @return unknown/false
     */
    public function get(string $clee)
    {
        if($this->cleeExiste($clee))
            return $this->donnees[$clee];
        else
            return false;
    }

    /**
     * ajoute une entrée aux données
     * si la clée existe, sa valeur est ecrasé
     * 
     * @param string $clee
     * @param mixed $valeur
     */
    public function set(string $clee, $valeur)
    {
        $this->donnees[$clee]=$valeur;
    }

    /**
     * insert un tableau de donnée dans le tableau de donnée de la collection
     * 
     * @param array $Tab
     */
    public function InsertDonnées(array $Tab):void
    {
        $listeClésDonnées = array_keys ($this->donnees);
        
        foreach ($listeClésDonnées as $clé)
        {
            
            $this->donnees[$clé] = $Tab[$clé];
        }
    }
    
    public function ajoutDonnées(array $Tab):void
    {
        $listeClésDonnées = array_keys ($Tab);
        
        foreach ($listeClésDonnées as $clé)
        {
            $this->donnees[$clé] = $Tab[$clé];
        }
    }
    
    /**
     * est ce que la clée existe ?
     * 
     * @param string $clee
     * @return bool
     */
    public function cleeExiste(string $clee):bool
    {
        return array_key_exists($clee,$this->donnees);
    }

    /**
     * ??? Je ne sais pas ce que j'ai voulu faire avec cette fonction ???
     * 
     * @param string $clee
     * @param ? $valeur
     * @return collection
     */
    public function listeDonnées(string $clee,$valeur)
    {

        $resultat=[];
        foreach ($this->donnees as $donnee)
        {   
            if(gettype($donnee)=="array" && array_key_exists($clee,$donnee) )
            {
                $resultat[$donnee[$clee]]=$donnee[$valeur];                
            }
        }
       
        return new Collection($resultat);

    }

    /**
     * ??? Je ne sais pas ce que j'ai voulu faire avec cette fonction ???
     * 
     * @param string $clee
     * @return Collection
     */
    public function extract(string $clee):Collection
    {
        $resultat=[];
        foreach ($this->donnees as $donnee)
        {
            if(gettype($donnee)=="array" && array_key_exists($clee,$donnee) )
            {
                $resultat[]=$donnee[$clee];
            }

        }
        return new Collection($resultat);
    }

    public function joint($separateur)
    {
        return implode($separateur,$this->donnees);
    }

    /**
     * 
     * @param ? $donnee
     */
    public function add($donnee):void
    {
        
        
        array_push($this->donnees,$donnee);
    }

    /**
     * 
     * @param array $données
     */
    public function __construct(array $données =[])
    {
        $this->donnees = $données;
    }
      
    
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

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->donnees);
    }
}