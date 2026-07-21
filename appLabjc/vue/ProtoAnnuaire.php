<?php ?>

<h1>Annuaire des URL</h1>
<div>
	<h2><?php echo $model->getNonDossier();?></h2>
	
</div>
<div>
	<h2>Dossiers</h2>
		
	<a href="<?= $this->routeur->getRoute('index')->generateUri(['Dossier' => "Data" ]);?> ">
    	<img src="..\appAnnuaire\vue\resources\img\folder_Add.png" title="racine" alt="racine" >    			
    </a>