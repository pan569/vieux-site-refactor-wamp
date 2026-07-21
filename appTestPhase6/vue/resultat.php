<?php
/** Résultat générique d'un test */
use systeme\securite\Securite;

$ok      = $ok      ?? false;
$message = $message ?? '';
$detail  = $detail  ?? '';
$couleur = $ok ? '#e8f5e9' : '#fdecea';
bordure  = $ok ? '#2e7d32' : '#c62828';
$icone   = $ok ? '✓' : '✗';
?>
<div class="test-phase6">
    <div style="padding:1.25rem;border-radius:8px;background:<?= $couleur ?>;border-left:6px solid <?= $bordure ?>;">
        <h1 style="margin-top:0;"><?= $icone ?> <?= Securite::e($message) ?></h1>
        <?php if ($detail !== ''): ?>
            <p style="color:#444;"><code><?= Securite::e($detail) ?></code></p>
        <?php endif; ?>
    </div>

    <p style="margin-top:1.5rem;">
        <a href="index.php?application=TestPhase6">← Retour protocole</a>
    </p>
</div>
