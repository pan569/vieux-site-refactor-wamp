<?php
/**
 * Interface d'administration Motif avec système d'onglets.
 * Approche B : CSS + JS léger.
 *
 * Onglets : apercu | configuration | credits | entete | menus | pied
 */
$onglet = $onglet ?? 'apercu';

// URLs des formulaires d'édition
$urlConfig  = $this->routeur->getRoute('modifConfiguration')->generateUri();
$urlCredit  = $this->routeur->getRoute('modifCredit')->generateUri();
$urlEntete  = $this->routeur->getRoute('modifEntete')->generateUri();
?>

<div class="admin-motif">
    <h1>Paramètres du site</h1>

    <!-- Barre d'onglets -->
    <nav class="tabs" role="tablist" aria-label="Sections d'administration">
        <button type="button" class="tab-btn<?= $onglet === 'apercu' ? ' active' : '' ?>" data-tab="apercu" role="tab" aria-selected="<?= $onglet === 'apercu' ? 'true' : 'false' ?>">Vue d'ensemble</button>
        <button type="button" class="tab-btn<?= $onglet === 'configuration' ? ' active' : '' ?>" data-tab="configuration" role="tab" aria-selected="<?= $onglet === 'configuration' ? 'true' : 'false' ?>">Configuration</button>
        <button type="button" class="tab-btn<?= $onglet === 'credits' ? ' active' : '' ?>" data-tab="credits" role="tab" aria-selected="<?= $onglet === 'credits' ? 'true' : 'false' ?>">Crédits</button>
        <button type="button" class="tab-btn<?= $onglet === 'entete' ? ' active' : '' ?>" data-tab="entete" role="tab" aria-selected="<?= $onglet === 'entete' ? 'true' : 'false' ?>">En-tête</button>
        <button type="button" class="tab-btn<?= $onglet === 'menus' ? ' active' : '' ?>" data-tab="menus" role="tab" aria-selected="<?= $onglet === 'menus' ? 'true' : 'false' ?>">Menus</button>
        <button type="button" class="tab-btn<?= $onglet === 'pied' ? ' active' : '' ?>" data-tab="pied" role="tab" aria-selected="<?= $onglet === 'pied' ? 'true' : 'false' ?>">Pied de page</button>
    </nav>

    <!-- ========== ONGLET : Vue d'ensemble ========== -->
    <div class="tab-panel<?= $onglet === 'apercu' ? ' active' : '' ?>" id="panel-apercu" role="tabpanel">
        <div class="card">
            <h2>Configuration <a class="btn btn-secondaire" href="<?= $urlConfig ?>" style="font-size:0.8rem;padding:0.3rem 0.7rem;">Modifier</a></h2>
            <div class="grid-2">
                <div>
                    <h3>Le site</h3>
                    <p><strong>Nom :</strong> <?= e($model['Configuration']['SiteNom'] ?? '') ?></p>
                    <p><strong>Descriptif :</strong> <?= e($model['Configuration']['SiteDescriptif'] ?? '') ?></p>
                    <p><strong>Thème :</strong> <?= e($model['Configuration']['SiteThemeNom'] ?? '') ?></p>
                    <p><strong>Dossier thèmes :</strong> <?= e($model['Configuration']['SiteThemeDossier'] ?? '') ?></p>
                    <p><strong>Copyright :</strong> <?= e($model['Configuration']['SiteCopyright'] ?? '') ?></p>
                </div>
                <div>
                    <h3>Base de données</h3>
                    <p><strong>Serveur :</strong> <?= e($model['Configuration']['DataBaseServeur'] ?? '') ?></p>
                    <p><strong>Utilisateur :</strong> <?= e($model['Configuration']['DataBaseUtilisateur'] ?? '') ?></p>
                    <p><strong>Base :</strong> <?= e($model['Configuration']['DataBaseNon'] ?? '') ?></p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Crédits <a class="btn btn-secondaire" href="<?= $urlCredit ?>" style="font-size:0.8rem;padding:0.3rem 0.7rem;">Modifier</a></h2>
            <div class="grid-3">
                <div>
                    <h3>Propriétaire</h3>
                    <p><?= e($model['Proprietaire']['nom'] ?? '') ?></p>
                    <p class="text-muted"><?= e($model['Proprietaire']['email'] ?? '') ?></p>
                </div>
                <div>
                    <h3>Développeur</h3>
                    <p><?= e($model['Developpeur']['nom'] ?? '') ?></p>
                    <p class="text-muted"><?= e($model['Developpeur']['email'] ?? '') ?></p>
                </div>
                <div>
                    <h3>Hébergeur</h3>
                    <p><?= e($model['Hebergeur']['nom'] ?? '') ?></p>
                    <p class="text-muted"><?= e($model['Hebergeur']['email'] ?? '') ?></p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>En-tête <a class="btn btn-secondaire" href="<?= $urlEntete ?>" style="font-size:0.8rem;padding:0.3rem 0.7rem;">Modifier</a></h2>
            <p><strong>Titre :</strong> <?= e($model['Entete']['titre'] ?? '') ?></p>
            <p><strong>Auteur :</strong> <?= e($model['Entete']['auteur'] ?? '') ?></p>
            <p><strong>Description :</strong> <?= e($model['Entete']['description'] ?? '') ?></p>
        </div>
    </div>

    <!-- ========== ONGLET : Configuration ========== -->
    <div class="tab-panel<?= $onglet === 'configuration' ? ' active' : '' ?>" id="panel-configuration" role="tabpanel">
        <div class="card">
            <h2>Configuration</h2>
            <p class="text-muted">Modifiez les paramètres généraux du site et de la base de données.</p>
            <p><a class="btn" href="<?= $urlConfig ?>">Ouvrir le formulaire de configuration</a></p>
        </div>
    </div>

    <!-- ========== ONGLET : Crédits ========== -->
    <div class="tab-panel<?= $onglet === 'credits' ? ' active' : '' ?>" id="panel-credits" role="tabpanel">
        <div class="card">
            <h2>Crédits</h2>
            <p class="text-muted">Propriétaire, développeur et hébergeur du site.</p>
            <p><a class="btn" href="<?= $urlCredit ?>">Ouvrir le formulaire des crédits</a></p>
        </div>
    </div>

    <!-- ========== ONGLET : En-tête ========== -->
    <div class="tab-panel<?= $onglet === 'entete' ? ' active' : '' ?>" id="panel-entete" role="tabpanel">
        <div class="card">
            <h2>En-tête (meta)</h2>
            <p class="text-muted">Titre, description, mots-clés, favicon…</p>
            <p><a class="btn" href="<?= $urlEntete ?>">Ouvrir le formulaire d'en-tête</a></p>
        </div>
    </div>

    <!-- ========== ONGLET : Menus ========== -->
    <div class="tab-panel<?= $onglet === 'menus' ? ' active' : '' ?>" id="panel-menus" role="tabpanel">
        <div class="card">
            <h2>Menus principaux</h2>
            <?php if (empty($model['Menus'])): ?>
                <p class="text-muted">Aucun élément de menu défini.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>URL</th>
                            <th>Cible</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model['Menus'] as $item): ?>
                        <tr>
                            <td><strong><?= e($item['titre'] ?? '') ?></strong></td>
                            <td><code><?= e($item['url'] ?? '') ?></code></td>
                            <td><?= e($item['cible'] ?? '') ?></td>
                            <td>
                                <a class="btn btn-secondaire" style="font-size:0.8rem;padding:0.25rem 0.6rem;"
                                   href="<?= $this->routeur->getRoute('modifMenu')->generateUri(['menu' => $item['titre']]) ?>">
                                    Modifier
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========== ONGLET : Pied de page ========== -->
    <div class="tab-panel<?= $onglet === 'pied' ? ' active' : '' ?>" id="panel-pied" role="tabpanel">
        <div class="card">
            <h2>Pied de page</h2>
            <?php if (empty($model['Pied'])): ?>
                <p class="text-muted">Aucun élément de pied de page défini.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>URL</th>
                            <th>Cible</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model['Pied'] as $item): ?>
                        <tr>
                            <td><strong><?= e($item['titre'] ?? '') ?></strong></td>
                            <td><code><?= e($item['url'] ?? '') ?></code></td>
                            <td><?= e($item['cible'] ?? '') ?></td>
                            <td>
                                <a class="btn btn-secondaire" style="font-size:0.8rem;padding:0.25rem 0.6rem;"
                                   href="<?= $this->routeur->getRoute('modifPied')->generateUri(['menu' => $item['titre']]) ?>">
                                    Modifier
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
(function () {
    const buttons = document.querySelectorAll('.admin-motif .tab-btn');
    const panels  = document.querySelectorAll('.admin-motif .tab-panel');

    function activerOnglet(nom) {
        buttons.forEach(btn => {
            const actif = btn.dataset.tab === nom;
            btn.classList.toggle('active', actif);
            btn.setAttribute('aria-selected', actif ? 'true' : 'false');
        });
        panels.forEach(panel => {
            panel.classList.toggle('active', panel.id === 'panel-' + nom);
        });

        // Met à jour l'URL sans recharger (pour partage / favoris)
        const url = new URL(window.location);
        url.searchParams.set('onglet', nom);
        history.replaceState(null, '', url);
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => activerOnglet(btn.dataset.tab));
    });
})();
</script>
