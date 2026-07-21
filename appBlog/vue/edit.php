<?php
use \systeme\vue\form;

$form = form::getInstance('form-control');

if($model->get('id') === null)
{
    $T="Ajout d'article";
    $action="ajouter";
}
else 
{
    $T= "Modifier l'article " . e($model['titre']) . ".";
    $action="editer";
}

?>

    <h1><?= e($T) ;?></h1>    

<form method="post" action="<?=  $this->routeur->getRoute($action)->generateUri(['id' => $model['id']]); ?>" enctype="multipart/form-data">
    <div class="form-group">
    <?= $this->champCsrf(); ?>
    <?= $form->ConstructeurChamp( "titre de l'article",'titre',$model->get('titre') !== null ? $model->get('titre') : "" ,'text');?>      
    <?= $form->ConstructeurChamp( "slug de l'article",'slug',$model->get('slug') !== null ? $model->get('slug') : "" ,'text');?>
    <?= $form->ConstructeurChamp( 'contenu','contenu', $model->get('contenu') !== null ? $model->get('contenu') : "" ,'textarea',[100,10]);?>
    
    <p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>

<?php if ($model->get('id') !== null): ?>
<form style="display: inline;" method="post" action="<?=  $this->routeur->getRoute('supprimer')->generateUri(['id' => $model->get('id')]); ?>" enctype="multipart/form-data">
    <?= $this->champCsrf(); ?>
	<input type="hidden" name="method" value="DELETE">
    <button class="btn btn-primary">Supprimer</button>
</form>
<?php endif; ?>
