
<?php 
//debug($model,"especeParFamille.php:model");
?>
<ul>
<?php foreach ( $model as $famille): ?>
    <li>
    	<?= "[".$famille['id']."] ".$famille['LATIN']  ;?>
    	<ul>
    		<?php foreach ( $famille['GENRE'] as $genres): ?>
    		<li>
    			<?= "[".$genres['id']."] ".$genres['LATIN']  ;?>
    			<ul>
    				<?php foreach ( $genres['ESPECE'] as $especes): ?>
    				<li>
    					<?= $genres['LATIN']." ".$especes['LATIN']." => ".$especes['FRANCAIS']  ;?>
    				</li>
    				<?php endforeach;?>
    			</ul>    		
    		</li>
    	<?php endforeach;?>
    	</ul>    	
    </li>
<?php endforeach;?>    
</ul>