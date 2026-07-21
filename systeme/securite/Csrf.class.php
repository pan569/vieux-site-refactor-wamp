<?php
namespace systeme\securite;

/**
 * Protection CSRF simple basée sur la session.
 *
 * Usage dans un formulaire :
 *   <?= \systeme\securite\Csrf::champ(); ?>
 *
 * Vérification côté contrôleur (avant traitement POST) :
 *   if (!\systeme\securite\Csrf::valider()) { ... }
 *
 * Compatible avec l'architecture modulaire : aucun lien vers une app particulière.
 */
class Csrf
{
    private const SESSION_KEY = '_csrf_token';

    /**
     * Démarre la session si nécessaire.
     */
    protected static function assurerSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Retourne le token courant (en crée un s'il n'existe pas).
     */
    public static function token(): string
    {
        self::assurerSession();

        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Génère le champ hidden HTML à placer dans chaque formulaire POST.
     */
    public static function champ(string $name = '_csrf'): string
    {
        $token = htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8');
        $name  = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        return '<input type="hidden" name="' . $name . '" value="' . $token . '">';
    }

    /**
     * Vérifie le token reçu (POST par défaut).
     *
     * @param string|null $tokenReçu Token à vérifier (null = lit $_POST['_csrf'])
     * @return bool true si le token est valide
     */
    public static function valider(?string $tokenReçu = null): bool
    {
        self::assurerSession();

        if ($tokenReçu === null) {
            $tokenReçu = $_POST['_csrf'] ?? '';
        }

        $attendu = $_SESSION[self::SESSION_KEY] ?? '';

        if ($attendu === '' || $tokenReçu === '') {
            return false;
        }

        return hash_equals($attendu, $tokenReçu);
    }

    /**
     * Régénère le token (après une action sensible réussie, optionnel).
     */
    public static function regenerer(): void
    {
        self::assurerSession();
        $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
    }
}
