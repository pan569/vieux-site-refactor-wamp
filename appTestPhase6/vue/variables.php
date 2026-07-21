<?php
/** Affiche les variables parsées depuis l'URL */
use systeme\securite\Securite;
?>
<div class="test-phase6">
    <h1>Variables URL (T05 / T06)</h1>

    <p>Variables reçues par le contrôleur après parsing / sanitisation :</p>

    <?php if (empty($variables)): ?>
        <p style="color:#888;"><em>Aucune variable.</em></p>
    <?php else: ?>
        <table style="border-collapse:collapse;width:100%;max-width:480px;">
            <thead>
                <tr style="background:#2c3e50;color:#fff;">
                    <th style="padding:8px;text-align:left;">Clé</th>
                    <th style="padding:8px;text-align:left;">Valeur</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($variables as $k => $v): ?>
                <tr style="border-bottom:1px solid #ddd;">
                    <td style="padding:8px;"><code><?= Securite::e($k) ?></code></td>
                    <td style="padding:8px;"><code><?= Securite::e(is_array($v) ? json_encode($v) : $v) ?></code></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top:1.5rem;">
        <a href="index.php?application=TestPhase6">← Retour protocole</a>
    </p>
</div>
