<?php 

$model = $model;

?>
<section>
<div>
	<h2><?= $model['NOM'] ." '". $model['VARIETEE']."' - ". $model->getGenre()['LATIN'] ." ". $model->getEspece()['LATIN'] ?></h2> 

	<ul>	
		<li>Ajouter photos General racine ecorse branche  feulle fleurs fruits</li>
	</ul>

	<p id="description"><?= $model['DESCRIPTION']; ?></p>
</div>

<div id="imagePlante">
	<div id="imagePlanteENSEMBLE">
		<img src="data:image/png;base64,<?= base64_encode($model['ENSEMBLE']); ?>" alt="Vue d'ensemble" />
	</div>
	<div id="imagePlanteFEUILLE">
		<img src="data:image/png;base64,<?= base64_encode($model['FEUILLE']); ?>" alt="La feuille" />
	</div>
	<div id="imagePlanteFRUIT">
		<img src="data:image/png;base64,<?= base64_encode($model['FRUIT']); ?>" alt="Le fruit" />
	</div>
	<div id="imagePlanteTIGE">
		<img src="data:image/png;base64,<?= base64_encode($model['TIGE']); ?>" alt="La tige" />
	</div>
	<div id="imagePlanteRACINE">
		<img src="data:image/png;base64,<?= base64_encode($model['RACINE']); ?>" alt="La racine" />
	</div>
	<div id="imagePlanteECORSE">
		<img src="data:image/png;base64,<?= base64_encode($model['ECORSE']); ?>" alt="l'ecorse" />
	</div>
</div>

<div id="ficheTechnique"> 
	<h3>Fiche technique</h3>

	<div id="identification">
		<P><i><b>Famille :</b> <?= $model->getFamille()['FRANCAIS']; ?></i></P>
		<P><i><b>Synonymes :</b> <?= $model->separateur ('SYNONYME'); ?></i></P>
		<P><i><b>type de reproduction :</b> <?= $model['SEXUALITE']; ?></i></P>
		<P><i><b>Periode de fleureson :</b> <?= $model->separateur ('FLEURESON'); ?></i></P>
		<P><i><b>Periode de fructification :</b> <?= $model['FRUCTIFICATION']; ?></i></P>
		<P><i><b>Hauteur :</b> Entre <?= $model['HAUTEUR_MIN']; ?> et <?= $model['HAUTEUR_MAX']; ?> cm</i></P>
		<P><i><b>Largeur moyenne :</b> <?= $model['LARGEUR']; ?> cm</i></P>
		<P><i><b>Croissance :</b> <?= $model['CROISSANCE']; ?> cm par an</i></P>
		<P><i><b>Durée de vie :</b> <?= $model['DUREE_DE_VIE']; ?> ans</i></P>
		<P><i><b>Cycle de vie :</b> <?= $model['CYCLE_DE_VIE']; ?></i></P>
		<P><i><b>Rusticité :</b> <?= $model['RUCTICITE']; ?></i></P>
		<P><i><b>Strate :</b> <?= $model['STRATE']; ?></i></P>
	</div>

	<div id="Milieux">
		<P><i><b>Exposition par raport au soleil :</b> <?= $model['EXPOSITION']; ?></i></P>
		<P><i><b>aération du sol :</b> <?= $model['AERATION']; ?></i></P>
		<P><i><b>Richesse du sol :</b> <?= $model['RICHESSE']; ?></i></P>
		<P><i><b>PH du sol :</b> <?= $model->separateur ('PH'); ?></i></P>		
		<P><i><b>Humidité du sol:</b> <?= $model['HUMIDITE'];?> %</i></P>
	</div>

	<div id="reproduction">
		<P><i><b>Type de multiplication:</b> <?= $model['MULTIPLICATION']; ?></i></P>
		<P><i><b>Periode te plantation/repicage :</b> <?= $model->separateur ('PLANTATION'); ?></i></P>
		<P><i><b>Periode de semis en interieur :</b> <?= $model->separateur ('SEMIS_INTERIEUR'); ?></i></P>
		<P><i><b>Periode de semis a l'exterieur :</b> <?= $model->separateur ('SEMIS_EXTERIEUR'); ?></i></P>
		<P><i><b>Type de greffe :</b> <?= $model['GREFFE']; ?></i></P>
	</div>
	
	<div id="nonClassé">
		<P><i><b>Sensible aux maladie nuisible :</b> <?= $model->separateur ('SENSIBILITE'); ?></i></P>
		<P><i><b>Utilité :</b> <?= $model['UTILITAIRE']; ?></i></P>
	</div>	
	
	

</div>
</section>
