<?php
namespace motif\modele;

class aside
{
    protected $listeLiens = [];
    
    public function getLiens()
    {
        return $this->listeLiens;
    }
    
    public function __construct()
    {   
        
        $this->listeLiens['Index'] = array( 'route' => 'index', 'count' => '');
        
        $this->listeLiens['configuration'] = array( 'route' => 'modifConfiguration', 'count' => '');
        
        $this->listeLiens['Credit'] = array( 'route' => 'modifCredit', 'count' => '');
        
        $this->listeLiens['Entete'] = array( 'route' => 'modifEntete', 'count' => '');
        
        //$this->listeLiens['Liste des plantes'] = array( 'route' => 'indexPlante', 'count' => Persistance::getInstance()->COUNT('plante')['Nbr']);
        /**/
        return $this;
    }
}

