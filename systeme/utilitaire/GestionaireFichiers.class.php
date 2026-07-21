<?php
namespace systeme\utilitaire;

class GestionaireFichiers
{
    
    protected $_racine;    
    protected $_extensionFiltre;
    protected $_listeDossiers;
    protected $_listeFichiers;    
    protected $_listeFichiersFiltrés;
    
    public function getRacine()
    {
        return $this->_racine;
    }    
    
    public function getNonDossier()
    {
        $r = explode ( DIRECTORY_SEPARATOR ,  $this->_racine);
        return $r[count($r)-2];
    }
    
    public function getListeDossiers()
    {
        return $this->_listeDossiers;
    }
    
    public function getListeFichiers() 
    {
       return $this->_listeFichiers;
    }
    
    public function getListeFichiersFiltrés(array $extensionTri = null)
    {
        if($extensionTri != null)
            $this->_extensionFiltre = $extensionTri;
        
       $this->filterFichiers();
       return $this->_listeFichiersFiltrés;
    }

    public function __construct(string $direction,array $extensionTri = null)
    {
              
        if(strrpos( $direction,DIRECTORY_SEPARATOR )+1 == strlen($direction))
            $this->_racine = $direction;
        else 
            $this->_racine = $direction.DIRECTORY_SEPARATOR;
        
        $this->_extensionFiltre = $extensionTri;
        $this->lister();
     
        // * lister fichiers (tout ou type)
        // * lister dossier 
        //creer fichier
        // * creer dossier
        // * supprimer fichier
        // * supprimer dossier

    }
    
    protected function lister()
    {
        $this->listerFichiers();
        $this->listerDossier();
    }
    
    protected function listerFichiers()
    {  
        $this->_listeFichiers = [];

        $scanDossier = scandir($this->_racine);
        foreach ( $scanDossier as $fichier)
        {
            if(!is_dir($this->_racine.$fichier) && !in_array($fichier, array('.','..')))
                $this->_listeFichiers[] = $fichier;
        }
    }
    
    protected function listerDossier()
    {
        $this->_listeDossiers = [];
        $a = scandir($this->_racine);
        foreach ($a as $fichier)
        {
            if(is_dir($this->_racine.$fichier) && !in_array($fichier, array('.','..')))
                $this->_listeDossiers[] = $fichier;
        }
    }
    
    protected function filterFichiers() 
    {
       
        if($this->_extensionFiltre != null)
        {
            foreach ($this->_listeFichiers as $fichier)
            {
            
                foreach ($this->_extensionFiltre as $ext)
                {
                    if(stristr($fichier, $ext) !== FALSE)
                        $this->_listeFichiersFiltrés[] = $fichier  ;
                }
                   
            }
        }
        else
        {            
            foreach ($this->_listeFichiers as $fichier)
            {
                if(!is_dir($this->_racine.$fichier) && !in_array($fichier, array('.','..')))
                    $this->_listeFichiersFiltrés[] = $fichier;
            }
        }
        
    }
    
    protected function isExtentionTri($extension) 
    {
        //in_array(mixed $needle, array $haystack, bool $strict = false): bool
        return in_array($extension, $this->_extensionTri);
    }
    
    public function CreerDissier(string $nomDossier) 
    {
        
        //debug($this->_racine.$nomDossier,"chemin");
        
        $permissions = 0777;
        if(!in_array($nomDossier, $this->_listeDossiers))
            mkdir( $this->_racine.$nomDossier , $permissions );
        
        $this->lister();
    }
    
    public function supprimerFichier($fichier)
    {
        if(!in_array($fichier, $this->_listeFichiers))
        {
            unlink($fichier);
        }
        
        $this->lister();
    }
    
    public function supprimerFichiers($dossier = null)
    {
        //debug($dossier);
        
        
        //recuperrerlesfichiers du dossier
        $scanDossier = scandir($dossier);
        foreach ( $scanDossier as $fichier)
        {
            if(!is_dir($dossier.DIRECTORY_SEPARATOR.$fichier) && !in_array($fichier, array('.','..')))
                unlink($dossier.DIRECTORY_SEPARATOR.$fichier);
        }
 
        $this->lister();
        
    }
    
    public function supprimerDossier($nomDossier) 
    {   
        if (in_array($nomDossier, $this->_listeDossiers))
        {
            //suppression des fichiers
            $this->supprimerFichiers($this->_racine.$nomDossier);
            
            //suppression du dossier
            rmdir($this->_racine.$nomDossier);
            
            $this->lister();
        }
        
    }
    
    public function copierFichier($source,$nomFichierCopie)
    {
        //debug(pathinfo($source)["extension"],"type de fichier");
        
        copy($source, $this->_racine.$nomFichierCopie.".".pathinfo($source)["extension"]);
        
        $this->lister();
    }
    
    public function ziperFichiersDossier()
    {
        $zip = new \ZipArchive();
        if ($zip->open($this->_racine.$this->getNonDossier().'.zip', \ZipArchive::CREATE)) 
        {
            foreach ($this->_listeFichiersFiltrés as $fichier)
            {                
                $zip->addFile($this->_racine.$fichier,$fichier);
            }
            
            $this->test($zip);
            $zip->close();
        }                       
    }
    
    public function deziperFichiersDossier()
    {
        $zip = new \ZipArchive();
        
        if ($zip->open($this->_racine.$this->getNonDossier().'.zip'))
        {
            $zip->extractTo($this->_racine);
            $zip->close();
            /*
            foreach ($this->_listeFichiersFiltrés as $fichier)
            {
                $zip->addFile($this->_racine.$fichier,$fichier);
            }
            
            /**/
            
        }
        
        /**/
    }
    
    public function test($zip)
    {
        //$za = new ZipArchive();
        
        //$zip->open('test_with_comment.zip');
        print_r($zip);
        var_dump($zip);
        echo "Nombre de fichiers : " . $zip->numFiles . "\n";
        echo "Statut : " . $zip->status  . "\n";
        echo "Statut du système : " . $zip->statusSys . "\n";
        echo "Nom du fichier : " . $zip->filename . "\n";
        echo "Commentaire : " . $zip->comment . "\n";
        
        for ($i=0; $i<$zip->numFiles;$i++) {
            echo "index : $i\n";
            print_r($zip->statIndex($i));
        }
        echo "Nombre de fichiers :" . $zip->numFiles . "\n";
    }
    
    
    /**
     * Recursively delete a directory
     *
     * @param string $dir Directory name
     * @param boolean $deleteRootToo Delete specified top-level directory as well
     */
    /*
    function unlinkRecursive($dir, $deleteRootToo)
    {
        if(!$dh = @opendir($dir))
        {
            return;
        }
        while (false !== ($obj = readdir($dh)))
        {
            if($obj == '.' || $obj == '..')
            {
                continue;
            }
            
            if (!@unlink($dir . '/' . $obj))
            {
                unlinkRecursive($dir.'/'.$obj, true);
            }
        }
        
        closedir($dh);
        
        if ($deleteRootToo)
        {
            @rmdir($dir);
        }
        
        return;
    }
    /**/
    
    
}

