<?php
/** Formulaire de test CSRF */
use systeme\securite\Csrf;
?>
<div class="test-phase6">
    <h1>Test CSRF (T07 / T08)</h1>

    <h2>T07 — Token valide</h2>
    <p>Soumets ce formulaire tel quel → doit être <strong>accepté</strong>.</p>
    <form method="post" action="index.php?application=TestPhase6&fonction=csrfSubmit" style="margin-bottom:2rem;padding:1rem;border:1px solid #ccc;border-radius:8px;">
        <?= Csrf::champ() ?>
        <p>
            <label>Message de test :
                <input type="text" name="message" value="hello phase6" style="width:60%;">
            </label>
        </p>
        <button type="submit">Envoyer avec token CSRF</button>
    </form>

    <h2>T08 — Sans token (manuel)</h2>
    <p>
        Ouvre les outils de développement (F12) → inspecte le formulaire ci-dessus →
        <strong>supprime</strong> l'input <code>name="_csrf"</code> → soumets à nouveau.
        Résultat attendu : <strong>refusé</strong>.
    </p>

    <p style="margin-top:1.5rem;">
        <a href="index.php?application=TestPhase6">← Retour protocole</a>
    </p>
</div>
