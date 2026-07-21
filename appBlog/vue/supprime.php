<?php 
use \systeme\vue\form;

$form = form::getInstance('form-control');

?>
    <h1>Supression de l'article " <?= $item->get('titre');?> " ?</h1>
    <p><?=$item->dateCreation();?></p>
	<p><?= $item->getExtrai();?></p>
	
	<a class="btn btn-primary" href="<?=  $router->generateUri('blogAdmin.index'); ?>">non</a>
	
	<form style="display: inline;" method="post" action="<?=  $router->generateUri('blogAdmin.supprimer', ['id' => $item->get('id')]); ?>" enctype="multipart/form-data">
    	<input type="hidden" name="method" value="DELETE">
     	<button class="btn btn-primary">Supprimer</button>
	</form>

