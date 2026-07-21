<?php
namespace systeme\objets;

/**
 *
 * @author Ulysse1976
 *        
 */
trait Paginer
{
    
    protected static $nombreItemParPage;//$perPage
    protected static $numeroPage;
    protected static $offset;
    protected static $nombreItem;
    protected static $nombrePage;
    protected static $listeItem;
    
    
    
    /**
     * calcul le nombre d'item que contien la table corespondante
     */
    public static function getNbreResutat()
    {
        
        $resultatRequette =  Persistance::getInstance()->COUNT(self::getNomTable());
        self::$nombreItem = $resultatRequette['Nbr'];

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
    public static function calculePagination($numeroPage, int $nombreItemParPage = 10)
    {
        self::getNbreResutat();
        self::$nombreItemParPage = $nombreItemParPage;
        self::$nombrePage = ceil(self::$nombreItem/self::$nombreItemParPage);

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
        
        if($numeroPage > self::$nombrePage)
        {
            $numeroPage = self::$nombrePage;
        }
        
        self::$numeroPage = $numeroPage;        
        self::$offset = ( self::$numeroPage-1)* self::$nombreItemParPage;
        
        
        
    }
    
    /*
     * recupere la liste des items en fonction des parametres de pagination
     */
    public static function getTranche()
    {
        return Persistance::getInstance()->SELECT_PAGINATION(self::getNomTable(),self::$offset,self::$nombreItemParPage);
    }
        
    /**
    *
    * fabrique le module de navigation de la pagination
    * 
    * @param string $lien
    * @return string
    */
    public static function affichePagination(string $lien):string
    {
        $formLien="{$lien}&variables=p:"; // encienne forme : {$lien}?p=
        
        $nombrePage = self::$nombrePage;
        
        $resultat = '';
        $resultat.= "<table>";
        $resultat.= "<tr>";

        if(self::$numeroPage != 1)
        {
            $resultat.= "<td>";
            $resultat.= "<a href=\"{$formLien}1\"><<</a>";
            $resultat.= "</td>";           
            $resultat.= "<td>";
            $numeroPageMoins = self::$numeroPage -1;
            $resultat.= "<a href=\"{$formLien}{$numeroPageMoins}\">précédent</a>";        
            $resultat.= "</td>";
        }
        
        for($i=1;$i<=self::$nombrePage;$i++)
        {
            $resultat.= "<td>";
            $resultat.= "<a href=\"{$formLien}{$i}\">{$i}</a>";
            $resultat.= "</td>";
        }
        
        if(self::$numeroPage != self::$nombrePage)
        {
            $resultat.= "<td>";
            $numeroPagePlus = self::$numeroPage +1;
            $resultat.= "<a href=\"{$formLien}{$numeroPagePlus}\">suivant</a>";
            $resultat.= "</td>";
        
            $resultat.= "<td>";
            $resultat.= "<a href=\"{$formLien}{$nombrePage}\">>></a>";
            $resultat.= "</td>";
        }
        
        $resultat.= "</tr>";
        $resultat.= "</table>";
       
        return $resultat;

    
    }

    public static function PageResultat($numeroPage, int $nombreItemParPage)
    {
        
        self::calculePagination($numeroPage, $nombreItemParPage);
        
        return self::TableauItem(self::getTranche());
    }
}

