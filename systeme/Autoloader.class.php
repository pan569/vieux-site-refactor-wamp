<?php

namespace systeme;

    /*
     * Permet de trouver les fichiers et de ainssi de charger automatiquement les classes.
     */
    class Autoloader
    {
        /**
         * Un tableau associatif où la clé est un préfixe d’espace de noms et la valeur est
         * un tableau de répertoires de base pour les classes de cet espace de noms.
         *
         * @var array
         */
        protected $espaceDeNomClasses = [];
        
        /**
         * Ajoute un répertoire de base pour un préfixe d’espace de noms.
         *
         * @param string $espaceDeNomClasse Préfixe d’espace de noms.
         * @param string $cheminPhysique Un répertoire de base pour les fichiers de classe dans l’espace de noms.
         * @param bool $prepend Si true, ajouter le répertoire de base à la pile au lieu de l’ajouter; Cela provoque la recherche d’abord plutôt que la dernière.
         * @return void
         */
        public function addNamespace($espaceDeNomClasse, $cheminPhysique, $prepend = false)
        {
            
            debug($espaceDeNomClasse,"espaceDeNomClasse");
            debug($cheminPhysique,"$cheminPhysique");
            
            
            // Normalisez le préfixe d’espace de noms
            $espaceDeNomClasse = trim($espaceDeNomClasse, '\\') . '\\';
            //var_dump('prefix: '.$espaceDeNomClasse);
            
            // Normalisez le répertoire de base avec un séparateur de fin
            if(strpbrk($cheminPhysique, '\\') === false)
            {
                $cheminPhysique = rtrim($cheminPhysique, DIRECTORY_SEPARATOR) . '/';
            }
            else 
            {
                $cheminPhysique = rtrim($cheminPhysique, DIRECTORY_SEPARATOR) . '\\';
            }
            
            
            //var_dump('base_dir: '.$cheminPhysique);
            /**/
            
            // initialiser le tableau de préfixe d’espace de noms
            if (isset($this->espaceDeNomClasses[$espaceDeNomClasse]) === false)
            {
                $this->espaceDeNomClasses[$espaceDeNomClasse] = array();
            }
            
            
            
            // conserver le répertoire de base pour le préfixe d’espace de noms
            if ($prepend)
            {
                array_unshift($this->espaceDeNomClasses[$espaceDeNomClasse], $cheminPhysique);
            }
            else
            {
                array_push($this->espaceDeNomClasses[$espaceDeNomClasse], $cheminPhysique);
            }
            
            //var_dump($this->espaceDeNomClasses);
        }
        
        /**
         * Enregistrez le chargeur avec la pile du SPL autoloadeur.
         *
         * @return void
         */
        public function register()
        {           
            spl_autoload_register(array(__CLASS__,'autoload'));
            //spl_autoload_register(array(__CLASS__,'autoload'));
        }

        /*
         * Determine le nom du fichier de la classe par rapport au nom de la classe
         */
        public function autoload($NomClasse)
        {   
             
            
           //echo '##########################<br>';
           //echo "DEBUT ".__FUNCTION__."({$NomClasse}) <br>";
            
            $resultat = false;
            $NomClasseT = $this->resolveurEspaceNom($NomClasse);

            
            $resultat = $this->ChargementFichierConventionel($NomClasseT['EspaceDeNomClasse'], $NomClasseT['nomClasse']);            
            
            //debug($resultat,"RESULTAT:");
            
            if($resultat === false )
            {
                $resultat = $this->ChargementFichierMappé($NomClasseT['EspaceDeNomClasse'], $NomClasseT['nomClasse']);
            }
            
          
            /*
            echo '<br>';
            echo '++ RESUME: ++++++++++++++++<br>';
            debug($NomClasse,'Non complet de la classe: ');
            debug($NomClasseT['nomClasse'],'Nom de la classe: ');
            debug($NomClasseT['EspaceDeNomClasse'],'Espace de nom de la classe: ');
            if(array_key_exists($NomClasseT['EspaceDeNomClasse'],$this->espaceDeNomClasses))
            {
               debug($this->espaceDeNomClasses[$NomClasseT['EspaceDeNomClasse']]);
            }
            debug($resultat,"Resultat:");
            echo '<br>+++++++++++++++++++++++++++<br>';
            /**/
            
            return $resultat;
            
            //echo "fin ".__FUNCTION__."({$NomClasse}) <br>";
            //echo '##########################<br>';
            

        }
        
        /**
         * 
         * Recherche 
         * 1) le nom de la classe courante
         * 2) l'espace de nom de la classe courante
         * 
         * @param string $NomClasseComplet
         */
        protected function resolveurEspaceNom(string $NomClasse) 
        {   
            //echo '##########################<br>';
            //echo "DEBUT ".__FUNCTION__."({$NomClasse}) <br>";
            
            //debug($NomClasse,"NomClasse");
            
            $resultat = [];
            
            $NomClasseCompletT = explode('\\', $NomClasse);
            //debug($NomClasseCompletT,"NomClasseComplet");
            
            $pos = count($NomClasseCompletT);
            //debug($pos,"pos");
            
            $resultat['nomClasse'] = $NomClasseCompletT[$pos-1];
            //var_dump($resultat['nomClasse']);
            
            $resultat['EspaceDeNomClasse'] = '';
            for ($cp = 0 ;$cp < $pos-1 ; $cp++) 
            {
                $resultat['EspaceDeNomClasse'].=rtrim($NomClasseCompletT[$cp].DIRECTORY_SEPARATOR);
            }
            //var_dump($resultat['EspaceDeNomClasse']);
            
            //debug($resultat,"resultat");
            
            return $resultat;
            /*
            echo "fin ".__FUNCTION__."({$NomClasse}) <br>";
            echo '##########################<br>';
            /*
            echo '***************************<br>';
            echo __FILE__.'<br>';
            var_dump('Non complet de la classe: '.$NomClasse);
            var_dump('Nom de la classe: '.$this->nomClasse['nomClasse']);
            var_dump('Espace de nom de la classe: '.$this->nomClasse['EspaceDeNomClasse']);
            echo '***************************<br>';
            /**/
        }        
        
        /**
         * 
         * Le cas le plus simple : Par convention, les nom de mes fichiers de classe se compose ainssi:
         * Nom De La Classe + "class" + extention de fichier php
         * @param string $espaceDeNomClasse
         * @param string $nomClasse
         * @return string|boolean
         */
        protected function ChargementFichierConventionel(string $espaceDeNomClasse, string $nomClasse)
        {   
            
            // Le cas le plus simple : Par convention, les nom de mes fichiers de classe se compose ainssi:
            // Nom De La Classe + "class" + extention de fichier php
            
            $s=DIRECTORY_SEPARATOR;
            
            //debug($s);
            
            $fichier =dirname( __DIR__).$s.$espaceDeNomClasse.$nomClasse.'.class.php';
            
            //debug($espaceDeNomClasse,"espaceDeNomClasse");
            //debug($nomClasse,"nomClasse");
            //debug($fichier,"fichier");
            
            // Si le fichier mappé existe, il faut
            if ($this->requerirFichier($fichier))
            {
                // Oui, c’est fini.
                return $fichier;
            }
            
            // Par convention, les nom de mes fichiers de trait se compose ainssi:
            // Nom De La Classe + "trait" + extention de fichier php
            $fichier =dirname( __DIR__).$s.$espaceDeNomClasse.$nomClasse.'.trait.php';
            // Si le fichier mappé existe, il faut
            if ($this->requerirFichier($fichier))
            {
                // Oui, c’est fini.
                return $fichier;
            }
            
            return false;

        }
        
        /**
         * Chargez le fichier mappé pour un préfixe d’espace de noms et une classe relative.
         *
         * @param string $prefix Préfixe d’espace de noms.
         * @param string $relative_class Le nom de classe relatif.
         * @return mixed Boolean false Si aucun fichier mappé ne peut être chargé ou le nom
         * du fichier mappé qui a été chargé.
         */
        protected function ChargementFichierMappé($espaceDeNomClasse, $nomClasse)
        {

            // y a-t-il des répertoires de base pour ce préfixe d’espace de noms?
            if (isset($this->espaceDeNomClasses[$espaceDeNomClasse]) === false)
            {                                
                return false;
            }

            // regarder à travers les répertoires de base pour ce préfixe d’espace de noms
            foreach ($this->espaceDeNomClasses[$espaceDeNomClasse] as $cheminPhysique)
            {
                // Remplacez le préfixe d’espace de noms par le répertoire de base, remplacez
                //les séparateurs d’espaces de noms par des séparateurs de répertoires dans
                //le nom de classe relatif, ajoutez avec. php
                $fichier = $cheminPhysique.$nomClasse.'.php';               
                                
                // Si le fichier mappé existe, il faut
                if ($this->requerirFichier($fichier))
                {                    
                    // Oui, c’est fini.
                    return $fichier;
                }
            }
            
            // jamais trouvé
            return false;
        }
        
        /**
         * Si un fichier existe, l’exiger du système de fichiers.
         *
         * @param string $file Le fichier à exiger.
         * @return bool True Si le fichier existe, false sinon.
         */
        protected function requerirFichier($fichier)
        {           
            if (file_exists($fichier))
            {                
                require $fichier;
                return true;
            }
             
             return false;
             
        }
  
    }
    
    

?>