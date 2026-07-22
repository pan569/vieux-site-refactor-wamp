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

<style>
/* Styles de secours pour les onglets (garantit le fonctionnement même si le CSS du thème est en cache) */
.admin-motif .tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    border-bottom: 2px solid #E5E5E5;
    margin: 1.25rem 0 1.5rem;
    padding: 0;
}
.admin-motif .tab-btn {
    background: transparent !important;
    color: #9F9F9F !important;
    border: none !important;
    border-bottom: 2px solid transparent !important;
    margin: 0 0 -2px 0 !important;
    padding: 0.65rem 1.1rem !important;
    font-size: 0.9rem !important;
    font-weight: 500 !important;
    border-radius: 0 !important;
    cursor: pointer;
    box-shadow: none !important;
}
.admin-motif .tab-btn:hover {
    color: #2c3e50 !important;
    background: transparent !important;
}
.admin-motif .tab-btn.active {
    color: #2c3e50 !important;
    border-bottom-color: #2c3e50 !important;
    background: transparent !important;
}
.admin-motif .tab-panel {
    display: none;
}
.admin-motif .tab-panel.active {
    display: block;
}
.admin-motif .card {
    background: #fff;
    border: 1px solid #E5E5E5;
    border-radius: 6px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 10px rgba(0,0,0,.05);
}
.admin-motif .card h2 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 0;
}
.admin-motif .grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}
.admin-motif .grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1.25rem;
}
@media (max-width: 720px) {
    .admin-motif .tabs {
        overflow-x: auto;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
    }
    .admin-motif .tab-btn {
        flex-shrink: 0;
        padding: 0.55rem 0.9rem !important;
        font-size: 0.85rem !important;
    }
    .admin-motif .grid-2,
    .admin-motif .grid-3 {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="admin-motif">
    <h1>Paramètres du site</h1>

    <!-- Barre d'onglets -->
    <nav class="tabs" role="tablist" aria-label="Sections d'administration">
        <button type="button" class="tab-btn<?= $onglet === 'apercu' ? ' active' : '' ?>" data-tab="apercu" role="tab">Vue d'ensemble</button>
        <button type="button" class="tab-btn<?= $onglet === 'configuration' ? ' active' : '' ?>" data-tab="configuration" role="tab">Configuration</button>
        <button type="button" class="tab-btn<?= $onglet === 'credits' ? ' active' : '' ?>" data-tab="credits" role="tab">Crédits</button>
        <button type="button" class="tab-btn<?= $onglet === 'entete' ? ' active' : '' ?>" data-tab="entete" role="tab">En-tête</button>
        <button type="button" class="tab-btn<?= $onglet === 'menus' ? ' active' : '' ?>" data-tab="menus" role="tab">Menus</button>
        <button type="button" class="tab-btn<?= $onglet === 'pied' ? ' active' : '' ?>" data-tab="pied" role="tab">Pied de page</button>
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
    var root = document.querySelector('.admin-motif');
    if (!root) return;

    var buttons = root.querySelectorAll('.tab-btn');
    var panels  = root.querySelectorAll('.tab-panel');

    function activerOnglet(nom) {
        for (var i = 0; i < buttons.length; i++) {
            var btn = buttons[i];
            var actif = btn.getAttribute('data-tab') === nom;
            if (actif) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        }
        for (var j = 0; j < panels.length; j++) {
            var panel = panels[j];
            if (panel.id === 'panel-' + nom) {
                panel.classList.add('active');
            } else {
                panel.classList.remove('active');
            }
        }

        // Met à jour l'URL sans recharger
        try {
            var url = new URL(window.location.href);
            url.searchParams.set('onglet', nom);
            history.replaceState(null, '', url.toString());
        } catch (e) {}
    }

    for (var k = 0; k < buttons.length; k++) {
        (function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                activerOnglet(btn.getAttribute('data-tab'));
            });
        })(buttons[k]);
    }

    // Au chargement : s'assurer qu'un panneau est bien visible
    var actif = root.querySelector('.tab-btn.active');
    if (actif) {
        activerOnglet(actif.getAttribute('data-tab'));
    } else if (buttons.length > 0) {
        activerOnglet(buttons[0].getAttribute('data-tab'));
    }
})();
</script>
