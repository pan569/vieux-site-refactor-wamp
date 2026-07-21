<?php
namespace appAnnuaire\modele;

use systeme\objets\DataDictionary;
use systeme\objets\Item;
use systeme\objets\ItemCollection;
use systeme\utilitaire\MyDateTime;
use systeme\utilitaire\GestionaireFichiers;


class Annuaire extends GestionaireFichiers
{
    //protected $_systemeFichier;
    protected $_listeURL;
    
    public function getListURL()
    {
        return $this->_listeURL;
    }
    
  
    
    public function __construct(string $direction,array $extensionTri = null)
    {
        
        parent::__construct($direction,$extensionTri);

        $this->liste();
        
        return $this;
    }
    
    public function dateCreation()
    {
        return MyDateTime::getInstance()->setDateTime($this->dateCreation)->getDateTimeFrLitér();
    }
    
    public function dateModification()
    {
        return MyDateTime::getInstance()->setDateTime($this->dateModification)->getDateTimeFrLitér();
    }

    protected function liste()
    {
        
        //$dossier ="C:\\wamp64\\www\\site01\\appAnnuaire\\vue\\resources\\data\\";
        
        //$resultat = [];
        /*
        //1) lister les fichiers. </br>";
        $fichiers = scandir($dossier);
        //debug($fichiers,"liste des fichiers");
        
        //2) trier fichiers, recuperer que les fichiers jpeg  </br>";
        foreach ($fichiers as $fichier)
        {
            if(stristr($fichier, '.url') !== FALSE)
            {
                $url = new Annuaire();
                
                $nom =  str_replace(".url","",$fichier) ;
                $nom =  str_replace(".URL","",$fichier) ;                
                $url['nom'] = $nom ;
                $url['url'] = self::lireFichier($dossier.$fichier);
                $url['image'] = file_get_contents($dossier."icone.ico");
                
                $resultat[] = $url;

            }
        }
        /**/
        
        foreach ($this->getListeFichiers() as $fichier)
        {
            
            //debug($fichier,"Annuaire.class.php ligne 84");
            //debug($this->_systemeFichier->getDirection(),"Annuaire.class.php ligne 85");
            
            $url = new url();
            
            $nom =  str_replace(".url","",$fichier) ;
            $nom =  str_replace(".URL","",$fichier) ;
            $url['nom'] = $nom ;
            $url['url'] = $this->lireFichier($this->_racine.$fichier);
            //$url['image'] = file_get_contents($this->_racine."icone.ico");
            
            
            $this->_listeURL[] = $url;
        }
                        
    }
    
    protected function lireFichier($fichier)
    {   
        $resultat = null;
        
        $ressource = fopen($fichier, 'rb');
         
        while(!feof($ressource)){
            $ligne = fgets($ressource);
            
            
            if(strstr($ligne, "URL") != false)
            {
                $resultat = str_replace("URL=","",$ligne);
            }
            
            //$resultat = fread($ressource, filesize($fichier));
        }
        
        fclose($ressource);
        
        return $resultat;
    }
}

