<?php
namespace systeme\utilitaire;

class MyDateTime
{
    
    const _JOURS = ['','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    const _MOIS = ['','Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
    
    private static $_myDateTime;
    public static function getInstance()
    {
        if(is_null(self::$_myDateTime))
        {
            self::$_myDateTime = new MyDateTime();
        }
            return self::$_myDateTime;
    }
    
    protected  $timestamp;
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    
    public function setTimestamp(int $timestamp = NULL)
    {         
        if($timestamp === NULL)
        {
            $this->timestamp = time();
        }
        else
        {
            $this->timestamp = $timestamp;
        }
        return $this;

    }
    
    public function setDateTime(string $DateTime)
    {
        $DT = new \DateTime($DateTime);
        $this->timestamp =$DT->getTimestamp();
        
        return $this;
    }
    
    public function __construct()
    {
        $this->timestamp = time();
    }
      
    public function getDateTime() 
    {
        return Date('Y-m-d h:i:s',$this->timestamp);
    }
    
    public function getDateTimefr()
    {
        return Date('d/m/Y h:i:s',$this->timestamp);
    }
    
    public function getDatefr()
    {
        return Date('d/m/Y',$this->timestamp);
    }
    
    public  function getTimefr()
    {
        return Date('h:i:s',$this->timestamp);
    }
    
    public  function getJourAnglais()
    {
        return Date('l');
    }
    
    public  function getJourFrancais()
    {
        return self::_JOURS[Date('N')];
    }
    
    public  function getMoisFrancais()
    {
        return self::_MOIS[Date('n')];
    }
    
    public  function getDateFrLitér() 
    {
       
        $d= Date('d',$this->timestamp);
        $Y= Date('Y',$this->timestamp);
        
        return "{$this->getJourFrancais()} {$d} {$this->getMoisFrancais()} {$Y}";
    }
    
    public  function getTimeFrLitér()
    {
        $H= Date('H',$this->timestamp);
        $i= Date('i',$this->timestamp);
        $s= Date('s',$this->timestamp);
        
        return "{$H}h{$i}:{$s}s";
    }
 
    public  function getDateTimeFrLitér()
    {        
        return "{$this->getDateFrLitér()} à {$this->getTimeFrLitér()}";
    }
	
}