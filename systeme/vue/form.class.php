<?php
namespace systeme\vue;

use systeme\securite\Csrf;

/**
 * Class Form
 * Permet de generer un formulaire
 *
 * le 08/12/2018 par ulysse1976
 *
 * Phase 6 : ajout de champCsrf() pour la protection CSRF.
 */
class form
{

    private static $_instance;
    /*
     * singleton de la classe
     */
    public static function getInstance(string $classe = null)
    {
        if(is_null(self::$_instance))
            self::$_instance = new form();

            return self::$_instance;
    }

    protected $classe;

    public function __construct(string $classe = null)
    {
        $this->classe =$classe;
    }

    /**
     * Champ hidden CSRF à placer dans chaque formulaire POST.
     * Usage : <?= $form->champCsrf(); ?>
     */
    public function champCsrf(string $name = '_csrf'): string
    {
        return Csrf::champ($name);
    }

    /**créer un champ pour formulaire
     * doté d'un <label> et d'un <span> pour afficher les erreurs
     *
     * @param string $nom nom de la variable a renseigner ( corespond aussi au for du label, a l'id du champ et au nom du champ
     * @param string $valeur valeur de la variable
     * @param string $type type du champ
     * @param string|null $description description du champ
     * @return string retourne un champ parfaitement formaté a inserrer dans un formulaire
     */
    public function ConstructeurChamp(string $titre, string $nom, string $valeur, string $type, array $options=[], string $description=null)
    {

        $resultat  = $this->LeLabel($titre, $nom);
        $resultat .= $this->ChoixTypeChamp($nom,$valeur,$type,$options);
        $resultat .= $this->spanErreur($nom);
        $resultat  = $this->BaliseDecoChamp($resultat,"p");

        return $resultat;
    }

    public function messageFlash(string $messageTexte, string $css)
    {
        //<?= $messageFlash->getMessage(\systeme\session\MessageFash::_Succes);
        return '<div class=\"'.$css.'\">'.$messageTexte.'</div>';
    }

    /**créer un champ pour formulaire de type checkbox ou radio
     * doté d'un <label> et d'un <span> pour afficher les erreurs
     *
     * @param string $nom nom de la variable a renseigner ( corespond aussi au for du label, a l'id du champ et au nom du champ
     * @param string $valeur valeur de la variable
     * @param string $type type du champ
     * @param string|null $description description du champ
     * @return string retourne un champ parfaitement formaté a inserrer dans un formulaire
     */
    public function ConstructeurChampSelection(string $titre, string $nom, string $valeur=null, string $type,$options=[], string $description=null)
    {

        $resultat  = $this->ChoixTypeChamp($nom,$valeur,$type,$options);
        $resultat .= $this->LeLabel($titre, $nom);
        $resultat .= $this->spanErreur($nom);
        $resultat  = $this->BaliseDecoChamp($resultat,"p");

        return $resultat;
    }

    /**créer un champ pour formulaire de type checkbox ou radio
     * doté d'un <label> et d'un <span> pour afficher les erreurs
     *
     * @param string $nom nom de la variable a renseigner ( corespond aussi au for du label, a l'id du champ et au nom du champ
     * @param string $valeur valeur de la variable
     * @param string $type type du champ
     * @param string|null $description description du champ
     * @return string retourne un champ parfaitement formaté a inserrer dans un formulaire
     */
    public function ConstructeurChampSelection_(string $titre, string $nom, string $valeur=null, string $type,$options=[], string $description=null)
    {

        $resultat  = $this->ChoixTypeChamp($nom,$valeur,$type,$options);
        $resultat .= $this->LeLabel($titre, $nom);
        $resultat .= $this->spanErreur($nom);
        //$resultat  = $this->BaliseDecoChamp($resultat,"p");

        return $resultat;
    }

    /**crée le label du champ pour identifier visuellement ce dernier
     *
     * @param string $nom
     * @return string
     */
    protected function LeLabel(string $titre,string $nom)
    {
        if($titre != "")
        {
            //$titre = strtoupper($titre);
            return "<label for=\"{$nom}\">{$titre} :</label>";
        }
        else
            return "<label for=\"{$nom}\"></label>";
    }

