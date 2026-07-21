<?php
$s=DIRECTORY_SEPARATOR;
$img = __DIR__."{$s}resources{$s}données{$s}img{$s}";
$imgB = __DIR__."{$s}resources{$s}données{$s}img{$s}ailleur{$s}";
$uploads = __DIR__."{$s}resources{$s}données{$s}uploads{$s}";

//data-value="<?php $file

?>
<script type="text/javascript">
	
	jQuery(function($){
		$('.dfA').dropfile({
			message : 'Déposer ici',
			  cible : "C:\wamp64\www\site01\appLabjc\vue\resources\données\img\\"
		});
	})
	
	jQuery(function($){
		$('.dfB').dropfile({
			message : 'Déposer la',
			  cible : "C:\wamp64\www\site01\appLabjc\vue\resources\données\img\ailleur\\"
		});
	})
	/**/	
</script>

<h1>telechargement avec dragdrop</h1>
<div class="block">
	<div class="title">Galerie d'image</div>
	<div class="dfA dropfile" >
		</div>
	<div class="content">
		<?php foreach (glob($img.'*') as $path):?>
			<?php $a = explode($s, $path) ?>
			<?php $file = end($a); ?>
		<div >
			<img src="<?= '\\appLabjc\\vue\\resources\\données\\img\\'.$file; ?>" alt="" height="150">
		</div>
		<?php endforeach;?>
		
	</div>

</div>

<div class="block">
	<div class="title">Galerie d'image</div>
	<div class="dfB dropfile" >
		</div>
	<div class="content">
		<?php foreach (glob($imgB.'*') as $path):?>
			<?php $a = explode($s, $path) ?>
			<?php $file = end($a); ?>
		<div >
			<img src="<?= '\\appLabjc\\vue\\resources\\données\\img\\ailleur\\'.$file; ?>" alt="" height="150">
		</div>
		<?php endforeach;?>
		
	</div>

</div>

<div class="block">
	<div class="title">Drop unique</div>
	<div class="content">
		<ul id="listContent">
		<?php foreach (glob($uploads.'*') as $path):?>
			<?php $a = explode($s, $path) ?>
			<?php $file = end($a); ?>		
			<li><?php echo end(explode('/',$file))?></li>
		<?php endforeach;?>
		</ul>
	</div>
</div>

