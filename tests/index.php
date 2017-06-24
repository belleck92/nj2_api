<?php

$token = '';

// Demande de token
$ch = curl_init("http://api.nj2.gruik.fr/v1/authenticate");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, '{"user":"manu","password":"zaza"}');
$ret = curl_exec($ch);
$info = curl_getinfo($ch);
echo "\n";
echo $ret;
echo "\n";
$returnedData = json_decode(explode("\r\n\r\n", $ret)[1], true);
if(isset($returnedData['token']) && !empty($returnedData['token'])) $token = $returnedData['token'];





//$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJyaXBlbWQzMjAifQ==.eyJyb2xlIjoyLCJpZFNvY2lldGUiOjEsImV4cCI6MTQ5Nzg4MjQxM30=.cf7abab36f3ceb032b80c79808b343df8e8df07e33cfcba3ff0838b888c2438d745f274e0904a5a1";
// Utilisation du token
/*
$ch = curl_init("http://api.nj2.gruik.fr/v1/societes/2/contacts");
curl_setopt($ch,CURLOPT_HTTPHEADER,[
    "Authorization: Bearer ".$token
]);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
$ret = curl_exec($ch);
$info = curl_getinfo($ch);
echo "\n";
echo $ret;
echo "\n";
*/

/*
$ch = curl_init("http://api.nj2.gruik.fr/v1/contacts/filter?nom=dede");
curl_setopt($ch,CURLOPT_HTTPHEADER,[
    "Authorization: Bearer ".$token
]);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$ret = curl_exec($ch);
$info = curl_getinfo($ch);
echo "\n";
echo $ret;
echo "\n";*/


$ch = curl_init("http://api.nj2.gruik.fr/v1/societes/2/contacts");
curl_setopt($ch,CURLOPT_HTTPHEADER,[
    "Authorization: Bearer ".$token
]);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$ret = curl_exec($ch);
$info = curl_getinfo($ch);
echo "\n";
echo $ret;
echo "\n";





