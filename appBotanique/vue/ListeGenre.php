<h1>Page de gestion des Genres</h1>
<p classe="text-right"><a href="<?=  $this->routeur->getRoute('ajouterGenre')->generateUri(); ?>"> ajouter </a></p>
<ul>
<?php foreach ( $model as $item): ?>
    <li>
    	<?= $item->get('LATIN')." - ".$item->get('FRANCAIS')  ;?>
    	<a href="<?= $this->routeur->getRoute('editerGenre')->generateUri(['id' => $item->get('id')]);?> "> editer </a>        
    </li>
<?php endforeach;?>
    
</ul>
<p><?= appObjet\modele\Objet::affichePagination($this->routeur->getRoute('indexGenre')->generateUri());?></p>