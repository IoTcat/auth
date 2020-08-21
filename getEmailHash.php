<?php

include './functions.php';

header('Access-Control-Allow-Origin:*');
header("Content-Type: application/json;charset=utf-8");

$cnn = db__connect();
$res = db__getData($cnn, "account");

$o = array();

foreach($res as $item){
    if($item['email']){
        array_push($o, md5($item['email']));
    }
}

echo json_encode($o);
