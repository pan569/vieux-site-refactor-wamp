<h1>Bienvenue sur le blog</h1>

<p classe="text-right"><a href="<?=  $this->routeur->getRoute('ajouter')->generateUri(); ?>"> ajouter </a></p>
<ul>
<?php foreach ( $model as $item): ?>
    <li>
    	<a href="<?= $this->routeur->getRoute('montrer')->generateUri(['id' => $item['id']]);?> "><?= $item['titre'] ;?></a>
    	<a href="<?= $this->routeur->getRoute('editer')->generateUri(['id' => $item['id']]);?> "> editer </a>
        <a href="<?= $this->routeur->getRoute('supprimer')->generateUri(['id' => $item['id']]);?> "> supprimer </a>
    </li>
    
<?php endforeach;?>
    
</ul>
<p><?= appBlog\modele\Blog::affichePagination($this->routeur->getRoute('index')->generateUri());?></p>