    /**crée le champs du formulaire selon son type
     *
     * @param string $nom
     * @param string $valeur
     * @param string $type
     * @return string
     */
    protected function ChoixTypeChamp(string $nom, string $valeur=null, string $type, $options = [])
    {
        switch ($type)
        {
            case 'text':
            case 'radio':
            case 'color':
            case 'date':
            case 'email':
            case 'password':
            case 'tel':
            case 'url':
                return "<input type=\"{$type}\" name=\"{$nom}\" id=\"{$nom}\" value=\"{$valeur}\" class=\"{$this->classe}\" />";
                break;

            case 'checkbox':

                $isCheck= false;

                if($valeur != null )
                    $isCheck = 'checked';


                return "<input type=\"{$type}\" name=\"{$nom}\" id=\"{$nom}\" value=\"{$valeur}\" class=\"{$this->classe}\" {$isCheck} />";
                break;

            case 'checkboxList':

                $resultat="";

                //debug($nom,"nom");
                //debug($valeur,"valeur");
                //debug($type,"type");
                //debug($options,"options");

                $valeurs = explode ( ';' , $valeur  );
                //debug($valeurs,"valeurs");


                foreach ($options as $option)
                {
                   //debug($option,"option");
                    if(!empty($option))
                    {
                        $isCheck = null;
                        if(in_array ($option , $valeurs ))
                        {
                           //debug("{$option} est dans le tableau valeurs");
                           $isCheck = 'checked';

                        }

                        $resultat.= $this->checkboxList($option,"{$nom}_{$option}", $isCheck);
                    }

                }

                return $resultat;
                break;
            case 'hidden':
                return "<input type=\"{$type}\" name=\"{$nom}\" id=\"{$nom}\" value=\"{$valeur}\" />";
                break;
            case 'date':
            case 'datetime-local':
            case 'time':
            case 'number':
                if(isset($options['min']) && isset($options['max']))
                    return "<input type=\"{$type}\" name=\"{$nom}\" id=\"{$nom}\" value=\"{$valeur}\" class=\"{$this->classe}\" min=\"{$options['min']}\" max=\"{$options['max']}\" />";
                else
                    return "<input type=\"{$type}\" name=\"{$nom}\" id=\"{$nom}\" value=\"{$valeur}\" class=\"{$this->classe}\"/>";
                break;
            case 'file':
                //$accept= implode ( ", " , $options ) ;//"image/png, image/jpeg" accept=\"{$accept}\"
                return "<input type=\"{$type}\" name=\"{$nom}\" id=\"{$nom}\" class=\"{$this->classe}\"  size=50 />";
                break;
            case 'image':
                $alt =$options['alt'];
                $src =$options['src'];
                $height =$options['height'];
                $width =$options['width'];
                return "<input type=\"{$type}\" name=\"{$nom}\" value=\"{$nom}\" class=\"{$this->classe}\" alt=\"{$alt}\" src=\"{$src}\" height=\"{$height}\" width=\"{$width}\" />";
                break;
            case 'submit':
                return "<input type=\"{$type}\" name=\"{$nom}\" value=\"{$valeur}\" class=\"{$this->classe}\" />";
                break;
            case 'textarea':
                $cols = $options[0];
                $rows = $options[1];
                return "<textarea name=\"{$nom}\" id=\"{$nom}\" cols=\"{$cols}\" rows=\"{$rows}\" class=\"{$this->classe}\" >{$valeur}</textarea>";
                break;
            case 'select':
                 $resultat = "<select name=\"{$nom}\" id=\"{$nom}\" class=\"{$this->classe}\" >";

                 foreach ($options as $c => $v)
                 {

                     $sel= null;

                     if($c == $valeur)
                         $sel='selected';
                     $resultat .= "<option value='{$c}' {$sel} >{$v}</option> ";
                 }

                $resultat .= "</select>";

                return $resultat;

                break;
            case 'selectDur':
                $resultat = "<select name=\"{$nom}\" id=\"{$nom}\" class=\"{$this->classe}\" >";

                foreach ($options as $option)
                {

                    $sel= null;

                    if($option == $valeur)
                        $sel='selected';
                        $resultat .= "<option value='{$option}' {$sel} >{$option}</option> ";
                }

                $resultat .= "</select>";

                return $resultat;

                break;
            case 'selectMultiple':
                $resultat = "<select name=\"{$nom}\" id=\"{$nom}\" class=\"{$this->classe}\" multiple=\"true\" >";

                //decompose la liste des valeurs a selectioner qui est sous chaine de caractaire en tableau
                $tabValeur = [];
                $separateur =';';
                if(strpos($valeur, $separateur) != false)
                {
                    $tabValeur = explode ( $separateur , $valeur);

                    //debug($tabValeur,"Conv convTexteVersTable tabValeur");
                }
                else
                {
                    $tabValeur[] = $valeur;
                }

                //ajoute toute les option a metre dans la liste selectable et selectionne selon la liste des valeurs
                foreach ($options as $option)
                {
                    $sel= null;
                    if(in_array ( $option , $tabValeur  ))
                    {
                        $sel='selected';

                    }

                    $resultat .= "<option value='{$option}' {$sel} >{$option}</option> ";
                }

                $resultat .= "</select>";

                return $resultat;

                break;
        }
    }

