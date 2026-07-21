<?php

//debug($model);

if($model['image'] !== null)
{
    $img="data:image/jpg;base64,".base64_encode($model['image']);
}
else
{
    $img="appBlog/vue/resource/img/article.jpg";
}

?>

<article class="article">
	<a href="<?= $this->routeur->getRoute('montrer')->generateUri(['id' => $model['id']]);?>" class="article-img"><img src="<?= $img; ?>" alt=""></a>
	<div class="article-date"><?= $model['titre'] ;?></div>
	<h2 class="article-title"><a href="article.html"><?= $model['titre'] ;?></a></h2>
	<p><?= $model['contenu'] ;?></p>
</article>