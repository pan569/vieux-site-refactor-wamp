<?php
?>
<h1>Parametres du site</h1>
<div>
	<h2>Données de configuration <a href="<?= $this->routeur->getRoute('modifConfiguration')->generateUri() ;?>">Modifier</a></h2>
		<div>
			<h3>le site</h3>
				<p>Nom du site: <?= $model['Configuration']['SiteNom'];?></p>
				<p>Descriptif: <?= $model['Configuration']['SiteDescriptif'];?></p>
				<p>dossier des themes: <?= $model['Configuration']['SiteThemeDossier'];?></p>
				<p>Theme courant: <?= $model['Configuration']['SiteThemeNom'];?></p>
				<p>Dossier des fichier JS: <?= $model['Configuration']['SiteJavaScriptDossier'];?></p>
				<p>Copyright: <?= $model['Configuration']['SiteCopyright'];?></p>    	
		</div>
		<div>
    		<h3>Base de données</h3>
    			<p>Nom du serveur: <?= $model['Configuration']['DataBaseServeur'];?></p>
    			<p>	Nom utilisateur: <?= $model['Configuration']['DataBaseUtilisateur'];?></p>
    			<p>Mot de passe utilisateur: <?= $model['Configuration']['DataBaseMdP'];?></p>
    			<p>Nom de la base: <?= $model['Configuration']['DataBaseNon'];?></p>
		</div>
		<div>
		<h2>Credit <a href="<?= $this->routeur->getRoute('modifCredit')->generateUri() ;?>">Modifier</a></h2>
		<div>
	    	<h3>Proprietaire du site</h3>
    			<p>nom: <?= $model['Proprietaire']['nom'];?></p>
    			<p>adresse postal: <?= $model['Proprietaire']['adresse'];?></p>
    			<p>telephone: <?= $model['Proprietaire']['telephone'];?></p>
    			<p>couriel: <?= $model['Proprietaire']['email'];?></p>
    			<p>site: <?= $model['Proprietaire']['www'];?></p>    		
		</div>
		<div>
	    	<h3>Developpeur du site</h3>
    			<p>nom: <?= $model['Developpeur']['nom'];?></p>
    			<p>adresse postal: <?= $model['Developpeur']['adresse'];?></p>
    			<p>telephone: <?= $model['Developpeur']['telephone'];?></p>
    			<p>couriel: <?= $model['Developpeur']['email'];?></p>
    			<p>site: <?= $model['Developpeur']['www'];?></p>    		
		</div>
		<div>
	    	<h3>Hebergeur du site</h3>
    			<p>nom: <?= $model['Hebergeur']['nom'];?></p>
    			<p>adresse postal: <?= $model['Hebergeur']['adresse'];?></p>
    			<p>telephone: <?= $model['Hebergeur']['telephone'];?></p>
    			<p>couriel: <?= $model['Hebergeur']['email'];?></p>
    			<p>site: <?= $model['Hebergeur']['www'];?></p>    		
		</div>
		<h2>Parametres de l'entete <a href="<?= $this->routeur->getRoute('modifEntete')->generateUri() ;?>">Modifier</a></h2>
		<div>
			<h3>Entete</h3>
				<p>auteur: <?= $model['Entete']['auteur'];?></p>
				<p>description: <?= $model['Entete']['description'];?></p>
				<p>motsCles: <?= $model['Entete']['motsCles'];?></p>
				<p>editeur: <?= $model['Entete']['editeur'];?></p>
				<p>titre: <?= $model['Entete']['titre'];?></p>
				<p>image: <?= $model['Entete']['image'];?></p>    	
		</div>	
		<h2>Parametres du menu </h2>
		<div>
			<h3>menu</h3>
				<ul>
				<?php foreach ( $model['Menus'] as $item): ?>
    				<li>
    					<?= $item['titre']  ;?>
    					<p><?= $item['description']  ;?></p>
    					<p>url:<?= $item['url'];?>() (<?= $item['cible'];?>)</p>
    					<p>fichier css: <?= $item['css'];?></p>    					
    					<p><?= $item['image'];?></p>    					
    					<a href="<?= $this->routeur->getRoute('modifMenu')->generateUri(['menu' => $item['titre']]);?> ">Modifier</a>
    				</li>
				<?php endforeach;?>    
				</ul>
				<div>
					<?= $model->nav()  ;?>
				</div>    	
		</div>
		<div>
			<h3>menu pied de page</h3>
				<ul>
				<?php foreach ( $model['Pied'] as $item): ?>
    				<li>
    					<?= $item['titre']  ;?>
    					<p><?= $item['description']  ;?></p>
    					<p>url:<?= $item['url'];?>() (<?= $item['cible'];?>)</p>
    					<p>fichier css: <?= $item['css'];?></p>    					
    					<p><?= $item['image'];?></p>    					
    					<a href="<?= $this->routeur->getRoute('modifPied')->generateUri(['menu' => $item['titre']]);?> ">Modifier</a>
    				</li>
				<?php endforeach;?>    
				</ul>
				<div>
					<?= $model->navpied()  ;?>
				</div>    	
		</div>
		
</div>