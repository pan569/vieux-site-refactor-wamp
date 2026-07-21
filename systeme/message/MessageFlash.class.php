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
     */
    public static function html(): string
    {
        $messages = self::consommer();

        if ($messages === []) {
            return '';
        }

        $html = '<div class="messages-flash" style="margin:1rem 0;">';

        foreach ($messages as $m) {
            $type = $m['type'] ?? self::INFO;
            $texte = Securite::e($m['message'] ?? '');

            $styles = [
                self::SUCCES => 'background:#d4edda;color:#155724;border:1px solid #c3e6cb;',
                self::ERREUR => 'background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;',
                self::INFO   => 'background:#d1ecf1;color:#0c5460;border:1px solid #bee5eb;',
            ];

            $style = $styles[$type] ?? $styles[self::INFO];

            $html .= '<div class="flash flash-' . Securite::e($type) . '" '
                . 'style="padding:.75rem 1rem;border-radius:6px;margin-bottom:.5rem;' . $style . '">'
                . $texte
                . '</div>';
        }

        $html .= '</div>';

        return $html;
    }
}
