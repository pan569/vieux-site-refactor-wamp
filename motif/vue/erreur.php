<?php
/**
 * Page d'erreur unifiée du motif.
 * Variables attendues : $message (string), $code (int, optionnel)
 */
$code    = $code    ?? 404;
$message = $message ?? 'Une erreur est survenue.';
$titre   = $code === 404 ? 'Page introuvable' : 'Erreur';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?> — <?= (int) $code ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background: #f4f6f8;
            color: #222;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
            max-width: 480px;
            width: 100%;
            padding: 2.5rem 2rem;
            text-align: center;
        }
        .code {
            font-size: 4rem;
            font-weight: 700;
            color: #c0392b;
            line-height: 1;
            margin-bottom: .5rem;
        }
        h1 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: #333;
        }
        p {
            color: #555;
            line-height: 1.5;
            margin-bottom: 1.75rem;
        }
        a {
            display: inline-block;
            background: #2c3e50;
            color: #fff;
            text-decoration: none;
            padding: .7rem 1.4rem;
            border-radius: 6px;
            font-weight: 500;
            transition: background .2s;
        }
        a:hover { background: #1a252f; }
    </style>
</head>
<body>
    <div class="card">
        <div class="code"><?= (int) $code ?></div>
        <h1><?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <a href="index.php">Retour à l'accueil</a>
    </div>
</body>
</html>
