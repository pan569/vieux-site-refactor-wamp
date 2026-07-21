<?php 

use systeme\vue\form;

$form = form::getInstance('form-control');

$action = $this->routeur->getRoute($nomDeVue)->generateUri(['id' => $model->get('id')]);

if($nomDeVue == "editerEspece")
{
    $titre = "Edition de l'éspece " . e($model->get('LATIN'));
}
else
{
    $titre ="Ajouter une éspece";
}

?>

<h1><?= e($titre); ?></h1>    

<a class="btn btn-primary" href="<?=  $this->routeur->getRoute('indexEspece')->generateUri(); ?>">Retour a la liste des especes</a>

<form method="post" action="<?=$action; ?>" enctype="multipart/form-data">
    <div class="form-group">
    <?= $this->champCsrf(); ?>
	<?= $form->ConstructeurChampSelection("Genre", "ID_GENRE", $model->get('ID_GENRE') !== null ? $model->get('ID_GENRE') : 0 ,"select",$listeGenre) ?>                               
    <?= $form->ConstructeurChamp( "LATIN",'LATIN', $model->get('LATIN') !== null ? $model->get('LATIN') : "",'text');?>      
    <?= $form->ConstructeurChamp( "FRANCAIS",'FRANCAIS',   $model->get('FRANCAIS') !== null ? $model->get('FRANCAIS') : "", 'text');?>
    <?= $form->ConstructeurChamp( "ENSEMBLE",'ENSEMBLE', "", 'file');?>
    <?= $form->ConstructeurChamp( "FEUILLE",'FEUILLE', "", 'file');?>
    <?= $form->ConstructeurChamp( "FLEUR",'FLEUR', "", 'file');?>
    <?= $form->ConstructeurChamp( "FRUIT",'FRUIT', "", 'file');?>
    <?= $form->ConstructeurChamp( "TIGE",'TIGE', "", 'file');?>
    <?= $form->ConstructeurChamp( "RACINE",'RACINE', "", 'file');?>
    <?= $form->ConstructeurChamp( "ECORSE",'ECORSE', "", 'file');?>
    <p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>

<?php if ($nomDeVue == "editerEspece"): ?>
<form style="display: inline;" method="post" action="<?=  $this->routeur->getRoute('supprimerEspece')->generateUri(['id' => $model->get('id')]); ?>" enctype="multipart/form-data">
    <?= $this->champCsrf(); ?>
	<input type="hidden" name="method" value="DELETE">
	<button class="btn btn-primary">Supprimer</button>
</form>
<?php endif; ?>
