<?php
namespace systeme\validateur;

/*

 erreur a coriger :
    -remplacer slug par regex [X]
    -revoir les messages d'erreur [ ]
    -test sur le type de données [ ]

/**/

class Erreurs
{
    protected $cle;
    
    protected $regle;
    
    protected $options;
    
    protected $messages =
    [
        'reclamé' => "le champs %s est récalmé",
        'type' => "le champs %s est de type %s. Celle-ci devrais etre de type '%s' ",
        'null' => "le champs %s ne doit pas etre vide",
        'testerExpReg' => "le champs %s n'est pas valide(%s) . regex: %s",
        'tailleEntre' => "le champs %s contient %d caractere. Il doit avoir un nombre de caractere compris entre %d et %d ",
        'tailleMinimal' => "le champs %s doit avoir moins de %d caractere",
        'tailleMaximal' => "le champs %s doit avoir plus de %d caractere",
        'date' => "le champs %s a comme valeur : %s. Celle-ci ne respecte pas le format '%s' "        
    ];
    
    public function __construct(string $cle, string $regle, array $options =[])
    {
        $this->cle=$cle;
        $this->regle=$regle;
        $this->options = $options;
    }
    
    public function __toString()
    {
        //debug($this->regle,"regle");
        //debug($this->cle,"cle");
        //debug($this->options,"options");
        debug($this->regle,"regle");
        
        if(array_key_exists ( $this->regle , $this->messages ))
        {
            $message= $this->messages[$this->regle];
        }
        else
        {
            $message="!!!";
        }
        
        $tab = array_merge([$message,$this->cle],$this->options);
        
        //debug($tab,"tab");
        
        return (string)call_user_func_array('sprintf',$tab);
    }
}

