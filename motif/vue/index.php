<?php
/**
 * Interface d'administration Motif — onglets + formulaires intégrés.
 * Approche B : CSS + JS léger.
 *
 * Onglets : apercu | configuration | credits | entete | menus | pied
 */
use systeme\vue\form;

$onglet = $onglet ?? 'apercu';
$form   = form::getInstance('form-control');

$urlConfig = $this->routeur->getRoute('modifConfiguration')->generateUri();
$urlCredit = $this->routeur->getRoute('modifCredit')->generateUri();
$urlEntete = $this->routeur->getRoute('modifEntete')->generateUri();
?>

<style>
/* Styles de secours pour les onglets */
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
.admin-motif details.menu-item-edit {
    border: 1px solid #E5E5E5;
    border-radius: 6px;
    margin-bottom: 0.75rem;
    background: #fafafa;
}
.admin-motif details.menu-item-edit summary {
    cursor: pointer;
    padding: 0.75rem 1rem;
    font-weight: 500;
    list-style: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.admin-motif details.menu-item-edit summary::-webkit-details-marker {
    display: none;
}
.admin-motif details.menu-item-edit summary::after {
    content: '▾';
    color: #9F9F9F;
    font-size: 0.85rem;
}
.admin-motif details.menu-item-edit[open] summary::after {
    content: '▴';
}
.admin-motif details.menu-item-edit .form-body {
    padding: 0 1rem 1rem;
    border-top: 1px solid #E5E5E5;
}
.admin-motif .url-hint {
    font-size: 0.85rem;
    color: #9F9F9F;
    margin: 0.25rem 0 0.75rem;
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
            <h2>Configuration</h2>
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
            <h2>Crédits</h2>
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
            <h2>En-tête</h2>
            <p><strong>Titre :</strong> <?= e($model['Entete']['titre'] ?? '') ?></p>
            <p><strong>Auteur :</strong> <?= e($model['Entete']['auteur'] ?? '') ?></p>
            <p><strong>Description :</strong> <?= e($model['Entete']['description'] ?? '') ?></p>
        </div>
    </div>

    <!-- ========== ONGLET : Configuration ========== -->
    <div class="tab-panel<?= $onglet === 'configuration' ? ' active' : '' ?>" id="panel-configuration" role="tabpanel">
        <div class="card">
            <h2>Configuration</h2>
            <form method="post" action="<?= $urlConfig ?>" enctype="multipart/form-data">
                <?= $this->champCsrf(); ?>
                <div class="grid-2">
                    <div>
                        <h3>Le site</h3>
                        <?= $form->ConstructeurChamp('Nom du site', 'SiteNom', $model['Configuration']['SiteNom'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Descriptif', 'SiteDescriptif', $model['Configuration']['SiteDescriptif'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Dossier des thèmes', 'SiteThemeDossier', $model['Configuration']['SiteThemeDossier'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Thème courant', 'SiteThemeNom', $model['Configuration']['SiteThemeNom'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Dossier des fichiers JS', 'SiteJavaScriptDossier', $model['Configuration']['SiteJavaScriptDossier'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Copyright', 'SiteCopyright', $model['Configuration']['SiteCopyright'] ?? '', 'text'); ?>
                    </div>
                    <div>
                        <h3>Base de données</h3>
                        <?= $form->ConstructeurChamp('Nom du serveur', 'DataBaseServeur', $model['Configuration']['DataBaseServeur'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Nom utilisateur', 'DataBaseUtilisateur', $model['Configuration']['DataBaseUtilisateur'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Mot de passe', 'DataBaseMdP', $model['Configuration']['DataBaseMdP'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Nom de la base', 'DataBaseNon', $model['Configuration']['DataBaseNon'] ?? '', 'text'); ?>
                    </div>
                </div>
                <?= $form->ConstructeurChamp('', 'form', 'true', 'hidden'); ?>
                <p><button type="submit" class="btn">Enregistrer la configuration</button></p>
            </form>
        </div>
    </div>

    <!-- ========== ONGLET : Crédits ========== -->
    <div class="tab-panel<?= $onglet === 'credits' ? ' active' : '' ?>" id="panel-credits" role="tabpanel">
        <div class="card">
            <h2>Crédits</h2>
            <form method="post" action="<?= $urlCredit ?>" enctype="multipart/form-data">
                <?= $this->champCsrf(); ?>
                <div class="grid-3">
                    <div>
                        <h3>Propriétaire</h3>
                        <?= $form->ConstructeurChamp('Nom', 'Proprietaire_nom', $model['Proprietaire']['nom'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Adresse', 'Proprietaire_adresse', $model['Proprietaire']['adresse'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Téléphone', 'Proprietaire_telephone', $model['Proprietaire']['telephone'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Courriel', 'Proprietaire_email', $model['Proprietaire']['email'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Site', 'Proprietaire_www', $model['Proprietaire']['www'] ?? '', 'text'); ?>
                    </div>
                    <div>
                        <h3>Développeur</h3>
                        <?= $form->ConstructeurChamp('Nom', 'Developpeur_nom', $model['Developpeur']['nom'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Adresse', 'Developpeur_adresse', $model['Developpeur']['adresse'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Téléphone', 'Developpeur_telephone', $model['Developpeur']['telephone'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Courriel', 'Developpeur_email', $model['Developpeur']['email'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Site', 'Developpeur_www', $model['Developpeur']['www'] ?? '', 'text'); ?>
                    </div>
                    <div>
                        <h3>Hébergeur</h3>
                        <?= $form->ConstructeurChamp('Nom', 'Hebergeur_nom', $model['Hebergeur']['nom'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Adresse', 'Hebergeur_adresse', $model['Hebergeur']['adresse'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Téléphone', 'Hebergeur_telephone', $model['Hebergeur']['telephone'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Courriel', 'Hebergeur_email', $model['Hebergeur']['email'] ?? '', 'text'); ?>
                        <?= $form->ConstructeurChamp('Site', 'Hebergeur_www', $model['Hebergeur']['www'] ?? '', 'text'); ?>
                    </div>
                </div>
                <?= $form->ConstructeurChamp('', 'form', 'true', 'hidden'); ?>
                <p><button type="submit" class="btn">Enregistrer les crédits</button></p>
            </form>
        </div>
    </div>

    <!-- ========== ONGLET : En-tête ========== -->
    <div class="tab-panel<?= $onglet === 'entete' ? ' active' : '' ?>" id="panel-entete" role="tabpanel">
        <div class="card">
            <h2>En-tête (meta)</h2>
            <form method="post" action="<?= $urlEntete ?>" enctype="multipart/form-data">
                <?= $this->champCsrf(); ?>
                <?= $form->ConstructeurChamp("Nom de l'auteur", 'auteur', $model['Entete']['auteur'] ?? '', 'text'); ?>
                <?= $form->ConstructeurChamp('Description', 'description', $model['Entete']['description'] ?? '', 'textarea', [50, 4]); ?>
                <?= $form->ConstructeurChamp('Mots-clés', 'motsCles', $model['Entete']['motsCles'] ?? '', 'textarea', [50, 3]); ?>
                <?= $form->ConstructeurChamp('Éditeur', 'editeur', $model['Entete']['editeur'] ?? '', 'text'); ?>
                <?= $form->ConstructeurChamp('Titre', 'titre', $model['Entete']['titre'] ?? '', 'text'); ?>
                <?= $form->ConstructeurChamp('Icône (favicon)', 'image', $model['Entete']['image'] ?? '', 'text'); ?>
                <?= $form->ConstructeurChamp('', 'form', 'true', 'hidden'); ?>
                <p><button type="submit" class="btn">Enregistrer l'en-tête</button></p>
            </form>
        </div>
    </div>

    <!-- ========== ONGLET : Menus ========== -->
    <div class="tab-panel<?= $onglet === 'menus' ? ' active' : '' ?>" id="panel-menus" role="tabpanel">
        <div class="card">
            <h2>Menus principaux</h2>
            <?php if (empty($model['Menus'])): ?>
                <p class="text-muted">Aucun élément de menu défini.</p>
            <?php else: ?>
                <?php foreach ($model['Menus'] as $item): ?>
                    <?php
                    $urlMenu = $this->routeur->getRoute('modifMenu')->generateUri(['menu' => $item['titre']]);
                    ?>
                    <details class="menu-item-edit">
                        <summary>
                            <span><?= e($item['titre'] ?? '') ?></span>
                        </summary>
                        <div class="form-body">
                            <p class="url-hint">URL : <code><?= e($item['url'] ?? '') ?></code></p>
                            <form method="post" action="<?= $urlMenu ?>" enctype="multipart/form-data">
                                <?= $this->champCsrf(); ?>
                                <?= $form->ConstructeurChamp('Description', 'description', $item['description'] ?? '', 'textarea', [50, 3]); ?>
                                <?= $form->ConstructeurChamp('Cible', 'cible', $item['cible'] ?? '', 'text'); ?>
                                <?= $form->ConstructeurChamp('CSS', 'css', $item['css'] ?? '', 'textarea', [50, 2]); ?>
                                <?= $form->ConstructeurChamp('Image', 'image', $item['image'] ?? '', 'text'); ?>
                                <?= $form->ConstructeurChamp('', 'menu', $item['titre'] ?? '', 'hidden'); ?>
                                <?= $form->ConstructeurChamp('', 'form', 'true', 'hidden'); ?>
                                <p><button type="submit" class="btn">Enregistrer « <?= e($item['titre'] ?? '') ?> »</button></p>
                            </form>
                        </div>
                    </details>
                <?php endforeach; ?>
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
                <?php foreach ($model['Pied'] as $item): ?>
                    <?php
                    $urlPied = $this->routeur->getRoute('modifPied')->generateUri(['menu' => $item['titre']]);
                    ?>
                    <details class="menu-item-edit">
                        <summary>
                            <span><?= e($item['titre'] ?? '') ?></span>
                        </summary>
                        <div class="form-body">
                            <p class="url-hint">URL : <code><?= e($item['url'] ?? '') ?></code></p>
                            <form method="post" action="<?= $urlPied ?>" enctype="multipart/form-data">
                                <?= $this->champCsrf(); ?>
                                <?= $form->ConstructeurChamp('Description', 'description', $item['description'] ?? '', 'textarea', [50, 3]); ?>
                                <?= $form->ConstructeurChamp('Cible', 'cible', $item['cible'] ?? '', 'text'); ?>
                                <?= $form->ConstructeurChamp('CSS', 'css', $item['css'] ?? '', 'textarea', [50, 2]); ?>
                                <?= $form->ConstructeurChamp('Image', 'image', $item['image'] ?? '', 'text'); ?>
                                <?= $form->ConstructeurChamp('', 'menu', $item['titre'] ?? '', 'hidden'); ?>
                                <?= $form->ConstructeurChamp('', 'form', 'true', 'hidden'); ?>
                                <p><button type="submit" class="btn">Enregistrer « <?= e($item['titre'] ?? '') ?> »</button></p>
                            </form>
                        </div>
                    </details>
                <?php endforeach; ?>
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
            if (btn.getAttribute('data-tab') === nom) {
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

    var actif = root.querySelector('.tab-btn.active');
    if (actif) {
        activerOnglet(actif.getAttribute('data-tab'));
    } else if (buttons.length > 0) {
        activerOnglet(buttons[0].getAttribute('data-tab'));
    }
})();
</script>
