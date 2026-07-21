<?php 
use systeme\vue\form;
$form = form::getInstance('form-control');

$action = $this->routeur->getRoute($nomDeVue)->generateUri(['id' => $model->get('id')]);

if($nomDeVue == "editerFamille")
{
    $titre = "Edition de la famille " . $model->get('LATIN');
}
else 
{
    $titre ="Ajouter une famille";
}
    
?>

<h1><?=$titre;?></h1>    

<a class="btn btn-primary" href="<?=  $this->routeur->getRoute('indexFamille')->generateUri(); ?>">Retour a la liste des familles</a>

<form method="post" action="<?= $action;?>" enctype="multipart/form-data">
    <div class="form-group">

	<?= $form->ConstructeurChamp( "LATIN",'LATIN', $model->get('LATIN') !== null ? $model->get('LATIN') : "",'text');?>      
    <?= $form->ConstructeurChamp( "FRANCAIS",'FRANCAIS',   $model->get('FRANCAIS') !== null ? $model->get('FRANCAIS') : "", 'text');?>
    
    <p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>


<?php if ($nomDeVue == "editerFamille"): ?>
<form style="display: inline;" method="post" action="<?=  $this->routeur->getRoute('supprimerFamille')->generateUri(['id' => $model->get('id')]); ?>" enctype="multipart/form-data">
	<input type="hidden" name="method" value="DELETE">
	<button class="btn btn-primary">Supprimer</button>
</form>
<?php endif; ?>