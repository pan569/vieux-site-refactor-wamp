<?php
namespace systeme\objets;

/*
 TINYINT   1 -128 127
 SMALLINT  2 -32.768 32.767
 MEDIUMINT 3 -8.388.608 8.388.607
 INT       4 -2.147.483.648 2.147.483.647
 BIGINT    8 -9.223.372.036.854.775.808 9.223.372.036.854.775.807
 
 nombre à virgule:
 FLOAT     4
 DOUBLE    8
 
 DECIMAL   *
 
 date & heure:
 TIME      3 Chaîne HH:MM:SS
 TIMESTAMP 4 Numérique AAAAMMJJHHMMSS
 DATETIME  8 (dont 3 non utilisés) Chaîne AAAA-MM-JJ HH:MM:SS
 DATE      3 Chaîne AAAA-MM-JJ
 YEAR      1 Numérique AAAA
 
 texte:
 TEXTE <- pour du texte, sensible a la case
 BLOB <- information binaire (exple Image), insensible a la case
 
 CHAR                   255           M
 VARCHAR                535           L+1
 TINYBLOB, TINYTEXT     255           L+1
 BLOB, TEXT             65.535        L+2
 MEDIUMBLOB, MEDIUMTEXT 16.777.215    L+3
 LONGBLOB, LONGTEXT     4.294.967.296 L+4
 
 choix multiple:
 ENUM
 SET
 /**/

/*
 TYPE_ENTIER[TAILLE]
 ->TINYINT
 ->SMALLINT
 ->MEDIUMINT
 ->INT
 ->BIGINT
 TYPE_DECIMAL[TAILLE]
 ->FLOAT
 
 TYPE_DATE[numerique/chaine]
 ->TIMESTAMP (Numérique) AAAAMMJJHHMMSS
 ->DATETIME  (Chaîne) AAAA-MM-JJ HH:MM:SS
 TYPE_CHAINE[TAILLE]
 ->CHAR
 ->VARCHAR
 ->TINYTEXT
 ->TEXT
 ->MEDIUMTEXT
 ->LONGTEXT
 TYPE_BINAIRE[TAILLE]
 ->TINYBLOB
 ->BLOB
 ->MEDIUMBLOB
 ->LONGBLOB
 TYPE_ENUMERATION[INCLUSIF/EXCLUSIF]
 ->ENUM (EXCLUSIF)
 ->SET (INCLUSIF)
 /**/

/**
 *
 * @author Ulysse1976
 *        
 */
class ColonneTableBD extends Collection
{
    

    protected $definition;
    
    public function getDataDictionary()
    {
        return $this->definition;
    }
    
    public function setDataDictionary(array $dataDictionary)
    {
        $this->definition = $dataDictionary;
    }
        

    public function __construct(array $dataDictionary)
    {
        $this->definition = $dataDictionary;

        return $this;
    }
    
    public function ecritureMySQL()
    {
        
        if($this->definition['commentaires'] =='CLE PRIMAIRE')
        {
            return $this->EcrireColonneCle();
        }
        else 
        {
            switch ($this->definition['type'])
            {
                case DataDictionary::TYPE_ENTIER:
                    return $this->EcrirColonneEntier();
                    break;
                case DataDictionary::TYPE_DECIMAL:
                    return $this->EcrirColonneVirgule();
                    break;
                case DataDictionary::TYPE_DATE:
                    return $this->EcrirColonneDate();
                    break;
                case DataDictionary::TYPE_CHAINE:
                    return $this->EcrirColonneChaine();
                    break;
                case DataDictionary::TYPE_BINAIRE:
                    return $this->EcrirColonneBinaire();
                    break;
                case DataDictionary::TYPE_ENUMERATION:
                    return $this->EcrirColonneEnumeration();
                    break;
                case DataDictionary::TYPE_BOOLEAN:
                    return $this->EcrirColonneBool();
                    break;
                
            }
        }
        
    }
      
    public function EcrireColonneCle()
    {
        return "{$this->definition['nom']} smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '{$this->definition['commentaires']}'";
    }
    
