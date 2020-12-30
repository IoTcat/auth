<?php

include './functions.php';

$hash = $_GET['hash'];
$token = $_GET['token'];
if(!isset($hash) || !isset($token)) die();


header('Access-Control-Allow-Origin:https://user.yimian.xyz');
header("Content-Type: application/json;charset=utf-8");

$cnn = db__connect();

db__pushData($cnn, "token", array(
    "state" => 0,
    "updated_at" => date("Y-m-d H:i:s")
), array(
    "token" => $token,
    "hash" => $hash
));

echo json_encode(array("status"=>true));
