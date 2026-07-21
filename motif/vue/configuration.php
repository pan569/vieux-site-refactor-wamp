<?php
use systeme\vue\form;
$form = form::getInstance('form-control');
?>
<h1>Parametres du site</h1>
<h2>Modification des données de configuration</h2>    
<form method="post" action="<?=  $this->routeur->getRoute('modifConfiguration')->generateUri(); ?>" enctype="multipart/form-data">
    <div class="form-group">
    <div>
    <h3>le site</h3>
    <?= $form->ConstructeurChamp( "Nom du site",'SiteNom', $model['Configuration']['SiteNom'] !== null ? $model['Configuration']['SiteNom'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Descriptif",'SiteDescriptif', $model['Configuration']['SiteDescriptif'] !== null ? $model['Configuration']['SiteDescriptif'] : "",'text');?>
    <?= $form->ConstructeurChamp( "dossier des themes",'SiteThemeDossier', $model['Configuration']['SiteThemeDossier'] !== null ? $model['Configuration']['SiteThemeDossier'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Theme courant",'SiteThemeNom', $model['Configuration']['SiteThemeNom'] !== null ? $model['Configuration']['SiteThemeNom'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Dossier des fichier JS",'SiteJavaScriptDossier', $model['Configuration']['SiteJavaScriptDossier'] !== null ? $model['Configuration']['SiteJavaScriptDossier'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Copyright",'SiteCopyright', $model['Configuration']['SiteCopyright'] !== null ? $model['Configuration']['SiteCopyright'] : "",'text');?>
    </div>
    <div>
    <h3>Base de données</h3>    
    <?= $form->ConstructeurChamp( "Nom du serveur",'DataBaseServeur', $model['Configuration']['DataBaseServeur'] !== null ? $model['Configuration']['DataBaseServeur'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Nom utilisateur",'DataBaseUtilisateur', $model['Configuration']['DataBaseUtilisateur'] !== null ? $model['Configuration']['DataBaseUtilisateur'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Mot de passe utilisateur",'DataBaseMdP', $model['Configuration']['DataBaseMdP'] !== null ? $model['Configuration']['DataBaseMdP'] : "",'text');?>
    <?= $form->ConstructeurChamp( "Nom de la base",'DataBaseNon', $model['Configuration']['DataBaseNon'] !== null ? $model['Configuration']['DataBaseNon'] : "",'text');?>          
    </div>    
    <?= $form->ConstructeurChamp('','form', 'true' , 'hidden') ?>
    <p><button class="btn btn-primary">Valider</button></p>
    </div>
</form>