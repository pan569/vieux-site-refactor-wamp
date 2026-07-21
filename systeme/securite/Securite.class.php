<?php
namespace systeme\securite;

/**
 * Helpers de sécurité transverses.
 *
 * - e()          : échappement HTML (anti-XSS)
 * - sanitizeNom  : n'autorise que [a-zA-Z0-9_-] pour application / fonction
 * - nettoyer     : trim + suppression des caractères de contrôle
 *
 * Utilisation dans les vues :
 *   <?= \systeme\securite\Securite::e($variable); ?>
 *
 * Ou via la fonction globale e() définie en bas de fichier.
 */
class Securite
{
    /**
     * Échappe une chaîne pour affichage HTML sûr.
     */
    public static function e($valeur): string
    {
        if ($valeur === null) {
            return '';
        }

        return htmlspecialchars((string) $valeur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Nettoie un identifiant (application, fonction, nom de route…).
     * N'autorise que lettres, chiffres, underscore et tiret.
     */
    public static function sanitizeNom(string $valeur, int $longueurMax = 64): string
    {
        $valeur = preg_replace('/[^a-zA-Z0-9_\-]/', '', $valeur);
        return substr($valeur, 0, $longueurMax);
    }

    /**
     * Nettoyage léger d'une chaîne utilisateur (trim + caractères de contrôle).
     */
    public static function nettoyer(string $valeur): string
    {
        // Supprime les caractères de contrôle sauf tabulation / saut de ligne
        $valeur = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $valeur);
        return trim($valeur);
    }

    /**
     * Vérifie qu'une valeur correspond à un entier positif (ou 0).
     */
    public static function estEntierPositif($valeur): bool
    {
        return is_numeric($valeur) && (int) $valeur >= 0 && (string) (int) $valeur === (string) $valeur;
    }
}

/**
 * Fonction globale de confort pour les vues.
 * Usage : <?= e($texte); ?>
 */
if (!function_exists('e')) {
    function e($valeur): string
    {
        return \systeme\securite\Securite::e($valeur);
    }
}
