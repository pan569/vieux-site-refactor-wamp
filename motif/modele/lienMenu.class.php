<?php
namespace motif\modele;

use systeme\objets\Item;
use systeme;

class lienMenu  extends Item
{
    
    public $fichierIni;
    protected $nomMenu;
    
    public function __construct(string $fichierIni = null,string $nomMenu = null, string $titre = null)
    {
        
        self::getDictionaire()->clearDefinition();
        $this->fichierIni = $fichierIni;
        $this->nomMenu = $nomMenu;
        $this->donnees['url']=NULL;
        $this->donnees['titre']=$titre;
        $this->donnees['description']=NULL;
        $this->donnees['image']=NULL;
        $this->donnees['css']=NULL;
        $this->donnees['cible']=NULL;
        
        if($this->donnees['titre'] != null && $this->fichierIni != null && $this->nomMenu != null)
            $this->LireElement();
                
        return $this;
    }
    
    public function LireElement()
    {
        
        $données =['url'=>'','description'=>'','image'=>'','css'=>'','cible'=>''];
        $resultat = \systeme\objets\Persistance::getInstance()->LireXmlElementAttribut($this->fichierIni, $this->nomMenu , $this->donnees['titre'], $données);
              
        foreach ($resultat as $key => $value) 
        {
            $this->donnees[$key]=$value;
        }
        
        //debug($this->donnees);
        
        /**/
        //$this->LireXmlElementAttribut($this->fichierIni, 'Menus', $this->donnees['titre']);
    }
        
    public function SauvegardeElement()
    {
        $this->EcrireXmlElementAttribut($this->fichierIni, 'Menus', $this->donnees['titre']);
    }
        
}

