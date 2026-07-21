<h1>Page de gestion des familles</h1>
<p classe="text-right"><a href="<?=  $this->routeur->getRoute('ajouterFamille')->generateUri(); ?>"> ajouter </a></p>
<ul>
<?php foreach ( $model as $item): ?>
    <li>
    	<?= $item->get('LATIN')." - ".$item->get('FRANCAIS')  ;?>
    	<a href="<?= $this->routeur->getRoute('editerFamille')->generateUri(['id' => $item->get('id')]);?> "> editer </a>
        <!--  <a href="< ?= $this->routeur->getRoute('supprimerFamille')->generateUri(['id' => $item->get('id')]);? > "> supprimer </a>-->
    </li>
<?php endforeach;?>
    
</ul>
<p><?= appObjet\modele\Objet::affichePagination($this->routeur->getRoute('indexFamille')->generateUri());?></p>

