<?php
header('content-type: application/json');

$s=DIRECTORY_SEPARATOR;
$dir= __DIR__."{$s}resources{$s}données{$s}dropFichier{$s}";
$source = file_get_contents('php://input');
$typesAccept = array ('image/png','image/gif','image/jpeg');
$reponse = new stdClass();
$headers = getallheaders();

$reponse->entetefileType = $headers['x-file-type'];
$reponse->entetefileSize = $headers['x-file-size'];
$reponse->entetefileName = $headers['x-file-name'];

$reponse->TypeFichier = pathinfo($dir.$headers['x-file-name'], PATHINFO_EXTENSION);

file_put_contents($dir.$headers['x-file-name'],$source);

if(!in_array($reponse->TypeFichier, $typesAccept))
{
    $reponse->error = $reponse->TypeFichier." n'est pas un type type non suporté ";
}
else
{
    file_put_contents($dir.$headers['x-file-name'],$source);
    $reponse->messageOK = "le fichier ".$headers['x-file-name']." a bien ete telechargé";
    //$reponse->imgHTML = '<img src="http://site01/appLabjc/vue/resources/donn%C3%A9es/img/'.$headers['x-file-name'].'"  />';
}

echo json_encode($reponse);
/**/
?>