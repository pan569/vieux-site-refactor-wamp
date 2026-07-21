<?php 
use \systeme\vue\form;

$form = form::getInstance('form-control');

?>

    <h1>Ajout d'article </h1>    

<form method="post" action="<?=  $router->generateUri('blogAdmin.ajout'); ?>" enctype="multipart/form-data">
    <div class="form-group">
    
    <?= $form->ConstructeurChamp( "titre de l'article",'titre',$model->get('titre') !== null ? $model->get('titre') : "" ,'text');?>      
    <?= $form->ConstructeurChamp( "slug de l'article",'slug',$model->get('slug') !== null ? $model->get('slug') : "" ,'text');?>
    <?= $form->ConstructeurChamp( 'contenu','contenu', $model->get('contenu') !== null ? $model->get('contenu') : "" ,'textarea',[100,10]);?>
    
    <p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>
