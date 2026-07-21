<?php 
/*
foreach ($menu as $lien => $valeur)
    {
        //$this->routeur->getRoute($valeur['route'])->generateUri();
        
        debug($this->routeur->getRoutes(),'routes');
        
        debug($lien,'lien');
        debug($valeur['route'],'route');
        debug($valeur['count'],'count');
    }
    
    
    
    <li><a href="<?=  $this->routeur->getRoute($valeur['route'])->generateUri(); ?>" data-count="<?=$valeur['count'];?>"><?=$lien;?></a></li>
/**/
?>

<aside class="sidebar">
    <h4 class="sidebar-title">Catégorie</h4>
    <ul>
<?php foreach ( $menu as $lien => $valeur): ?>		
        <li><a href="<?=  $this->routeur->getRoute($valeur['route'])->generateUri(); ?>" data-count=""><?=$lien;?></a></li>        
<?php endforeach;?>        
    </ul>
    <hr>
    <h4 class="sidebar-title">Auteurs</h4>
    <ul>
        <li><a href="#">Ulysse1976</a></li>
    </ul>
</aside>