    /**Permet de creer les balises <datalist>, option de balises <input>
     * @param string $nom id de la balise <datalist>
     * @param array $options contient les données a inserrer dans les balises <option>
     * @return string
     */
    protected function DataList(string $nom, array $options)
    {
        $resultat = "<datalist id=\"{$nom}\">";
        foreach ($options as $clee => $valeur)
        {
            $resultat .= "<option value=\"{$clee}\">\"{$valeur}\"</option>";
        }
        $resultat .= "</datalist>";

        return $resultat;
    }

    /**crée une balise <button>
     *
     * @param string $titre etiquette de la balise
     * @param string $nom id de la balise
     * @param string $valeur
     * @param ?string $class
     * @param string $type type de bouton: submit/reset/button/menu
     * @return string
     */
    protected function Bouton (string $nom, string $valeur=null, string $type ='button' ,string $titre, $class = null)
    {
        return "<button id=\"{$nom}\"  type=\"{$type}\"  class=\"{$class}\"  value=\"{$valeur}\" >{$titre}</button>";
    }

    public function BoutonSupprimer (string $urlAction):string
    {
        //$urlAction =  $router->generateUri('blogAdmin.suppression', ['id' => $item->get('id')]);

        $csrf = Csrf::champ();

        $resultat ="
        <form method=\"post\" action=\"$urlAction\" enctype=\"multipart/form-data\">
        <div class=\"form-group\">
        <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
        {$csrf}
        <p><button class=\"btn btn-primary\">Supprimer</button></p>
        </div>
        </form>
        ";

        return $resultat;
    }

    /**
     * permet de creer le span qui affiche que le champ est mal renseigné
     *
     * @param string $nom
     * @return string
     */
    protected function spanErreur(string $nom)
    {
        //$nom = ''.$nom;
        return "<span class=\"spanErreur\" id=\"erreur{$nom}\"></span>";
    }

    /**
     * @param string $champ corespond a un champ du formulaire
     * @param string $balise element qui entour le formulaire
     * @return string le champ entouré d'une balise
     */
    protected function BaliseDecoChamp ($champ, $balise)
    {
        return "<{$balise}>{$champ}</{$balise}>";
    }


    public function LienMenu(string $href, string $titre, bool $active = false)
    {
        $lien = $this->Lien($href, $titre , ['nav-link'], null);

        if($active)
        {
            $class = 'class="nav-item active"';
        }
        else
        {
            $class = 'class="nav-item"';
        }


        return "<li $class >{$lien}</li>";
    }

    public function Lien(string $href, string $titre, string $Css, ?string $src, ?string $cible = null )
    {


        //$class = implode(" ", $Css);
        $class = $Css;

        if($cible != null)
        {
            $target = "target=\"{$cible}\"";
        }
        else
        {
            $target = null;
        }


        if($src == null)
        {
            return "<a class=\"{$class}\" href=\"{$href}\" {$target}>{$titre}</a>";
        }
        else
        {
            return "<a class=\"{$class}\" href=\"{$href}\" {$target} ><img src=\"{$src}\" title=\"{$titre}\" alt=\"{$titre}\" ></a>";
        }

    }

    public function link($href)
    {
        return "<link href=\"{$href}\" rel=\"stylesheet\" type=\"text/css\">";
    }

    public function script($src)
    {
        //return "<script src=\"{$src}\" async></script>";
        return "<script src=\"{$src}\" ></script>";
    }

    public function test01 (/*$titre, $nom, $valeur*/)
    {

        $valeur = "Fr;Al;Jn;At;Oe;De";

        $tabValeur = explode ( ';' ,  $valeur  );

        //debug($tabValeur,"form test01 tabValeur");


        $list= array('Jr','Fr','Ms','Al','Mi','Jn','Jt','At','Se','Oe','Ne','De');
        $resultat = NULL;
        foreach ($list as $mois)
        {

            if (in_array ( $mois , $tabValeur ,false ))
            {
                $val = true;
            }
            else
            {
                $val = false;
            }

            //debug($val,$mois);

            $resultat .= $this->ConstructeurChampSelection_($mois, $mois, $val , 'checkbox');
        }

        $resultat  = $this->BaliseDecoChamp($resultat,"p");
        //

        return $resultat;

    }


    public function checkboxList(string $titre, string $nom, string $valeur = null, string $option = null)
    {

        //$resultat  = $this->LeLabel( substr($titre, 0, 3) , $nom);
        $resultat  = $this->LeLabel( $titre, $nom);
        $resultat .= $this->ChoixTypeChamp($nom,$valeur,'checkbox',$option);
        //$resultat .= $this->spanErreur($nom);
        //$resultat  = $this->BaliseDecoChamp($resultat,"p");

        return $resultat;
    }



}

?>
