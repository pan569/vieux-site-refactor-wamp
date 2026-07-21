<?php
/** Test d'échappement XSS */
use systeme\securite\Securite;
?>
<div class="test-phase6">
    <h1>Test échappement XSS (T09)</h1>

    <h2>Charge utile brute (ne jamais afficher telle quelle en prod)</h2>
    <pre style="background:#fff3cd;padding:1rem;border-radius:6px;overflow:auto;"><?= Securite::e($brut) ?></pre>

    <h2>Affichage via Securite::e() / e()</h2>
    <p style="background:#e8f5e9;padding:1rem;border-radius:6px;">
        <?= $echappe /* déjà échappé côté contrôleur */ ?>
    </p>

    <h2>Contrôle</h2>
    <ul>
        <li>Aucun popup <code>alert</code> ne doit apparaître.</li>
        <li>Tu dois voir le texte littéral <code>&lt;script&gt;...</code> ou les entités HTML.</li>
        <li>Le <code>&lt;b&gt;gras&lt;/b&gt;</code> ne doit pas être rendu en gras s'il est bien échappé.</li>
    </ul>

    <h2>Variante via URL</h2>
    <p>
        <a href="index.php?application=TestPhase6&fonction=escape&variables=payload:%3Cimg%20src=x%20onerror=alert(1)%3E">
            Lancer avec payload dans l'URL
        </a>
    </p>

    <p style="margin-top:1.5rem;">
        <a href="index.php?application=TestPhase6">← Retour protocole</a>
    </p>
</div>
