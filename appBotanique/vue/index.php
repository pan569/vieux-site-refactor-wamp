<h1>Botanique</h1>

<ul>
    <li><a href="<?= $this->routeur->getRoute('indexFamille')->generateUri() ;?>">Liste des familles</a></li>
    <li><a href="<?= $this->routeur->getRoute('indexGenre')->generateUri() ;?>">Liste des genres</a></li>
    <li><a href="<?= $this->routeur->getRoute('indexEspece')->generateUri() ;?>">Liste des especes</a></li>
    <li><a href="<?= $this->routeur->getRoute('indexPlante')->generateUri() ;?>">Liste des Plantes</a></li>
</ul>


