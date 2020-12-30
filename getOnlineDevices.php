<?php

include './functions.php';

$hash = $_GET['hash'];
if(!isset($hash)) die();


header('Access-Control-Allow-Origin:https://user.yimian.xyz');
header("Content-Type: application/json;charset=utf-8");

$cnn = db__connect();
$cnnLog = db__connect('log');
$res = db__getData($cnn, "token", 'hash', $hash);


$o = array();

foreach($res as $item){
    if($item['state']){
        $data = db__getData($cnn, 'fip', 'token', $item['token']);
        $t = array();
        foreach($data as $r) array_push($t, $r['created_at']);
        array_multisort($t, $data);
        $item['fp'] = $data[count($data)-1]['fp'];
        $item['ip'] = $data[count($data)-1]['ip'];
        $log = db__getData($cnnLog, 'log_iis', 'fp', $item['fp'], 'ip', ip2long($item['ip']));
        if($log != 404){
            $item['log'] = $log;
        }
        array_push($o, $item);
    }
}

echo json_encode($o);
