# Protocole de test — Phase 6

Application : **appTestPhase6**  
Principe : *ajouter le dossier = activer les tests · supprimer le dossier = tout retirer*

## Prérequis

- Branche `refactor-decouverte-auto` déployée sous WAMP
- Dossier `appTestPhase6/` présent à la racine du site (DOCUMENT_ROOT)
- PHP avec sessions activées

## Accès

```
index.php?application=TestPhase6
```

Le tableau de bord liste tous les cas avec liens « Lancer ».

---

## Cas de test

| ID  | Cas | Résultat attendu | Comment tester |
|-----|-----|------------------|----------------|
| T01 | Application inexistante | Page `motif/vue/erreur.php` code 404 | Lien fourni |
| T02 | Fonction inexistante | Page erreur 404 « méthode introuvable » | Lien fourni |
| T03 | Sanitize `application` (XSS dans le nom) | Caractères dangereux retirés → 404 propre | Lien fourni |
| T04 | Sanitize `fonction` | Idem, pas d'exécution de script | Lien fourni |
| T05 | Variables URL bien formées | `id=42`, `msg=bonjour` affichés | Lien fourni |
| T06 | Variables URL mal formées | Parsing tolérant, pas de crash | Lien fourni |
| T07 | CSRF token valide | Message vert « CSRF valide » | Formulaire → Envoyer |
| T08 | CSRF sans token | Message rouge « CSRF invalide » | F12 → supprimer `_csrf` → soumettre |
| T09 | Échappement XSS `e()` | Texte littéral, aucun `alert` | Lien fourni |
| T10 | Route absente `renduPage` | Commentaire HTML « introuvable », pas de fatal | Lien fourni |
| T11 | Redirection relative | Retour sur index TestPhase6, même hôte (pas `site01`) | Lien fourni |
| T12 | Session PHP active | `session_status = ACTIVE`, token présent | Lien fourni |
| T13 | `application=` et `fonction=` vides | Fallback défaut / index, pas de crash | Lien fourni |
| T14 | Plug-and-play dossier | Dossier présent → OK ; dossier renommé/supprimé → 404 | Manuel |

---

## Procédure recommandée

1. Ouvrir `index.php?application=TestPhase6`
2. Exécuter T01 → T13 dans l'ordre (noter ☐ / ☑)
3. T08 en manuel (devtools)
4. T14 : renommer `appTestPhase6` en `_appTestPhase6`, recharger → 404 ; remettre le nom → OK
5. Si tout est vert → Phase 6 validée
6. **Supprimer** (ou renommer) `appTestPhase6/` pour retirer les tests du site

---

## Critères de réussite globaux

- Aucune notice / warning / fatal PHP sur les cas prévus
- Les pages 404 utilisent bien `motif/vue/erreur.php`
- Aucun domaine hardcodé dans les redirections
- CSRF bloque les POST sans token
- `e()` empêche l'exécution de HTML/JS injecté
- Supprimer le dossier ne casse aucune autre application
