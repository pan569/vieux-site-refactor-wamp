<?php
namespace motif\modele;

use systeme\objets\Item;
use systeme\objets\Persistance;
use systeme\vue\form;
use systeme;

class Motif extends Item
{
    //const _FICHIER_INI =
    
    public $fichierIni ;
    
    public function getDossierTheme(string $s = null )
    {
        $resultat = $this->donnees['Configuration']['SiteThemeDossier'].DIRECTORY_SEPARATOR."theme.".$this->donnees['Configuration']['SiteThemeNom'].DIRECTORY_SEPARATOR;
        
        
        if($s==null)
        {
            $s = DIRECTORY_SEPARATOR;
        }
                
        $resultat = str_replace( ["\\",'/'] , $s , $resultat  );
        
        return $resultat;
        //return $_SERVER ["DOCUMENT_ROOT"].$this->donnees['Configuration']['SiteThemeDossier'].DIRECTORY_SEPARATOR."theme.".$this->donnees['Configuration']['SiteThemeNom'];
    }
    
    public function __construct(string $fichierIni = null)
    {
        
        //debug($fichierIni,"Motif->constructeur() fichierIni");
        
        self::getDictionaire()->clearDefinition();
        
        if($fichierIni == null)
        {
            $this->fichierIni = $_SERVER ["DOCUMENT_ROOT"] .DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'ini.xml';//'/resourses/ini_monBlog.xml'
        }
        else
        {
            $this->fichierIni = $_SERVER ["DOCUMENT_ROOT"] .DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.$fichierIni;//'/resourses/ini_monBlog.xml'
        }
            
        $this->donnees['Configuration'] = $this->iniConfiguration();                                      
        $this->donnees['Developpeur'] = $this->iniPersonne('Developpeur');        
        $this->donnees['Proprietaire'] = $this->iniPersonne('Proprietaire');        
        $this->donnees['Hebergeur'] = $this->iniPersonne('Hebergeur');
        $this->donnees['Entete'] = $this->iniEntete();
        $this->donnees['Menus'] = $this->iniMenu('Menus');
        $this->donnees['Pied'] = $this->iniMenu('Pied');
        
        $this->donnees['aside'] = [];
        $this->donnees['fichiersCss'] = [];
        $this->donnees['fichiersJavaSript'] = [];

        $dossier = $this->donnees['Configuration']['SiteThemeDossier'].DIRECTORY_SEPARATOR."theme.".$this->donnees['Configuration']['SiteThemeNom'];        
        $this->ajoutFichier($dossier);
        
        
        
        return $this;
    }    
 
    
    public function iniConfiguration()
    {
        $t=[];
        $t['SiteNom']=NULL;
        $t['SiteDescriptif']=NULL;
        $t['SiteThemeDossier']=NULL;
        $t['SiteThemeNom']=NULL;
        $t['SiteJavaScriptDossier']=NULL;
        $t['DataBaseServeur']=NULL;
        $t['DataBaseUtilisateur']=NULL;
        $t['DataBaseMdP']=NULL;
        $t['DataBaseNon']=NULL;
        $t['SiteCopyright']=NULL;
        
        $t = Persistance::getInstance()->LireXmlElement($this->fichierIni, 'Configuration', $t);
        
        
        foreach (array_keys($t) as $clé)
        {
            $t[$clé]=str_replace("|" , DIRECTORY_SEPARATOR , $t[$clé] );
        }
        
        
        return $t;
        
    }
    
    public function iniPersonne(string $personne)
    {
        $t=[];
        $t['nom']=NULL;
        $t['adresse']=NULL;
        $t['telephone']=NULL;
        $t['email']=NULL;
        $t['www']=NULL;
        
        //$this->LireXmlElementAttribut($this->fichierIni, 'Credits', $this->personne);        
        $t = Persistance::getInstance()->LireXmlElementAttribut($this->fichierIni, 'Credits', $personne, $t);
        
        return $t;
    }
    
