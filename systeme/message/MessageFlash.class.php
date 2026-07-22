<?php
namespace systeme\message;

use systeme\securite\Securite;

/**
 * Messages flash en session (affichés une seule fois).
 *
 * Usage côté contrôleur :
 *   MessageFlash::succes('Article enregistré.');
 *   MessageFlash::erreur('Token CSRF invalide.');
 *
 * Affichage (déjà branché dans motif/vue/body.php) :
 *   <?= MessageFlash::html(); ?>
 *
 * Styles : classes .flash / .flash-succes|erreur|info dans le thème (theme.monBog).
 * Compatible avec la modularité : aucune dépendance à une application.
 */
class MessageFlash
{
    private const SESSION_KEY = '_messages_flash';

    public const SUCCES = 'succes';
    public const ERREUR = 'erreur';
    public const INFO   = 'info';

    protected static function assurerSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Ajoute un message flash.
     */
    public static function ajouter(string $type, string $message): void
    {
        self::assurerSession();

        if (!isset($_SESSION[self::SESSION_KEY]) || !is_array($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }

        $_SESSION[self::SESSION_KEY][] = [
            'type'    => $type,
            'message' => $message,
        ];
    }

    public static function succes(string $message): void
    {
        self::ajouter(self::SUCCES, $message);
    }

    public static function erreur(string $message): void
    {
        self::ajouter(self::ERREUR, $message);
    }

    public static function info(string $message): void
    {
        self::ajouter(self::INFO, $message);
    }

    /**
     * Récupère et vide les messages (consommation unique).
     *
     * @return array<int, array{type: string, message: string}>
     */
    public static function consommer(): array
    {
        self::assurerSession();

        $messages = $_SESSION[self::SESSION_KEY] ?? [];
        unset($_SESSION[self::SESSION_KEY]);

        return is_array($messages) ? $messages : [];
    }

    /**
     * Rend le HTML des messages flash (et les consomme).
     * Le style vient du thème via .flash / .flash-{type}.
     */
    public static function html(): string
    {
        $messages = self::consommer();

        if ($messages === []) {
            return '';
        }

        $html = '<div class="messages-flash">';

        foreach ($messages as $m) {
            $type = $m['type'] ?? self::INFO;
            $texte = Securite::e($m['message'] ?? '');
            $classe = 'flash flash-' . preg_replace('/[^a-z]/', '', strtolower($type));

            $html .= '<div class="' . $classe . '">' . $texte . '</div>';
        }

        $html .= '</div>';

        return $html;
    }
}
