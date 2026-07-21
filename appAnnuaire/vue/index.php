<h1>Annuaire des URL</h1>
<ul>
<?php foreach ( $model as $item): ?>
    <li>
    	<a href="<?= $item["url"];?> " target="_blank">
    	<?= $item["nom"] ;?> 
    	</a>    	
    </li>
<?php endforeach;?>    
</ul>