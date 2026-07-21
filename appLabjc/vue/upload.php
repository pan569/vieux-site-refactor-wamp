<?php
//header('content-type: application/json');

$s=DIRECTORY_SEPARATOR;
$dir= __DIR__."{$s}resources{$s}données{$s}img{$s}";
$source = file_get_contents('php://input');

$typesAccept = array ('image/png','image/gif','image/jpeg');
$reponse = new stdClass();
$headers = getallheaders();


//print_r($headers['test']);


if(!in_array($headers['x-file-type'], $typesAccept))
{
    $reponse->error = 'type non suporté ';
}
else 
{
    file_put_contents($dir.$headers['x-file-name'],$source);
    $reponse->fileName = $headers['x-file-name'];
    $reponse->imgHTML = '<img src="http://site01/appLabjc/vue/resources/donn%C3%A9es/img/'.$headers['x-file-name'].'"  />'; 
}

echo json_encode($reponse);
/**/
?>