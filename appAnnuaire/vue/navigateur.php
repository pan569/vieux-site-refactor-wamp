<?php

//debug($model->getListeDossiers() ,"model->getListeDossiers() navigateur.php ligne 3");
//debug($model->getNonDossier(),"model_NomDossier navigateur.php ligne 4");
//debug($model->getRacine(),"modelRacine navigateur.php ligne 5");

$GR=explode (DIRECTORY_SEPARATOR,$model->getRacine());
//debug($GR,"GR navigateur.php ligne 8");

while($GR[0] != "data")
{
    array_shift($GR);
}
//debug($GR,"GR navigateur.php ligne 14");

$key = array_search($model->getNonDossier(), $GR);
//debug($key,"key navigateur.php ligne 15");

if($GR[$key] != "data")
{
    $D = $GR[$key]."-";
}
else
{
    $D ="";
}
//debug($D,"D navigateur.php ligne 22");

?>
<h1>Annuaire des URL</h1>
<div>
	<h2><?php echo $model->getNonDossier();?></h2>
	
</div>
<div>
	<h2>Dossiers</h2>
		
			<a href="<?= $this->routeur->getRoute('index')->generateUri(['Dossier' => "Data" ]);?> ">
    			<img src="..\appAnnuaire\vue\resources\img\folder_Add.png" title="racine" alt="racine" >    			
    		</a>
				
	<div>
		<div>
			<a href="<?= $this->routeur->getRoute('index')->generateUri(['Dossier' => $GR[$key-1] ]);?> ">
    			<img src="..\appAnnuaire\vue\resources\img\Folder_arr.png" title="racine" alt="racine" >    			
    		</a>
		</div>
	
	<?php foreach ($model->getListeDossiers() as $item): ?>
		<div>
			<a href="<?= $this->routeur->getRoute('index')->generateUri(['Dossier' => $D.$item ]);?> ">
				<img src="..\appAnnuaire\vue\resources\img\Folder.png" title="<?= $item ;?>" alt="<?= $item ;?>" >
				<?= $item ;?> 
			</a>
    	</div>
    <?php endforeach;?>		
	</div>
</div>
<div>
	<h2>fichiers</h2>
		<a href="<?= $this->routeur->getRoute('index')->generateUri(['Dossier' => "Data" ]);?> ">
			<img src="..\appAnnuaire\vue\resources\img\Add.png" title="racine" alt="racine" height="22" width="22" >    			
		</a>
	<div>
	<?php foreach ($model->getListURL() as $item): ?>
		<div>
			<a href="<?= $item["url"];?> " target="_blank">
    			<?= $item["nom"] ;?> 
    		</a>
    		<a href="<?= $this->routeur->getRoute('index')->generateUri(['Dossier' => "Data" ]);?> ">
				<img src="..\appAnnuaire\vue\resources\img\Sous.png" title="racine" alt="racine" height="22" width="22" >    			
			</a>
			<a href="<?= $this->routeur->getRoute('index')->generateUri(['Dossier' => "Data" ]);?> ">
				<img src="..\appAnnuaire\vue\resources\img\Arrows.png" title="racine" alt="racine" height="22" width="22" >    			
			</a>
    	</div>
    <?php endforeach;?>
</div>