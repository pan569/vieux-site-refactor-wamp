<?php
namespace systeme\objets;

use PDO;
use PDOStatement;
use systeme\Noyau;

/**
 *
 * @author Ulysse1976
 *        
 */
class Persistance
{
    private static $_instance = null;
    public static function getInstance():Persistance
    {
        if(is_null(self::$_instance))
        { 
           self::$_instance = new Persistance();
        }
        
        return self::$_instance;
    }
    
    protected static $_connexionBD = null;
    public static function getConnexionBD()
    {
        if(is_null(self::$_connexionBD))
        {

            //'pgsql:host=192.168.137.1;port=5432;dbname=anydb', 'anyuser', 'pw'
            $noyau = Noyau::getInstance();
            
            self::$_connexionBD = new PDO ( 
                "mysql:host={$noyau->getDonnées('#DataBaseServeur')};
                 port={$noyau->getDonnées('#DatabasePort')};
			     dbname={$noyau->getDonnées('#DataBaseNon')};
			     charset={$noyau->getDonnées('#DatabaseCharset')}", 
			     $noyau->getDonnées('#DataBaseUtilisateur'), 
			     $noyau->getDonnées('#DataBaseMdP'),
                array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                );
        }
        return self::$_connexionBD;
    }
    
    public function __construct()
    {
        
    }

    /**
     * recupere le nom de la table a partir du nom de la classe
     * (la classe doit etre une fille de la classe item)
     *
     * @param $nomClasse
     * @return string
     */
    protected function getNomTable($nomClasse)
    {
        $tab = explode("\\", $nomClasse);
        return $tab[count($tab)-1];
    }
    
    /**
     * Exécute une requête SQL avec PDO
     *
     * @param string $query La requête SQL
     * @return PDOStatement Retourne l'objet PDOStatement
     */
    public function ExecuteRequette($requette)
    {
        return self::getConnexionBD()->query($requette);
    }
    
    /**
     * Retourne l'id de la dernière ligne insérée
     *
     * @return string
     */
    public static function BDlastInsertId()
    {
        return  static::getConnexionBD()->lastInsertId();
    }
    
    /**
     * execute une requette préparé
     *
     * @param string $requette
     * @param array $attributs
     * @param string $nomClasse
     * @param bool $All
     * @return array|mixed
     */
    public function BDitemRequette(string $requette, array $attributs, string $nomClasse=null, bool $All=false)
    {
        
        $req = static::getConnexionBD()->prepare($requette);
        $req->execute($attributs);
        
        if(is_null($nomClasse))
            $req->setFetchMode(PDO::FETCH_OBJ);
            else
                $req->setFetchMode(PDO::FETCH_CLASS, $nomClasse);
                
                if($All)
                    return $req->fetchAll();
                    else
                        return $req->fetch();
                        
    }
    
