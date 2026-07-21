<h1><?= $model->getGenre(); ?> <?= $model['LATIN']; ?> </h1>
<p><?= $model['FRANCAIS']; ?> (<?= $model['id']; ?>)</p>
<img src="data:image/png;base64,<?= base64_encode($model['ENSEMBLE']); ?>" alt="Red dot" />

