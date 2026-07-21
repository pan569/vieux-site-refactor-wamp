<?php 

use systeme\vue\form;
$form = form::getInstance('form-control');

$action = $this->routeur->getRoute($nomDeVue)->generateUri(['id' => $model->get('id')]);

if($nomDeVue == "editerGenre")
{
    $titre = "Edition de la Genre " . e($model->get('LATIN'));
}
else
{
    $titre ="Ajouter un genre";
}

?>

<h1><?= e($titre); ?></h1>

<a class="btn btn-primary" href="<?=  $this->routeur->getRoute('indexGenre')->generateUri(); ?>">Retour a la liste des genres</a>    

<form method="post" action="<?=  $action; ?>" enctype="multipart/form-data">
    <div class="form-group">
    <?= $this->champCsrf(); ?>
	<?= $form->ConstructeurChampSelection("Famille", "ID_FAMILLE", $model->get('ID_FAMILLE') !== null ? $model->get('ID_FAMILLE') : 0 ,"select",$listeFamille) ?>                               
    <?= $form->ConstructeurChamp( "LATIN",'LATIN', $model->get('LATIN') !== null ? $model->get('LATIN') : "",'text');?>      
    <?= $form->ConstructeurChamp( "FRANCAIS",'FRANCAIS',   $model->get('FRANCAIS') !== null ? $model->get('FRANCAIS') : "", 'text');?>
    
    <p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>

<?php if ($nomDeVue == "editerGenre"): ?>
<form style="display: inline;" method="post" action="<?=  $this->routeur->getRoute('supprimerGenre')->generateUri(['id' => $model->get('id')]); ?>" enctype="multipart/form-data">
    <?= $this->champCsrf(); ?>
	<input type="hidden" name="method" value="DELETE">
	<button class="btn btn-primary">Supprimer</button>
</form>
<?php endif; ?>
