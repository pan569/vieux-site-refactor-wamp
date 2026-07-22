<?php
use systeme\Autoloader;
use systeme\Noyau;
use systeme\securite\Securite;

?>

<?php

//https://stackoverflow.com/questions/36577020/php-failed-to-open-stream-no-such-file-or-directory

$s = DIRECTORY_SEPARATOR;

require $_SERVER["DOCUMENT_ROOT"] . $s . 'debug.php';
require $_SERVER["DOCUMENT_ROOT"] . $s . 'systeme' . $s . 'Autoloader.class.php';

// ## instanciation de l'autoloader ##
$autoloader = new Autoloader();
$autoloader->register();

// Charge Securite dès le démarrage → définit la fonction globale e()
class_exists(Securite::class);
?>

<?php

Noyau::getInstance()->navig();
//Noyau::getInstance()->memAllUrl();
/**/
?>
