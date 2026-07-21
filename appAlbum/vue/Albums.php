<?php
?>
<h1>ALBUMS</h1>
<div >

<div style="display: inline;">
		<a href="<?= $this->routeur->getRoute('listerAlbums')->generateUri();?> "> 
			<div><img src="/appAlbum/vue/resources/img/09care.png" alt="Creer un album" height="150" /></div>
			<div>Creer un album</div> 
		</a>    	
	</div>

<?php foreach ( $model as $item): ?>
	<div style="display: inline;">
		<a href="<?= $this->routeur->getRoute('visualiserAlbum')->generateUri(['nomAlbum' => $item ]);?> "> 
			<div><img src="/appAlbum/vue/resources/img/09care.png" alt="<?=$item ?>" height="150" /></div>
			<div><?=$item ?></div> 
		</a>    	
	</div>
<?php endforeach;?>    
</div>


