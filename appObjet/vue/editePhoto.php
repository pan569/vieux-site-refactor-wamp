<?php
use \systeme\vue\form;

$form = form::getInstance('form-control');

debug($this->routeur->getRoute('editerPhoto')->generateUri(),'adresse')

?>

<form method="post" action="<?=  $this->routeur->getRoute('editerPhoto')->generateUri(); ?>" enctype="multipart/form-data">
	<div class="form-group">		
		<input type="hidden" name="fonction" value="modifier">
		<input type="hidden" name="MAX_FILE_SIZE" value="600000">
		<input type="hidden" name="id" value="">		
		<?= $form->ConstructeurChamp( "Photo",'Photo', "", 'file');?>
		<?= $form->ConstructeurChamp( "description",'description',"" ,'text');?>
		<?= $form->ConstructeurChamp( "Bulle",'Bulle', "", 'file');?>
		<?= $form->ConstructeurChamp( "Texte de la bulle",'texteBulle',"" ,'text');?>
		<p><button class="btn btn-primary">Valider</button></p>
	</div>
</form>