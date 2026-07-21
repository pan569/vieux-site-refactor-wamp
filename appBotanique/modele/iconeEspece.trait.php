<?php
namespace appBotanique\modele;

trait iconeEspece
{
    public $cote;
    public $bordure;
    public $width;
    public $xMilieux;
    public $yMilieux;
    public $yBranche;
    public $texte;
    public $href;
    
    public function calcul($coté,$bordure)
    {        
        $this->cote = $coté;
        $this->bordure = $bordure;
        $this->width = $this->cote + 2 * $this->bordure;
        
        $this->xMilieux = $this->width / 2;
        $this->yMilieux = $this->cote / 2;
        
        $this->yBranche = 250;
        
        $this->texte = "icone" ;
        $this->href = "/appBotanique/vue/img_09.png" ;
    }
    
    public function g()
    {
        $resultat = null;
        $resultat .='<g id="'.$this->texte.'" >'."\n";
        //$resultat .="\t"."\t"."\t".'<rect width="'.$this->cote.'" height="'.$this->cote.'" x=" '.$this->bordure.' " class="forme" />'."\n";
        $resultat .="\t"."\t"."\t".'<image xlink:href="'.$this->href.'" x="'.$this->bordure.'"  width="'.$this->cote.'" height="'.$this->cote.'" />'."\n";
        $resultat .="\t"."\t"."\t".'<text x="'.$this->xMilieux.'" y="'.($this->cote - 4)  .'" style="text-anchor:middle;">'.$this->texte.'</text>'."\n";
        $resultat .="\t"."\t".'</g>'."\n";
       
        return $resultat;
    }
}

