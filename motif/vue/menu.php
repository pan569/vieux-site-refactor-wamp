<?php
use systeme\vue\form;
$form = form::getInstance('form-control');
?>
<h1>Parametres du menu</h1>
<h2>Modification des données du menu</h2>    
<form method="post" action="<?=  $this->routeur->getRoute('modifMenu')->generateUri(); ?>" enctype="multipart/form-data">
    <div class="form-group">
    <?= $this->champCsrf(); ?>
    	<div>
    		<h3><?= e($model['titre'] ?? ''); ?></h3>
    		<p>url: <?= e($model['url'] ?? ''); ?></p>
    		<?= $form->ConstructeurChamp( "Description",'description', $model['description'] !== null ? $model['description'] : "",'textarea',[50,5]);?>    					
    		<?= $form->ConstructeurChamp( "Cible",'cible', $model['cible'] !== null ? $model['cible'] : "",'text');?>
    		<?= $form->ConstructeurChamp( "Css",'css', $model['css'] !== null ? $model['css'] : "",'textarea',[50,2]);?>
    		<?= $form->ConstructeurChamp( "Image",'image', $model['image'] !== null ? $model['image'] : "",'text');?>
    	</div>
    	<?= $form->ConstructeurChamp('','menu', $model['titre'] , 'hidden') ?>        
    	<?= $form->ConstructeurChamp('','form', 'true' , 'hidden') ?>
    	<p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>
