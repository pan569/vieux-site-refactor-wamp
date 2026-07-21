<?php 

use systeme\vue\form;

$form = form::getInstance('form-control');

if($nomDeVue == "editerPlante")
{
    $action = $this->routeur->getRoute($nomDeVue)->generateUri(['id' => $model->get('id')]);
    $titre = "Edition de la plante " . e($model->get('LATIN'));
}
else
{
    $action = $this->routeur->getRoute($nomDeVue)->generateUri();    
    $titre ="Ajouter une plante";
}

?>

<h1><?= e($titre); ?></h1>

<a class="btn btn-primary" href="<?=  $this->routeur->getRoute('indexPlante')->generateUri(); ?>">Retour a la liste des plantes</a>
    
<form method="post" action="<?= $action; ?>" enctype="multipart/form-data">
    <div class="form-group">
    <?= $this->champCsrf(); ?>

	<?= $form->ConstructeurChamp("Espece", "ID_ESPECE", $model->get('ID_ESPECE') !== null ? $model->get('ID_ESPECE') : 0 ,"select",$listeEspece) ?>                                           
    <?= $form->ConstructeurChamp( "Varieté",'VARIETEE', $model->get('VARIETEE') !== null ? $model->get('VARIETEE') : "",'text');?>    
    <?= $form->ConstructeurChamp( "Synonymes",'SYNONYME', $model->get('SYNONYME') !== null ? $model->get('SYNONYME') : "",'textarea',[50,5]);?>      
    <?= $form->ConstructeurChamp( "Type de sesexualité",'SEXUALITE', $model->get('SEXUALITE') !== null ? $model->get('SEXUALITE') : "",'selectDur',$model::_SEXUALITE);?>        
    
    <?= $form->ConstructeurChamp( "Periode de fleuraison",'FLEURESON', $model->get('FLEURESON') !== null ? $model->get('FLEURESON') : "",'checkboxList',$model::_PERIODE); ?>
    
    <?= $form->ConstructeurChamp( "Periode de fructification",'FRUCTIFICATION', $model->get('FRUCTIFICATION') !== null ? $model->get('FRUCTIFICATION') : "",'checkboxList',$model::_PERIODE); ?>
    
    <?= $form->ConstructeurChamp( "Hauteur minimal",'HAUTEUR_MIN', $model->get('HAUTEUR_MIN') !== null ? $model->get('HAUTEUR_MIN') : "",'text');?>
    <?= $form->ConstructeurChamp( "Hauteur maximal",'HAUTEUR_MAX', $model->get('HAUTEUR_MAX') !== null ? $model->get('HAUTEUR_MAX') : "",'text');?>
    <?= $form->ConstructeurChamp( "Largeur",'LARGEUR', $model->get('LARGEUR') !== null ? $model->get('LARGEUR') : "",'text');?>
    <?= $form->ConstructeurChamp( "Coissance",'CROISSANCE', $model->get('CROISSANCE') !== null ? $model->get('CROISSANCE') : "",'text');?>
    <?= $form->ConstructeurChamp( "Durée de vie",'DUREE_DE_VIE', $model->get('DUREE_DE_VIE') !== null ? $model->get('DUREE_DE_VIE') : "",'text');?>
    <?= $form->ConstructeurChamp( "Cycle de vie",'CYCLE_DE_VIE', $model->get('CYCLE_DE_VIE') !== null ? $model->get('CYCLE_DE_VIE') : "",'selectDur',$model::_CYCLE_DE_VIE);?>
    <?= $form->ConstructeurChamp( "Rusticité",'RUCTICITE', $model->get('RUCTICITE') !== null ? $model->get('RUCTICITE') : "",'text');?>
    <?= $form->ConstructeurChamp( "Exposition",'EXPOSITION', $model->get('EXPOSITION') !== null ? $model->get('EXPOSITION') : "",'selectMultiple',$model::_EXPOSITION);?>
    <?= $form->ConstructeurChamp( "Aeration",'AERATION', $model->get('AERATION') !== null ? $model->get('AERATION') : "",'selectMultiple',$model::_AERATION);?>     
    <?= $form->ConstructeurChamp( "PH",'PH[]', $model->get('PH') !== null ? $model->get('PH') : "",'selectMultiple',$model::_PH);?>
    <?= $form->ConstructeurChamp( "Richesse",'RICHESSE', $model->get('RICHESSE') !== null ? $model->get('RICHESSE') : "",'selectMultiple',$model::_RICHESSE);?>
    <?= $form->ConstructeurChamp( "Humidité",'HUMIDITE', $model->get('HUMIDITE') !== null ? $model->get('HUMIDITE') : "",'text');?>
    
    <?= $form->ConstructeurChamp( "Type de multiplication",'MULTIPLICATION', $model->get('MULTIPLICATION') !== null ? $model->get('MULTIPLICATION') : "",'checkboxList',$model::_MULTIPLICATION); ?>
    
    <?= $form->ConstructeurChamp( "Periode de semis en interieur",'SEMIS_INTERIEUR', $model->get('SEMIS_INTERIEUR') !== null ? $model->get('SEMIS_INTERIEUR') : "",'checkboxList',$model::_PERIODE); ?>
    
    <?= $form->ConstructeurChamp( "Periode de semis en exterieur",'SEMIS_EXTERIEUR', $model->get('SEMIS_EXTERIEUR') !== null ? $model->get('SEMIS_EXTERIEUR') : "",'checkboxList',$model::_PERIODE); ?>
    
    <?= $form->ConstructeurChamp( "Periode de plantation",'PLANTATION', $model->get('PLANTATION') !== null ? $model->get('PLANTATION') : "",'checkboxList',$model::_PERIODE); ?>
    
    <?= $form->ConstructeurChamp( "Types de greffe",'GREFFE', $model->get('GREFFE') !== null ? $model->get('GREFFE') : "",'text');?>    
    <?= $form->ConstructeurChamp( "Strate forestiere",'STRATE', $model->get('STRATE') !== null ? $model->get('STRATE') : "",'selectDur',$model::_STRATE);?>
    
    <?= $form->ConstructeurChamp( "Sensible a",'SENSIBILITE', $model->get('SENSIBILITE') !== null ? $model->get('SENSIBILITE') : "",'checkboxList',$model::_SENSIBILITE); ?>
    
    <?= $form->ConstructeurChamp( "Etiquette perso",'LIBELLE', $model->get('LIBELLE') !== null ? $model->get('LIBELLE') : "",'selectDur',$model::_LIBELLE);?>
    
    <h2>Intérêts</h2>
    <?= $form->ConstructeurChamp( "Intérêts Culinaires",'COMESTIBLE',$interetPlante->get('COMESTIBLE') !== null ? $interetPlante->get('COMESTIBLE') : "",'textarea',[50,5]);?>
    <?= $form->ConstructeurChamp( "Partie comestible",'P_COMESTIBLE',$interetPlante->get('P_COMESTIBLE') !== null ? $interetPlante->get('P_COMESTIBLE') : "",'checkboxList',$model::_PARTIE_PLANTE); ?>
    
    <?= $form->ConstructeurChamp( "Intérêts médicinaux",'MEDICINAL',$interetPlante->get('MEDICINAL') !== null ? $interetPlante->get('MEDICINAL') : "",'textarea',[50,5]);?>
    <?= $form->ConstructeurChamp( "Partie médicinal",'P_MEDICINAL',$interetPlante->get('P_MEDICINAL') !== null ? $interetPlante->get('P_MEDICINAL') : "",'checkboxList',$model::_PARTIE_PLANTE); ?>
    
    <?= $form->ConstructeurChamp( "Intérêts Environemental",'ENVIRONNEMENTAL',$interetPlante->get('ENVIRONNEMENTAL') !== null ? $interetPlante->get('ENVIRONNEMENTAL') : "",'textarea',[50,5]);?>
    <?= $form->ConstructeurChamp( "Partie environemental",'P_ENVIRONNEMENTAL',$interetPlante->get('P_ENVIRONNEMENTAL') !== null ? $interetPlante->get('P_ENVIRONNEMENTAL') : "",'checkboxList',$model::_PARTIE_PLANTE); ?>
    
    <?= $form->ConstructeurChamp( "Toxicité",'TOXICITE', $interetPlante->get('TOXICITE') !== null ? $interetPlante->get('TOXICITE') : "",'textarea',[50,5]);?>
    <?= $form->ConstructeurChamp( "Partie toxique",'P_TOXICITE',$interetPlante->get('P_TOXICITE') !== null ? $interetPlante->get('P_TOXICITE') : "",'checkboxList',$model::_PARTIE_PLANTE); ?>
    
	<?= $form->ConstructeurChamp( "AUTRE",'AUTRE',$interetPlante->get('AUTRE') !== null ? $interetPlante->get('AUTRE') : "",'textarea',[50,5]);?>
        
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

<?php if ($nomDeVue == "editerPlante"): ?>
<form style="display: inline;" method="post" action="<?=  $this->routeur->getRoute('supprimerPlante')->generateUri(['id' => $model->get('id')]); ?>" enctype="multipart/form-data">
    <?= $this->champCsrf(); ?>
	<input type="hidden" name="method" value="DELETE">
	<button class="btn btn-primary">Supprimer</button>
</form>
<?php endif; ?>
