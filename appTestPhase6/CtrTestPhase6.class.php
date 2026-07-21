<?php
/**
 * Application de test Phase 6 — plug-and-play
 *
 * Ajouter ce dossier  → les tests sont disponibles
 * Supprimer ce dossier → les tests disparaissent (aucun impact ailleurs)
 *
 * Accès : index.php?application=TestPhase6
 */

namespace appTestPhase6;

use systeme\routeur\Route;
use systeme\controleur\Controleur;
use systeme\securite\Csrf;
use systeme\securite\Securite;
use motif\modele\Motif;

class CtrTestPhase6 extends Controleur
{
    public function __construct(Motif $motif)
    {
        parent::__construct($motif);

        $s = DIRECTORY_SEPARATOR;
        $vue = __DIR__ . "{$s}vue{$s}";

        $this->routeur->addRoute(new Route($this->nomApplication, 'index', '', '', $vue . 'index.php'));
        $this->routeur->addRoute(new Route($this->nomApplication, 'csrfForm', '', '', $vue . 'csrfForm.php'));
        $this->routeur->addRoute(new Route($this->nomApplication, 'csrfOk', '', '', $vue . 'resultat.php'));
        $this->routeur->addRoute(new Route($this->nomApplication, 'csrfKo', '', '', $vue . 'resultat.php'));
        $this->routeur->addRoute(new Route($this->nomApplication, 'escape', '', '', $vue . 'escape.php'));
        $this->routeur->addRoute(new Route($this->nomApplication, 'routeAbsente', '', '', $vue . 'resultat.php'));
        $this->routeur->addRoute(new Route($this->nomApplication, 'rediriger', '', '', $vue . 'resultat.php'));
        $this->routeur->addRoute(new Route($this->nomApplication, 'variables', '{id:[0-9]+}{msg:[\w]+}', '', $vue . 'variables.php'));
        $this->routeur->addRoute(new Route($this->nomApplication, 'session', '', '', $vue . 'resultat.php'));
    }

    public function afficherPage(string $main): void
    {
        $this->motif['aside'] = [
            'Protocole' => ['lien' => $this->routeur->getRoute('index')->generateUri(), 'count' => 0],
            'Form CSRF' => ['lien' => $this->routeur->getRoute('csrfForm')->generateUri(), 'count' => 0],
            'Escape XSS' => ['lien' => $this->routeur->getRoute('escape')->generateUri(), 'count' => 0],
        ];

        $body = $this->renduPage('body', compact('main'));
        echo $this->renduPage('page', compact('body'));
    }

    /** Tableau de bord + protocole de test */
    public function index(array $variables = []): void
    {
        $cas = $this->listeCasTests();
        $main = $this->renduPage('index', compact('cas'));
        $this->afficherPage($main);
    }

    /** Formulaire CSRF (avec token) */
    public function csrfForm(array $variables = []): void
    {
        $main = $this->renduPage('csrfForm', []);
        $this->afficherPage($main);
    }

    /** Traitement POST avec vérification CSRF */
    public function csrfSubmit(array $variables = []): void
    {
        if ($this->verifierCsrf()) {
            $ok = true;
            $message = 'CSRF valide — le token a été accepté.';
            $detail = 'hash_equals a confirmé le token de session.';
        } else {
            $ok = false;
            $message = 'CSRF invalide — requête refusée.';
            $detail = 'Token absent, vide ou différent de la session.';
        }

        $main = $this->renduPage('resultat', compact('ok', 'message', 'detail'));
        $this->afficherPage($main);
    }

    /** Test d'échappement XSS via Securite::e() / e() */
    public function escape(array $variables = []): void
    {
        // Charge utile volontairement dangereuse
        $brut = $variables['payload'] ?? '<script>alert("XSS")</script><b>gras</b>';
        $echappe = Securite::e($brut);

        $main = $this->renduPage('escape', compact('brut', 'echappe'));
        $this->afficherPage($main);
    }

    /**
     * Tente de rendre une vue qui n'a PAS de route enregistrée.
     * Attendu : commentaire HTML sûr, pas de fatal error.
     */
    public function routeAbsente(array $variables = []): void
    {
        $rendu = $this->renduPage('vueQuiNexistePas', []);
        $ok = (strpos($rendu, 'introuvable') !== false);
        $message = $ok
            ? 'renduPage a géré la route absente sans planter.'
            : 'Comportement inattendu.';
        $detail = 'Contenu retourné : ' . $rendu;

        $main = $this->renduPage('resultat', compact('ok', 'message', 'detail'));
        $this->afficherPage($main);
    }

    /** Test redirection relative (header Location sans domaine hardcodé) */
    public function rediriger(array $variables = []): void
    {
        $this->redirigerRoute([
            'Callback'         => 'index',
            'variableCallback' => [],
        ]);
    }

    /** Affiche les variables parsées depuis l'URL */
    public function variables(array $variables = []): void
    {
        $main = $this->renduPage('variables', compact('variables'));
        $this->afficherPage($main);
    }

