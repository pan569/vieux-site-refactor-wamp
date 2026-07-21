<h1>Page de gestion des Plantes</h1>
<p classe="text-right"><a href="<?=  $this->routeur->getRoute('ajouterPlante')->generateUri(); ?>"> ajouter </a></p>


<ul>
<?php foreach ( $model as $item): ?>
    <li>
    	<!--  < ?= $item->get('NOM')  ;? > -->
    	<a href="<?= $this->routeur->getRoute('montrerPlante')->generateUri(['id' => $item->get('id')]);?> "> <?= $item->get('NOM')." - ".$item->get('VARIETEE')  ;?> </a>
    	<a href="<?= $this->routeur->getRoute('editerPlante')->generateUri(['id' => $item->get('id')]);?> "> editer </a>
        <!--  <a href="<?= $this->routeur->getRoute('supprimerPlante')->generateUri(['id' => $item->get('id')]);?> "> supprimer </a> -->
    </li>
<?php endforeach;?>
    
</ul>
<p><?= appObjet\modele\Objet::affichePagination($this->routeur->getRoute('indexPlante')->generateUri());?></p>