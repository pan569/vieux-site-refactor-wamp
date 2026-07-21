<?php
namespace systeme\exceptions;

class myException extends \Exception
{
    /**
     * Constructeur
     *
     * <p>cr�ation de l'instance de la classe. On rappelle le
     * constructeur de la classe parente (Exception).</p>
     *
     * @name MyException::__construct()
     * @return void
     */
    public function __construct($msg) 
    {
        parent :: __construct($msg);
    }
    
    public function getError() 
    {
        
        /* On retourne un message d'erreur complet pour nos besoins. avec le numero de ligne */
        $return  = 'Une exception a �t� g�r�e :<br/>';
        $return .= '<strong>Message : ' . $this->getMessage() . '</strong><br/>';
        $return .= 'A la ligne : ' . $this->getLine();
        
        return $return;
    }
    
    /**
     * Destructeur
     *
     * <p>Destruction de l'instance de classe</p>
     *
     * @name myException::__destruct()
     * @return void
     */
    public function __destruct() 
    {
        
    }
}

