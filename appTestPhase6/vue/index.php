<?php
/** Tableau de bord du protocole de test Phase 6 */
use systeme\securite\Securite;
?>
<div class="test-phase6">
    <h1>Protocole de test — Phase 6</h1>
    <p>
        Application <strong>appTestPhase6</strong> (plug-and-play).<br>
        Ajouter le dossier = activer les tests · Supprimer le dossier = tout retirer.
    </p>

    <h2>Checklist</h2>
    <table class="test-table" style="width:100%;border-collapse:collapse;font-size:0.95rem;">
        <thead>
            <tr style="background:#2c3e50;color:#fff;">
                <th style="padding:8px;text-align:left;">ID</th>
                <th style="padding:8px;text-align:left;">Cas de test</th>
                <th style="padding:8px;text-align:left;">Résultat attendu</th>
                <th style="padding:8px;text-align:left;">Action</th>
                <th style="padding:8px;text-align:center;">OK ?</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cas as $i => $c): ?>
            <tr style="background:<?= $i % 2 ? '#f8f9fa' : '#fff' ?>;border-bottom:1px solid #ddd;">
                <td style="padding:8px;font-weight:bold;"><?= Securite::e($c['id']) ?></td>
                <td style="padding:8px;"><?= Securite::e($c['titre']) ?></td>
                <td style="padding:8px;color:#555;"><?= Securite::e($c['attendu']) ?></td>
                <td style="padding:8px;">
                    <?php if ($c['type'] === 'manuel'): ?>
                        <em style="color:#888;">manuel</em>
                    <?php else: ?>
                        <a href="<?= Securite::e($c['url']) ?>" target="_blank" rel="noopener">Lancer</a>
                    <?php endif; ?>
                </td>
                <td style="padding:8px;text-align:center;">☐</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2 style="margin-top:2rem;">Mode d'emploi rapide</h2>
    <ol>
        <li>Ouvrir chaque lien « Lancer » (nouvel onglet).</li>
        <li>Comparer avec la colonne « Résultat attendu ».</li>
        <li>Cocher mentalement / noter les ☐.</li>
        <li>Pour <strong>T08</strong> : ouvrir le formulaire CSRF, retirer le champ <code>_csrf</code> via les outils de développement, puis soumettre.</li>
        <li>Pour <strong>T14</strong> : renommer temporairement le dossier <code>appTestPhase6</code> et vérifier le 404, puis le remettre.</li>
    </ol>

    <p style="margin-top:1.5rem;padding:1rem;background:#e8f5e9;border-radius:6px;">
        Quand tous les tests sont verts, la Phase 6 est validée.<br>
        Tu peux alors <strong>supprimer le dossier appTestPhase6</strong> sans impacter le reste du site.
    </p>
</div>
