<?php
use appAlbum\modele\iptc;

echo "editeur exif";


$nomImage="SainteNiTouche.jpg";
$chemin = "C:\\wamp64\\www\\site01\\appAlbum\\vue\\resources\\img\\X\\".$nomImage;
$iptc = new \appAlbum\modele\iptc($chemin);


$iptc['Description']="La sainte ni touche";
$iptc['Instructions']='{"image":"bulle06.png","translate":"50,50","scale":"1.5","texte":"tu veux savoir si je porte une culotte ?."}';
$iptc->sauvegarderIptc();

/*
 * 
 * Categorie
 * SupplementalCategories
 * Motsclé
 * ReleaseDate
 * 
 */


debug('',"executé");

?>