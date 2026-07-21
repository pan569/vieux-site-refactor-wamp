<?php
$requette =  'SELECT * FROM article';

$resultats= \systeme\objets\Persistance::getInstance()->requettePerso($requette);

debug(count($resultats));

foreach ($resultats as $resultat)
{
    $item =  new \appBlog\modele\Blog();

    $item['titre']=$resultat['titre'];
    $item['slug']=str_replace( ' ' , '_' ,  $resultat['titre']);
    $item['contenu']=$resultat['contenu'];
    $item['image']=$resultat['image'];
    
    if($resultat['dateCreation'] != null)
    {
        $item['dateCreation']= \systeme\utilitaire\MyDateTime::getInstance()->getDateTime();
    }
    else 
    {
        $item['dateCreation']=$resultat['dateCreation'];
    }
    
    if($resultat['dateModification'] != null)
    {
        $item['dateModification']= \systeme\utilitaire\MyDateTime::getInstance()->getDateTime();
    }
    else
    {
        $item['dateModification']=$resultat['dateModification'];
    }
    
    
    
    $item['idCategorie']=$resultat['id_categorie'];
    
    //$item->INSERT();
    /*
    if(gettype($item->INSERT()) =="array" )
    {
        echo "il y a eu un probleme avec {$item['titre']} lors de l'insertion des données dans la base. </br>";
        debug($item->getDonnees());
    }
    */
}
/*
debug(count($resultats));

foreach ($resultats as $resultat)
{
    
    $b = new blog();
    $b['titre']=$resultat['titre'];
    $b['slug']=str_replace( ' ' , '_' ,  $resultat['titre']);
    $b['contenu']=$resultat['contenu'];
    $b['image']=$resultat['image'];
    $b['dateCreation']=$resultat['dateCreation'];
    $b['dateModification']=$resultat['dateModification'];
    $b['idCategorie']=$resultat['id_categorie'];
    
    debug($b->getDonnees(),"b{$resultat['titre']}");
    
    $b->INSERT();
/**/
?>