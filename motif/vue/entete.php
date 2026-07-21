<?php
use systeme\vue\form;
$form = form::getInstance('form-control');
?>
<h1>Entete</h1>
<h2>Modification des données de Entete</h2>    
<form method="post" action="<?=  $this->routeur->getRoute('modifEntete')->generateUri(); ?>" enctype="multipart/form-data">
    <div class="form-group">
    <?= $this->champCsrf(); ?>
    <div>
    <h3>le site</h3>
    <?= $form->ConstructeurChamp( "Nom de l'auteur",'auteur', $model['Entete']['auteur'] !== null ? $model['Entete']['auteur'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Description",'description', $model['Entete']['description'] !== null ? $model['Entete']['description'] : "",'textarea',[50,5]);?>
    <?= $form->ConstructeurChamp( "Mots clées",'motsCles', $model['Entete']['motsCles'] !== null ? $model['Entete']['motsCles'] : "",'textarea',[50,5]);?>
    <?= $form->ConstructeurChamp( "Editeur",'editeur', $model['Entete']['editeur'] !== null ? $model['Entete']['editeur'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Titre",'titre', $model['Entete']['titre'] !== null ? $model['Entete']['titre'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Icone",'image', $model['Entete']['image'] !== null ? $model['Entete']['image'] : "",'text');?>
    </div>    
    <?= $form->ConstructeurChamp('','form', 'true' , 'hidden') ?>
    <p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>
