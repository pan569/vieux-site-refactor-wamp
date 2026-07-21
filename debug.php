<?php

function debug($objet, $titre = null)
{

    $type = gettype($objet);    
    $valeur = null;
    
    if(is_bool ($objet) )   
    {        
        $valeur = ($objet) ? 'true' : 'false';
         
    }
    else
    {
        $valeur = "<pre>".print_r($objet,true)."</pre>";
    } 
    
    /*
    echo "<p>nom:{$titre}</p>";
    echo "<p>type:{$type}</p>";
    echo "<p>valeur:{$valeur}</p>";
    /**/
    
    echo '<table  style="border-collapse: collapse;">';
    echo '  <tr>';
    echo '      <th scope="col" colspan="2" style="border:1px solid black;">';
    echo "          nom:{$titre}";
    echo '      </th>';
    echo '  </tr>';
    echo '  <tr>';
    echo '      <th scope="col" style="border:1px solid black;">';
    echo "          type";
    echo '      </th>';
    echo '      <th scope="col" style="border:1px solid black;">';
    echo "          valeur";
    echo '      </th>';
    echo '  </tr>';
    echo '  <tr>';
    echo '      <td style="border:1px solid black;">';
    echo "          {$type}";
    echo '      </td>';
    echo '      <td style="border:1px solid black;">';
    echo "          {$valeur}";
    echo '      </td>';
    echo '  </tr>';
    echo '</table>';
    /**/    
}

function url()
{    
    /*
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https";
        else
            $url = "http";
            
            // Ajoutez // à l'URL.
            $url .= "://";
            
            // Ajoutez l'hôte (nom de domaine, ip) à l'URL.
            $url .= $_SERVER['HTTP_HOST'];
            
            // Ajouter l'emplacement de la ressource demandée à l'URL
            $url .= $_SERVER['REQUEST_URI'];
            
            // Afficher l'URL
            return  $url;
            
    /**/    
        
        echo "<pre>";
        print_r($GLOBALS);
        echo "</pre>";
}

function tableDansHTMLTable($table,$titre =null)
{
    
    //echo "type de variable :".gettype($table);
  
    
    $resultat = "";
    
    $resultat .="<table style=\" border-collapse: collapse \" >\n"; 
    
    $resultat .="<thead>\n";
    $resultat .="<tr>\n";
    $resultat .="<th colspan=\"2\" style=\"border: 1px solid black \">{$titre}</th>";    
    $resultat .="</tr>";
    $resultat .="<tr>\n";
    $resultat .="<th style=\"border: 1px solid black \">clé</th>";
    $resultat .="<th style=\"border: 1px solid black \">valeur</th>\n";
    $resultat .="</tr>";
    $resultat .="</thead>\n";
    $resultat .="<tbody>\n";
    foreach ($table as $clé => $valeur)
    {
        $resultat .="<tr>\n";
        $resultat .="<td style=\"border: 1px solid black \">{$clé}</td>\n";
        
                
        
        if(is_array($valeur))
        {
            $t=tableDansHTMLTable($valeur);
            $resultat .="<td style=\"border: 1px solid black \">{$t}</td>\n";
        }
        else 
        {
            $resultat .="<td style=\"border: 1px solid black \">";
            $resultat .="<pre>".print_r($valeur)."</pre>";
            $resultat .="</td>\n";
        }
        /**/
        $resultat .="</tr>\n";
    }
    
    $resultat .="</tbody>\n";
    $resultat .="</table>\n";
       
    
    return $resultat;
    

}