    /** Vérifie que la session est active (prérequis CSRF) */
    public function session(array $variables = []): void
    {
        $status = session_status();
        $ok = ($status === PHP_SESSION_ACTIVE);
        $message = $ok
            ? 'Session PHP active.'
            : 'Session PHP inactive (CSRF ne pourra pas fonctionner).';
        $detail = 'session_status() = ' . $status
            . ' | id = ' . (session_id() ?: '(vide)')
            . ' | token CSRF présent = ' . (Csrf::token() ? 'oui' : 'non');

        $main = $this->renduPage('resultat', compact('ok', 'message', 'detail'));
        $this->afficherPage($main);
    }

    /**
     * Liste structurée des cas de test pour le protocole.
     */
    protected function listeCasTests(): array
    {
        $base = 'index.php';

        return [
            [
                'id'       => 'T01',
                'titre'    => 'Application inexistante → page 404 unifiée',
                'attendu'  => 'Page motif/vue/erreur.php avec code 404, message clair, lien accueil.',
                'url'      => $base . '?application=AppQuiNexistePas',
                'type'     => 'externe',
            ],
            [
                'id'       => 'T02',
                'titre'    => 'Fonction inexistante → page 404 unifiée',
                'attendu'  => 'Page erreur 404 : méthode introuvable dans le contrôleur.',
                'url'      => $base . '?application=TestPhase6&fonction=methodeInconnue',
                'type'     => 'externe',
            ],
            [
                'id'       => 'T03',
                'titre'    => 'Sanitisation application (caractères spéciaux)',
                'attendu'  => 'Caractères hors [a-zA-Z0-9_-] retirés → application « nettoyée » puis 404 si inexistante.',
                'url'      => $base . '?application=Test<script>Evil</script>',
                'type'     => 'externe',
            ],
            [
                'id'       => 'T04',
                'titre'    => 'Sanitisation fonction (caractères spéciaux)',
                'attendu'  => 'fonction=index%3Cimg%20src=x%20onerror=alert(1)%3E → nettoyée en « index… » ou 404.',
                'url'      => $base . '?application=TestPhase6&fonction=index<img src=x onerror=alert(1)>',
                'type'     => 'externe',
            ],
            [
                'id'       => 'T05',
                'titre'    => 'Variables URL bien formées',
                'attendu'  => 'id=42 et msg=bonjour extraits correctement.',
                'url'      => $this->routeur->getRoute('variables')->generateUri(['id' => '42', 'msg' => 'bonjour']),
                'type'     => 'interne',
            ],
            [
                'id'       => 'T06',
                'titre'    => 'Variables URL mal formées / injection',
                'attendu'  => 'Parsing tolérant, clés sanitizées, pas de crash.',
                'url'      => $base . '?application=TestPhase6&fonction=variables&variables=id:1|bad<script>:x|msg:ok',
                'type'     => 'externe',
            ],
            [
                'id'       => 'T07',
                'titre'    => 'CSRF — formulaire avec token valide',
                'attendu'  => 'Soumission acceptée (message vert).',
                'url'      => $this->routeur->getRoute('csrfForm')->generateUri(),
                'type'     => 'interne',
            ],
            [
                'id'       => 'T08',
                'titre'    => 'CSRF — POST sans token (ou token trafiqué)',
                'attendu'  => 'Requête refusée (message rouge). Tester en retirant le champ _csrf via les devtools.',
                'url'      => $this->routeur->getRoute('csrfForm')->generateUri(),
                'type'     => 'manuel',
            ],
            [
                'id'       => 'T09',
                'titre'    => 'Échappement XSS — Securite::e() / e()',
                'attendu'  => 'Le script s\'affiche en texte, ne s\'exécute pas.',
                'url'      => $this->routeur->getRoute('escape')->generateUri(),
                'type'     => 'interne',
            ],
            [
                'id'       => 'T10',
                'titre'    => 'Route absente dans renduPage()',
                'attendu'  => 'Commentaire HTML « introuvable », pas de fatal error / notice.',
                'url'      => $this->routeur->getRoute('routeAbsente')->generateUri(),
                'type'     => 'interne',
            ],
            [
                'id'       => 'T11',
                'titre'    => 'Redirection relative (plus de http://site01/)',
                'attendu'  => 'Header Location relatif → retour sur index TestPhase6, même hôte.',
                'url'      => $this->routeur->getRoute('rediriger')->generateUri(),
                'type'     => 'interne',
            ],
            [
                'id'       => 'T12',
                'titre'    => 'Session PHP démarrée (prérequis CSRF)',
                'attendu'  => 'session_status = ACTIVE, token CSRF générable.',
                'url'      => $this->routeur->getRoute('session')->generateUri(),
                'type'     => 'interne',
            ],
            [
                'id'       => 'T13',
                'titre'    => 'Application vide / fonction vide',
                'attendu'  => 'Fallback application par défaut ou index, pas de crash.',
                'url'      => $base . '?application=&fonction=',
                'type'     => 'externe',
            ],
            [
                'id'       => 'T14',
                'titre'    => 'Découverte auto — cette app apparaît seule via son dossier',
                'attendu'  => 'Si appTestPhase6 est présent → accessible. Si dossier supprimé → T01-like 404.',
                'url'      => $base . '?application=TestPhase6',
                'type'     => 'manuel',
            ],
        ];
    }
}
