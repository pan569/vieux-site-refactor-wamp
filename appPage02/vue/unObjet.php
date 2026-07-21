<?php foreach ( $model as $item): ?>
		<article class="article">
			<a href="article.html" class="article-img"><img src="<?= $item['image'];?>" alt=""></a>
			<div class="article-date">Publié le <?= $item['dateCreation'];?></div>
			<h2 class="article-title"><a href="article.html"><?= $item['titre'];?></a></h2>
			<p><?= $item['contenu'];?></p>
		</article>
<?php endforeach;?>