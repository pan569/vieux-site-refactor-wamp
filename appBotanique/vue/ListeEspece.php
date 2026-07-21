<h1>Page de gestion des Especes</h1>
<p classe="text-right"><a href="<?=  $this->routeur->getRoute('ajouterEspece')->generateUri(); ?>"> ajouter </a></p>
<ul>
<?php foreach ( $model as $item): ?>
    <li>
    	<a href="<?= $this->routeur->getRoute('montrerEspece')->generateUri(['id' => $item->get('id')]);?> "> <?= $item->get('LATIN')." - ".$item->get('FRANCAIS')  ;?> </a>
    	<a href="<?= $this->routeur->getRoute('editerEspece')->generateUri(['id' => $item->get('id')]);?> "> editer </a>
    </li>
<?php endforeach;?>    
</ul>
<p><?= appObjet\modele\Objet::affichePagination($this->routeur->getRoute('indexEspece')->generateUri());?></p>