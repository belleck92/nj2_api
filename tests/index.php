<?php

$token = '';

// Demande de token
$ch = curl_init("http://api.nj2.gruik.fr/v1/authenticate");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, '{"email":"eleparquier@gmail.com","password":"123456"}');
$ret = curl_exec($ch);
$info = curl_getinfo($ch);
echo "\n";
echo $ret;
echo "\n";
$returnedData = json_decode(explode("\r\n\r\n", $ret)[1], true);
if(isset($returnedData['token']) && !empty($returnedData['token'])) $token = $returnedData['token'];

// connection à la partie n°1
$ch = curl_init("http://api.nj2.gruik.fr/v1/authenticate/connectToGame");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, '{"idGame":1}');
curl_setopt($ch,CURLOPT_HTTPHEADER,[
    "Authorization: Bearer ".$token
]);
$ret = curl_exec($ch);
$info = curl_getinfo($ch);
echo "\n";
echo $ret;
echo "\n";
$returnedData = json_decode(explode("\r\n\r\n", $ret)[1], true);
if(isset($returnedData['token']) && !empty($returnedData['token'])) $token = $returnedData['token'];

// Requête MAP
$ch = curl_init("http://api.nj2.gruik.fr/v1/map?idCenter=600&width=10&height=10");
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


