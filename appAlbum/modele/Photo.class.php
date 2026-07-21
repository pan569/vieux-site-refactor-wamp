<?php
namespace appAlbum\modele;

use appAlbum\modele\iptc;



/**
 *
 * @author Ulysse1976
 *
 */
class Photo extends iptc
{
    const CHEMIN_DATA = "C:\\wamp64\\www\\site01\\appAlbum\\vue\\resources\\data\\";
    
    private $_ImageDimension;
    protected $_chemin;
    protected $_imageNomAlbum;
    protected $_imageNomPhoto;
   
    protected $_affichageHauteur;
    protected $_affichageLargeur;
    protected $_affichageEchelle;
    protected $_affichageDecalageHorizontal;
    
    protected $_png;
    
    
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getimageNomAlbum()
    {
        return $this->_imageNomAlbum;
    }
    /**
     * blablabla
     *
     * @param array $tab
     * @return void
     */
    public function setImageAlbum(array $tab):void
    {
        foreach ($tab as $clée => $valeur)
        {
            $this->donnees[$clée] = $valeur;
        }
    }
    
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getimageNomPhoto()
    {
        return $this->_imageNomPhoto;
    }
    /**
     * blablabla
     *
     * @param array $tab
     * @return void
     */
    public function setImageNom(array $tab):void
    {
        foreach ($tab as $clée => $valeur)
        {
            $this->donnees[$clée] = $valeur;
        }
    }
    
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getImageChemin()
    {
        
        return $this->_chemin.$this->_imageNomAlbum.'\\'.$this->_imageNomPhoto.'.jpg';
    }

    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getImageUrl()
    {
        $resultat =  str_replace( '\\', '/' , $this->getImageChemin());
        $resultat =  str_replace( $_SERVER ["DOCUMENT_ROOT"], '' , $resultat) ;
        
        return $resultat;
    }
       
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getImageHauteur()
    {
        return $this->_ImageDimension[1];
    }
        
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getImageLargeur()
    {
        return $this->_ImageDimension[0];
    }
  
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getAffichageHauteur()
    {
        return $this->_affichageHauteur;
    }
        
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getAffichageLargeur()
    {
        return $this->_affichageLargeur;
    }
   
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getAffichageEchelle()
    {
        return $this->_affichageEchelle;
    }

    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getAffichageDecalageHorizontal()
    {
        return $this->_affichageDecalageHorizontal;
    }
    
    /**
     * blablabla
     *
     * @param void
     * @return array $donnees
     */
    public function getpng()
    {
        return $this->_png;
    }
    
    
    public function __construct($chemin = null,$nomAlbum = null, $nomPhoto = null)
    {
        
        $this->_chemin = $chemin;
        $this->_imageNomAlbum = $nomAlbum;
        $this->_imageNomPhoto = $nomPhoto;    
        $this->_ImageDimension = getimagesize($this->getImageChemin());
        $this->_affichageHauteur= 600;
        $this->_affichageEchelle =  $this->_affichageHauteur/$this->getImageHauteur();
        $this->_affichageLargeur =$this->getImageLargeur() * $this->_affichageEchelle;
        
        parent::__construct($this->getImageChemin());
       
        $this->_png = null;
        if($this->offsetExists('Instructions'))
        {
            $this->_png = json_decode($this['Instructions'], true);
        }
        
        return $this;
    }
    
}