    public function iniEntete()
    {
        
        $t['auteur']=NULL;
        $t['description']=NULL;
        $t['motsCles']=NULL;
        $t['editeur']=NULL;
        $t['titre']=NULL;
        $t['image']=NULL;
        
        //$this->LireXmlElement($this->fichierIni, 'Entete');
        $t = Persistance::getInstance()->LireXmlElement($this->fichierIni, 'Entete', $t);
        
        return $t;
    }
    
    public function iniMenu(string $menus)
    {
        $t=[];
        
        $lienMenu = new lienMenu();
        $tab = Persistance::getInstance()->LireXmlListeElement($this->fichierIni, $menus,  $lienMenu->getCle());
        
        foreach ($tab as $titre)
        {
            $newlienMenu= new lienMenu($this->fichierIni, $menus,  $titre);
            $t[$newlienMenu['titre']]=$newlienMenu;
        }
        
        return $t;
    }
    
    public function iniAside(string $fichierIni = null)
    {
       
    }
    
    public function SauvegardeElement($element)
    {        
        Persistance::getInstance()->EcrireXmlElement($this->fichierIni, $element, $this->donnees[$element]);
    }
    public function SauvegardeElementAttribut($element,$attribut)
    {        
        debug($element,"motif->SauvegardeElementAttribut() element");
        debug($attribut,"motif->SauvegardeElementAttribut() attribut");
        debug($this->donnees[$attribut],"motif->SauvegardeElementAttribut() this->donnees[attribut]");
        Persistance::getInstance()->EcrireXmlElementAttribut($this->fichierIni, $element, $attribut, $this->donnees[$attribut]);        
    }
    
    
    /**
     * Liste les fichiers d'un type donné (css|js) dans un dossier resources.
     * Si le sous-dossier n'existe pas (app sans JS, après nettoyage, etc.), retourne [] sans warning.
     */
    public function lister(string $dossier = null, string $typeFichier = null)
    {
        $resultat = [];

        $dirname = $_SERVER["DOCUMENT_ROOT"] . $dossier . DIRECTORY_SEPARATOR . $typeFichier . DIRECTORY_SEPARATOR;

        // Robustesse : une app peut n'avoir que du CSS, ou aucun resource après nettoyage des doublons
        if (!is_dir($dirname)) {
            return $resultat;
        }

        $dir = @opendir($dirname);
        if ($dir === false) {
            return $resultat;
        }

        while ($file = readdir($dir)) {
            if ($file != '.' && $file != '..' && !is_dir($dirname . $file)) {
                $extension = substr(strrchr($file, '.'), 1);
                if ($extension == $typeFichier) {
                    $fichier = str_replace('\\', '/', $dossier) . "/{$typeFichier}/" . $file;
                    $resultat[] = $fichier;
                }
            }
        }

        closedir($dir);

        return $resultat;
    }
    
    public function ajoutFichier(string $dossier = null)
    {
        $this->ajoutFichierCSS($dossier);
        $this->ajoutFichierJS($dossier);
    }
     
    public function ajoutFichierCSS(string $dossier = null)
    {
        $this->donnees['fichiersCss'] = array_merge($this->donnees['fichiersCss'],  $this->lister($dossier,'css'));        
    }
    
    public function ajoutFichierJS(string $dossier = null)
    {        
        $this->donnees['fichiersJavaSript'] = array_merge($this->donnees['fichiersJavaSript'],  $this->lister($dossier,'js'));
    }
    
    
    public function head()
    {
        $resultat = null;
        
        $resultat .="<head>"."\n";
        
        $resultat .="\t"."<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" >"."\n";
        $resultat .="\t"."<meta name=\"author\" content=\"{$this->donnees['Entete']['auteur']}\" >"."\n";
        $resultat .="\t"."<meta name=\"description\" content=\"{$this->donnees['Entete']['description']}\" >"."\n";
        $resultat .="\t"."<meta name=\"keywords\" content=\"{$this->donnees['Entete']['motsCles']}\" >"."\n";
        $resultat .="\t"."<meta name=\"generator\" content=\"{$this->donnees['Entete']['editeur']}\" >"."\n";
        $resultat .="\t"."<title>{$this->donnees['Entete']['titre']}</title>"."\n";
        
        $resultat .= "\n";
        
        $resultat .="\t"."<link href=\"{$this->getDossierTheme('/')}img/{$this->donnees['Entete']['image']}\" rel=\"shortcut icon\" type=\"image/ico\" />"."\n";
        
        $resultat .= "\n";
        
        foreach ($this->donnees['fichiersCss'] as $fichierCSS)
        {
            $resultat .="\t". form::getInstance()->link($fichierCSS)."\n";
            //debug($r."\n");
        }
        
        $resultat .= "\n";
        
        foreach ($this->donnees['fichiersJavaSript'] as $fichierJavaSript)
        {
            $resultat .="\t". form::getInstance()->script($fichierJavaSript)."\n";
            //debug($r."\n");
        }
        
        $resultat .="</head>"."\n";
        
        return $resultat;
    }

