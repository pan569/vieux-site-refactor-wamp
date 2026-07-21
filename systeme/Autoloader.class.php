<?php

namespace systeme;

/**
 * Autoloader personnalisé.
 *
 * Convention principale :
 *   Namespace\Classe  →  Namespace/Classe.class.php
 *   (ou .trait.php pour les traits)
 *
 * Support également d'un mapping manuel via addNamespace().
 */
class Autoloader
{
    /**
     * Tableau associatif : préfixe d’espace de noms → tableau de répertoires de base.
     *
     * @var array
     */
    protected $espaceDeNomClasses = [];

    /**
     * Ajoute un répertoire de base pour un préfixe d’espace de noms.
     *
     * @param string $espaceDeNomClasse Préfixe d’espace de noms.
     * @param string $cheminPhysique    Répertoire de base pour les classes de cet espace de noms.
     * @param bool   $prepend           Si true, ajoute en tête de la pile.
     * @return void
     */
    public function addNamespace($espaceDeNomClasse, $cheminPhysique, $prepend = false)
    {
        // Normalise le préfixe d’espace de noms
        $espaceDeNomClasse = trim($espaceDeNomClasse, '\\') . '\\';

        // Normalise le répertoire de base avec un séparateur de fin
        if (strpbrk($cheminPhysique, '\\') === false) {
            $cheminPhysique = rtrim($cheminPhysique, DIRECTORY_SEPARATOR) . '/';
        } else {
            $cheminPhysique = rtrim($cheminPhysique, DIRECTORY_SEPARATOR) . '\\';
        }

        // Initialise le tableau si nécessaire
        if (isset($this->espaceDeNomClasses[$espaceDeNomClasse]) === false) {
            $this->espaceDeNomClasses[$espaceDeNomClasse] = array();
        }

        // Conserve le répertoire de base
        if ($prepend) {
            array_unshift($this->espaceDeNomClasses[$espaceDeNomClasse], $cheminPhysique);
        } else {
            array_push($this->espaceDeNomClasses[$espaceDeNomClasse], $cheminPhysique);
        }
    }

    /**
     * Enregistre le chargeur dans la pile SPL.
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Détermine le fichier correspondant à la classe et le charge.
     */
    public function autoload($NomClasse)
    {
        $resultat = false;
        $NomClasseT = $this->resolveurEspaceNom($NomClasse);

        $resultat = $this->ChargementFichierConventionel(
            $NomClasseT['EspaceDeNomClasse'],
            $NomClasseT['nomClasse']
        );

        if ($resultat === false) {
            $resultat = $this->ChargementFichierMappé(
                $NomClasseT['EspaceDeNomClasse'],
                $NomClasseT['nomClasse']
            );
        }

        return $resultat;
    }

    /**
     * Sépare le nom de la classe et son espace de noms.
     *
     * @param string $NomClasse Nom complet de la classe
     * @return array
     */
    protected function resolveurEspaceNom(string $NomClasse)
    {
        $resultat = [];

        $NomClasseCompletT = explode('\\', $NomClasse);
        $pos = count($NomClasseCompletT);

        $resultat['nomClasse'] = $NomClasseCompletT[$pos - 1];

        $resultat['EspaceDeNomClasse'] = '';
        for ($cp = 0; $cp < $pos - 1; $cp++) {
            $resultat['EspaceDeNomClasse'] .= rtrim($NomClasseCompletT[$cp] . DIRECTORY_SEPARATOR);
        }

        return $resultat;
    }

    /**
     * Charge par convention :
     *   NomClasse.class.php  ou  NomClasse.trait.php
     *
     * @return string|false
     */
    protected function ChargementFichierConventionel(string $espaceDeNomClasse, string $nomClasse)
    {
        $s = DIRECTORY_SEPARATOR;

        // Classe classique
        $fichier = dirname(__DIR__) . $s . $espaceDeNomClasse . $nomClasse . '.class.php';
        if ($this->requerirFichier($fichier)) {
            return $fichier;
        }

        // Trait
        $fichier = dirname(__DIR__) . $s . $espaceDeNomClasse . $nomClasse . '.trait.php';
        if ($this->requerirFichier($fichier)) {
            return $fichier;
        }

        return false;
    }

    /**
     * Charge via le mapping manuel (addNamespace).
     *
     * @return string|false
     */
    protected function ChargementFichierMappé($espaceDeNomClasse, $nomClasse)
    {
        if (isset($this->espaceDeNomClasses[$espaceDeNomClasse]) === false) {
            return false;
        }

        foreach ($this->espaceDeNomClasses[$espaceDeNomClasse] as $cheminPhysique) {
            $fichier = $cheminPhysique . $nomClasse . '.php';

            if ($this->requerirFichier($fichier)) {
                return $fichier;
            }
        }

        return false;
    }

    /**
     * Inclut le fichier s'il existe.
     *
     * @return bool
     */
    protected function requerirFichier($fichier)
    {
        if (file_exists($fichier)) {
            require $fichier;
            return true;
        }

        return false;
    }
}
