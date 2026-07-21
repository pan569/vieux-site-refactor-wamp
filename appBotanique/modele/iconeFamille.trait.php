<?php
namespace appBotanique\modele;

trait iconeFamille
{
    public static $cote;
    public static $bordure;
    //public static $width;
    public static $xMilieux;
    public static $yMilieux;
    public static $yBranche;
    public static $texte;
    public static $href;
    
    public static function calcul($coté,$texte)
    {        
        self::$cote = $coté;
        //self::$bordure = $bordure;
        //self::$width = self::$cote + 2 * self::$bordure;
        
        self::$xMilieux = 0 ;//self::$cote / 2;
        self::$yMilieux = 2 ;//self::$cote / 2;
        
        self::$yBranche = 250;
        
        self::$texte = $texte ;
        self::$href = "/appBotanique/vue/img_09.png" ;
    }
    
    public static function g()
    {
        $resultat = null;
        $resultat .='<g id="'.self::$texte.'" >'."\n";
        $resultat .="\t"."\t"."\t".'<circle  r="'. self::$cote/2 .'" class="forme" />'."\n";
        
        //$resultat .="\t"."\t"."\t".'<image xlink:href="'.self::$href.'" x="'.self::$bordure.'"  width="'.self::$cote.'" height="'.self::$cote.'" />'."\n";
        $resultat .="\t"."\t"."\t".'<text x="'.self::$xMilieux.'" y="'.self::$yMilieux.'" style="text-anchor:middle;">'.self::$texte.'</text>'."\n";
        $resultat .="\t"."\t".'</g>'."\n";
       
        
        return $resultat;
    }
}

