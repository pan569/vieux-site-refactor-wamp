<?php
namespace appAlbum\modele;

use systeme\utilitaire\MyDateTime;

/**
 *
 * @author Ulysse1976
 * 
 */
class Album
{
    protected $_direction;
    protected $_nomAlbum;
    protected $_listePhotos;
    
    public function getPhotos()
    {
        return $this->_listePhotos;
    }
    
    public function getPhoto(string $nomPhoto)
    {
        return $this->_listePhotos[$nomPhoto];
    }
    
    public function __construct(string $direction, string $nomAlbum)
    {
        $this->_direction = $direction;
        $this->_nomAlbum = $nomAlbum;
        $this->ListerPhotos();
    }
    
    public function dateCreation()
    {
        return MyDateTime::getInstance()->setDateTime($this->dateCreation)->getDateTimeFrLitér();
    }
    
    public function dateModification()
    {
        return MyDateTime::getInstance()->setDateTime($this->dateModification)->getDateTimeFrLitér();
    }
    
    public function index($nomPhoto)
    {
        $resultat = 0;
        
        foreach ($this->_listePhotos as $p)
        {
            if($p->getimageNomPhoto() == $nomPhoto)
                return $resultat;
            else 
                $resultat++;
        }
     
    }
    
    protected function ListerPhotos()
    {
        $fichiers = scandir($this->_direction.$this->_nomAlbum);
        
        foreach ($fichiers as $fichier)
        {
            if(stristr($fichier, '.jpg') !== FALSE)
            {
                $nomPhoto = str_replace( '.jpg' , '' , $fichier);
                $this->_listePhotos[$nomPhoto] = new Photo($this->_direction,$this->_nomAlbum,$nomPhoto) ;
            }
        }
    }
    
}

