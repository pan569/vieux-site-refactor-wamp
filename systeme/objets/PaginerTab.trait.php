<?php
namespace systeme\objets;

/**
 *
 * @author Ulysse1976
 *        
 */
trait PaginerTab
{
    protected $nombreItemParPage;//$perPage
    protected $numeroPage;
    protected $offset;
    protected $nombreItem;
    protected $nombrePage;
    protected $listeItem = [];
    
    
    /**
     * Retourne le tableau de données
     *
     * @param void
     * @return array $donnees
     */
    public function getListeItem()
    {
        return $this->listeItem;
    }
    
    /**
     * Charge un tableau dans le tableau de données
     *
     * @param array $tab
     * @return void
     */
    public function setListeItem(array $tab):void
    {
        foreach ($tab as $cle => $valeur)
        {
            $this->listeItem[$cle] = $valeur;
        }
    }
        
    /**
     * calcul le nombre d'item que contien la table corespondante
     */
    public function getNbreResutat()
    {        
        $this->nombreItem = count($this->listeItem);        
    }
    
    /**
     *
     *  * Claclul les parametres de pagination (en fonction du numero de page ($numeroPage)
     * et du nombre d'item devant etre afficher sur une page ($nombreItemParPage):
     * (Nombe d'item dans le tableau de la base de donnée($nombreItem),
     * le nombre de pages au total ($nombrePage),
     * l'offset ($offset) ).
     *
     * @param int $numeroPage numero page courante
     * @param int $nombreItemParPage Nombre d'item max a afficher sur 1 page.
     */
    public function calculePagination($numeroPage, int $nombreItemParPage = 10)
    {
        $this->getNbreResutat();
        $this->nombreItemParPage = $nombreItemParPage;
        $this->nombrePage = ceil($this->nombreItem/$this->nombreItemParPage);
        
        $numeroPage = (int)$numeroPage;
        
        if(! is_int( $numeroPage))
        {
            $numeroPage = 1;
        }
        
        if($numeroPage < 1)
        {
            //debug($numeroPage,"inferieur a 1");
            $numeroPage = 1;
        }
        
        if($numeroPage > $this->nombrePage)
        {
            $numeroPage = $this->nombrePage;
        }
        
        $this->numeroPage = $numeroPage;
        $this->offset = ( $this->numeroPage-1) * $this->nombreItemParPage;
        
    }
    
    /*
     * recupere la liste des items en fonction des parametres de pagination
     */
    public function getTranche()
    {
        return  array_slice ( $this->listeItem , $this->offset, $this->nombreItemParPage );
        //return Persistance::getInstance()->SELECT_PAGINATION(self::getNomTable(),self::$offset,self::$nombreItemParPage);
    }
    
    /**
     *
     * fabrique le module de navigation de la pagination
     *
     * @param string $lien
     * @return string
     */
    public function affichePagination(string $lien):string
    {
        
        $nombrePage = $this->nombrePage;
        
        $resultat = '';
        $resultat.= "<table>";
        $resultat.= "<tr>";
        
        if($this->numeroPage != 1)
        {
            $resultat.= "<td>";
            $resultat.= "<a href=\"{$lien}?p=1\"><<</a>";
            $resultat.= "</td>";
            
            $resultat.= "<td>";
            $numeroPageMoins = $this->numeroPage -1;
            $resultat.= "<a href=\"{$lien}?p={$numeroPageMoins}\">précédent</a>";
            $resultat.= "</td>";
        }
        
        for($i=1;$i<=$this->nombrePage;$i++)
        {
            $resultat.= "<td>";
            $resultat.= "<a href=\"{$lien}?p={$i}\">{$i}</a>";
            $resultat.= "</td>";
        }
        
        if($this->numeroPage != $this->nombrePage)
        {
            $resultat.= "<td>";
            $numeroPagePlus = $this->numeroPage +1;
            $resultat.= "<a href=\"{$lien}?p={$numeroPagePlus}\">suivant</a>";
            $resultat.= "</td>";
            
            $resultat.= "<td>";
            $resultat.= "<a href=\"{$lien}?p={$nombrePage}\">>></a>";
            $resultat.= "</td>";
        }
        
        $resultat.= "</tr>";
        $resultat.= "</table>";
        
        return $resultat;
        
        
    }
    
    public function PageResultat($numeroPage, int $nombreItemParPage)
    {        
        $this->calculePagination($numeroPage, $nombreItemParPage);
        return $this->TableauItem($this->getTranche());
    }
    
}