    public function EcrirColonneEntier()
    {
       
        //nom de la colonne
        $nomColonne = $this->definition['nom'];

        //ype de colonne entier
        $taille = (abs($this->definition['tailleMin']) + abs($this->definition['tailleMax'])) * 255;
        $typeColonne=null;
        if ($taille <= 255)
        {
            $typeColonne = "TINYINT";
            
        }
        elseif ($taille > 255 && $taille <= 65535)
        {
            $typeColonne = "SMALLINT";
            
        }
        elseif ($taille > 65535 && $taille <= 16777215)
        {
            $typeColonne = "MEDIUMINT";
            
        }
        elseif ($taille > 16777215 && $taille <= 4294967295)
        {
            $typeColonne = "INT";
            
        }
        elseif ($taille > 4294967295 && $taille <= 1.844674407371E+19)
        {
            $typeColonne = "BIGINT";
            
        }
        else
        {
            $typeColonne = "INT";
        }
        
        //Nombre negatif ?
        $unsigned=null;
        if(!($this->definition['tailleMin'] < 0))
        {
            $unsigned =" UNSIGNED ";
        }
        
        //colonne null ou non
        $nullable= null;
        if($this->definition['null'])
        {
            $nullable= "NOT NULL";
        }
        
        //valeur par defaut
        $valeurDefaut = null;
        if($this->definition['defaut'] !== null)
        {
            $valeurDefaut = "DEFAULT {$this->definition['defaut']}";
        }
        
        //valeur par defaut
        $commentaire = null;
        if($this->definition['commentaires'] !== null)
        {
            $commentaire = "COMMENT '{$this->definition['commentaires']}'";
        }
        
        return "{$nomColonne} {$typeColonne} {$unsigned} {$nullable} {$valeurDefaut} {$commentaire}";
    }
    
    public function EcrirColonneVirgule()
    {
        
        //nom de la colonne
        $nomColonne = $this->definition['nom'];
        
        //colonne null ou non
        $nullable= null;
        if($this->definition['null'])
        {
            $nullable= "NOT NULL";
        }
        
        //valeur par defaut
        $valeurDefaut = null;
        if($this->definition['defaut'] !== null)
        {
            $valeurDefaut = "DEFAULT {$this->definition['defaut']}";
        }
        
        //valeur par defaut
        $commentaire = null;
        if($this->definition['commentaires'] !== null)
        {
            $commentaire = "COMMENT '{$this->definition['commentaires']}'";
        }
        
        return "{$nomColonne} FLOAT {$nullable} {$valeurDefaut} {$commentaire}";
        //$resultat = "{$nomColonne} FLOAT {$nullable} {$valeurDefaut} {$commentaire}";
    }
    
    public function EcrirColonneDate()
    {
        //nom de la colonne
        $nomColonne = $this->definition['nom'];
        
        //type de colonne entier
        //TYPE_DATE[numerique/chaine]
        //->TIMESTAMP (Numérique) AAAAMMJJHHMMSS
        //->DATETIME  (Chaîne) AAAA-MM-JJ HH:MM:SS
        $typeColonne=null;
                
        switch ($this->definition['option']['TYPE_DATE'])
        {
            case 'Chaîne':
                $typeColonne= 'DATETIME';
                break;
            case 'Numérique':
                $typeColonne = 'TIMESTAMP';
                break;
        }
        
        
        //colonne null ou non
        $nullable= null;
        if($this->definition['null'])
        {
            $nullable= "NOT NULL";
        }
        
        //valeur par defaut
        $valeurDefaut = null;
        if($this->definition['defaut'] !== null)
        {
            $valeurDefaut = "DEFAULT {$this->definition['defaut']}";
        }
        
        //valeur par defaut
        $commentaire = null;
        if($this->definition['commentaires'] !== null)
        {
            $commentaire = "COMMENT '{$this->definition['commentaires']}'";
        }
        
        return "{$nomColonne} {$typeColonne} {$nullable} {$valeurDefaut} {$commentaire}";
        
    }
    
    public function EcrirColonneChaine()
    {
        //nom de la colonne
        $nomColonne = $this->definition['nom'];

        
        //ype de colonne entier
        $taille = $this->definition['tailleMax'];
        $typeColonne=null;
        if ($taille <= 255)
        {
            $typeColonne = "CHAR({$taille})";
        }
        elseif ($taille > 255 && $taille <= 65535)
        {
            $typeColonne = "TEXT";
        }
        elseif ($taille > 65535 && $taille <= 16777215)
        {
            $typeColonne = "MEDIUMTEXT";
        }
        elseif ($taille > 16777215 && $taille <= 4294967295)
        {
            $typeColonne = "LONGTEXT";
        }
        else
        {
            $typeColonne = "VARCHAR({$taille})";
        }
        

        //colonne null ou non
        $nullable= null;
        if($this->definition['null'])
        {
            $nullable= "NOT NULL";
        }
        
        //valeur par defaut
        $valeurDefaut = null;
        if($this->definition['defaut'] !== null)
        {
            $valeurDefaut = "DEFAULT {$this->definition['defaut']}";
        }
        
        //valeur par defaut
        $commentaire = null;
        if($this->definition['commentaires'] !== null)
        {
            $commentaire = "COMMENT '{$this->definition['commentaires']}'";
        }
        
        return "{$nomColonne} {$typeColonne} {$nullable} {$valeurDefaut} {$commentaire}";
        
    }
    