    public function nav()
    {
        $form = systeme\vue\form::getInstance('form-control');
        
        $resultat = null;        
        $tab = "\t\t";
        
        $resultat .=$tab."<nav>"."\n";
        
        foreach ($this->donnees['Menus']  as $lienMenu)
        {
            if($lienMenu['image'] != "")
            {
                $src= "..".$this->getDossierTheme()."img\\".$lienMenu['image'];
            }
            else 
            {
                $src = null;
            }
            
            $resultat .= "\t".$tab.$form->Lien($lienMenu['url'], $lienMenu['titre'], $lienMenu['css'],$src,$lienMenu['cible'])."\n";;
        }
        
        $resultat .=$tab."</nav>"."\n";
        
        return $resultat;
        
    }
    
    public function header()
    {
        
        
        $resultat = null;        
        $tab = "\t";
        
        $resultat .=$tab."<header>"."\n";        
        $resultat .= $this->nav();
        $resultat .=$tab."</header>"."\n";
        
        return $resultat;
    }
    
    public function navpied()
    {
        $form = systeme\vue\form::getInstance('form-control');
        $resultat = null;
        
        $tab = "\t\t";
        
        $resultat .=$tab."<nav>"."\n";
        
        foreach ($this->donnees['Pied']  as $lienMenu)
        {
            if($lienMenu['image'] != "")
            {
                $src= "..".$this->getDossierTheme()."img\\".$lienMenu['image'];
            }
            else
            {
                $src = null;
            }
            $resultat .= "\t".$tab.$form->Lien($lienMenu['url'], $lienMenu['titre'], $lienMenu['css'], $src, $lienMenu['cible'])."\n";
            
        }
        
        $resultat .=$tab."</nav>"."\n";
        
        return $resultat;
        
    }

    public function navApp()
    {
        $resultat = null;
        
        $tab = "\t\t";
        
        $resultat .=$tab."<aside class=\"sidebar\">"."\n";
        $resultat .=$tab." <h4 class=\"sidebar-title\">Catégorie</h4>"."\n";
        $resultat .=$tab." <ul>"."\n";
        if($this->donnees['aside'] != null)
        {
            foreach ($this->donnees['aside']  as $menu => $valeur)
            {           
                $resultat .="<li><a href=\" ".$valeur['lien']." \" data-count=\"  ".$valeur['count']." \">$menu</a></li>";           
            }
        }
        
        $resultat .=$tab." </ul>"."\n";
        $resultat .=$tab."</aside>"."\n";
        
        return $resultat;
    }
    
    public function footer()
    {
        $resultat = null;
        
        $tab = "\t";
        
        $resultat .=$tab."<footer class=\"footer\" >"."\n";
        $resultat .="\t".$tab."Créé par {$this['Developpeur']['nom']}"."\n";
        $resultat .= $this->navpied();
        $resultat .=$tab."</footer>"."\n";
        
        return $resultat;
    }
    
    public function body($model)
    {
        $resultat = null;
        $tab = "\t";
    
        $resultat .=$tab."<body>"."\n";
        $resultat .=$this->header();
        $resultat .="<div id=\"banniere\"></div>"."\n";
        $resultat .="<div id=\"body\">"."\n";
        $resultat .= $model; 
        
        $resultat .= $this->navApp();
        
        $resultat .="</div>"."\n";
        
        $resultat .=$this->footer();    
		$resultat .=$tab."</body>"."\n";

		return $resultat;
    }

    

}

