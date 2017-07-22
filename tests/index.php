<?php

$token = '';

// Demande de token
/*$ch = curl_init("http://api.nj2.gruik.fr/v1/authenticate");
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
*/

// Requête MAP
/*$ch = curl_init("http://api.nj2.gruik.fr/v1/map?idCenter=600&width=10&height=10");
curl_setopt($ch,CURLOPT_HTTPHEADER,[
    "Authorization: Bearer ".$token
]);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
$ret = curl_exec($ch);
$info = curl_getinfo($ch);
echo "\n";
echo $ret;
echo "\n";*/

// Création Joueur à la partie n°1
/*$ch = curl_init("http://api.nj2.gruik.fr/v1/games/1/players");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, '[{"idGame":1,"name":"manuche","color":"F00"}]');
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

*/
// connection à la partie n°1
/*$ch = curl_init("http://api.nj2.gruik.fr/v1/authenticate/connectToGame");
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
*/
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJyaXBlbWQzMjAifQ==.eyJpZFVzZXIiOiIyIiwicm9sZSI6IjEiLCJleHAiOjE1MDA3MjI5MTEsImlkR2FtZSI6IjEiLCJpZFBsYXllciI6IjIiLCJpZENhcGl0YWxDaXR5IjoiNjc3In0=.23d82e0cbf1380098ab680c0f70c3c09eac1eb59028a51c6583600e76540af1d178eaf5bca109ee1';

// MAP
$ch = curl_init("http://api.nj2.gruik.fr/v1/map?idCenter=677&width=10&height=10");
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