    /**
     * 
     * verifi si la table existe
     * 
     * @param string $table
     * @return bool
     */
    public function TableEXIST (string $table):bool
    {
        $requette = "SHOW TABLES LIKE '{$table}'";
        
        $requettePrépare = Persistance::getInstance()->ExecuteRequette($requette)->fetchAll(\PDO::FETCH_ASSOC);

        if (count($requettePrépare) == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * crée une table
     * 
     * @param string $table
     * @param string $definition
     * @param string $commentaire
     * @return PDOStatement
     */
    public function CREATE_TABLE(string $table,string $definition, string $commentaire = null)
    {

        if($commentaire == null )
            $commentaire="donnée relatif a un(e) {$table}";
        
        $requette = "CREATE TABLE IF NOT EXISTS {$table} ({$definition}) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '{$commentaire}'";    
        
        //debug($requette, "requette");
        //die();
        $req = static::getConnexionBD()->prepare($requette);
        $req->execute();
        
        return $req;
        
        
    }
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function SELECT(string $table):array
    {
        $requette = "SELECT * FROM {$table}";
        
        $requettePrépare = static::getInstance()->ExecuteRequette($requette)->fetchAll(PDO::FETCH_ASSOC);
        
        return $requettePrépare;
        //return $requettePrépare ?: null;
    }
    
    /**
     * 
     * @param string $table
     * @param int $page
     * @return array
     */
    public function SELECT_PAGE(string $table,int $page =10):array
    {
        
       
        $requette = "SELECT * FROM {$table} ORDER BY dateCreation LIMIT $page";
        
        $requettePrépare = static::getInstance()->ExecuteRequette($requette)->fetchAll(PDO::FETCH_ASSOC);
        
        return $requettePrépare;
    }
    
    public function COUNT(string $table)
    {
        
        $requette = "SELECT COUNT(id) as Nbr FROM {$table}";
        
        $requettePrépare = $this::getInstance()->ExecuteRequette($requette)->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($requettePrépare) != 0)
        {
            $resultat = $requettePrépare[0];
        }
        else
        {
            $resultat = null;
        }
        return $resultat;
    }
    
    /**
     * 
     * recupere une portion de la table $table
     * 
     * @param string $table
     * @param int $offset (a partir de)
     * @param int $longueur (nombre d'entrée)
     * @return array
     */
    public function SELECT_PAGINATION(string $table,int $offset,int $longueur):array //
    {
        $requette = "SELECT * FROM {$table} ORDER BY dateCreation LIMIT :offset,:longueur";
        
        $req = static::getConnexionBD()->prepare($requette);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->bindValue(':longueur', $longueur, PDO::PARAM_INT);      
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * 
     * @param string $table
     * @param int $id
     * @return array
     */
    public function SELECT_ID(string $table,int $id):array
    {
        $requette = "SELECT * FROM {$table} WHERE ID = {$id}";
        
        $requettePrépare = static::getInstance()->ExecuteRequette($requette)->fetchAll(PDO::FETCH_ASSOC);
       
        if(count($requettePrépare) != 0)
        {
            $resultat = $requettePrépare[0];
        }
        else 
        {
            $resultat = null;
        }
        return $resultat;
    }
    
    /**
     * 
     * @param string $table
     * @param array $Donnee
     * @return PDOStatement|bool
     */
    public function INSERT(string $table,array $Donnee):bool
    {
        
        $tabClées = [];
        $tabChamps =[];
        $attributs=[];
        foreach ( $Donnee as $cle => $valeur )
        {
            if($valeur != null)
            {
                $tabClées [] = "{$cle}";
                $tabChamps [] = ":{$cle}";
                $attributs[":{$cle}"] = $valeur;
            }
        }
        $valeurs = implode (', ', $tabClées);
        $champs = implode ( ', ', $tabChamps );
        
        $requette = "INSERT INTO {$table} ( {$valeurs} ) VALUE ({$champs})";
        
        $req = static::getConnexionBD()->prepare($requette);
        
        return $req->execute($attributs);
    }
    
    /**
     * 
     * @param string $table
     * @param array $Donnee
     * @return bool
     */
    public function UPDATE(string $table,array $Donnee):bool
    {
        
        $tabChamps =[];
        $attributs=[];
        foreach ( $Donnee as $cle => $valeur )
        {
            if($valeur != null)
            {
                $tabChamps [] = "{$cle} = :{$cle}";
                $attributs[":{$cle}"] = $valeur;
            }
        }
        
        $champs = implode ( ', ', $tabChamps );
        $requette = "UPDATE {$table} SET {$champs}  WHERE id= :id";
        $attributs[":id"] = $Donnee['id'];
        
        $req = static::getConnexionBD()->prepare($requette);
        
        
        return $req->execute($attributs);
        
        
    }
    
    /**
     * 
     * @param string $table
     * @param int $id
     * @return bool
     */
    public function DELETE(string $table,int $id):bool
    {
        $requette = "DELETE FROM {$table} WHERE id = :id ";
        
        $attributs = [];
        $attributs[":id"] = $id;
        
        $req = static::getConnexionBD()->prepare($requette);
        return $req->execute($attributs);
    }
    
    /**
     * 
     * @param string $table
     * @param string $clé
     * @param ? $valeur
     * @return bool
     */
    public function EXIST(string $table, string $clé, $valeur):bool
    {
        
        $requette = "SELECT COUNT(*) AS {$clé} FROM {$table} WHERE {$clé} = '{$valeur}'";
        
        $requettePrépare = $this::getInstance()->ExecuteRequette($requette)->fetchAll(PDO::FETCH_ASSOC);
        $resultat = $requettePrépare[0];
        

        if ($resultat [$clé] == 0 || $resultat [$clé] == null)
        {
            return false;
        }
        else
        {
            return true;
        }

    }
    
    /**
     * 
     * @param string $table
     * @param ? $clé
     * @param ? $valeur
     * @return NULL|array
     */
    public function FIND(string $table,$clé,$valeur)
    {

        $requette = "SELECT * FROM {$table} WHERE {$clé} ='{$valeur}'";
        
        $requettePrépare = $this::getInstance()->ExecuteRequette($requette)->fetchAll(PDO::FETCH_ASSOC);
                
        if(count($requettePrépare) != 0)
        {
            $resultat = $requettePrépare[0];
        }
        else
        {
            $resultat = null;
        }
        return $resultat;
    }

    
    public function requettePerso(string $requettePrépare)
    {                                
        return $this::getInstance()->ExecuteRequette($requettePrépare)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function requettePersoFetch(string $requettePrépare)
    {
        return $this::getInstance()->ExecuteRequette($requettePrépare)->fetch(PDO::FETCH_BOTH);
    }
    
    public function LireXmlElement($fichier, $element, $données)
    {
        
        $dom = new \DOMDocument();
        $dom->load($fichier);
        
        $elem = $dom->getElementsByTagName($element)->item(0);
        foreach (array_keys($données) as $clé)
        {
            $données[$clé] = $elem->getElementsByTagName($clé)->item(0)->nodeValue;
        }
        
        return $données;
    }    
    
    public function LireXmlElementAttribut($fichier, $element, $SElement, $données)
    {
        
        //debug($fichier,"Persistance->LireXmlElementAttribut:fichier");
        //debug($element,"Persistance->LireXmlElementAttribut:element");
        //debug($SElement,"Persistance->LireXmlElementAttribut:SElement");
        //debug($données,"Persistance->LireXmlElementAttribut:données");
        
        
        $dom = new \DOMDocument();
        $dom->load($fichier);
        
        $elementDom = $dom->getElementsByTagName($element)->item(0);
        $SElementDom = $elementDom->getElementsByTagName($SElement)->item(0);
        
        foreach (array_keys($données) as $attribut)
        {
            $données[$attribut] =$SElementDom->getAttribute($attribut);
        }
        
        //debug($données,"Persistance->données");
        return $données;
    }
    
    public function LireXmlElementAttributs($fichier, $element, $SElement,  $listeClées)
    {
      
        //debug($fichier,"Persistance->LireXmlElementAttributs:fichier");
        //debug($element,"Persistance->LireXmlElementAttributs:element");
        //debug($SElement,"Persistance->LireXmlElementAttributs:SElement");
        //debug($listeClées,"Persistance->LireXmlElementAttributs:listeClées");
        
        
        $dom = new \DOMDocument();
        $dom->load($fichier);
        
        $elementDom = $dom->getElementsByTagName($element)->item(0);
        $SousElementDom = $elementDom->getElementsByTagName($SElement);
        
        
        $resultat = [];
        foreach($SousElementDom as $x)
        {
            
            //debug($x,"Persistance->LireXmlElementAttributs:x");
         
            
            foreach ($listeClées as $attribut)
            {
                $lienMenu[$attribut] =$x->getAttribute($attribut);
            }
            $resultat[]=$lienMenu;
            
        }
        /**/
        
        return $resultat;
    }
    
    public function LireXmlListeElement($fichier, $element,  $listeClées)
    {
        // -X-
        //debug($fichier,"Persistance->LireXmlElementAttributs:fichier");
        //debug($element,"Persistance->LireXmlElementAttributs:element");
        //debug($SElement,"Persistance->LireXmlElementAttributs:SElement");
        //debug($listeClées,"Persistance->LireXmlElementAttributs:listeClées");
        
        
        $dom = new \DOMDocument();
        $dom->load($fichier);
        
        $elementDom = $dom->getElementsByTagName($element)->item(0);        
        $childNodes = $elementDom->childNodes;              
        
        $resultat = [];
        foreach($childNodes as $noeud)
        {
                        
            if(get_class($noeud) == "DOMElement")
            {
                //debug($noeud->tagName,"Persistance->LireXmlElementAttributs:x");
                $resultat[]=$noeud->tagName;
            }
            
        }
        
        //debug($resultat,"Persistance->LireXmlElementAttributs:resultat");
               
        return $resultat;
    }
    
    public function EcrireXmlElement($fichier, $element, $données)
    {
        debug($fichier,"fichier");
        
        $dom = new \DomDocument();
        $dom->load($fichier);
        
        $elementDom = $dom->getElementsByTagName($element)->item(0);
        foreach (array_keys($données) as $attribut)
        {            
            $elementDom->getElementsByTagName($attribut)->item(0)->nodeValue = $données[$attribut];//utf8_decode( $sString )
        }
     
        $dom->save($fichier);    
    }
    
    public function EcrireXmlElementAttribut($fichier, $element, $SElement, $données)
    {     
        //debug($fichier,"Persistance->EcrireXmlElementAttribut:fichier");
        //debug($element,"Persistance->EcrireXmlElementAttribut:element");
        //debug($SElement,"Persistance->EcrireXmlElementAttribut:SElement");
        //debug($données,"Persistance->EcrireXmlElementAttribut:données");
        
        
        $dom = new \DOMDocument();
        $dom->load($fichier);
        
        $elementDom = $dom->getElementsByTagName($element)->item(0);
        $SElementDom = $elementDom->getElementsByTagName($SElement)->item(0);
        foreach (array_keys($données) as $attribut)
        {
            
            //debug($attribut,"Persistance->EcrireXmlElementAttribut:attribut");
            //debug($données[$attribut],"Persistance->EcrireXmlElementAttribut:valeur");
            $SElementDom->setAttribute($attribut,$données[$attribut]);
            
        }
                        
        $dom->save($fichier);
        
    }
    
    public function LireTxt($fichier)
    {
        $resutat = file_get_contents($fichier);
        //readfile($fichier);
        
        return $resutat;
    }
}