    Public function EcrirColonneBinaire()
    {
        //nom de la colonne
        $nomColonne = $this->definition['nom'];
        
        //ype de colonne entier
        $taille = $this->definition['tailleMax'];
        $typeColonne=null;
        if ($taille <= 255)
        {
            $typeColonne = "TINYBLOB({$taille})";
        }
        elseif ($taille > 255 && $taille <= 65535)
        {
            $typeColonne = "BLOB";
        }
        elseif ($taille > 65535 && $taille <= 16777215)
        {
            $typeColonne = "MEDIUMBLOB";
        }
        elseif ($taille > 16777215 && $taille <= 4294967295)
        {
            $typeColonne = "LONGBLOB";
        }
        else
        {
            $typeColonne = "BLOB({$taille})";
        }
        
        
        //colonne null ou non
        $nullable= null;
        if($this->definition['null'])
        {
            $nullable= "NOT NULL";
        }
        
        //valeur par defaut
        $valeurDefaut = null;
        if($this->definition['defaut'] !== null)
        {
            $valeurDefaut = "DEFAULT {$this->definition['defaut']}";
        }
        
        //valeur par defaut
        $commentaire = null;
        if($this->definition['commentaires'] !== null)
        {
            $commentaire = "COMMENT '{$this->definition['commentaires']}'";
        }
        
        return "{$nomColonne} {$typeColonne} {$nullable} {$valeurDefaut} {$commentaire}";
    }
    
    public function EcrirColonneEnumeration()
    {
        //nom de la colonne
        $nomColonne = $this->definition['nom'];
        
        //type de colonne entier
        //TYPE_DATE[numerique/chaine]
        //->TIMESTAMP (Numérique) AAAAMMJJHHMMSS
        //->DATETIME  (Chaîne) AAAA-MM-JJ HH:MM:SS
        $typeColonne=null;
        
        debug($this->definition['option'],'<h1>lecture des options</h1>');
        
        $enumeration ="";
        
        switch ($this->definition['option'])
        {
            case 'inclusif':
                $typeColonne= "SET({$enumeration})";
                break;
            case 'exclusif':
                $typeColonne = "ENUM({$enumeration})";
                break;
        }
        
        
        //colonne null ou non
        $nullable= null;
        if($this->definition['null'])
        {
            $nullable= "NOT NULL";
        }
        
        //valeur par defaut
        $valeurDefaut = null;
        if($this->definition['defaut'] !== null)
        {
            $valeurDefaut = "DEFAULT {$this->definition['defaut']}";
        }
        
        //valeur par defaut
        $commentaire = null;
        if($this->definition['commentaires'] !== null)
        {
            $commentaire = "COMMENT '{$this->definition['commentaires']}'";
        }
        
        return "{$nomColonne} {$typeColonne} {$nullable} {$valeurDefaut} {$commentaire}";
        
       
    }
    
    public function EcrirColonneBool()
    {
        //nom de la colonne
        $nomColonne = $this->definition['nom'];
        
        //colonne null ou non
        $nullable= null;
        if($this->definition['null'])
        {
            $nullable= "NOT NULL";
        }
        
        //valeur par defaut
        $valeurDefaut = null;
        if($this->definition['defaut'] !== null)
        {
            $valeurDefaut = "DEFAULT {$this->definition['defaut']}";
        }
        
        //valeur par defaut
        $commentaire = null;
        if($this->definition['commentaires'] !== null)
        {
            $commentaire = "COMMENT '{$this->definition['commentaires']}'";
        }
        
        return "{$nomColonne} TINYINT(1) {$nullable} {$valeurDefaut} {$commentaire}";
        //$resultat = "{$nomColonne} FLOAT {$nullable} {$valeurDefaut} {$commentaire}";
    }
}

