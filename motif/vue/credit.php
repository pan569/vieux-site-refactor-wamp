<?php
use systeme\vue\form;
$form = form::getInstance('form-control');
?>
<h1>Parametres du site</h1>
<h2>Modification des données de configuration</h2>    
<form method="post" action="<?=  $this->routeur->getRoute('modifCredit')->generateUri(); ?>" enctype="multipart/form-data">
    <div class="form-group">
    <div>
    <h3>Proprietaire du site</h3>
    <?= $form->ConstructeurChamp( "Nom",'Proprietaire_nom', $model['Proprietaire']['nom'] !== null ? $model['Proprietaire']['nom'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Adresse",'Proprietaire_adresse', $model['Proprietaire']['adresse'] !== null ? $model['Proprietaire']['adresse'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Telephone",'Proprietaire_telephone', $model['Proprietaire']['telephone'] !== null ? $model['Proprietaire']['telephone'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Couriel",'Proprietaire_email', $model['Proprietaire']['email'] !== null ? $model['Proprietaire']['email'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Site",'Proprietaire_www', $model['Proprietaire']['www'] !== null ? $model['Proprietaire']['www'] : "",'text');?>
    </div>
    <div>
    <h3>Developpeur du site</h3>
    <?= $form->ConstructeurChamp( "Nom",'Developpeur_nom', $model['Developpeur']['nom'] !== null ? $model['Developpeur']['nom'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Adresse",'Developpeur_adresse', $model['Developpeur']['adresse'] !== null ? $model['Developpeur']['adresse'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Telephone",'Developpeur_telephone', $model['Developpeur']['telephone'] !== null ? $model['Developpeur']['telephone'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Couriel",'Developpeur_email', $model['Developpeur']['email'] !== null ? $model['Developpeur']['email'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Site",'Developpeur_www', $model['Developpeur']['www'] !== null ? $model['Developpeur']['www'] : "",'text');?>
    </div>
    <h3>Proprietaire du site</h3>
    <?= $form->ConstructeurChamp( "Nom",'Hebergeur_nom', $model['Hebergeur']['nom'] !== null ? $model['Hebergeur']['nom'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Adresse",'Hebergeur_adresse', $model['Hebergeur']['adresse'] !== null ? $model['Hebergeur']['adresse'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Telephone",'Hebergeur_telephone', $model['Hebergeur']['telephone'] !== null ? $model['Hebergeur']['telephone'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Couriel",'Hebergeur_email', $model['Hebergeur']['email'] !== null ? $model['Hebergeur']['email'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Site",'Hebergeur_www', $model['Hebergeur']['www'] !== null ? $model['Hebergeur']['www'] : "",'text');?>
    </div>    
    <?= $form->ConstructeurChamp('','form', 'true' , 'hidden') ?>
    <p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>